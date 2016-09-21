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
use Validator;
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

    public function create(Request $request)
    {
        $idProject = $request->get("project");

        $result = ['data' => []];

        $project = Project::find($idProject);

        $result = array(
            'project' => $project
        );

        return response()->json($result, 200);

    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nome' => 'required|min:7|max:400',
            'project_id' => 'required',
        ],
        [
            'nome.min' => 'O campo nome deve ter no mínimo 7 caracteres',
            'project_id.required' => 'O id do projeto não foi encontrado'
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->messages(), 500, [], JSON_UNESCAPED_UNICODE);
        }

        try{
            $task = new Task();

            if (!$request->project_id){
                return new JsonResponse("O id do projeto não foi encontrado", 400, [], JSON_UNESCAPED_UNICODE);
            }

            $task->nome = $request->nome;
            $task->idProject = $request->project_id;

            $task->save();

            return new JsonResponse(['task' => $task,'message' =>"Tarefa criada com sucesso"], 200);
        }catch (Exception $e){
            return new JsonResponse("Erro ao tentar criar nova tarefa. Por favor tente novamente", 500);
        }
    }

    public function destroy(Request $request)
    {
        $idTask = $request->get("task");

        try {

            DB::beginTransaction();

            $task = Task::find($idTask);

            if (!$task) {
                return new JsonResponse("Tarefa não existe.", 404, [], JSON_UNESCAPED_UNICODE);
            }

            $idProjeto = $task->idProject;

            $task->delete();

            DB::commit();

            return new JsonResponse("Tarefa deletada com sucesso.");


        } catch (\Exception $e) {

            DB::rollBack();

            return new JsonResponse("Erro ao tentar deletar tarefa. Por favor, tente novamente.", 500);

        }


    }

    public function edit(Request $request)
    {
        $idTask = $request->get("task");

        $result = ['data' => []];

        $task = Task::find($idTask);

        $result = array(
          'task' => $task
        );

        return response()->json($result, 200);
    }

    public function update(Request $request, $idTask)
    {
        //Validação
        $this->validate($request, array(
            'nome' => 'required|max:400',
        ));

        try{
            $task = Task::find($idTask);

            if (!$task){
                return new JsonResponse("O id do projeto não foi encontrado", 400, [], JSON_UNESCAPED_UNICODE);
            }
            $task->update($request->all());
            return new JsonResponse(['task' => $task,'message' =>"Tarefa atualizada com sucesso"], 200);
        }catch (Exception $e){
            return new JsonResponse("Erro ao tentar salvar. Por favor, tente novamente.", 500);
        }
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
