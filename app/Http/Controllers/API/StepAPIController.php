<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateStepAPIRequest;
use App\Http\Requests\API\UpdateStepAPIRequest;
use App\Models\Step;
use App\Repositories\StepRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class StepController
 * @package App\Http\Controllers\API
 */

class StepAPIController extends AppBaseController
{
    /** @var  StepRepository */
    private $stepRepository;

    public function __construct(StepRepository $stepRepo)
    {
        $this->stepRepository = $stepRepo;
    }

    /**
     * Display a listing of the Step.
     * GET|HEAD /steps
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->stepRepository->pushCriteria(new RequestCriteria($request));
        $this->stepRepository->pushCriteria(new LimitOffsetCriteria($request));
        $steps = $this->stepRepository->all();

        return $this->sendResponse($steps->toArray(), 'Steps retrieved successfully');
    }

    /**
     * Store a newly created Step in storage.
     * POST /steps
     *
     * @param CreateStepAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateStepAPIRequest $request)
    {
        $input = $request->all();

        $steps = $this->stepRepository->create($input);

        return $this->sendResponse($steps->toArray(), 'Step saved successfully');
    }

    /**
     * Display the specified Step.
     * GET|HEAD /steps/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Step $step */
        $step = $this->stepRepository->findWithoutFail($id);

        if (empty($step)) {
            return $this->sendError('Step not found');
        }

        return $this->sendResponse($step->toArray(), 'Step retrieved successfully');
    }

    /**
     * Update the specified Step in storage.
     * PUT/PATCH /steps/{id}
     *
     * @param  int $id
     * @param UpdateStepAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStepAPIRequest $request)
    {
        $input = $request->all();

        /** @var Step $step */
        $step = $this->stepRepository->findWithoutFail($id);

        if (empty($step)) {
            return $this->sendError('Step not found');
        }

        $step = $this->stepRepository->update($input, $id);

        return $this->sendResponse($step->toArray(), 'Step updated successfully');
    }

    /**
     * Remove the specified Step from storage.
     * DELETE /steps/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Step $step */
        $step = $this->stepRepository->findWithoutFail($id);

        if (empty($step)) {
            return $this->sendError('Step not found');
        }

        $step->delete();

        return $this->sendResponse($id, 'Step deleted successfully');
    }
}
