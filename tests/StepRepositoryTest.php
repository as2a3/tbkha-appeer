<?php

use App\Models\Step;
use App\Repositories\StepRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StepRepositoryTest extends TestCase
{
    use MakeStepTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var StepRepository
     */
    protected $stepRepo;

    public function setUp()
    {
        parent::setUp();
        $this->stepRepo = App::make(StepRepository::class);
    }

    /**
     * @test create
     */
    public function testCreateStep()
    {
        $step = $this->fakeStepData();
        $createdStep = $this->stepRepo->create($step);
        $createdStep = $createdStep->toArray();
        $this->assertArrayHasKey('id', $createdStep);
        $this->assertNotNull($createdStep['id'], 'Created Step must have id specified');
        $this->assertNotNull(Step::find($createdStep['id']), 'Step with given id must be in DB');
        $this->assertModelData($step, $createdStep);
    }

    /**
     * @test read
     */
    public function testReadStep()
    {
        $step = $this->makeStep();
        $dbStep = $this->stepRepo->find($step->id);
        $dbStep = $dbStep->toArray();
        $this->assertModelData($step->toArray(), $dbStep);
    }

    /**
     * @test update
     */
    public function testUpdateStep()
    {
        $step = $this->makeStep();
        $fakeStep = $this->fakeStepData();
        $updatedStep = $this->stepRepo->update($fakeStep, $step->id);
        $this->assertModelData($fakeStep, $updatedStep->toArray());
        $dbStep = $this->stepRepo->find($step->id);
        $this->assertModelData($fakeStep, $dbStep->toArray());
    }

    /**
     * @test delete
     */
    public function testDeleteStep()
    {
        $step = $this->makeStep();
        $resp = $this->stepRepo->delete($step->id);
        $this->assertTrue($resp);
        $this->assertNull(Step::find($step->id), 'Step should not exist in DB');
    }
}
