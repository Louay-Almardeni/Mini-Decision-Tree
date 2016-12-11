@extends('layout')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Select File</div>
        <div class="panel-body">
            @if($files)
                <select id="files">
                    @foreach($files as $f)
                        <option>{{$f}}</option>
                    @endforeach
                </select>
                <button class="btn btn-success" onclick="loadFile()">Load</button>
                <button class="btn btn-danger" onClick="window.location.reload()">Reset</button>
            @else
                <label>No XML Files to load!</label>
            @endif
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        var loadFileUrl = '{{$app->urlFor('loadFile')}}';
    </script>
@endsection
