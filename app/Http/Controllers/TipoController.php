<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo;

class TipoController extends Controller
{
    public function show()
    {
        return Tipo::all();
    }

    public function create(Request $request)
    {
        Tipo::create($request->all());
        return response()->json('Tipo adicionado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $tipo = Tipo::findOrFail($id);
        $tipo->update($request->all());
        return response()->json('Tipo atualizado com sucesso!');
    }

    public function delete($id)
    {
        $tipo = Tipo::findOrFail($id);
        $tipo->delete();
        return response()->json('Tipo deletado com sucesso!'); 
    }


    
    
    






}
