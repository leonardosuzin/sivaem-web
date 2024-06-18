<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curriculo extends Model
{
    protected $fillable = ['descricao', 'cargo', 'experiencia', 'salario', 'user_id'];
}
