<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Admin;
use Validator;
use Illuminate\Http\Request;
error_reporting(E_ALL);
class Admin extends Authenticatable
{

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    protected static function create_admin($name, $email, $pass) // создает нового админа
    {
         $data = array(  // собыраем данные 
            'name' => $name,
            'email' => $email,
            'password' => $pass
            );
            
        Validator::make($data, [     // проверяем данные 
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        
        Admin::create([   // создаем админа
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
