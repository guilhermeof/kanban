@extends('layouts.app')

@section('title')
    Projetos
    @endsection
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Projetos</h1>

                <div class="btn-group">
                    <a href="{{ route('ProjectCreate') }}" class="btn btn-primary">
                        <i class="fa fa-floppy-o"></i>&nbsp;
                         Novo Projeto
                    </a>
                </div>

            </div>

        </div> <!-- .row -->

        <div class="row" id="projects">

            @foreach($projects as $project)
            <div class="col-md-4">
                {{--<a href="{{ route('TaskMain', ['id' => $project->id]) }}">--}}
                        <div class="panel panel-default panel-body-project">
                            <div class="panel-body">
                                <p class="text-justify">{{ $project->nome }}</p>


                                <div class="row">
                                    <div class="col-md-3 ">
                                        <a href="{{ route('TaskMain', ['id' => $project->id]) }}" class="btn btn-info fa fa-angle-up">Abrir</a>

                                    </div>

                                    <div class="col-md-3">
                                        <a href="{{ route('ProjectEdit',['id'=>$project->id]) }}" class="btn btn-success fa fa-edit">Editar</a>
                                    </div>
                                     <div class="col-md-5 text-right ">
                                        {!! Form::open([ 'method' => 'DELETE', 'route' => ['ProjectDestroy', $project->id]]) !!}
                                        {!! Form::button('Remover', ['class' => 'btn btn-danger fa fa-trash-o', 'type' => 'submit', 'style' => 'color:black']) !!}
                                        {!! Form::close() !!}
                                    </div>


                                </div>


                            </div>
                        </div>

                {{--</a>--}}
            </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')

<script>

    $('.btn-danger').click(function excluir(e){
            e.preventDefault();
        var btn = $(this);
        swal({
                    title: "Exclusão de Projeto",
                    text: "Você deseja realmente excluir o projeto?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: "Sim",
                    cancelButtonText: "Não",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },

                function(isConfirm){
                    if (isConfirm){

                        btn.closest('form').trigger("submit");


                    }
                });
    });




</script>

@endsection