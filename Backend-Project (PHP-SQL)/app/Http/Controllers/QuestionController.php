<?php

namespace App\Http\Controllers;

use Auth;
use App\AdminMonitor;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Question;
use App\Tag;
use Telegram\Bot\Api;
//error_reporting(E_ALL);

class QuestionController extends Controller
{
    
    public function __construct() 
    {
        $this->middleware('auth');
    }
    
    public function questionsAll() // возвращает список всех вопросов и другую информацию о них
    {
         return view('questionAll', ['data' => Question::orderBy('id', 'desc')->get(), 'tags' => Tag::all(), 'i' => 0]);
    }

    protected function questionsUnsMgt() // возвращает список неотвеченных вопросов и другую информацию о них
    {    
         return view('questionUnaMgt', ['data' => Question::getUnsQuestions(), 'tags' => Tag::all(), 'i'=> 0]);
    }
    
    protected function questionsCenosred() // возвращает список заблокированных вопросов и другую информацию о них
    {
         return view('questionCensored', ['data' => Question::where('censored', '=', 1)->get(), 'tags' => Tag::all()]);
    }
    
    protected function deleteQuestion($id, $tag) // удаляет вопрос и возвращает назад
    {
          // удаляем из таблицы
          Question::where('id', '=', $id)->delete();
    
          // журналируем действие админа
          $description = 'Удалил вопрос № '.$id.' в категории "'.$tag.'"';
          AdminMonitor::adminActions($description);
          
          return redirect()->back();
    }
    
    protected function makeNonVisible($id) // делает вопрос невидимым для пользователей
    {
          // в таблице напротив вопроса ставим флаг, что он невидимый для пользователей
          Question::where('id', '=', $id)->update(['visible'=>0]);
          
          // журналируем действие админа
          $description = 'Сделал вопрос № '.$id.' невидимым.';
          AdminMonitor::adminActions($description);
          
          return redirect()->back();
    }
    
    protected function makeVisible($id) // делает вопрос видимым для пользователей
    {
          // в таблице напротив вопроса ставим флаг, что он видимый для пользователей
          Question::where('id', '=', $id)->update(['visible'=>1]);
          
          // журналируем действие админа
          $description = 'Сделал вопрос № '.$id.' видимым.';
          AdminMonitor::adminActions($description);
          
          return redirect()->back();
    }
    
    protected function answer($id, $tag, Request $request) // сохраняет ответ на вопрос и возвращает назад
    {
        // сохраняем ответ и ставим флаг, что вопрос имеет ответ
        Question::where('id', '=', $id)->update(['answer'=>$request->input('answer'), 'answered'=>1]); 

        // проверка, с Telegram ли вопрос, и, если да, отправка ответа в Telegram
        $get = Question::find($id);
        if($get->telegram==1)
        {
            $telegram = new Api('257019768:AAFQAKGyP3vpXmfZGTxTXq5JzdJyPPq9BNk');
            $response = $telegram->sendMessage([
                'chat_id' => $get->telegram_chat, 
                'text' => 'Здравствуйте '.$get->author.'. Мы разместили ответ на Ваш вопрос 
                 на http://sdf-andriish.c9users.io/laravel/public/home в категории
                 "'.$tag.'". '.$request->input('answer'),
            ]);
        }
        
        // журналируем действие админа
        $description = 'Ответил на вопрос № '.$id.' в категории "'.$tag.'".';
        AdminMonitor::adminActions($description);
        
        return redirect()->back();
    }
    
    protected function questionAnsMgt() // возвращает все отвеченные вопросы, ответы и другую информацию 
    {
         return view('questionAnsMgt', ['data' =>Question::where('answered', '=', 1)->orderBy('id', 'desc')->get(), 'tags' => Tag::all()]);
    }
    
    protected function changeUnaQuestionTag($id, $tag, Request $request) // изменят категорию неотвеченного вопроса  возвращает назад
    {
         // присваиваем новую категорию
         Question::where('id', '=', $id)->update(['tag'=>$request->input('newtag')]);
         
         // журналируем действия админа
         $description = 'Перенес вопрос № '.$id.' из категории "'.$tag.'" в категорию "'.$request->input('newtag').'".';
         AdminMonitor::adminActions($description);
         
         return redirect()->back();
    }
    
    protected function changeAnsQuestionTag($id, $tag, Request $request) // изменяет категорию отвеченного вопроса и возвращает назад
    {
        // присваиваем новую категорию
         Question::where('id', '=', $id)->update(['tag'=>$request->input('newtag')]);
         
         // журналируем действия админа
         $description = 'Перенес вопрос № '.$id.' из категории "'.$tag.'" в категорию "'.$request->input('newtag').'".';
         AdminMonitor::adminActions($description);
         
         return redirect()->back();
    }
    
    protected function authorChange($id, $author, Request $request) // изменяет автора вопроса и возвращает назад
    {
         // изменяем вопрос
         Question::where('id', '=', $id)->update(['author'=>$request->input('author')]);
         
         // журналируем действия админа
         $description = 'Заменил автора вопроса № '.$id.' ('.$author.') на '.$request->input('author').'';
         AdminMonitor::adminActions($description);
        
         return redirect()->back();
    }
    
    protected function questionChange($id, $question, Request $request) // изменяет вопрос и возвращает назад
    {
         // изменяем вопрос
         Question::where('id', '=', $id)->update(['question'=>$request->input('question')]);
         
          // журналируем действия админа
         $description = 'Изменил вопрос № '.$id.' с "'.$question.'" на "'.$request->input('question').'".';
         AdminMonitor::adminActions($description);
    
         return redirect()->back();
    }
    
    protected function answerChange($id, $answer, Request $request) // изменяет ответ и возвращает назад
    {
         // изменяем ответ
         Question::where('id', '=', $id)->update(['answer'=>$request->input('answer')]);
         
          // журналируем действия админа
         $description = 'Изменил ответ на вопрос № '.$id.' с "'.$answer.'" на "'.$request->input('answer').'".';
         AdminMonitor::adminActions($description);
    
         return redirect()->back();
    }
    
    protected function allowQuestion($id, $tag) // разблокирует вопрос и возвращает назад
    {
         // в таблице напротив вопроса ставим флаг, что он разблокированный
         Question::where('id', '=', $id)->update(['censored'=>0]);
         
          // журналируем действия админа
         $description = 'Разблокировал вопрос № '.$id.' в категории "'.$tag.'".';
         AdminMonitor::adminActions($description);
         
         return redirect()->back();
    }
    
}