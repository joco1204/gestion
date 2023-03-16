<?php

namespace App\Models\Riesgos\Ajustes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OpcionesPregunta extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'opciones_pregunta_valoracion';
    protected $primaryKey= 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
    'nombre',
    'pregunta_id',
    'porcentaje',
    ];
    public $timestamps = true;
  
}
