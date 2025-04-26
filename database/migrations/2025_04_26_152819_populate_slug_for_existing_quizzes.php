<?php

use App\Models\Quiz;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all quizzes
        $quizzes = DB::table('quizzes')->get();
        
        foreach ($quizzes as $quiz) {
            // Generate a slug from the title
            $baseSlug = Str::slug($quiz->title);
            $slug = $baseSlug;
            $counter = 1;
            
            // Check if the slug already exists
            while (DB::table('quizzes')->where('slug', $slug)->where('id', '!=', $quiz->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            // Update the quiz with the slug
            DB::table('quizzes')->where('id', $quiz->id)->update(['slug' => $slug]);
        }
        
        // Make slug required after all quizzes have a slug
        DB::statement('ALTER TABLE quizzes MODIFY slug VARCHAR(255) NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Nothing to do here as we don't want to remove the slugs
        // If needed, the previous migration's down method will handle removing the column
    }
};
