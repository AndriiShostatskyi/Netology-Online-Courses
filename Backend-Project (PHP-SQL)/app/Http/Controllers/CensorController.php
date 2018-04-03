<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Validator;
use App\AdminMonitor;
use App\Censor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

//error_reporting(E_ALL);
class CensorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function index() // возвращает все заблокированные вопросы
    {
        return view('censorMgt', ['data' => Censor::all()]);
    }
    
    protected function addWord(Request $request) // вводит новое запрещенное слово и возвращает назад
    {
         // добавляем новое запрещенное сдово в таблицу
         $censor = new Censor;
         $censor->word = $request->input('word');
         $censor->save();
        
          // журналируем действия админа
         $description = 'Добавил новое запрещенное слово "'.$request->input('word').'".';
         AdminMonitor::adminActions($description);
         
         return redirect()->back();
    }
    
    protected function deleteWord($id, $word) // удаляет запрещенное слово и возвращает назад
    {
         // удаляем запрещенное слово из таблицы
         $word_delete = Censor::find($id);
         $word_delete->delete();
        
          // журналируем действия админа
         $description = 'Удалил запрещенное слово "'.$word.'".';
         AdminMonitor::adminActions($description);
         
         return redirect()->back();
    }
    
 
    
    
}
