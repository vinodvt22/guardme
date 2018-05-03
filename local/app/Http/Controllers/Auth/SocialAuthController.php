<?php

namespace Responsive\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Responsive\Http\Controllers\Controller;
use Responsive\Http\Repositories\SocialAuthRepository;
use \Socialite;


class SocialAuthController extends Controller
{
    /**
     * @var SocialAuthRepository
     */
    private $socialAuthRepository;
    private $socialite;

    /**
     * SocialAuthController constructor.
     * @param SocialAuthRepository $socialAuthRepository
     * @param Socialite $socialite
     */
    public function __construct(SocialAuthRepository $socialAuthRepository)
    {
        $this->socialAuthRepository = $socialAuthRepository;
    }


    /**
     * @param $social
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function socialLogin($social)
    {
        return Socialite::driver($social)->redirect();
    }

    /**
     * Obtain the user information from Socialite returned information.
     * @param $provider
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $userSocial = Socialite::driver($provider)->user();

        if ($userSocial->getEmail()) {
            $details['id'] = $userSocial->getId();
            $details['username'] = $userSocial->getName();
            $details['email'] = $userSocial->getEmail();
            $details['provider'] = $provider;
            $user = $this->socialAuthRepository->saveSocialDetail($details);

            $redirect_route = $user->requiresInitialSetup() ?
                '/welcome/setup' :
                redirect()->intended()->getTargetUrl();

            auth()->guard('web')->login($user, true);

            return redirect()->to($redirect_route);

        } else {
            return redirect('login?email=false&provider=twitter&id=' .
                $userSocial->getId() . '&name=' . $userSocial->getName());
        }
    }

    public function loginUser(User $user)
    {
        auth()->guard('web')->login($user, true);

        publish(new UserHasLoggedIn($user));

        /** @var User $user */
        $user = TalkstuffUser::find($user->id);

        if($user->requiresInitialSetup()){
            return view('welcome::setup.profile');
        }else{
            return redirect()->intended()->getTargetUrl();
        }
    }

    public function NoSocialmediaEmail()
    {
        $details['id'] = request()->input('id');
        $details['username'] = request()->input('name');
        $details['email'] = request()->input('email');
        $details['provider'] = request()->input('provider');

        $user = $this->socialAuthRepository->saveSocialDetail($details);

        return $this->loginUser($user);
    }
}
