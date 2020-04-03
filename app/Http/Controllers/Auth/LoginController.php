<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider( $channel )
    {
        return Socialite::driver($channel)->redirect();
    }

    /**
     * Obtain the user information from Twitter.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (Exception $e) {
            return redirect('auth/google');
        }
        
        $authUser = $this->findOrCreateUser($user, 'google');

        Auth::login($authUser, true);

        return redirect('/');
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGithubCallback()
    {
        try {
            $user = Socialite::driver('github')->user();
        } catch (Exception $e) {
            return redirect('auth/github');
        }
        
        $authUser = $this->findOrCreateUser($user, 'github');

        Auth::login($authUser, true);

        return redirect('/');
    }

    /**
     * Obtain the user information from Twitter.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleTwitterCallback()
    {
        try {
            $user = Socialite::driver('twitter')->user();
        } catch (Exception $e) {
            return redirect('auth/twitter');
        }
        
        $authUser = $this->findOrCreateUser($user, 'twitter');

        Auth::login($authUser, true);

        return redirect('/');
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (Exception $e) {
            return redirect('auth/facebook');
        }
        
        $authUser = $this->findOrCreateUser($user, 'facebook');

        Auth::login($authUser, true);

        return redirect('/');
    }

    public function randomUsername( $username )
    {
        $newname = $username.mt_rand(0,10000);

        if ( User::where('nickname', $newname)->first() ) {
            randomUsername($username);
        } else {
            return $newname;
        }
    }

    public function findOrCreateUser($user, $channel)
    {

        if( $authUser = User::where('email', $user->email)->first() ) {
            return $authUser;
        }

        if ( $user->nickname === null || User::where('nickname', $user->nickname)->first() ) {
            $nickname = $this->randomUsername(strtolower(explode(' ', $user->name)[0]));
        } else {
            $nickname = $user->nickname;
        }
        
        if ( "google" === $channel ) {
            return User::create([
                'auth_id' => $channel . '-' . $user->id,
                'name' => $user->name,
                'nickname' => $nickname,
                'email' => $user->email,
                'avatar' => $user->avatar
            ]);
        }

        if ( "github" === $channel ) {
            return User::create([
                'auth_id' => $channel . '-' . $user->id,
                'name' => $user->name,
                'nickname' => $nickname,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'company' => $user->user['company'],
                'location' => $user->user['location'],
                'website' => $user->user['blog'],
                'bio' => $user->user['bio'],
            ]);
        }

        if ( "twitter" === $channel ) {
            return User::create([
                'auth_id' => $channel . '-' . $user->id,
                'name' => $user->name,
                'nickname' => $nickname,
                'email' => $user->email,
                'avatar' => $user->avatar_original,
                'location' => $user->user['location'],
                'website' => $user->user['url'],
                'bio' => $user->user['description'],
            ]);
        }

        if ( "facebook" === $channel ) {
            return User::create([
                'auth_id' => $channel . '-' . $user->id,
                'name' => $user->name,
                'nickname' => $nickname,
                'email' => $user->email,
                'avatar' => $user->avatar
            ]);
        }
        
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }
}