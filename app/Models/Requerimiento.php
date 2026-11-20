<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['puesto_id', 'dia_semana', 'tipo', 'cantidad'])]
class Requerimiento extends Model
{
    public function puesto()
    {
        return $this->belongsTo(Puesto::class);
    }
}
