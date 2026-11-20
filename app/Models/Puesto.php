<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['departamento_id', 'nombre'])]
class Puesto extends Model
{
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }

    public function requerimientos()
    {
        return $this->hasMany(Requerimiento::class);
    }
}
