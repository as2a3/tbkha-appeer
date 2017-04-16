<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests;
use Socialite;
use Response;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * Class SocialMediaControllerController
 * @package App\Http\Controllers\API
 */

class SocialMediaAPIController extends AppBaseController
{
  /** @var  userRepository */
private $userRepository;
public function __construct(UserRepository $userRepo)
{
    $this->userRepository = $userRepo;
}

public function handleProviderLogIn($token,$fcm_token=null){
  $userData=Socialite::driver('facebook')->userFromToken($token);
  $authUser = $this->findOrCreateUser($userData,$fcm_token);
  return Response::json($authUser, 200);
}

 /**
 * Return user if exists; create and return if doesn't
 *
 * @param $facebookUser
 * @return User
 */
private function findOrCreateUser($facebookUser,$fcm_token)
{
    // $input = [
    //         'name' => $facebookUser->name,
    //         'email' => $facebookUser->email,
    //         'facebook_id' => $facebookUser->id,
    //         'avatar' => $facebookUser->avatar_original,
    //         'facebook_token' => $facebookUser->token,
    //         'FCM_token' => $fcm_token ,
    //         'admin' => '0'
    //       ];
    // if ($authUser = $this->userRepository->findWhere(['facebook_id'  => $facebookUser->id])->first()) {
    //   $authUser=$this->userRepository->update($input,$authUser->toArray()['id']);
    //   $auth_user = ((collect(($authUser)->toArray()))
    //   ->except('created_at','updated_at','deleted_at','email','FCM_token','facebook_id','admin','password','remember_token','facebook_token'))->all();
    //   // $auth_user['token']=$authUser['user_token'];
    //   // dd($auth_user);
    //   return $auth_user;
    // }
    $token = JWTAuth::fromUser($facebookUser);
    // $input['user_token'] = $token;
    // $new_user=$this->userRepository->create($input);
    // $new_user['user_token']=$token;
    // $new_user=((collect($new_user))->except('email','admin','FCM_token','facebook_id','password','remember_token','created_at','updated_at','deleted_at'))->all();
    return $token;

}





}
