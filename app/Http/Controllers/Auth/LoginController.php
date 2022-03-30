<?php

namespace App\Http\Controllers\Auth;

use App\Services\UserStravaService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthCreateRequest;
use App\Providers\RouteServiceProvider;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /* @var UserService */
    protected $userService;

    /* @var UserStravaService */
    protected $userStravaService;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct(UserService $userService, UserStravaService $userStravaService)
    {
        $this->userService       = $userService;
        $this->userStravaService = $userStravaService;
        $this->middleware('guest')->except('logout');
    }

    public function redirectToGoogleProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleProviderCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login');
        }

        if (explode('@', $googleUser->email)[1] !== 'before.com.br') {
            return redirect()->route('login');
        }

        Storage::disk('public')->put('avatars/' . $googleUser->id, file_get_contents
        ($googleUser->avatar_original), 'public');
        $avatarUrl = Storage::url('avatars/' . $googleUser->id);

        try {
            $user = $this->userService->findUserBy(['email' => $googleUser->email]);

            if (empty($user->api_token)) {
                $user->api_token = Str::random(60);
            }

            $this->userService->update($user, [
                'id'            => $user->id,
                'active'        => true,
                'email'         => $googleUser->email,
                'google_id'     => $googleUser->id,
                'google_avatar' => $avatarUrl,
                'updated_at'    => Carbon::now('UTC'),
                'api_token'     => $user->api_token
            ]);
        } catch (\Exception $exception) {
            $user = $this->userService->create([
                'active'        => true,
                'name'          => $googleUser->name,
                'email'         => $googleUser->email,
                'password'      => Hash::make(''),
                'google_id'     => $googleUser->id,
                'google_avatar' => $avatarUrl,
                'api_token'     => Str::random(60),
                'created_at'    => Carbon::now('UTC')
            ]);
        }

        auth()->login($user, true);
        return redirect()->route('home');
    }

    public function register(AuthCreateRequest $request)
    {
        $this->userService->create([
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'password'  => Hash::make($request->get('password')),
            'api_token' => Str::random(60),
        ]);

        return redirect()->route('home');
    }

}
