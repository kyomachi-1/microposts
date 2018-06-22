<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; // 追加
use App\Micropost; // 追加

class FavoritesController extends Controller
{
public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $favoriteMicroposts = $user->feed_favoriteMicroposts()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'user' => $user,
                'favoriteMicroposts' => $favoriteMicroposts,
            ];
             $data += $this->counts($user);
        }
        return view('users.favorites', $data);
    }
    public function store(Request $request, $id)
    {
        \Auth::user()->favorite($id);
        return redirect()->back();
    }

    public function destroy($id)
    {
        \Auth::user()->unfavorite($id);
        return redirect()->back();
    }
}
