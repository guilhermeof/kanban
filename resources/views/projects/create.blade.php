@extends('layouts.app')

@section('title')
Criar Projeto
@endsection

@section('content')
    <div class="container">
        <h1>Novo Projeto</h1>

        @if ($errors->any())
            <ul class="alert alert-warning">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">


                {!! Form::open(['route'=>'ProjectStore']) !!}
                {!! Form::input('hidden', 'idCreator', Auth::user()->id, array('class'=>'form-control') ) !!}

                <!-- Nome Form Input -->
                    <div class="form-group">
                        {!! Form::label('nome', 'Nome:') !!}
                        {!! Form::text('nome', null,['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}

                    </div>
                    {!! Form::close() !!}



                </div>

            </div>
        </div>
    </div>


    </div>

@endsection