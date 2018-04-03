@extends('layouts.app')
@section('content')
<body data-spy="scroll" data-target="#myScrollspy" data-offset="200">
    
 <div class="col-sm-2 col-sm-push  col-md-2 col-md-push-1">
 	<nav class="hidden-xs" id="myScrollspy">
</br>
<ul class="nav nav-pills nav-stacked "  data-spy="affix" data-offset-top="200">
    	@foreach ($tags as $tag)
      	<li><a href="#{{ $tag }}"> {{ $tag }} </a></li>
      	@endforeach
	</ul> <!-- cd-faq-categories -->
</nav>

</div>

<div class="col-sm-6 col-md-6">
<div class="container">
	
    <div class="row">
    	
        <div class="col-md-10 col-md-offset-1">
        	 	 @foreach ($data as $key => $value)
        	<h3 id="{{$key}}" style="color:#337ab7; "> {{$key}} </h3>
             @foreach ($value as $v)
        	  <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headin{{$v->id}}">
                            <h3 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse"
                                     data-parent="#accordion" href="#{{$v->id}}"
                                     aria-expanded="false" aria-controls="{{$v->id}}">
                                    {{$v->question}} </a>
                            </h3>
                        </div>
                        <div role="tabpanel" class="panel-collapse collapse"
                             id="{{$v->id}}"    aria-labelledby="heading{{$v->id}}">
                            <div class="panel-body">
                                               <p>{{$v->answer}} </p>

                            </div>
                        </div>
                    </div>
                    	@endforeach
	           @endforeach
            
</div>
</div>
</div>
</body>
@endsection
