@extends('layouts.app')

@section('content')

<div class="container">
     
    <div class="row">
        <div class="row row-header">
            <div class="col-xs-12">
                <ol class="breadcrumb">
				     <li><a href="home">Главная </a></li>
				     <li><a href="questionUnaMgt"> Админ </a></li>
				     <li class="active">Отвеченные вопросы </li>
			    </ol>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"> <b class='tb_header'> Отвеченные вопросы </b> </div>

                <div class="panel-body">
                     <table class='table table-hover'>
                     <thead>
                         <th>id</th>
                         <th>Вопрос</th>
                         <th> Автор </th>
                         <th> Дата </th>
                         <th> Ответ </th>
                         <th> Категория </th>
                         <th> Видимость </th>
                         <th> Опции </th>
                     </thead>
                    <tbody>
                     @foreach ($data as $item)
                     <tr>
                      <td> {{ $item->id }} </td> 
                     <td style="width: 29%;"> {{ $item->question }}  </td>
                     <td>  {{ $item->author }}  </td>
                     <td> {{ $item->created_at }} </td>
                     <td style="width: 29%;">  {{ $item->answer }}  </td>
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
