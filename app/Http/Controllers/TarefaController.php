<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;

class TarefaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //verificar se o usuário tem permissão para acessar as tarefas de tal projeto e esta logado.
        try{
            $tarefas = Tarefa::with('projeto')->get();
            return response()->json($tarefas, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //verifica se o usuário tem permissão para criar uma tarefa e esta logado.
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_vencimento' => 'nullable|date',
            'projeto_id' => 'nullable|exists:projetos,id',
        ]);

        try {
            $tarefa = Tarefa::create($data);
            return response()->json($tarefa, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarefa $tarefa)
    {
        
        //verficar se o usuário tem permissão para acessar a tarefa e esta logado.
        try {
            $tarefa->load('projeto'); //verificar esse load
            return response()->json($tarefa, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarefa $tarefa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        //verfiicar se o usuário tem permissão para atualizar a tarefa e esta logado.
        $data = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'descricao' => 'nullable|string',
            'data_vencimento' => 'nullable|date',
            'concluida' => 'boolean',
            'projeto_id' => 'nullable|exists:projetos,id',
        ]);

        try{
            $tarefa->update($data);
            return response()->json($tarefa, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarefa $tarefa)
    {
        //verficar se o usuário tem permissão para deletar a tarefa e esta logado.
        try{
            $tarefa_id = $tarefa->id;
            $tarefa->delete($tarefa_id);
            return response()->json(['message' => 'Tarefa deletada com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function toggleConcluida(Tarefa $tarefa)
    {
        //verificar se o usuário tem permissão para atualizar a tarefa e esta logado.
        try {
            $tarefa->concluida = !$tarefa->concluida;
            $tarefa->save();
            return response()->json($tarefa, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
