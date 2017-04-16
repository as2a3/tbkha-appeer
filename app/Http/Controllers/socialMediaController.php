<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests;
use Socialite;
use Response;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class socialMediaController extends Controller
{
    /** @var  userRepository */
  private $userRepository;
  public function __construct(UserRepository $userRepo)
  {
      $this->userRepository = $userRepo;
  }


  public function redirectToProvider()
  {
    return Socialite::driver('facebook')->redirect();
  }

  /**
  * Obtain the user information from GitHub.
  *
  * @return Response
  */
  public function handleProviderCallback()
  {
    $user = Socialite::driver('facebook')->user();

    dd($user);
  }

}
