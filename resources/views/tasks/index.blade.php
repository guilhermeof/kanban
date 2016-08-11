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

                                    <button id="delete">
                                        <i class="fa fa-trash-o"></i>
                                        Delete
                                    </button>
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


    <div id="modalTask" class="modal fade" tabindex="-1" role="dialog">
    </div><!-- /.modal -->


@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('.panel-gray .panel-body').on('click',function(e) {
               var id = $(this).attr('data-task-id');

                $.get('/project/task/'+id+'/async', function(data) {

                    var task = data.task;
                    var select = data.select;

                    $('#modalTask').empty();

                    var html_modal = '<div class="modal-dialog" role="document">' +
                            '<div class="modal-content">' +
                           '<div class="modal-header">' +
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                    '<h4 class="modal-title">'+task.nome+'</h4>' +
                    '</div>' +
                    '<div class="modal-body">' +
                            '<p>One fine body&hellip;</p>' +
                    '</div>'+
                    '<div class="modal-footer">' +
                            '<div class="col-md-1">' +
                                '<a href="/project/task/'+task.id+'/edit" class="btn btn-default"><i class="fa fa-edit"></i></a>&nbsp;' +
                            '</div>' +
                            '<div class="col-md-1">' +
                                '<a href="/project/task/'+task.id+'/destroy" class="btn btn-danger"><i class="fa fa-trash"></i></a>' +
                            '</div>';


                    if(select.length > 0) {
                        html_modal +=  '<form class="form-inline" method="GET" action="/project/task/change/'+task.id+'/status"><div class="form-group"><select name="status" id="status" class="form-control select-status"><option value="0">Status</option>';
                        for(var i=0; i<select.length;i++) {
                            html_modal += '<option value="'+select[i]+'">'+select[i]+'</option>';
                        }
                        html_modal += '</select></div>&nbsp;<button class="btnStatus btn btn-info">Ok</button></form>';
                    }

                    html_modal += '</div>' +
                    '</div>' +
                    '</div>' ;

                    $('#modalTask').append(html_modal);
                    $('#modalTask').modal();
                });
            });


            $(".btnStatus").click(function (e) {
                e.preventDefault();

                var status  = S('select-status').val();

                if(status != '0') {
                    $('form').submit();
                }
            });


        });
    </script>
@endsection












