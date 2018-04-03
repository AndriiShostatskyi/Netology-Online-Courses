<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Question;
use App\Tag;
use App\Сensor;

error_reporting(E_ALL);
class Home extends Model
{
    protected $table = 'questions';
    
    public static function saveQuestion($name, $question, $tag, $email)  // проверяет и сохраняет вопрос
    {
         date_default_timezone_set("Europe/Moscow");
         
         $words = Censor::all(); // берем все запрещенные слова
         $matchWords=""; // найденные запрещенные слова
         $cnt=0; // количество найденных запрещенных слов 
         
         foreach ($words as $word) // проверка наличия в вопросе запрещенных слов
         {
             if (preg_match("/".$word->word."/i", $question)) 
             {
                 $matchWords .= ", ".$word->word;
                 $cnt++;
             }
         }
         
         if ($cnt>0)
         {
             $censored = 1; // флаг, что вопрос заблокированный
         } else $censored = 0; // флаг, что вопрос незаблокированный
         
         // сохраняем данные в таблицу вопросов
         $questions = new Question;
         $questions->author = $name;
         $questions->question = $question;
         $questions->tag = $tag;
         $questions->censored = $censored;
         $questions->censored_words = $matchWords;
         $questions->email = $email;
         $questions->save();
    }
}
