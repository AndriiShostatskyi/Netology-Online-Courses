@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="row row-header">
            <div class="col-xs-12">
                <ol class="breadcrumb">
				     <li><a href="home">Главная </a></li>
				     <li class="active"> Форма для вопроса </li>
			    </ol>
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"> <b class='tb_header'> Форма для вопроса </b> </div>
                    <div class="panel-body">
                         <form action="asked"  method="POST">
                                <table>    
                                       <tr> 
                                           <td> <label for="Name"> Имя </label> &nbsp;&nbsp; &nbsp;&nbsp;</td> 
                                             <td>
                     <input id ="Name" name="name" required> </br> </br>
                      </td></tr>
                      <tr> <td>
                     <label for="email"> Эл. почта </label> &nbsp;&nbsp; &nbsp;&nbsp; 
                      </td> <td>
                     <input id ="email" name="email" required> </br> </br>
                       </td></tr>
                     <tr> <td>
                     <label for="Tag"> Категория </label> 
                       </td> <td>
                     <select id ="Tag"  name="tag">
                         @foreach ($data as $item)
                          <option> {{ $item->name }} </option>
                         @endforeach
                     </select> </br> </br>
                       </td></tr>
                        <tr> <td>
                     <label for="Question"> Вопрос  </label> 
                      </td> <td>
                     <textarea type="text" id ="Question" name="question" rows="8" cols="100" required></textarea> </br>
                     <input type="submit" name="submit" value="Спросить"> 
                     <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                      </td></tr>
                      </table>
                     </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
