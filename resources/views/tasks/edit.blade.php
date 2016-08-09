@extends('layouts.app')

@section('title')
Editar Projeto
@endsection

@section('content')

    <div class="container">

        <h1>Editar Projeto: {{ $task->nome }}</h1>

        @if ($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        {!! Form::open(['route'=> ['TaskUpdate', $task->id], 'method'=>'POST']) !!}
           {!! Form::input('hidden', 'idProject', $task->idProject, array('class'=>'form-control') ) !!}

    <!-- Nome Form Input -->

        <div class="form-group">
            {!! Form::label('nome', 'Nome :') !!}
            {!! Form::text('nome', $task->nome, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Salvar Projeto', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
@endsection