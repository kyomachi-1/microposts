<?php

namespace App;

use Illuminate\Notifications\Notifiable;

// Illuminate\Notifications\Notifiable（トレイト）
// Illuminate\Notifications\ は名前空間
// Notifiable はトレイト
// どうしてそうなるかは
// Illuminate\Notifications を Laravel API サイトで確認すると Namespace となっており、
// Illuminate\Notifications\Notifiable で確認すると Trait となっているからです。

// ここでのコードの意味は、Illuminate\Notifications\Notifiable トレイトを
// 名前空間 App では、Notifiable と省略して使うよということです。

use Illuminate\Foundation\Auth\User as Authenticatable;

// Illuminate\Foundation\Auth の中の User クラスを Authenticatable という名前で承継。

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
    }

    public function follow($userId)
    {
    // 既にフォローしているかの確認
    $exist = $this->is_following($userId);
    // 自分自身ではないかの確認
    $its_me = $this->id == $userId;

    if ($exist || $its_me) {
        // 既にフォローしていれば何もしない
        return false;
    } else {
        // 未フォローであればフォローする
        $this->followings()->attach($userId);
        return true;
    }
    }

    public function unfollow($userId)
    {
    // 既にフォローしているかの確認
    $exist = $this->is_following($userId);
    // 自分自身ではないかの確認
    $its_me = $this->id == $userId;

    if ($exist && !$its_me) {
        // 既にフォローしていればフォローを外す
        $this->followings()->detach($userId);
        return true;
    } else {
        // 未フォローであれば何もしない
        return false;
    }
    }

    public function is_following($userId) {
    return $this->followings()->where('follow_id', $userId)->exists();
    }
    public function feed_microposts()
    {
        $follow_user_ids = $this->followings()-> pluck('users.id')->toArray();
        $follow_user_ids[] = $this->id;
        return Micropost::whereIn('user_id', $follow_user_ids);
    }

    public function favoriteMicroposts()
    {
        return $this->belongsToMany(Micropost::class, 'favorites', 'user_id', 'micropost_id')->withTimestamps();
    }

    public function favorite($micropostId)
    {
    // 既にお気に入りにしているかの確認
    $exist = $this->isFavorite($micropostId);

    if ($exist) {
        // 既にお気に入りにしていれば何もしない
        return false;
    } else {
        // お気に入りにされていなければ、お気に入りに追加する
        $this->favoriteMicroposts()->attach($micropostId);
        return true;
    }
    }

    public function unfavorite($micropostId)
    {
    // 既にお気に入りにしているかの確認
    $exist = $this->isFavorite($micropostId);

    if ($exist) {
        // 既にお気に入りにしていれば、お気に入りを外す
        $this->favoriteMicroposts()->detach($micropostId);
        return true;
    } else {
        // 既にお気に入りを外していれば、何もしない
        return false;
    }
    }
    public function isFavorite($micropostId) {
    return $this->favoriteMicroposts()->where('micropost_id', $micropostId)->exists();
    }

    public function feed_favoriteMicroposts()
    {
        $favorite_micropost_ids = $this->favoriteMicroposts()-> pluck('favorites.micropost_id')->toArray();
        $favorite_micropost_ids[] = $this->id; 
        return Micropost::whereIn('id', $favorite_micropost_ids);
    }


}
