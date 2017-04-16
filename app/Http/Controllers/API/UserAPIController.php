<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\RecipeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use InfyOm\Generator\Utils\ResponseUtil;
use Illuminate\Support\Facades\Request as auth_request;

/**
 * Class PlayerController
 * @package App\Http\Controllers\API
 */

class UserAPIController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;
    private $recipeRepository;

    public function __construct(UserRepository $userRepo, RecipeRepository $recipeRepo)
    {
        $this->userRepository = $userRepo;
        $this->recipeRepository = $recipeRepo;
    }

    public function user_profile($id){
      $user_data               = $this->userRepository->findWhere(['id' => $id])->first();
      // $user_recipes            = $this->recipeRepository->recipe_object($user_data->recipes);
      $user_data               = collect($user_data)->only(['id', 'name', 'avatar', 'user_token','facebook_token','email']);
      // $user_data['user_recipes'] = $user_recipes;
      return $this->sendResponse($user_data, 'Recipes retrieved successfully');
    }

    public function player_FCM(Request $request){
      $fcm_token=$request->all()['fcm_token'];
      $user1_id  = ($this->playerRepository->findWhere(['user_token' => auth_request::header('Authorization')])->first())->toArray()['id'];
      $input=['FCM_token' => $fcm_token ];
      $updated_user=$this->playerRepository->update($input,$user1_id);
    }








}
