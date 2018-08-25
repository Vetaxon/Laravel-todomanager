@component('mail::message')
Dear, {{$user}}, here are your actual tasks:

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
                                    <td>{{$task['task']}}<p style="text-align: right; font-size:small">{{ $task['created_at'] }}</p></td>
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

Thanks,
{{ config('app.name') }}
@endcomponent
