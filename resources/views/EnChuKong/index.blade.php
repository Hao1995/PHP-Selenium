@extends('layouts.EnChuKong')
@section('content')

    <h1>En Chu Kong</h1>

    @if ($status)
        <h2>Port 4444 is used</h2>
    @else
        <h2>Port 4444 is not used</h2>
    @endif

    {!! Form::open(['method'=>'POST', 'action'=>'EnChuKongController@startSeleniumServer']) !!}
        <div class="form-group">
            {!! Form::submit('Start Selenium Server', ['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

@endsection
