@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-default">
                <div class="panel-heading"> <b class='tb_header'> Управление админами </b> </div>
                <div class="panel-body">
                    <table class='table table-hover'>
                     <thead>
                         <th>id</th>
                         <th>Имя</th>
                         <th>Эл. почта</th>
                         <th>Пароль</th>
                         <th>Опции</th>
                     </thead>
                    <tbody>
                     @foreach ($data as $item)
                     <tr>
                     <td> {{ $item->id }} </td> 
                     <td> {{ $item->name }}  </td>
                     <td>  {{ $item->email }}  </td>
                     <td>  {{ $item->password }}  </td>
                     <td>
                     <a href="deleteAdmin/{{ $item->id }}/{{ $item->name }}"> Удалить  </a> |
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $item->id }}"> Изменить пароль </a>
                         <div id="collapse{{ $item->id }}" class="panel-collapse collapse">
                             <form action="resetpass/{{ $item->id }} / {{ $item->name}}" method="post">
                                  <input type="password"name="pass"> </input>
                                   <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                  <button type="submit" name="reset"> Сохранить </button> 
                             </form>
                         </div>
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
@endsection
