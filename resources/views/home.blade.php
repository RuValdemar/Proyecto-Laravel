@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Videos</div>        
                @include('video.videosList')
    </div>
</div>
@endsection
