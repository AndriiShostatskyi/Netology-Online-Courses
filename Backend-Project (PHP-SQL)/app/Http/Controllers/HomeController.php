<?php

namespace App\Http\Controllers;

use App\Question;
use App\Tag;
use App\Home;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

//error_reporting(E_ALL);
class HomeController extends Controller
{
    public function index() // возвращает список отвеченных вопросв и другую информацию о них из таблицы questions
    {
        $tags = array();
        $data = array();
        $taglist = Tag::all();
        foreach ($taglist as $tag)
        {
            $tags [] = $tag->name;
            $data [$tag->name] = Question::where('tag', '=', $tag->name)
            ->where('answered', '=', 1)
            ->where('visible', '=', 1)
            ->where('censored', '=', 0)->get();
        }
        
        return view('/home', compact('tags', $tags, 'data', $data));
    }
    
    public function askQuestion() // возвращает список категорий для формы вопроса
    {
         return view('ask', ['data' => Tag::all()]);
    }
    
    public function askedQuestion(Request $request) // сохраняет вопрос в талицу вопросов и возвращает назад
    {
         Home::saveQuestion($request->input('name'), $request->input('question'), $request->input('tag'), $request->input('email'));
         
         return redirect()->back();
    }
    
    
}
