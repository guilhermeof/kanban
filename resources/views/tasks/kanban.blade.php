@extends('layouts.app')

@section('content')
    <div class="container">

        <div>
            <h1>Tarefas do Projeto {{ $project->nome }}</h1>

            <div class="btn-group">
                <a href="{{ route('TaskCreate', ['id' => $project->id]) }}" class="btn btn-primary">
                    <i class="fa fa-floppy-o"></i>  Nova Tarefa
                </a>
            </div>
        </div>

        <div id="sortableKanbanBoards" class="row">

            <div class="col-md-3">
                <div class="panel title-red">
                    <div class="panel-heading">
                        TO DO
                        <i class="fa fa-2x fa-minus-circle pull-right"></i>
                    </div>
                    <div class="panel-body">
                        <div id="TODO" class="kanban-centered">

                            @foreach($tasks['todo'] as $task)
                                <article class="kanban-entry grab" id="{{$task->id}}" draggable="true">
                                    <div class="kanban-entry-inner">
                                        <div class="kanban-label">
                                            <h2><a href="#">Tarefa</a></h2>
                                            <p>{{$task->nome}}</p>
                                        </div>
                                    </div>
                                </article>
                            @endforeach

                        </div>
                    </div>
                    <div class="panel-footer">
                        <a href="{{ route('TaskCreate', ['id' => $project->id]) }}">Nova Tarefa...</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
            <div class="panel title-yellow">
                <div class="panel-heading">
                    DOING
                    <i class="fa fa-2x fa-minus-circle pull-right"></i>
                </div>
                <div class="panel-body">
                    <div id="DOING" class="kanban-centered">

                        @foreach($tasks['doing'] as $task)
                            <article class="kanban-entry grab" id="{{$task->id}}" draggable="true">
                                <div class="kanban-entry-inner">
                                    <div class="kanban-label">
                                        <h2><a href="#">Tarefa</a></h2>
                                        <p>{{$task->nome}}</p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
            </div>

            <div class="col-md-3">
            <div class="panel title-blue">
                <div class="panel-heading">
                    REVIEW
                    <i class="fa fa-2x fa-minus-circle pull-right"></i>
                </div>
                <div class="panel-body">
                    <div id="REVIEW" class="kanban-centered">

                        @foreach($tasks['review'] as $task)
                            <article class="kanban-entry grab" id="{{$task->id}}" draggable="true">
                                <div class="kanban-entry-inner">
                                    <div class="kanban-label">
                                        <h2><a href="#">Tarefa</a></h2>
                                        <p>{{$task->nome}}</p>
                                    </div>
                                </div>
                            </article>
                        @endforeach

                    </div>
                </div>
            </div>
            </div>

            <div class="col-md-3">
            <div class="panel title-green">
                <div class="panel-heading">
                    DONE
                    <i class="fa fa-2x fa-minus-circle pull-right"></i>
                </div>
                <div class="panel-body">
                    <div id="DONE" class="kanban-centered">

                        @foreach($tasks['done'] as $task)
                            <article class="kanban-entry grab" id="{{$task->id}}" draggable="true">
                                <div class="kanban-entry-inner">
                                    <div class="kanban-label">
                                        <h2><a href="#">Tarefa</a></h2>
                                        <p>{{$task->nome}}</p>
                                    </div>
                                </div>
                            </article>
                        @endforeach

                    </div>
                </div>
            </div>


        </div>
    </div>


    <!-- Static Modal -->
    <div class="modal modal-static fade" id="processing-modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-refresh fa-5x fa-spin"></i>
                        <h4>Processando...</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal modalTela fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <div class="col-md-1">
                        <a class="btn btn-success" href=""><i class="fa fa-edit"></i></a>
                    </div>
                    <div class="col-md-1">
                        <form class="form-inline formDelete" action="">
                            <button class="btn btn-danger" >
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>


                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection


@section('scripts')
    <script type="application/javascript">

        var csrf_token = "{{ csrf_token() }}";

        $(function () {
            $('.grab .kanban-entry-inner').click(function () {
                var id = $(this).parent().attr('id');

                $.ajax({
                    method: 'GET',
                    url: '/project/task/'+id+'/show'
                }).done(function (data){
                    var task = data.task;
                    var modal = $('.modalTela');

                    var title = $('.modalTela .modal-title');
                    var body = $('.modalTela .modal-body');
                    var footer = $('.modalTela .modal-footer');

                    title.empty();
                    title.append(task.nome);

                    body.empty();
                    body.append('<p>Aqui fica a descrição da tarefa</p>');

                    $('.modal-footer .btn-success').attr('href', '/project/task/'+id+'/edit');
                    $('.formDelete').attr('action', '/project/task/'+id+'/destroy');


                    modal.modal();
                }).fail(function(data){
                    var obj = data.responseJSON;
                    alert(obj.error);
                });

                $('.btn-danger').click(function excluir(e){
                    e.preventDefault();
                    swal({
                                title: "Exclusão de Tarefa",
                                text: "Você deseja realmente excluir a tarefa ?",
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


            });


            draggableInit();

            $('.panel-heading').click(function() {
                var $panelBody = $(this).parent().children('.panel-body');
                $(this).find('i').toggleClass('fa-plus-circle fa-minus-circle');
                $panelBody.slideToggle();
            });
        });

        function draggableInit() {
            var sourceId;

            $('[draggable=true]').bind('dragstart', function (event) {
                sourceId = $(this).parent().attr('id');
                event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
            });

            $('.panel-body').bind('dragover', function (event) {
                event.preventDefault();
            });

            $('.panel-body').bind('drop', function (event) {
                var children = $(this).children();
                var targetId = children.attr('id');

                if (sourceId != targetId) {
                    var elementId = event.originalEvent.dataTransfer.getData("text/plain");
                    var element = document.getElementById(elementId);

                    var data = { task: elementId, status: targetId, _token: csrf_token };

                    $('#processing-modal').modal('toggle');

                    $.ajax({
                        type: 'POST',
                        url: "/project/task/changestatus",
                        data: data,
                        success: function(data) {
                            children.prepend(element);
                            toastr.success('Tarefa atualizada com sucesso.', null, {progressBar: true} );
                        },
                        error: function(xhr, textStatus, error) {
                            toastr.error(xhr.responseText, null, {progressBar: true} );
                        },
                        complete: function() {
                            $('#processing-modal').modal('toggle');
                        }
                    });
                }

               event.preventDefault();
            });
        }

    </script>
@stop