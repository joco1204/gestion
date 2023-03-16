<?php

namespace App\Models\Riesgos\Ajustes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Riesgos\Ajustes\CriterioAnalisisImpacto;
class ImpactoMatriz extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'impacto_matriz';
    protected $primaryKey= 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
    'matriz_id',
    'nombre',
    'valor',
    'descripcion'

    ];
    public $timestamps = true;
    public function criterios_analisis()
    {
        return $this->hasMany(CriterioAnalisisImpacto::class , 'impacto_id');
    }
}
