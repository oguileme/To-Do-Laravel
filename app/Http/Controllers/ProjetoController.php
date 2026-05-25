<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use Illuminate\Http\Request;

class ProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //verificar se o usuário tem permissão para acessar os projetos e esta logado.

        try{

            //if(!auth()->check()){
                //return response()->json(['error' => 'Usuário não autenticado'], 401);
            //}


            //$projetos = Projeto::with('tarefas', 'users')->get();
            
            $projetos = Projeto::all();
            return response()->json($projetos, 200);
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
        //verifica se o usuário tem permissão para criar um projeto e esta logado.

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        try {
            $projeto = Projeto::create($data);
            //$projeto->users()->attach($request->user()->id); // Adiciona o usuário criador ao projeto. Mudar para auth dps
            return response()->json($projeto, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Projeto $projeto)
    {
        //verficar se o usuário tem permissão para acessar o projeto e esta logado.

        try {
            $projeto->load('tarefas', 'users'); //verificar esse load
            return response()->json($projeto, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projeto $projeto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Projeto $projeto)
    {
        // verificar se o usuário tem permissão para atualizar o projeto e esta logado.
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        try {
            $projeto->update($data);
            return response()->json($projeto, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projeto $projeto)
    {
        //verficar se o usuário tem permissão para deletar o projeto e esta logado.
        try{
            $projeto_id = $projeto->id;
            $projeto->delete($projeto_id);
            return response()->json(['message' => 'Projeto deletado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addUser(Request $request, Projeto $projeto)
    {
        //verificar se o usuário tem permissão para adicionar um usuário ao projeto e esta logado.
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        try {
            $projeto->users()->attach($data['user_id']);
            return response()->json(['message' => 'Usuário adicionado ao projeto com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
