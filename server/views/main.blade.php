@extends('layout')

@section('content')
    <div id="main-panel" class="panel panel-primary">
        <div class="panel-body">
            <button onclick="window.location.href='/builder'" class="btn btn-primary">
                Start As Builder
            </button>
            <button onclick="window.location.href='/player'" class="btn btn-primary">
                Start As Player
            </button>
        </div>
    </div>
@endsection