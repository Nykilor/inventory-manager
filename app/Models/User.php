<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getCategoryAccessAttribute()
    {
        return $this->categoryAccess()->get(['create', 'read', 'update', 'category_id']);
    }

    public function categoryAccess()
    {
        return $this->hasMany('App\Models\CategoryAccess', 'users_id');
    }

    public function person()
    {
        return $this->hasOne('App\Models\Person');
    }

    /**
     * Returns array of category_id's that the given user has the privilege to use given action on
     * @param string $action Either value of [write, read, update]
     * @param bool $toArray Returns array or collection
     * @throws \Exception
     */
    public function getUserCategoryAccess(string $action = 'read', $toArray = true)
    {
        if(!in_array($action, ['create', 'read', 'update'])) {
            throw new \Exception("Only 'create', 'read' or 'update' parameter is accepted");
        }

        //If the user is a super_user he can access any category
        if($this->super_user) {
            if($toArray) {
                return Category::all()->pluck('id')->toArray();
            } else {
                return Category::all();
            }

        }

        list($user_category_access) = $this->getCategoryAccessAttribute()->partition(function($entry) use($action) {
            return $entry->$action;
        });

        if($toArray) {
            return $user_category_access->pluck('category_id')->toArray();
        } else {
            return $user_category_access;
        }
    }
}
