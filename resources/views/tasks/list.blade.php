@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <button type="button" class="btn btn-success">Aperte e o Modal aparecerá</button>
                <button type="button" class="btn btn-info btnProject">Aperte e o Novo Modal aparecerá</button>
            </div>
        </div>
    </div>

    <div class="modal fade modal1" tabindex="-1" role="dialog">
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('scripts')
    <script>
        $(function () {
            $('.container .btn-success').click(function (e) {

                $.ajax({
                    method: 'GET',
                    url: '/project/task/14/async'
                }).done(function (data){
                    var task = data.task;
                    var modal = $('.modal1');

                    var title = $('.modal1 .modal-title');
                    var body = $('.modal1 .modal-body');

                    title.empty();
                    title.append(task.nome);

                    body.empty();
                    body.append('<p>Este é o corpo do Modal</p>');

                    modal.modal();
                }).fail(function(data){
                    var obj = data.responseJSON;
                    alert(obj.error);
                });
            })

            $('.container .btnProject').click(function (e) {

                var modal = $('.modal1');

                var title = $('.modal1 .modal-title');
                var body = $('.modal1 .modal-body');

                title.empty();
                title.append("Project 1");

                body.empty();
                body.append('<p>Este é o corpo do Modal Project</p>');

                modal.modal();
            });
        });
    </script>
@endsection