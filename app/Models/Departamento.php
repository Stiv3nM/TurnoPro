<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nombre'])]
class Departamento extends Model
{
    public function puestos()
    {
        return $this->hasMany(Puesto::class);
    }

    public function empleados()
    {
        return $this->hasManyThrough(Empleado::class, Puesto::class);
    }
}
