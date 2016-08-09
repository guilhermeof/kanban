@extends('layouts.app')

@section('title')
    Projetos
    @endsection
@section('content')

    <div class="container">

        <h1>Projetos</h1>

        <div class="checkbox">
            <a href="{{ route('ProjectCreate') }}" class="btn btn-default"> Novo Projeto </a>
        </div>

        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Ação</th>
            </tr>

            </thead>
            <tbody>

            @foreach($projects as $project)

                <tr>
                    <td>{{ $project->nome }}</td>
                    <td>
                        <a href="{{ route('TaskMain', ['id' => $project->id]) }}" class="btn btn-warning glyphicon glyphicon-arrow-up"> Abrir</a>
                        <a href="{{ route('ProjectEdit',['id'=>$project->id]) }}" class="btn btn-success glyphicon glyphicon-edit">Editar</a>
                        <a href="{{ route('ProjectDestroy',['id'=>$project->id]) }}" class="btn btn-danger glyphicon glyphicon-remove">Remover</a>

                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>
    </div>


@endsection