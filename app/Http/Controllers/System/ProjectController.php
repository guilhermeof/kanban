<?php

namespace App\Http\Controllers\System;

use App\Project;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $user = $request->user();

        $projects = $user->projects;

        return view('projects.index',['projects' => $projects]);

    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        // Validação
        $this->validate($request, array(
            'nome' => 'required|max:400',
            'idCreator' => 'required'
        ));

        $project = new Project();
        $project->nome = $request->nome;
        $project->idCreator = $request->idCreator;

        $project->save();

        flash('Projeto criado com Sucesso !', 'success');

        return redirect()->route('ProjectMain');

    }

    public function edit($id)
    {

        $project = Project::find($id);

        return view('projects.edit', compact('project'));

    }

    public function update(Request $request, $id)
    {
        //Validação
        $this->validate($request, array(
            'nome' => 'required|max:400',
            'idCreator' => 'required'
        ));

        $project = Project::find($id);
        $project->nome = $request->nome;
        $project->idCreator = $request->idCreator;
        $project->save();

        flash('Projeto Atualizado com Sucesso !', 'success');

        return redirect()->route('ProjectMain');
    }

    public function destroy($id)
    {

        $project = Project::find($id);

        $tasks = $project->tasks;

        foreach($tasks as $task) {
            $task->delete();
        }

        $project->delete();

        flash('Projeto deletado com Sucesso !', 'success');

        return redirect()->route('ProjectMain');

    }
}
