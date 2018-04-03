@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
         <div class="row row-header">
            <div class="col-xs-12">
                <ol class="breadcrumb">
				     <li><a href="home">Главная </a></li>
				     <li><a href="questionUnaMgt"> Админ </a></li>
				     <li class="active">Управление категориями </li>
			    </ol>
            </div>
        </div>
               <!-- Trigger the modal with a button -->
  <button style = "margin-left: 18px; margin-bottom: 15px;" type="button" class="btn btn-info btn-md" 
  data-toggle="modal" data-target="#myModal">  Добавить категорию </button>
        <div class="col-md-11">
            <div class="panel panel-default">
                <div class="panel-heading"><b class='tb_header'> Категории </b> </div>

                <div class="panel-body">
                    <table class='table table-hover'>
                     <thead>
                         <th>id</th>
                         <th>Название категории </th>
                         <th> Дата создания </th>
                         <th> Все вопросы </th>
                         <th> Отвеченные вопросы </th>
                         <th> Неотвеченные </th>
                         <th> Опции </th>
                     </thead>
                    <tbody>
                     @foreach ($data as $k => $v)
                     <tr>
                      <td> {{ $v['id'] }} </td> 
                     <td> {{ $v['name'] }}  </td>
                      <td>  {{ $v['date'] }}  </td>
                     <td>  {{ $v['all'] }}  </td>
                     <td>  {{ $v['ans'] }}  </td>
                     <td>  {{ $v['una'] }}  </td>
                     <td>
                     <a href="deleteTag/{{ $v['id'] }} / {{ $v['name'] }}"> Удалить  </a> 
                     </td>
                     </tr>
                     @endforeach
                      </tbody>
                    </table>
                    <div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h5 class="modal-title"> Введите новую категорию </h5>
        </div>
        <div class="modal-body">
        <form action="addTagname" method="post">
            <label for="tag"></label> </br>
            <input id="tag" name="tagname" type="text"> </input> &nbsp;  </br>
            <input type="hidden" name="_token" value="{!! csrf_token() !!}"> </br> 
            <button type="submit" class="btn btn-info btn-sm"> Сохранить</button> 
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
</div> 
<div>
@endsection
