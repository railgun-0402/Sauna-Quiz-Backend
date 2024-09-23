<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * ユーザの情報を編集するメソッド
     * 
     * @param mixed $userName
     * @param mixed $introduction
     * @param mixed $sex
     * 
     * @return void
     */
    public function editUsersData($userName, $introduction, $sex)
    {
        try {
            // ID取得
            $id = Auth::id();
            $userData = User::find($id);

            // データ登録
            $userData->name = $userName;                 // ユーザ名
            $userData->introduction = $introduction;     // 自己紹介
            $userData->sex = $sex;                       // 性別
            
            DB::beginTransaction();
            
            // 編集を反映
            $userData->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("");
        }
    }


    /**
     * IDに紐づくユーザ情報取得
     * 
     * @return User|void
     */
    public function getUserDataWithID()
    {
        try {
            $id = Auth::id();
            $userData = User::find($id);

            if ($userData) {
                return $userData;
            } else {
                // ユーザが見つからなかった場合の処理
                // TODO: ユーザがない場合は404が返るので、404ページを作成次第遷移させる
                $this->error("User not found");
            }
        } catch (\Exception $e) {
            $this->error("");
        }
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'is_admin',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}