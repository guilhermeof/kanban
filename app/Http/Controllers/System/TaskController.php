<?php

namespace App\Http\Controllers\System;

use App\Project;
use App\Task;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\System;
use App\Http\Requests;


class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($idProject)
    {
        $project = Project::find($idProject);

        $tasksAll = $project->tasks;

        $tasks = ['todo' => [], 'doing' => [], 'review' => [], 'done' => []];

        foreach($tasksAll as $obj) {
            if($obj->status == "todo") {
                $tasks['todo'][] = $obj;
            } elseif ($obj->status == 'doing') {
                $tasks['doing'][] = $obj;
            } elseif ($obj->status == 'review') {
                $tasks['review'][] = $obj;
            } else {
                $tasks['done'][] = $obj;
            }
        }

        return view('tasks.index',['tasks' => $tasks , 'project' => $project]);
    }

    public function create($idProject)
    {

        $project = Project::find($idProject);

        return view('tasks.create', ['project' => $project]);

    }

    public function store(Request $request)
    {
        // Validação
        $this->validate($request, array(
            'nome' => 'required|max:400',
            'idProject' => 'required'
        ));

        $task = new Task();
        $task->nome = $request->nome;
        $task->idProject = $request->idProject;


        $task->save();

        flash('Tarefa Criada com Sucesso !', 'success');


        return redirect()->route('TaskMain', ['id' => $request-> idProject]);

    }

    public function destroy($idProjeto, $idTask)
    {

        try {

            DB::beginTransaction();

            $task = Task::find($idTask);

            if (!$task) {
                flash('Erro !', 'danger');

            }

            $task->delete();

            DB::commit();
            flash('Tarefa Deletado com Sucesso !', 'success');

            return redirect()->route('TaskMain', ['id' => $idProjeto]);

        } catch (\Exception $e) {

            DB::rollBack();

            if (config('app.debug') == true) {
                return $e->getMessage();
            }

        }


    }

    public function edit($id)
    {
        $task = Task::find($id);

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        //Validação
        $this->validate($request, array(
            'nome' => 'required|max:400',
            'idProject' => 'required'


        ));

        $task = Task::find($id);

        $task->update($request->all());

        flash('Tarefa Atualizada com Sucesso !', 'success');

        return redirect()->route('TaskMain', ['id' => $task->idProject]);
    }

    public function status($id)
    {
        $status = Task::find($id);

        //$tasks = ['todo' => [], 'doing' => [], 'review' => [], 'done' => []];


        if($status->status === "todo"){
            $status->status = "doing";
            $status->save();
            return redirect()->back();
        }
        if($status->status === "doing"){
            $status->status = "review";
            $status->save();
            return redirect()->back();
        }
        if($status->status === "review"){
            $status->status = "done";
            $status->save();
            return redirect()->back();
        }





    }
}
