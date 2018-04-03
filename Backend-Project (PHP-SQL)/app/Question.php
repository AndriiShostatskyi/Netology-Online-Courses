<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Api;
error_reporting(E_ALL);
class Question extends Model
{
    protected function getUnsQuestions() // возвращает список неотвеченных вопросов, подгружает вопросы с Telegram
    {
        // сначала проверяю наличие вопросов из Telegram и, если такие есть, добавляю их в таблицу вопросов
        
        /* Для проверки вопросов из Телеграмма есть таблица telegram. Там сохраняю айдишкники 
         уже полученных вопросов. Сравниваю json-апдейт от Телеграма, если там есть айдишники больше 
         тех, которые у мене в таблице telegram, подгружаю их вопросы */
         
         $last_update = DB::table('telegram')->orderBy('id', 'desc')->first(); 
         require $_SERVER['DOCUMENT_ROOT']."/laravel/vendor/autoload.php";
         $telegram = new Api('257019768:AAFQAKGyP3vpXmfZGTxTXq5JzdJyPPq9BNk');
         $response = $telegram->getUpdates();  
         
         foreach ($response as $k=>$v) 
         {
             foreach($v as $value )
             {
                 if(is_int($value)) continue;
                 if($value['message_id'] > $last_update->id && isset($value['text']))
                 {
                     $question = new Question;
                     $question->author = $value['from']['first_name']." ".$value['from']['last_name'];
                     $question->question =  $value['text'];
                     $question->tag = 'Другое';
                     $question->telegram = 1;
                     $question->telegram_chat = $value['chat']['id'];
                     $question->save();
                     
                     DB::table('telegram')->insert(['id' => $value['message_id']]);
                 }
                 
             }
         }
         
         // подгружаю все неотвеченные вопросы
         $data = Question::where('answered', '=', 0)->orderBy('id', 'asc')->get();
         
         return $data;
    }
}
