@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row"> 
    <div class="row row-header">
            <div class="col-xs-12">
                <ol class="breadcrumb">
				     <li><a href="home">Главная </a></li>
				     <li><a href="questionUnaMgt"> Админ </a></li>
				     <li class="active"> Журнал действий админа</li>
			    </ol>
            </div>
        </div>
        <div class="col-md-11">
            <div class="panel panel-default">
                <div class="panel-heading"> <b class='tb_header'> Журнал действий админа </b></div>
                <div class="panel-body">
                    <table class='table table-hover'>
                     <thead>
                         <th>Дата</th>
                         <th>Админ</th>
                         <th>Действие</th>
                     </thead>
                    <tbody>
                     @foreach ($data as $item)
                     <tr>
                     <td> {{ $item->created_at }}  </td>
                     <td>  {{ $item->name }}  </td>
                     <td style='width: 75%'>  {{ $item->description }}  </td>
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
