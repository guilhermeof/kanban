@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <h1>Tarefas do Projeto {{ $project->nome }}</h1>

                <div class="btn-group">
                    <a href="{{ route('TaskCreate', ['id' => $project->id]) }}" class="btn btn-default"> Nova Tarefa </a>
                </div>
            </div>
        </div> <!-- .row -->

        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-box-title title-red">To Do</div>
                    <div class="panel-body">
                        @foreach($tasks['todo'] as $task)
                            <div class="panel panel-default panel-gray">
                                <div class="panel-body" data-task-id="{{$task->id}}">
                                    {{$task->nome}}

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-box-title title-yellow">Doing</div>
                    <div class="panel-body">
                        @foreach($tasks['doing'] as $task)
                            <div class="panel panel-default panel-gray">
                                <div class="panel-body" data-task-id="{{$task->id}}">
                                    {{$task->nome}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-box-title title-blue">Review</div>
                    <div class="panel-body">
                        @foreach($tasks['review'] as $task)
                            <div class="panel panel-default panel-gray">
                                <div class="panel-body" data-task-id="{{$task->id}}">
                                    {{$task->nome}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-box-title title-green">Done</div>
                    <div class="panel-body">
                        @foreach($tasks['done'] as $task)
                            <div class="panel panel-default panel-gray">
                                <div class="panel-body" data-task-id="{{$task->id}}">
                                    {{$task->nome}}

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- ;container -->


    <div class="modal fade" tabindex="-1" role="dialog">
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
                    <div class="pull-left">
                        <form class="form-inline formDelete" href="" action="">
                            <button class="btn btn-danger" >
                                <i class="fa fa-trash"></i>
                            </button>

                        </form>
                        <a class="btn btn-default" href=""><i class="fa fa-edit"></i></a>

                    </div>
                    <div class="pull-right">
                        <form method="get" class="form-inline formStatus" action="">
                            <select name="status" class="form-control"></select>
                        <button class="btn btn-info btn-submit">Ok</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


@endsection

@section('scripts')
    <script>

        $(document).ready(function () {
            $('.panel-gray .panel-body ').click(function (e) {
                var id = $(this).attr('data-task-id');

                $.ajax({
                    method: 'GET',
                    url: '/project/task/'+id+'/async'
                }).done(function (data){
                    var task = data.task;
                    var modal = $('.modal');

                    var title = $('.modal .modal-title');
                    var body = $('.modal .modal-body');
                    var footer = $('.modal .modal-footer');

                    title.empty();
                    title.append(task.nome);

                    body.empty();
                    body.append('<p>Este é o corpo do Modal</p>');

                    $('.modal-footer .btn-default').attr('href', '/project/task/'+id+'/edit');
                    $('.modal-footer .formDelete').attr('href', '/project/task/'+id+'/destroy');

                    //Popular Select
//                    $('select')
                    var status = data.select ;
                    var footer_html = '<option value="0">Status</option>';

                    if (status.length > 0){
                        for(var i=0; i<status.length;i++){
                            footer_html += '<option value="'+status[i]+'">'+status[i]+'</option>';
                        }
                        $('select').empty();
                        $('select').append(footer_html);
                        $('.formStatus').attr('action', '/project/task/change/'+id+'/status');
                    }else {
                        $('.formStatus').hide();
                    }

                    modal.modal();
                }).fail(function(data){
                    var obj = data.responseJSON;
                    alert(obj.error);
                });
            });

                $('.btn-submit').click(function (e) {
                   e.preventDefault();
                    var status = $('select').val();
                    if (status != 0){
                        $('.formStatus').submit();
                    }

                });

            $('.formDelete').click(function excluir(e){
                e.preventDefault();
                //var btn = $(this);
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

                                //btn.closest('form').trigger('submit');
                                $('.formDelete').submit();

                            }
                        });
            });

        });


    </script>
@endsection












