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
use Illuminate\Http\JsonResponse;
use Mockery\CountValidator\Exception;
use Symfony\Component\HttpFoundation\Response;


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

    public function kanban($idProject)
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

        return view('tasks.kanban',['tasks' => $tasks , 'project' => $project]);
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


        return redirect()->route('TaskKanban', ['id' => $request-> idProject]);

    }

    public function destroy($idTask)
    {

        try {

            DB::beginTransaction();

            $task = Task::find($idTask);

            if (!$task) {
                flash('Erro !', 'danger');
            }

            $idProjeto = $task->idProject;

            $task->delete();

            DB::commit();
            flash('Tarefa Deletado com Sucesso !', 'success');

            return redirect()->route('TaskKanban', ['id' => $idProjeto]);

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

        return redirect()->route('TaskKanban', ['id' => $task->idProject]);
    }

    public function changeStatus($id, Request $request)
    {
        $task = Task::find($id);

        if($request->input('status') != '0')
        {
            $task->status = $request->input('status');
        }

        $task->save();

        return redirect()->route('TaskKanban', ['id' => $task->idProject]);
    }

    public function ascynChangeStatus(Request $request)
    {
        $taskId = $request->get("task");
        $status = $request->get("status");

        try {
            $task = Task::find($taskId);

            if (is_null($task)) {
                return new JsonResponse("Tarefa não existe.", 404, [], JSON_UNESCAPED_UNICODE);
            }

            if ( !$this->canChangeStatus($task->status, $status)) {
                return new JsonResponse('Você não pode alterar essa tarefa para este status.', 403, [], JSON_UNESCAPED_UNICODE);
            }

            $task->status = $status;

            $task->save();

            return new JsonResponse("Tarefa atualizada com sucesso.");
        } catch (Exception $e) {
            return new JsonResponse("Erro ao tentar salvar. Por favor, tente novamente.", 500);
        }
    }

    private function canChangeStatus($statusAtual, $novoStatus)
    {
        $novoStatus = strtolower($novoStatus);

        switch ($statusAtual) {
            case 'todo':
                if ($novoStatus == 'doing') {
                    return true;
                }
            break;
            case 'doing':
                if ($novoStatus == 'todo' || $novoStatus == 'review') {
                    return true;
                }
            break;
            case 'review':
                if ($novoStatus == 'done') {
                    return true;
                }
            break;
        }

        return false;
    }

    public function show($id)
    {
        $task = Task::find($id);

        $result = ['data' => [], 'error' => []];

        if(is_null($task)) {
            $result['error'] = "Task não encontrada";
            return response()->json($result, 404);
        }

        $result = array(
            'task' => $task
        );

        return response()->json($result, 200);
    }

}
