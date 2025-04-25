<?php

namespace App\Console\Commands;

use App\Enums\QuizDifficulty;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuestionChoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class ImportQuizzesFromCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quiz:import {file : Path to the CSV file} {--truncate : Truncate existing data before import}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import quizzes with questions and choices from a CSV file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the file path from the command argument
        $filePath = $this->argument('file');
        
        // Check if the file exists
        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }
        
        // Check if truncate option is used
        $truncate = $this->option('truncate');
        if ($truncate) {
            if ($this->confirm('Are you sure you want to truncate all existing quizzes, questions, and choices?')) {
                $this->info('Truncating existing data...');
                DB::table('question_choices')->truncate();
                DB::table('questions')->truncate();
                DB::table('quizzes')->truncate();
                $this->info('Existing data truncated.');
            } else {
                $truncate = false;
            }
        }
        
        // Read and parse the CSV file
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0); // First row contains headers
        $records = $csv->getRecords();
        $recordsArray = iterator_to_array($records); // Convert to array to count
        
        // Track the current quiz to avoid duplicates
        $currentQuizTitle = null;
        $currentQuiz = null;
        $quizCount = 0;
        $questionCount = 0;
        $choiceCount = 0;
        
        // Start a database transaction
        DB::beginTransaction();
        
        try {
            // Process each row in the CSV
            $this->info('Importing quizzes from CSV...');
            $progressBar = $this->output->createProgressBar(count($recordsArray));
            $progressBar->start();
            
            foreach ($recordsArray as $record) {
                // If this is a new quiz, create it
                if ($currentQuizTitle !== $record['quiz_title']) {
                    $currentQuizTitle = $record['quiz_title'];
                    
                    // Map the difficulty string to enum
                    $difficultyMap = [
                        'easy' => QuizDifficulty::EASY->value,
                        'medium' => QuizDifficulty::MEDIUM->value,
                        'hard' => QuizDifficulty::HARD->value,
                    ];
                    
                    $difficulty = $difficultyMap[strtolower($record['quiz_difficulty'])] ?? QuizDifficulty::MEDIUM->value;
                    
                    // Check if the quiz already exists (if not truncating)
                    if (!$truncate) {
                        $existingQuiz = Quiz::where('title', $record['quiz_title'])->first();
                        if ($existingQuiz) {
                            $currentQuiz = $existingQuiz;
                            $this->line("Using existing quiz: {$currentQuizTitle}");
                            $progressBar->advance();
                            continue;
                        }
                    }
                    
                    // Create the new quiz
                    $currentQuiz = Quiz::create([
                        'title' => $record['quiz_title'],
                        'description' => $record['quiz_description'],
                        'difficulty' => $difficulty,
                    ]);
                    
                    $quizCount++;
                }
                
                // Create the question
                $question = Question::create([
                    'quiz_id' => $currentQuiz->id,
                    'question' => $record['question'],
                ]);
                
                $questionCount++;
                
                // Create the choices
                for ($i = 1; $i <= 4; $i++) {
                    QuestionChoice::create([
                        'question_id' => $question->id,
                        'choice' => $record["choice_{$i}"],
                        'is_correct' => ($i == $record['correct_choice']),
                    ]);
                    $choiceCount++;
                }
                
                $progressBar->advance();
            }
            
            // Commit the transaction
            DB::commit();
            
            $progressBar->finish();
            $this->newLine(2);
            $this->info("Import completed successfully!");
            $this->info("Created {$quizCount} quizzes with {$questionCount} questions and {$choiceCount} choices.");
            
            return 0;
        } catch (\Exception $e) {
            // Roll back the transaction on error
            DB::rollBack();
            
            $this->error('Import failed: ' . $e->getMessage());
            $this->error('Line: ' . $e->getLine());
            return 1;
        }
    }
}
