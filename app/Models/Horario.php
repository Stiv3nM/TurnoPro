<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['empleado_id', 'turno_id', 'fecha', 'observaciones'])]
class Horario extends Model
{
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }
}
