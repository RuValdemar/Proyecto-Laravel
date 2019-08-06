@extends('layouts.app')

@section('content')
<br>
<div class="container">
	<h2>{{ $video->title }}</h2>
	<hr>
	<div class="row">
        <div class="col-lg-5">
			<!--video-->
			<video controls id="video-player">
				<source src="{{ route('fileVideo', ['filename' => $video->video_path]) }}"></source>
					Tu navegador no es compatible con HTML5
			</video>
		</div>
		<div class="col-lg-7">
			<!--descripción-->
			<div class="card">
                <div class="card-header">
                	Subido por: 
                	<strong><a href="{{ route('channel', ['user_id' => $video->user->id ]) }}">{{ $video->user->name. ' ' .$video->user->username }}</a></strong> {{ \FormatTime::LongTimeFilter($video->created_at) }}
                </div>
                <div class="card-body">
                	{{ $video->description }}
                </div>
            </div>
		</div>
	</div>
	<!--comentarios-->	
	@include('video.comments')

</div>
@endsection