<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nombre', 'apellido', 'correo', 'puesto_id'])]
class Empleado extends Model
{
    public function puesto()
    {
        return $this->belongsTo(Puesto::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
