@extends('layouts.app')

@section('content')

<div class="container">	
	<div class="row">
		<div class="col-lg-7">
			<div class="card">
				<div class="card-header">	
					<div class="card-title">
						<h2>Crear nuevo video</h2>
					</div>
				</div>
		  		<div class="card-body">			
					<form action="{{route('saveVideo')}}" method="post" enctype="multipart/form-data">
						@csrf
						@if($errors->any())
							<div class="alert alert-danger">
								<ul>
									@foreach($errors->all() as $error)
										<li>{{$error}}</li>
									@endforeach
								</ul>
							</div>
						@endif

					    <div class="form-group">
					    	<label for="title">Titulo</label>			    
					    	<input class="form-control" type="text" id="title" name="title" placeholder="Titulo" value="{{ old('title') }}">
					    </div>

					    <div class="form-group">
					    	<label for="description">Descripción</label>			    
					    	<textarea class="form-control" id="description" name="description" placeholder="Descripción">{{ old('description') }}</textarea>
					    </div>

					    <div class="form-group">
					    	<label for="image">Miniatura</label>			    
					    	<input class="form-control" type="file" id="image" name="image" >
					    </div>

					    <div class="form-group">
					    	<label for="video">Archivo de video</label>			    
					    	<input class="form-control" type="file" id="video" name="video" >
					    </div>
					  
					  	<button type="submit" class="btn btn-primary">Crear video</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection