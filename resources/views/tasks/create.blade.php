@extends('layouts.app')

@section('content')

    <div class="container">

        <h1>Nova Tarefa</h1>

        @if ($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
    @endif

    {!! Form::open(['route'=>'TaskStore']) !!}

    {!! Form::input('hidden', 'idProject', $project->id) !!}

    <!-- Nome Form Input -->
        <div class="form-group">
            {!! Form::label('nome', 'Nome :') !!}
            {!! Form::text('nome', null,['class' => 'form-control']) !!}
        </div>


        <div class="form-group">
            {!! Form::submit('Criar Tarefa', ['class' => 'btn btn-primary']) !!}

        </div>
    {!! Form::close() !!}



@endsection