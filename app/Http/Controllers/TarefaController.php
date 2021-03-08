<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarefa;

class TarefaController extends Controller
{
    public function show()
    {
       return Tarefa::orderBy('data', 'DESC')->get();
    }

    public function filter($filter)
    {
      //SELECT * FROM `tarefas` WHERE tipo = 'Normal' 
      return Tarefa::where('tipo', '=' ,$filter)->get();


     

    }

    public function create(Request $request)
    {
        Tarefa::create($request->all());
        return response()->json('Tarefa adicionada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->update($request->all());
        return response()->json('Tarefa atualizado com sucesso!');
    }

    public function delete($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->delete();
        return response()->json('Tarefa deletada com sucesso!'); 
    }
}
