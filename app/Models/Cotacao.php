<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotacao extends Model
{
    use HasFactory;

    // Indica quais as colunas que podem ser preenchidas automaticamente
    protected $fillable = [
        'nome',
        'data_nascimento',
        'destino',
        'data_inicio',
        'data_fim',
        'bagagem',
        'dias_cobrados',
        'idade',
        'valor_base',
        'subtotal',
        'valor_bagagem',
        'total',
    ];
}