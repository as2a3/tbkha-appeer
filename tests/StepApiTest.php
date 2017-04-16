<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StepApiTest extends TestCase
{
    use MakeStepTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateStep()
    {
        $step = $this->fakeStepData();
        $this->json('POST', '/api/v1/steps', $step);

        $this->assertApiResponse($step);
    }

    /**
     * @test
     */
    public function testReadStep()
    {
        $step = $this->makeStep();
        $this->json('GET', '/api/v1/steps/'.$step->id);

        $this->assertApiResponse($step->toArray());
    }

    /**
     * @test
     */
    public function testUpdateStep()
    {
        $step = $this->makeStep();
        $editedStep = $this->fakeStepData();

        $this->json('PUT', '/api/v1/steps/'.$step->id, $editedStep);

        $this->assertApiResponse($editedStep);
    }

    /**
     * @test
     */
    public function testDeleteStep()
    {
        $step = $this->makeStep();
        $this->json('DELETE', '/api/v1/steps/'.$step->iidd);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/steps/'.$step->id);

        $this->assertResponseStatus(404);
    }
}
