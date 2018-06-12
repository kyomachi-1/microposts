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
}
