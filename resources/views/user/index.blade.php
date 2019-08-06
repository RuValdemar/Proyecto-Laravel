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
	            			<b>Canal de: </b><span>{{ $user->name . ' ' . $user->surname}}</span>
	            		</div>
	            		
					</div>
            	</div>
	        	@include('video.videosList')
    </div>
</div>
@endsection