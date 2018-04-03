<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

error_reporting(E_ALL);
class Tag extends Model
{
    // 
    protected function tagStatistics() // возвращает список категорий с статистикой вопросов по каждой из категорий
    {
        $arr = array(); 
        $data = Tag::all();
        foreach($data as $tag) // для каждой категории считает вопросы (с ответом, без него и все вместе)
        {
            $que = DB::table('questions')->where('tag','=', $tag->name)->get(); // подгружаем таблицу с вопросами
            $all= count($que);// все вопросы
            $una = 0; // вопросы без ответа
            foreach ($que as $v)
            {
                if($v->answered==0) $una++;
            }
            $ans = $all-$una; // вопросы с ответом 
            $arr[] = array( // массив данных (категории и статистика по ним) для передачи контроллеру
                'id' =>$tag->id,
                'name' =>$tag->name,
                'date' =>$tag->created_at,
                'all' =>$all,
                'una'=>$una,
                'ans'=>$ans,
                );
         }
         return $arr;
    }
    
    protected static function add_tag($name) // добавляет новую категорию
    {
         $add_word = new Tag;
         $add_word->name = $name;
         $add_word->save();
    }
    
    protected static function delete_tag($id) // удаляет категорию
    {
         Tag::where('id', '=', $id)->delete();
    }
    
}
