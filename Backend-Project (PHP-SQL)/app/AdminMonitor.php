<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

//error_reporting(E_ALL);
class AdminMonitor extends Model
{
    protected $table = 'admin_monitors';
    
    protected static function adminActions($description) // журналирует действия админа через модель Admin_monitor - использую во всех остальных контроллерах
    {
          $admin_monitor = new AdminMonitor;
          $admin_monitor->name = Auth::user()->name;
          $admin_monitor->description = $description;
          $admin_monitor->save();
    }
}
