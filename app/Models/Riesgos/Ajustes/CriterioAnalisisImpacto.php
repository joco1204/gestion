<?php

namespace App\Models\Riesgos\Ajustes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CriterioAnalisisImpacto extends Model
{
   use SoftDeletes;
    use HasFactory;
    protected $table = 'criterios_analisis_impacto';
    protected $primaryKey= 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
    'impacto_id',
    'nombre'

    ];
    public $timestamps = true;
}
