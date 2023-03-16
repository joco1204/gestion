<?php

namespace App\Models\Riesgos\Ajustes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Riesgos\Ajustes\ProbabilidadMatriz;
use App\Models\Riesgos\Ajustes\ImpactoMatriz;
class MatrizRiesgo extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'matrices_riesgo';
    protected $primaryKey= 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
    'nombre' 

    ];
    public $timestamps = true;

    public function impactos()
    {
        return $this->hasMany(ImpactoMatriz::class , 'matriz_id')->with('criterios_analisis');
    }

    public function probabilidades()
    {
        return $this->hasMany(ProbabilidadMatriz::class , 'matriz_id')->with('criterios_analisis');
    }
}
