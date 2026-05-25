<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    //
    protected $table = 'tarefas';

    protected $fillable = [
        'titulo',
        'descricao',
        'data_vencimento',
        'concluida',
        'projeto_id',
    ];

    // Relacionamento com Projeto N:1
    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }
}
