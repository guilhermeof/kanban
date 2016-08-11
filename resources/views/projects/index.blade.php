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
                <a href="{{ route('TaskMain', ['id' => $project->id]) }}">
                        <div class="panel panel-default panel-body-project">
                            <div class="panel-body">
                                <p class="text-justify">{{ $project->nome }}</p>

                                <a href="{{ route('TaskMain', ['id' => $project->id]) }}" class="btn btn-info">Abrir</a>
                                <a href="{{ route('ProjectEdit',['id'=>$project->id]) }}" class="btn btn-success fa fa-edit">Editar</a>
                                <a id="delete" type="submit" href="{{ route('ProjectDestroy',['id'=>$project->id]) }}" class="btn btn-danger fa fa-trash-o">Remover</a>
                            </div>
                        </div>

                </a>
            </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')

<script>

    $('.btn-danger').click(function excluir(e){
            e.preventDefault();
        var btn = $(this); // Captura o botão que foi clicado
        swal({
                    title: "Exclusão de Tarefa",
                    text: "Você deseja realmente excluir a tarefa?",
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
                        // Continuar evento
                        btn.closest('form').trigger("submit");
                    }
                });
    });




</script>

@endsection