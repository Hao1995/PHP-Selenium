@extends('layouts.EnChuKong')
@section('content')

    <h1 class="text-center">En Chu Kong</h1>

    <table class="table table-striped">
        <thead>
          <tr>
            <th colspan="2" class="text-center">Selenium Server</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="text-center">
                @if ($status)
                    <p class="d-inline">Port 4444 is used</p>
                @else
                    <p class="d-inline">Port 4444 is not used</p>
                @endif
            </th>
            <td>
                @if ($status)
                    {!! Form::open(['method'=>'DELETE', 'action'=>'EnChuKongController@stopSeleniumServer']) !!}
                        <div class="form-group">
                            {!! Form::submit('Stop', ['class'=>'btn btn-danger']) !!}
                        </div>
                    {!! Form::close() !!}   
                @else
                    {!! Form::open(['method'=>'POST', 'action'=>'EnChuKongController@startSeleniumServer']) !!}
                        <div class="form-group">
                            {!! Form::submit('Start', ['class'=>'btn btn-primary']) !!}
                        </div>
                    {!! Form::close() !!}
                @endif
            </td>
          </tr>
        </tbody>
    </table>

    <hr>

    <table class="table table-striped">
        <thead>
            <tr>
                <th colspan="6" class="text-center">
                    Status Data
                    <a class="btn btn-info float-right" href="{{route('EnChuKong.index')}}">Refresh</a>
                    @if ($status)
                        <a class="btn btn-info float-right" href="{{route('crawler')}}">Fetch</a>
                    @endif
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">Date</td>
                <td class="text-center">Week</td>
                <td class="text-center">Doctor</td>
                <td class="text-center">Status</td>
                <td class="text-center">Created_at</td>
                <td class="text-center">Updated_at</td>
            </tr>
            @if (count($data) >0)
                @foreach ($data as $item)
                    <tr>
                        <td class="text-center">{{$item->date}}</td>
                        <td class="text-center">{{$item->week}}</td>
                        <td class="text-center">{{$item->doctor}}</td>
                        <td class="text-center">{{$item->status}}</td>
                        <td class="text-center">{{$item->created_at->diffForHumans()}}</td>
                        <td class="text-center">{{$item->updated_at->diffForHumans()}}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">No Data</td>
                </tr>
            @endif
            
        </tbody>
    </table>

@endsection
