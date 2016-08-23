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

                    <input name="id_project" type="hidden" value="{{$task->idProject}}">
                    <label for="nome">Editar Nome :</label>
                    <input value="" class="form-control formNomeEdit" id="nomeEdit" type="text">

                </div>
                <div class="modal-footer">
                    <div class="col-md-3">
                        <input class="btn btn-success btn-submitEdit" type="submit" value="Atualizar Tarefa">
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
                    <div class="panel-body">

                            <input name="project_id" type="hidden" value="{{$project->id}}">
                            <label for="nome">Nome :</label>
                            <input class="form-control formNome" id="nomeCreate" type="text">

                    </div>
                </div>
                <div class="modal-footer modal-footer-create">
                    <input class="btn btn-primary btn-submit-create" type="submit" value="Criar Tarefa">
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection


@section('scripts')
    <script type="application/javascript">

        var csrf_token = "{{ csrf_token() }}";
        var project_id = "{{$project->id}}";
        var idProject = "{{$task->idProject}}";

        //Abrindo modal com comando de telca SHIFT + N
        $("html").keypress(function(event){
            var titleCreate = $('.modalCreate .modal-title');
            if ( event.which == 78 ) {
                event.preventDefault();

                titleCreate.empty();
                titleCreate.append("Nova Tarefa");

                $('.modalCreate .formNome').each(function(){
                    $(this).val('');
                });

                $('.modalCreate').modal();
            }
        });

        //Direcionando focus para o input nome do modal Create
        $(".modalCreate").on('shown.bs.modal', function(){
            $(this).find('#nomeCreate').focus();
        });

        //Direcionando focus para o input nome do modal Show
        $(".modalShow").on('shown.bs.modal', function(){
            $(this).find('#nomeEdit').focus();
        });

        //Abrindo modalCreate ao clicar no botão Nova Tarefa
        $('.btn-create').click(function () {
            var titleCreate = $('.modalCreate .modal-title');

            titleCreate.empty();
            titleCreate.append("Nova Tarefa");

            $('.modalCreate .formNome').each(function(){
                $(this).val('');
            });

            $('.modalCreate').modal();
        });

        $("#nomeCreate").keypress(function(event){
            if ( event.which == 13 ) {
                event.preventDefault();

                salvarTarefa();
            }
        });

        $('.modalCreate .btn-submit-create').click(function () {
            salvarTarefa();
        });

        var salvarTarefa = function() {

            var nome = $("#nomeCreate").val();

            if (nome.length < 7) {
                toastr.warning('O nome da tarefa deve ter pelo menos 7 caracteres.', null, {progressBar: true} );

                return;
            }

            var data = {project_id: project_id, _token: csrf_token, nome: nome };

            $.ajax({
                type: 'POST',
                url: '/project/task/store',
                data: data,
                success: function (data) {
                    toastr.success(data.message, null, {progressBar: true} );
                    var task = data.task;
                    var article = '<article class="kanban-entry grab" id="'+task.id+'" draggable="true">' +
                            '<div class="kanban-entry-inner">' +
                            '<div class="kanban-label">' +
                            '<h2><a href="#">Tarefa</a></h2>' +
                            '<p>'+task.nome+'</p>' +
                            '</div></div></article>';

                    $('#TODO').append(article);
                },
                error: function(xhr, textStatus, error) {
                    var erros = $.parseJSON(xhr.responseText);
                    for(var key in erros){
                        toastr.error(erros[key], null, {progressBar: true} );
                    }
                }

            });

            $('.modalCreate').modal('hide');
        }

            $(document).on('click','.grab .kanban-entry-inner', function () {
                var id = $(this).parent().attr('id');

                $.ajax({
                    method: 'GET',
                    url: '/project/task/'+id+'/show'
                }).done(function (data){
                    var task = data.task;
                    var modal = $('.modalShow');

                    $('.modalShow .formNomeEdit').each(function(){
                        $(this).val('');
                    });


                    var title = $('.modalShow .modal-title');
                    var body = $('.modalShow .formNomeEdit');
                    var footer = $('.modalShow .modal-footer');

                    title.empty();
                    title.append(task.nome);

                    body.empty();
                    body.append(task.nome);

                    modal.find('.modal-footer .btn-danger').attr('data-task-id', id);

                    modal.modal();
                }).fail(function(data){
                    var obj = data.responseJSON;
                    toastr.error(obj.error);
                });
            });

        $(document).on('click', '.modalShow .btn-submitEdit',function () {
            editarTarefa();
        });

        var editarTarefa = function() {
            var id = $('.modalShow .btn-danger').attr('data-task-id');
            var nomeEdit = $("#nomeEdit").val();

            var dados = {idProject: idProject, task: id, _token: csrf_token, nome: nomeEdit };

            $.ajax({
                type: 'POST',
                url: '/project/task/'+id+'/update',
                data: dados,
                success: function (dados) {
                    toastr.success('Tarefa atualizada com sucesso.', null, {progressBar: true} );
                    var task = dados.task;
                    $('#'+id+' .kanban-entry-inner .kanban-label p').html(task.nome);
                },
                error: function(xhr, textStatus, error) {
                    toastr.error(xhr.responseText, null, {progressBar: true} );
                    }
            });

            $('.modalShow').modal('hide');
        }

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