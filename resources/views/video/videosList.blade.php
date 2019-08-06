        <div class="card-body">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            
            @if(count($videos) >= 1)
                @foreach($videos as $video)
                    <div class="row video">
                        <div class="col-md-2 image">
                            @if(Storage::disk('images')->has($video->image))
                                <img src="{{ url('/thumbnail/'. $video->image) }}" class="img-fluid img-thumbnail" alt="Imagen en miniatura ">
                            @else
                                <img src="{{ url('/thumbnail/imageDefault.jpg') }}" class="img-fluid img-thumbnail" alt="Imagen por defecto">
                            @endif
                        </div>
                        <div class="col-md-10 content">
                            <h4><a href="{{ route('detailVideo', ['video_id' => $video->id]) }}" id="title">{{ $video->title }}</a></h4>
                            <p>
                                <a href="{{ route('channel', ['user_id' => $video->user->id ]) }}"> 
                                    <i>{{ $video->user->name. ' ' .$video->user->surname }}</i>
                                </a>
                                | {{ \FormatTime::LongTimeFilter($video->created_at) }}
                            </p>

                            <!--Botones de acción-->
                            <a href="{{ route('detailVideo', ['video_id' => $video->id]) }}" class="btn btn-success btn-sm">Ver</a>
                            @if(Auth::check() && Auth::user()->id == $video->user->id)
                                <a href="{{ route('videoEdit', ['video_id' => $video->id]) }}" class="btn btn-info btn-sm">Editar</a>
                                
                                <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                                <a href="#confirmar{{$video->id}}" role="button" class="btn btn-danger btn-sm" data-toggle="modal">Eliminar</a>

                                <!-- Modal / Ventana / Overlay en HTML -->
                                <div class="modal fade" id="confirmar{{$video->id}}" tabindex="-1" role="dialog">
                                   <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">¿Estás seguro?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Seguro que quieres eliminar este video?</p>
                                                <p><small>{{ $video->title }}</small></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <a href="{{ url('/delete-video/' . $video->id) }}" class="btn btn-danger">Eliminar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <hr>             
                @endforeach
            @else
                <div class="alert alert-warning">No hay videos actualmente!!</div>
            @endif
                               
        </div>
    </div>            
    <br>    
    <!--Paginado--> 
    {{ $videos->links() }}        
</div>