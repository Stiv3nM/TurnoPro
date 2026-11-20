<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nombre', 'tipo', 'hora_inicio', 'hora_fin'])]
class Turno extends Model
{
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
