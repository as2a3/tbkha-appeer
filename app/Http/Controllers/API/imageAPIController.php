<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateimageAPIRequest;
use App\Http\Requests\API\UpdateimageAPIRequest;
use App\Models\image;
use App\Repositories\imageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Input;

/**
 * Class imageController
 * @package App\Http\Controllers\API
 */

class imageAPIController extends AppBaseController
{
    /** @var  imageRepository */
    private $imageRepository;

    public function __construct(imageRepository $imageRepo)
    {
        $this->imageRepository = $imageRepo;
    }

    /**
     * Store a newly created image in storage.
     * POST /images
     *
     * @param CreateimageAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateimageAPIRequest $request,$type)
    {
        $input = $request->all();
        if (Input::file('image')) {
          if($type == 0){
            $input['image'] = Input::file('image')->getClientOriginalName();
            $request->file('image')->move(public_path().'/recipesImages/', $input['image']);
          }elseif ($type == 1) {
            $input['image'] = Input::file('image')->getClientOriginalName();
            $request->file('image')->move(public_path().'/stepsImages/', $input['image']);
          }elseif ($type == 2)  {
            $input['image'] = Input::file('image')->getClientOriginalName();
            $request->file('image')->move(public_path().'/CategoriesImages/', $input['image']);
          }
        }
        $images = $this->imageRepository->create($input);
        return $this->sendResponse($images->id, 'Image saved successfully');
    }

    /**
     * Remove the specified image from storage.
     * DELETE /images/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var image $image */
        $image = $this->imageRepository->findWithoutFail($id);

        if (empty($image)) {
            return $this->sendError('Image not found');
        }

        $image->delete();

        return $this->sendResponse($id, 'Image deleted successfully');
    }
}
