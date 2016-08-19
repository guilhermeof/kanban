@extends('layouts.app')

@section('content')
    <div class="container">

        <div>
            <h1>Tarefas do Projeto {{ $project->nome }}</h1>

            <div class="btn-group">
                <a  id="{{$project->id}}" class="btn btn-primary btn-create">

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
                                        <h2 id="idH2"><a href="#">Tarefa</a></h2>
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

    <!-- Modal Show, exibe informações da tarefa-->
    <div class="modal modalShow fade" tabindex="-1" role="dialog">
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
                        <button class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal de criar uma nova tarefa-->
    <div class="modal modalCreate fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title modal-title-create">Modal title</h3>
                </div>
                <div class="modal-body modal-body-create">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                {!! Form::open(['route'=>'TaskStore']) !!}

                                {!! Form::input('hidden', 'idProject', $project->id) !!}

                                <!-- Nome Form Input -->
                                    <div class="form-group">
                                        {!! Form::label('nome', 'Nome :') !!}
                                        {!! Form::text('nome', null,['class' => 'form-control']) !!}
                                    </div>


                                    <div class="form-group">
                                        {!! Form::submit('Criar Tarefa', ['class' => 'btn btn-primary btn-submit-create']) !!}

                                    </div>
                                    {!! Form::close() !!}


                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer modal-footer-create">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection


@section('scripts')
    <script type="application/javascript">

        var csrf_token = "{{ csrf_token() }}";

        $(function () {
            $('.btn-create').click(function () {
                var id = $(this).attr('id');

                
                $.ajax({
                    method: 'GET',
                    url: '/project/'+id+'/task/create'

                }).done(function (data) {
                    var modal = $('.modalCreate');
                    var title = $('.modalCreate .modal-title-create');

                    title.append('Nova tarefa');

                    modal.find('.btn-submit-create').attr('idProject', id);
                    modal.modal();

                });

            });

        });

        $('.modalCreate .btn-submit-create').click(function () {
           var id = $('.modalCreate form').attr('route');

           // var data = {project: id, _token: csrf_token };


            $.ajax({
                type: 'POST',
                url: '/project/task/store',
                success: function (data) {
                    toastr.success('Tarefa criada com sucesso.', null, {progressBar: true} );
                },
                error: function(xhr, textStatus, error) {
                    toastr.error(xhr.responseText, null, {progressBar: true} );
                }
            });
            $('.modalShow').modal('hide');
        });

        $(function () {
            $('.grab .kanban-entry-inner').click(function () {
                var id = $(this).parent().attr('id');

                $.ajax({
                    method: 'GET',
                    url: '/project/task/'+id+'/show'
                }).done(function (data){
                    var task = data.task;
                    var modal = $('.modalShow');

                    var title = $('.modalShow .modal-title');
                    var body = $('.modalShow .modal-body');
                    var footer = $('.modalShow .modal-footer');


                    title.empty();
                    title.append(task.nome);


                    body.empty();
                    body.append('<p>Aqui fica a descrição da tarefa</p>');

                    modal.find('.modal-footer .btn-success').attr('href', '/project/task/'+id+'/edit');
                    modal.find('.modal-footer .btn-danger').attr('data-task-id', id);

                    modal.modal();
                }).fail(function(data){
                    var obj = data.responseJSON;
                    toastr.error(obj.error);
                });
            });

            $('.modalShow .btn-danger').click(function (e){
                e.preventDefault();
                swal({
                    title: "Exclusão de Tarefa",
                    text: "Você deseja realmente excluir a tarefa ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: "Sim",
                    cancelButtonText: "Não",
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function (isConfirm) {
                    if(isConfirm) {
                        var id = $('.modalShow .btn-danger').attr('data-task-id');

                        var dados = { task: id, _token: csrf_token };

                        $.ajax({
                            type: 'POST',
                            url: '/project/task/destroy',
                            data: dados,
                            success: function (response) {
                                toastr.success('Tarefa deletada com sucesso.', null, {progressBar: true} );
                                $('article#'+id).remove();
                            },
                            error: function(xhr, textStatus, error) {
                                toastr.error(xhr.responseText, null, {progressBar: true} );
                            }
                        });
                        $('.modalShow').modal('hide');
                    }
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