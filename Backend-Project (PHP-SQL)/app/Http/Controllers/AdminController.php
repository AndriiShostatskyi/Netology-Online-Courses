<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Http\Requests;
use App\AdminMonitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

//error_reporting(E_ALL);
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    protected function adminMgt() // возвращает данные об админах
    {
        return view('adminMgt', ['data' => Admin::all()]);
    }
    
    protected function deleteAdmin($id, $name) // удаляет админа и возвращает назад
    {
         // удаляем другого админа из таблицы
         Admin::where('id', '=', $id)->delete();
         
         // журналируем действия этого админа
         $description = 'Удалил админа "'.$name.'".';
         AdminMonitor::adminActions($description);
         
         return redirect()->back();
    }
    
    protected function resetpass($id, $name, Request $request) // изменяет пароль админа и возвращает назад
    {
         // кодируем новый пароль и обновляем им старый пароль админа в таблице
         Admin::where('id', '=', $id)->update(['password'=> Hash::make($request->input('pass'))]);
         
          // журналируем действия админа
         $description = 'Изменил пароль админа "'.$name.'".';
         AdminMonitor::adminActions($description);
         
         return redirect()->back();
         
    }

    protected function createAdmin(Request $request) // создает нового админа и возвращает назад
    {
        // создаем нового админа
        Admin::create_admin($request->input('name'), $request->input('email'), $request->input('password'));
        
        // журналируем действия админа
         $description = 'Создал нового админа "'.$request->input('name').'".';
         AdminMonitor::adminActions($description);
        
         return redirect()->back();
    }
    
    protected function adminMonitor() // возвращает данные о зажурналированных действиях админа
    {
         return view('adminMonitor', ['data' =>  AdminMonitor::orderBy('id', 'desc')->get()]);
    }
    
}
