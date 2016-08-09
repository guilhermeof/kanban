@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Tarefas do Projeto {{ $project->nome }}</h1>



        <div class="checkbox">
            <a href="{{ route('TaskCreate', ['id' => $project->id]) }}" class="btn btn-default"> Nova Tarefa </a>
        </div>



        <table class="table table-striped table-bordered table-hover">
            <thead >
            <tr>
                <th>To do</th>
                <th>Doing</th>
                <th>Review</th>
                <th>Done</th>
            </tr>

            </thead>
            <tbody>

            @foreach($tasks as $task)

                <tr>
                    <td>{{ $task->nome }}</td>
                    <td>
                        <a href="{{ route('TaskEdit',['project' => $project->id, 'id'=>$task->id]) }}" class="btn btn-success glyphicon glyphicon-edit">Editar</a>
                        <a href="{{ route('TaskDestroy',['project' => $project->id, 'id'=>$task->id]) }}" class="btn btn-danger glyphicon glyphicon-remove">Remover</a>

                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
@endsection
