<?php

namespace Responsive\Http\Controllers\Api\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Responsive\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Responsive\User;

class AuthController extends Controller
{
    use AuthenticatesUsers;


    public function apiRegister(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->apiLoginSuccessResponse();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|regex:/^[\w-]*$/|unique:users|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required|string|max:255',
            'usertype' => 'required|string|max:255',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],

            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'gender' => $data['gender'],
            'phone' => $data['phoneno'],
            'photo' => '',
            'admin' => $data['usertype'],
        ]);
    }

    public function apiSocialLogin(Request $request)
    {
        /** @var User $user */
        $user = $this->getUserByEmail($request->get('email'));

        if($user->id){
            // existing user
        } else {
            // new user
            $user = $this->createNewUserFromEmail($request->get('email'));
        }

        \auth()->login($user);

        return $this->apiLoginSuccessResponse();
    }

    public function apiLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        if(Auth::attempt($credentials)){
            return $this->apiLoginSuccessResponse();
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    protected function apiLoginSuccessResponse(){
        /** @var User $user */
        $user = Auth::user();
        $success['token'] =  $user->createToken(config('app.name'))->accessToken;
        return response()->json([
            'success' => $success
        ]);
    }

    public function getAuthUserDetails()
    {
        $user = Auth::user();
        return response()->json(['authUser' => $user]);
    }

    public function profile()
    {
        $user = Auth::user();
        return response()->json([
            'username' => $user->name,
            'first_name' => $user->firstname,
            'last_name' => $user->lastname,
            'email' => $user->email,
            'address_line1' => $user->address ? $user->address->line1 : null,
            'address_line2' => $user->address ? $user->address->line2 : null,
            'address_line3' => $user->address ? $user->address->line3 : null,
            'address_country' => $user->address ? $user->address->country : null,
            'address_postcode' => $user->address ? $user->address->postcode : null,
            'address_town' => $user->address ? $user->address->citytown : null,
            'phone' => $user->phone,
            'gender' => $user->gender,
            'dob' => $user->dob,
            'avatar' => $user->photo ? url("/local/images/userphoto/".$user->photo) : null,
            'nationality' => $user->nationality ? $user->nationality->name : null,
            'visa_number' => $user->visa_no,
            'sia_number' => $user->sia_license,
            'sia_expiry_date' => $user->sia_expirydate,
            'work_category' => User::getWorkCategories()[$user->work_category],
            'passport_photo' => $user->passphoto ? url("/local/images/userdoc/".$user->passphoto) : null,
            'passport_page' => $user->pass_page ? url("/local/images/userdoc/".$user->pass_page) : null,
            'visa_page' => $user->visa_page ? url("/local/images/userdoc/".$user->visa_page) : null,
            'sia_license' => $user->sia_doc ? url("/local/images/userdoc/".$user->sia_doc) : null,
            'address_proof' => $user->address_proof ? url("/local/images/userdoc/".$user->address_proof) : null,
        ]);
    }

    protected function credentials(Request $request)
    {
        $usernameInput = trim($request->{$this->username()});
        $usernameColumn = filter_var($usernameInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        return [$usernameColumn => $usernameInput, 'password' => $request->password];

    }

    private function getUserByEmail($emailAddress)
    {
        return User::firstOrNew([
            'email' => $emailAddress
        ]);
    }

    private function createNewUserFromEmail($emailAddress)
    {
        return User::create([
            'email' => $emailAddress
        ]);
    }
}
