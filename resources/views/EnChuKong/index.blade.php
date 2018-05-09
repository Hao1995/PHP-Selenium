@extends('layouts.EnChuKong')
@section('content')

    <h1>En Chu Kong</h1>

    <table class="table table-striped">
        <thead>
          <tr>
            <th colspan="3" class="text-center">Selenium Server</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">
                @if ($status)
                    <p>Port 4444 is used</p>
                @else
                    <p>Port 4444 is not used</p>
                @endif
            </th>
            <td>
                {!! Form::open(['method'=>'POST', 'action'=>'EnChuKongController@startSeleniumServer']) !!}
                    <div class="form-group">
                        {!! Form::submit('Start Selenium Server', ['class'=>'btn btn-primary']) !!}
                    </div>
                {!! Form::close() !!}
            </td>
            <td>
                {!! Form::open(['method'=>'DELETE', 'action'=>'EnChuKongController@stopSeleniumServer']) !!}
                    <div class="form-group">
                        {!! Form::submit('Stop Selenium Server', ['class'=>'btn btn-danger']) !!}
                    </div>
                {!! Form::close() !!}    
            </td>
          </tr>
        </tbody>
    </table>

@endsection
