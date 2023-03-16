<?php

namespace App\Models\Riesgos\Ajustes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class EscalasValoracion extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'escalas_valoracion';
    protected $primaryKey= 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
    'cantidad_casillas_id',
    'nombre',
    'porcentaje',
    'color',
    

    ];
    public $timestamps = true;
}
