@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="row">
    	<div class="col-md-12">
            <div class="card">
            	<div class="card-header">
            		<div class="row justify-content-between">
	            		<div class="col-md-6">            			
	            			<b>Resultados de busqueda para: </b><span>{{ $search }}</span>
	            		</div>
	            		<div class="col-md-3 form-inline">
							<form action="{{ url('/buscar-video/' . $search) }}" method="get">
								<div class="form-group">								    
								    <select class="form-control" name="filter">
								    	<option>Ordenar</option>
								      	<option value="new">Más nuevos</option>
								      	<option value="old">Más antiguos</option>
								      	<option value="alfa">De la A a la Z</option>
								    </select>

								    <input type="submit" class="btn btn-info" value="Ordenar" />
								</div>
							</form>	
						</div>
					</div>
            	</div>
	        	@include('video.videosList')
    </div>
</div>
@endsection