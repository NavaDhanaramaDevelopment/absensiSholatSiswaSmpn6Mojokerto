<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'username',
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
        'password' => 'hashed',
    ];

    // ***** Relationship ***** //
    public function role()
    {
        return $this->belongsTo(Roles::class);
    }
    // ***** Relationship ***** //

        // Check Images
    public function getImage()
    {
        if(!$this->image || $this->image == null){
            return 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTa1DxUfQMzO1sop6bSYve0McW6ynr6zEgfwJFnuORImw&s';
        }

        return asset('backend/images/profile/'.$this->image);
    }
    // Check Images

    // CheckRole
    private function getUserRole()
    {
        return $this->role()->getResults();
    }

    private function checkRole($role)
    {
        return (strtolower($role) == strtolower($this->have_role->role)) ? true : false ;
    }

    public function hasRole($roles)
    {
        $this->have_role = $this->getUserRole();

        if (is_array($roles)) {
            foreach ($roles as $need_role) {
                if ($this->checkRole($need_role)) {
                    return true;
                }
            }
        } else {
            return $this->checkRole($roles);
        }
        return false;
    }
    // Check Role

    // ***** User Access ***** //
    public function hasAccess($moduleFunctionId){
        $userId = Auth::user()->role_id;
        $userAccess = UserAccess::where('module_function_id', $moduleFunctionId)
                        ->where('role_id', $userId)
                        ->first();
        if(!empty($userAccess) || !is_null($userAccess)){
            return true;
        }else{
            return false;
        }
    }
    // ***** User Access ***** //
}
