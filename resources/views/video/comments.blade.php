<div class="row">
	<div class="col-md-12">		
		<br>
		@if(session('message'))
			<div class="alert alert-success">
				{{ session('message') }}
			</div>
		@endif
		@if(Auth::check())
			<form action="{{ url('/comment') }}" method="POST">
				@csrf
			    <input type="hidden" name="video_id" value="{{ $video->id }}" required /> 	

			    <div class="form-group row">			    	
			    	<div class="col-md-12">
			      		<textarea name="comment" class="form-control" required ></textarea>
			    	</div>
			    </div>
			    <input type="submit" value="Comentar" class="btn btn-success" />
			</form>
		@endif		  

	</div>
</div>
<br>

<div class="row">
	<div class="col-md-12">
		<hr>
		<p>COMENTARIOS</p>
		<hr>
	</div>
</div>

<div class="row">		
	@foreach($video->comments as $comment)
		<div class="comment-item col-md-4 pull-right">		
			<div class="card comment-data">
                <div class="card-header">
                	Subido por: 
                	<strong>{{ $comment->user->name. ' ' .$comment->user->username }}</strong> {{ \FormatTime::LongTimeFilter($comment->created_at) }}

					@if(Auth::check() && (Auth::user()->id == $comment->user_id || Auth::user()->id == $video->user_id))
						<!-- Botón en HTML (lanza el modal en Bootstrap) -->
						<a href="#confirmar{{$comment->id}}" class="ml-2 mb-1 close" data-toggle="modal">
							<span aria-hidden="true">&times;</span>	        
						</a>
						<!-- Modal / Ventana / Overlay en HTML -->
						<div class="modal fade" id="confirmar{{$comment->id}}" tabindex="-1" role="dialog">
						   <div class="modal-dialog" role="document">
							    <div class="modal-content">
							        <div class="modal-header">
								        <h5 class="modal-title">¿Estás seguro?</h5>
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <span aria-hidden="true">&times;</span>
								        </button>
							        </div>
							        <div class="modal-body">
							        	<p>¿Seguro que quieres eliminar este comentario?</p>
							        	<p><small>{{ $comment->body }}</small></p>
							        </div>
							        <div class="modal-footer">
								        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
								        <a href="{{ url('/delete-comment/' . $comment->id) }}" class="btn btn-danger">Eliminar</a>
							        </div>
							    </div>
						    </div>
						</div>

					@endif
                	
                </div>
                <div class="card-body">
                	{{ $comment->body }}
                </div>
            </div>
		</div>
	@endforeach
	
</div>

