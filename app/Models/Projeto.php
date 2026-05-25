<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    //
    protected $table = 'projetos';

    protected $fillable = [
        'nome',
        'descricao',
    ];

    // Relacionamento com Tarefa 1:N
    public function tarefas(){
        return $this->hasMany(Tarefa::class);
    }

    // Relacionamento com User N:N
    public function users(){
        return $this->belongsToMany(User::class, 'projeto_user');
    }

    
}
