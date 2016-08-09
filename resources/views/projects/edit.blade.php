@extends('layouts.app')

@section('title')
Editar Projeto
@endsection

@section('content')

    <div class="container">

        <h1>Editar Projeto: {{ $project->nome }}</h1>

        @if ($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        {!! Form::open(['route'=> ['ProjectUpdate', $project->id], 'method'=>'post']) !!}
        {!! Form::input('hidden', 'idCreator', Auth::user()->id, array('class'=>'form-control') ) !!}

    <!-- Nome Form Input -->

        <div class="form-group">
            {!! Form::label('nome', 'Nome :') !!}
            {!! Form::text('nome', $project->nome, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Salvar Projeto', ['class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}
    </div>
@endsection