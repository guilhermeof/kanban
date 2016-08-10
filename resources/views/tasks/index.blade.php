@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <h1>Tarefas do Projeto {{ $project->nome }}</h1>

            <div class="btn-group">
                <a href="{{ route('TaskCreate', ['id' => $project->id]) }}" class="btn btn-default"> Nova Tarefa </a>
            </div>
        </div> <!-- .row -->

        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-box-title title-red">To Do</div>
                    <div class="panel-body">
                        @foreach($tasks['todo'] as $task)
                            <div class="panel panel-default panel-gray">
                                <div class="panel-body">
                                    {{$task->nome}}

                                    <a style="float:right; position: static" href="{{ route('TaskEdit',['project' => $project->id, 'id'=>$task->id]) }}" class="btn glyphicon glyphicon-edit">Editar</a>
                                    <a style="float:right; position: static" href="{{ route('TaskDestroy',['project' => $project->id, 'id'=>$task->id]) }}" class="btn glyphicon glyphicon-remove">Remover</a>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-box-title title-yellow">Doing</div>
                    <div class="panel-body">
                        @foreach($tasks['doing'] as $task)
                            <div class="panel panel-default panel-gray">
                                <div class="panel-body">
                                    {{$task->nome}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-box-title title-blue">Review</div>
                    <div class="panel-body">
                        @foreach($tasks['review'] as $task)
                            <div class="panel panel-default panel-gray">
                                <div class="panel-body">
                                    {{$task->nome}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-box-title title-green">Done</div>
                    <div class="panel-body">
                        @foreach($tasks['done'] as $task)
                            <div class="panel panel-default panel-gray">
                                <div class="panel-body">
                                    {{$task->nome}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- ;container -->

@endsection












