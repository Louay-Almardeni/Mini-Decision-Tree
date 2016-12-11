@extends('layout')

@section('content')

    <label id="error">{{$error}}</label>
    <form id="builder" action="/builder" method="post">
        <div class="row">
            <div id="builder-panel" class="panel panel-default">
                <div class="panel-heading">
                    <label>Builder</label>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <label> File Name: </label>
                        <input id="file-name" name="file_name"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="alternatives-panel" class="panel panel-default">
                <div class="panel-heading">
                    <label>Mapping List</label>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <label> Name: </label>
                        <input id="map-name" name="map_name"/>
                    </div>
                    <div class="row">
                        <label> MapTo: </label>
                        <input id="map-to" name="map_to"/>
                    </div>
                </div>
            </div>

            <div id="children-nodes-panel" class="panel panel-default">
                <div class="panel-heading">
                    <label>Children Node</label>
                    <i class="fa fa-plus fa-2x" title="Add Alternative" onclick="addAlternative()"></i>
                </div>

                <div class="panel-body">
                    <div id="alternatives">
                        <div class="row">
                            <label> Alternative: </label>
                            <input id="alternative" name="alternative_1"/>
                        </div>
                    </div>
                </div>
            </div>

            <button id="generate-xml" class="btn btn-success" onclick="generateXml()">Generate XML</button>
        </div>
    </form>

    <div class="row">
        <textarea id="xml" name="xml" disabled>{{$xml}}</textarea>
    </div>
@endsection

@section('custom-js')
    <script>
        preventDoubleSubmission();
        var alternatives_count = 1;
        {{--        var saveFileUrl = '{{$app->urlFor('createFile')}}';--}}
    </script>
@endsection

