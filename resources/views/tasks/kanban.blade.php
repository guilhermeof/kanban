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
                        <h4>Processing...</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

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
    <script type="application/javascript">



        $(function () {
            var kanbanCol = $('.panel-body');
            //kanbanCol.css('max-height', (window.innerHeight - 150) + 'px');

            //var kanbanColCount = parseInt(kanbanCol.length);
            //$('.container-fluid').css('min-width', (kanbanColCount * 350) + 'px');

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

                    var idTask = elementId;
                    var status = targetId;

                    console.log(idTask);
                    console.log(status);

                    children.prepend(element);

                }

               event.preventDefault();
            });
        }

    </script>
@stop