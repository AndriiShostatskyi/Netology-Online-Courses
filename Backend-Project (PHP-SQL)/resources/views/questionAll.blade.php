@extends('layouts.app')

@section('content')

<div class="container">
     
    <div class="row">
     <div class="row row-header">
            <div class="col-xs-12">
                <ol class="breadcrumb">
				     <li><a href="home">Главная </a></li>
				     <li><a href="questionUnaMgt"> Админ </a></li>
				     <li class="active"> Все вопросы </li>
			    </ol>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"> <b class='tb_header'> Все вопросы </b> </div>

                <div class="panel-body">
                     <table class='table table-hover'>
                     <thead>
                         <th>id</th>
                         <th>Вопрос</th>
                         <th> Автор </th>
                         <th> Ответ </th>
                         <th> Дата </th>
                         <th> Категория </th>
                         <th> Видимость </th>
                         <th> Опции </th>
                     </thead>
                    <tbody>
                     @foreach ($data as $item)
                     <tr>
                      <td> {{ $item->id }} </td> 
                     <td style="width: 30%;">  
                     <a data-toggle="collapse" data-parent="#accordion" 
                     href="#collapse{{ $i}}"> {{ $item->question }} </a> 
                      <div id="collapse{{ $i}}" class="panel-collapse collapse">
                             <form action="questionChange/{{ $item->id }}/{{ $item->question}}" method="post">
                                  <textarea type="text" id ="question" name="question"  rows="8" cols="50"> {{ $item->question }}  </textarea> </br>
                                   <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                  <button type="submit" name="submitauthor"> Изменить вопрос </button> 
                             </form> 
                         </div>
                     </td>
                     <td> <a data-toggle="collapse" data-parent="#accordion" 
                     href="#collapse{{ $i+1}}"> {{ $item->author }} </a> 
                      <div id="collapse{{ $i+1}}" class="panel-collapse collapse">
                             <form action="authorChange/{{ $item->id }}/{{ $item->author }}" method="post">
                                  <input type="text" id ="author" name="author" value="{{ $item->author }}">  </input> </br>
                                   <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                  <button type="submit" name="submitauthor"> Изменить автора</button> 
                             </form>
                         </div>
                     </td>
                       <td> <a data-toggle="collapse" data-parent="#accordion" 
                     href="#collapse{{ $i+2}}"> {{ $item->answer }} </a> 
                      <div id="collapse{{ $i+2}}" class="panel-collapse collapse">
                             <form action="answerChange/{{ $item->id }} / {{ $item->answer }}" method="post">
                                 <textarea type="text" id ="answer" name="answer" rows="8" cols="50"> {{ $item->answer }} </textarea></br>
                                   <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                  <button type="submit" name="submitanswer"> Изменить ответ </button> 
                             </form>
                         </div>
                     </td>
                     <td> {{ $item->created_at }} </td>
                     <td>  {{ $item->tag }}  </td>
                     <td>  {{ $item->visible }}  </td>
                     <td>
                     <a href="deleteQuestion/{{ $item->id }}/{{ $item->tag }}"> Удалить  </a> |
                     <a href="makeNonVisible/{{ $item->id }}"> Невидимый  </a> |
                     <a href="makeVisible/{{ $item->id }}"> Видимый  </a> | 
                     <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $item->id+1 }}"> Категория </a>
                         <div id="collapse{{ $item->id+1 }}" class="panel-collapse collapse">
                               <form action="changeAnsQuestionTag/{{ $item->id}} /{{$item->tag }}"  method="POST">    
                                   <label for="Tag"> Выбрать категорию: </label> 
                                   <select id ="Tag"  name="newtag">
                                        @foreach ($tags as $item)
                                        <option> {{ $item->name }} </option>
                                        @endforeach
                                   </select> 
                                   <input type="submit" name="submit" value="Присвоить"> 
                                   <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                               </form>
                        </div> 
                     </td>
                      <?php $i+=4; ?>
                     </tr>
                     @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
  </div>
</div>

@endsection
