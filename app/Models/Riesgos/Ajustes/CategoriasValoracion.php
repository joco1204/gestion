<?php

namespace App\Models\Riesgos\Ajustes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Riesgos\Ajustes\PreguntasCategoria;
class CategoriasValoracion extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'categorias_valoracion';
    protected $primaryKey= 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
    'nombre',
    ];
    public $timestamps = true;


    public function preguntas()
    {
        return $this->hasMany(PreguntasCategoria::class , 'categoria_id')->with('opciones');
    }
}
