<?php

namespace Tests\Feature\Repositories;

use App\Models\QuestionChoice;
use App\Repositories\QuestionChoiceRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuestionChoiceRepositoryTest extends TestCase
{
    use RefreshDatabase;
    private readonly QuestionChoiceRepository $questionChoiceRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->questionChoiceRepository = new QuestionChoiceRepository();
    }

    public function test_can_find_question_choice()
    {
        QuestionChoice::factory([
            'question_id' => 2,
            'id' => 1,
        ])->create();
        $this->questionChoiceRepository->findOrFail(1, 2);
        $this->assertDatabaseHas('question_choices', ['id' => 1, 'question_id' => 2]);
    }

    public function test_cannot_find_question_choice()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->questionChoiceRepository->findOrFail(1, 2);
        $this->assertDatabaseHas('question_choices', ['id' => 1, 'question_id' => 2]);
    }
}
