<?php

namespace Tests\Unit\Services;

use App\Repositories\Contracts\LeaderboardRepositoryInterface;
use App\Services\LeaderboardService;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\TestCase;

class LeaderboardServiceTest extends TestCase
{
    private readonly LeaderboardRepositoryInterface|MockObject $leaderboardRepository;

    private readonly LeaderboardService $leaderboardService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->leaderboardRepository = $this->createMock(LeaderboardRepositoryInterface::class);
        $this->leaderboardService = new LeaderboardService($this->leaderboardRepository);
    }

    public function test_can_return_leaderboard()
    {
       $this->leaderboardRepository->expects($this->once())
            ->method('getUsers')
            ->with(quizId: 1)
            ->willReturn(collect([1 => 'John Doe', 2 => 'Jane Doe']));

        $leaderboard = $this->leaderboardService->__invoke(1);

        $this->assertEquals([1 => 'John Doe', 2 => 'Jane Doe'], $leaderboard->toArray());
    }
}
