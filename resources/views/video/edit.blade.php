@extends('layouts.app')

@section('content')
	<br>
	<div class="container">	
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">	
						<div class="card-title">
							<h2>Editar </h2><span>{{ $video->title }}</span><br>
						</div>
					</div>
			  		<div class="card-body">			
						<form action="{{route('updateVideo', ['video_id' => $video->id])}}" method="post" enctype="multipart/form-data">
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
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
								    	<label for="title">Titulo</label>			    
								    	<input class="form-control" type="text" id="title" name="title" placeholder="Titulo" value="{{ $video->title }}">
								    </div>

								    <div class="form-group">
								    	<label for="description">Descripción</label>			    
								    	<textarea class="form-control" id="description" name="description" placeholder="Descripción">{{ $video->description }}</textarea>
								    </div>

								    <div class="form-group">
								    	<label for="image">Miniatura</label><br>
								    	@if(Storage::disk('images')->has($video->image))
		                                    <img style="width: 100px;" src="{{ url('/thumbnail/'. $video->image) }}" class="img-thumbnail" alt="Imagen en miniatura ">
		                                @else
		                                    <img style="width: 100px;" src="{{ url('/thumbnail/imageDefault.jpg') }}" class="img-fluid" alt="Imagen por defecto">
		                                @endif			    
								    	<input class="form-control" type="file" id="image" name="image" >
								    </div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
								    	<label for="video">Archivo de video</label><br>		    
								    	<video controls id="video-player">
											<source src="{{ route('fileVideo', ['filename' => $video->video_path]) }}"></source>
												Tu navegador no es compatible con HTML5
										</video>
								    	<input class="form-control" type="file" id="video" name="video" >
								    </div>
								</div>
							</div>
						    

						   
						  
						  	<button type="submit" class="btn btn-primary">Actualizar</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
