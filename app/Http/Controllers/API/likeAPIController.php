<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatelikeAPIRequest;
use App\Http\Requests\API\UpdatelikeAPIRequest;
use App\Models\like;
use App\Repositories\likeRepository;
use App\Repositories\UserRepository;
use App\Repositories\RecipeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Request as auth_request;

/**
 * Class likeController
 * @package App\Http\Controllers\API
 */

class likeAPIController extends AppBaseController
{
    /** @var  likeRepository */
    private $likeRepository;
    private $userRepository;
    private $recipeRepository;

    public function __construct(likeRepository $likeRepo, UserRepository $userRepo, RecipeRepository $recipeRepo)
    {
        $this->likeRepository = $likeRepo;
        $this->userRepository = $userRepo;
        $this->recipeRepository = $recipeRepo;
    }


    /**
     * Store a newly created like in storage.
     * POST /likes
     *
     * @param CreatelikeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatelikeAPIRequest $request)
    {
        $user_data = $this->userRepository->findWhere(['user_token' => auth_request::header('Authorization')])->first();
        $input     = $request->all();
        $recipe    = $this->recipeRepository->findWithoutFail($input['recipe_id']);
        $recipe_likes    = $this->likeRepository->findWhere(['recipe_id' => $input['recipe_id']]);
        $plucked = ($recipe_likes)->pluck('user_id');
        if(in_array($user_data['id'], $plucked->toArray())){
          $like = $this->likeRepository->findWhere(['user_id' => $user_data['id'] , 'recipe_id' => $input['recipe_id']]);
          $this->destroy($like[0]->id);
        }else {
          $input['user_id'] =  $user_data->id;
          $like  = $this->likeRepository->create($input);
        }
        $recipes = array('0' => $recipe);
        return $this->sendResponse($this->recipeRepository->recipe_object($recipes,$user_data->id), 'Recipe retrieved successfully');
    }
    /**
     * Remove the specified like from storage.
     * DELETE /likes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var like $like */
        $like = $this->likeRepository->findWithoutFail($id);

        if (empty($like)) {
            return $this->sendError('Like not found');
        }

        $like->delete();

        return $this->sendResponse($id, 'Like deleted successfully');
    }
}
