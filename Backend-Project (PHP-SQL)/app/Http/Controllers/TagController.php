<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Tag;
use App\AdminMonitor;
use App\Question;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//error_reporting(E_ALL);
class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function index() // возвращает список всех категорий и статистику вопросов по ним
    {
        return view('tagMgt', ['data' =>Tag::tagStatistics()]);
    }
    
    protected function addTagName(Request $request) // добавляет новую категорию и возвращает назад
    {
         // добавляем назву категории в таблицу
         Tag::add_tag($request->input('tagname'));
         
         // журналируем действия админа
         $description = 'Добавил новую категорию "'.$request->input('tagname').'".';
         AdminMonitor::adminActions($description);
         
         return redirect()->back();
    }
    
    protected function deleteTag($id, $name) // удаляет категорию c ее вопросами и возвращает назад
    {
         // удаляем категорию из таблицы категорий
         Tag::delete_tag($id);
         
         // удаляем вопросы данной категории из таблицы вопросов
         Question::where('tag', '=', $name)->delete();
         
         // журналируем действия админа
         $description = 'Удалил категорию "'.$name.'" c ее вопросами.';
         AdminMonitor::adminActions($description);
         
         return redirect()->back();
    }
    
}
