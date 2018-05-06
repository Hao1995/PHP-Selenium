@extends('layouts.EnChuKong')
@section('content')

    <h1>En Chu Kong</h1>

    {!! Form::open(['method'=>'POST', 'action'=>'EnChuKongController@startSeleniumServer']) !!}
        <div class="form-group">
            {!! Form::submit('Start Selenium Server', ['class'=>'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}

@endsection
