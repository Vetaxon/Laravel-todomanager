@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <table class="table">
                        @foreach($tasks as $key => $taskGroup)
                            @foreach($taskGroup as $key => $taskGroup)

                        <thead>
                        <tr>
                            <th scope="col" style="text-align: center; text-transform: uppercase;">{{$key}}</th>
                        </tr>
                        </thead>
                            @foreach($taskGroup as $task)
                        <tbody>
                        <tr>
                            <td>{{$task['task']}}<p style="text-align: right">{{ $task['created_at'] }}</p></td>
                        </tr>
                        </tbody>
                                @endforeach
                                @endforeach
                        @endforeach
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection