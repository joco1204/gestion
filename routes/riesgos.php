<?php
use App\Http\Controllers\Riesgos\RiesgosController;
use App\Http\Controllers\Riesgos\Ajustes\AgentesGeneradoresController;
use App\Http\Controllers\Riesgos\Ajustes\ClasesControlesController;
use App\Http\Controllers\Riesgos\Ajustes\ClasesController;
use App\Http\Controllers\Riesgos\Ajustes\ValoracionController;
use App\Http\Controllers\Riesgos\Ajustes\MatrizRiesgosController;

Route::group(['prefix' => 'riesgos'], function(){
    Route::get('/',  [RiesgosController::class, 'getHome']);
   //Ajustes->AgentesGeneradores
   Route::get('/ajustes/agentes_generadores/lista-agentes',  [AgentesGeneradoresController::class, 'listaAgentesGeneradores']);
   Route::apiResource('/ajustes/agentes_generadores', AgentesGeneradoresController::class);
   
   //Ajustes->ClasesControles
   Route::get('/ajustes/clases_controles/lista',  [ClasesControlesController::class, 'lista']);
   Route::apiResource('/ajustes/clases_controles', ClasesControlesController::class);

   //Ajustes-->Clases
   Route::get('/ajustes/clases/lista',  [ClasesController::class, 'lista']);
   Route::get('/ajustes/clases/lista-matrices',  [ClasesController::class, 'listaMatrices']);
   Route::get('/ajustes/clases/lista-agentes-activos',  [ClasesController::class, 'listaAgentesActivos']);
   Route::get('/ajustes/clases/lista-agentes-asignados/{id}',  [ClasesController::class, 'listaAgentesAsignados']);
   Route::apiResource('/ajustes/clases', ClasesController::class);

   //Ajustes->Valoracion
   Route::get('/ajustes/valoracion/lista-categorias',  [ValoracionController::class, 'listaCategorias']);
   Route::get('/ajustes/valoracion/crear',  [ValoracionController::class, 'store2']);
    Route::get('/ajustes/valoracion/lista-escalas',  [ValoracionController::class, 'listaEscalas']);
   Route::put('/ajustes/valoracion/editarEscalas',  [ValoracionController::class, 'edicionEscalas']);
   Route::delete('/ajustes/valoracion/eliminarOpcion/{id}',  [ValoracionController::class, 'eliminarOpcion']);
   Route::delete('/ajustes/valoracion/eliminarPregunta/{id}',  [ValoracionController::class, 'eliminarPregunta']);
   Route::post('/ajustes/valoracion/guardarNuevos',  [ValoracionController::class, 'guardar']);

   Route::apiResource('/ajustes/valoracion', ValoracionController::class);

   //Ajustes Matrices de riesgo
   Route::apiResource('/ajustes/matrices_riesgo', MatrizRiesgosController::class);

});