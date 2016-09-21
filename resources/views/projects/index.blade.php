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
                <a href="{{ route('TaskKanban', ['id' => $project->id]) }}">
                        <div class="panel panel-default panel-body-project">
                            <div class="panel-body">
                                <p class="text-justify">{{ $project->nome }}</p>


                                <div class="row">

                                    <div class="col-md-2">

                                        <a href="{{ route('ProjectEdit',['id'=>$project->id]) }}">
                                            <button class="btn btn-success">
                                                <i class=" fa fa-edit"></i>
                                            </button>
                                        </a>
                                    </div>
                                     <div class="col-md-2 ">
                                         <form class="form-inline formDelete" action="{{ route('ProjectDestroy', [$project->id]) }}">
                                             <button class="btn btn-danger" >
                                                 <i class="fa fa-trash"></i>
                                             </button>
                                         </form>
                                    </div>


                                </div>


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


                        $('.formDelete').submit();


                    }
                });
    });




</script>

@endsection