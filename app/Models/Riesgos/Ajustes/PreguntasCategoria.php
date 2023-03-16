<?php

namespace App\Models\Riesgos\Ajustes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Riesgos\Ajustes\OpcionesPregunta;
class PreguntasCategoria extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'preguntas_categoria_valoracion';
    protected $primaryKey= 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
    'nombre',
    'categoria_id',
    ];
    public $timestamps = true;
    public function opciones()
    {
        return $this->hasMany(OpcionesPregunta::class , 'pregunta_id');
    }
}
