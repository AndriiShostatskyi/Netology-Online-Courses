@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="row row-header">
            <div class="col-xs-12">
                <ol class="breadcrumb">
				     <li><a href="home">Главная </a></li>
				     <li><a href="questionUnaMgt"> Админ </a></li>
				     <li class="active">Запрещенные слова </li>
			    </ol>
            </div>
        </div>
               <!-- Trigger the modal with a button -->
  <button style = "margin-left: 18px; margin-bottom: 15px;" type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal"> Добавить новое слово </button>
        <div class="col-md-11">
            <div class="panel panel-default">
                <div class="panel-heading"> <b class='tb_header'>Запрещенные слова</b></div>

                <div class="panel-body">
                    <table class='table table-hover'>
                     <thead>
                         <th>id</th>
                         <th> Слово <th>
                         <th>  </th>
                     </thead>
                    <tbody>
                     @foreach ($data as $item)
                     <tr>
                      <td> {{ $item->id }} </td> 
                     <td> {{ $item->word}}  </td>
                     <td style='text-align: center'>
                     <a href="deleteWord/{{ $item->id }} / {{ $item->word }}"> Удалить  </a> 
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
          <h5 class="modal-title"> Введите новое запрещенное слово  </h5>
        </div>
        <div class="modal-body">
        <form action="addWord" method="post">
            <label for="word"></label> </br>
            <input id="word" name="word" type="text"> </input> </br>
            <input type="hidden" name="_token" value="{!! csrf_token() !!}"> </br> 
            <button type="submit" class="btn btn-info btn-md"> Сохранить</button> 
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
