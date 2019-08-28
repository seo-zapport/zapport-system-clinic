<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'emp_number', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id');
    }

    public function user_roles()
    {
        return $this->belongsToMany(User_role::class, 'user_roles', 'use_id', 'role_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function medicine()
    {
        return $this->hasMany(Medicine::class, 'user_id');
    }

    public function employeesMedical()
    {
        return $this->hasMany(Employeesmedical::class, 'user_id');
    }

    public function addMeds(Medicine $medicine)
    {
        return $this->medicine()->save($medicine);
    }

    public function employeesMedicals()
    {
        return $this->belongsToMany(Employeesmedical::class, 'employeesmedical_medicine_users', 'user_id')->withPivot('quantity')->withTimestamps();
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'employeesmedical_medicine_users', 'user_id')->withPivot('quantity')->withTimestamps();
    }

    public function medias()
    {
        return $this->hasMany(Media::class);
    }

    public function addMedia(Media $media)
    {
        $this->medias()->save($media);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function published(Post $post)
    {
        $this->posts()->save($post);
    }

}
