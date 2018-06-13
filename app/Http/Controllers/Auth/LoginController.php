<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

    /* logout アクション以外では guest である必要があるという条件を持ったミドルウェアが設定されています。
        guest とは、ログイン認証されていない閲覧者のことです。
        つまり、 logout アクション以外ではログイン認証されていないことが必要という条件です。
        これを満たさない（既にログインしているのに login アクションにアクセスした場合など）は、
        指定のリダイレクト先へ飛ばされます。*/
    }
}
