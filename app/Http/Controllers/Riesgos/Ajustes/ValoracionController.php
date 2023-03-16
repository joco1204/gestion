<?php

namespace App\Http\Controllers\Riesgos\Ajustes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Riesgos\Ajustes\PreguntasCategoria;
use App\Models\Riesgos\Ajustes\OpcionesPregunta;
use App\Models\Riesgos\Ajustes\CategoriasValoracion;
use App\Models\Riesgos\Ajustes\EscalasValoracion;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
class ValoracionController extends Controller
{

    public function index()
    {
     return view("riesgos.ajustes.valoracion.inicio-valoracion");
    }

    public function listaCategorias(){

        $categorias =CategoriasValoracion::with('preguntas')->get(['id', 'nombre']);
        return $categorias;
         
    }

    public function listaEscalas(){

        $escalas =EscalasValoracion::where('id','>' , 0)->orderBy('id','ASC')->get();
        return $escalas;
         
    }

    public function edicionEscalas(Request $request){
        $idEscala=0;
        $color='';
        $porcentaje=0;
        $cantidad_id=0;

        foreach ($request['edit'] as  $lista) {
            foreach ($lista as  $nombre=>$valor) {

                
                if($nombre === "porcentaje"){
                  $porcentaje = $valor; 
                }
                if($nombre === "id"){
                  $idEscala=$valor;  
                }
                if($nombre === "color"){
                    $color = $valor; 
                }
                if($nombre === "cantidad_casillas_id"){
                  $cantidad_id=$valor;
                  $escala = EscalasValoracion::find($idEscala);
                  $escala->cantidad_casillas_id=$cantidad_id;
                  $escala->color=$color;
                  $escala->porcentaje=$porcentaje;

                  $escala->save();
                  if($escala->nombre == 'Fuerte'){
                    $escalaDebil =EscalasValoracion::where('nombre' , 'Débil')->first(['porcentaje']);
                    $promedio= ($escala->porcentaje + $escalaDebil->porcentaje)/2;
                    $escalaModerado=EscalasValoracion::where('nombre' , 'Moderado')->first();
                    $escalaModerado->porcentaje = intval($promedio);
                    $escalaModerado->save();

                  }
                  $idEscala=0;
                  $color='';
                  $porcentaje=0;
                  $cantidad_id=0;
                }
               
            }
          
        }
         
    }


    public function edicionPreguntas($preguntas){
        $idPregunta=0;
        $nombre_pregunta='';
        foreach ($preguntas as $pregunta) {
            foreach ($pregunta as $nombrePregunta => $valorPregunta ) {
                    if($nombrePregunta == "id"){
                      $idPregunta=$valorPregunta;  
                    }
                    if($nombrePregunta == "nombre"){
                      $nombre_pregunta=$valorPregunta;

                    }       
                    if($nombrePregunta == "opciones"){

                       $preguntaEdit =PreguntasCategoria::find($idPregunta);
                       $preguntaEdit->nombre=$nombre_pregunta;
                       $preguntaEdit->save();
                       $idPregunta=0;
                       $nombre_pregunta='';
                       $this->edicionOpciones($valorPregunta);
                            
                    } 
                           
            }
                       
        }


    }
    public function guardar(Request $request){
      switch($request['id']){
        case 1 :
        $categoria = new CategoriasValoracion;

        $datos=collect($request)->except(['id','porcentaje','categoria_id','pregunta_id'])->toArray();
        $categoria->create($datos);
        
        break ;
        case 2 : 
        $pregunta = new PreguntasCategoria;

        $datos=collect($request)->except(['id','porcentaje','pregunta_id'])->toArray();
        $pregunta->create($datos);
        break;

        case 3 :
        $opciones = new OpcionesPregunta;

        $datos=collect($request)->except(['id','categoria_id'])->toArray();
        $opciones->create($datos);
        break;



      }

    }

    public function edicionOpciones($opciones){
        $idOpcion=0;
        $nombre_opcion='';
        $porcentaje =0.0;
        foreach ($opciones as $opcion) {

            foreach ($opcion as $nombreOpcion => $valorOpcion ) {
              
              if($nombreOpcion == "id"){
                $idOpcion=$valorOpcion;                        
              }
              if($nombreOpcion == "nombre"){
                  $nombre_opcion=$valorOpcion;                      
              }                      
              if($nombreOpcion == "porcentaje"){
                 $porcentaje=$valorOpcion;
                 $opcionEdit =OpcionesPregunta::find($idOpcion);
                 $opcionEdit->nombre=$nombre_opcion;
                 $opcionEdit->porcentaje=$porcentaje;
                 $opcionEdit->save();
                 $idOpcion=0;
                $nombre_opcion='';
                $porcentaje =0.0;  

              }
                                       
            }
                                   
        }

    }

    public function store(Request $request)
    {

        $idCategoria=0;
        $nombre_categoria='';
        foreach ($request['editados'] as  $lista) {
            foreach ($lista as  $nombreCategoria=>$valorCategoria) {
                if($nombreCategoria == "id"){
                  $idCategoria=$valorCategoria;  
                }
                if($nombreCategoria == "nombre"){
                    $nombre_categoria=$valorCategoria;

                }
                if($nombreCategoria == "preguntas"){

                    $categoria =CategoriasValoracion::find($idCategoria);
                    $categoria->nombre=$nombre_categoria;
                    $categoria->save();
                    $idCategoria=0;
                    $nombre_categoria='';
                    $this->edicionPreguntas($valorCategoria); 
                }
               
            }
          
        }


 
        
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($idCategoria)
    {

         $this->eliminarPreguntas($idCategoria);
        $categoria =CategoriasValoracion::findOrFail($idCategoria)->delete();
           
        
    }
    public function eliminarOpcion($idOpcion)
    {
        $opcion= OpcionesPregunta::find($idOpcion);
        $opcion->delete();
    }

    public function eliminarPregunta($idPregunta)
    {
        if(PreguntasCategoria::findOrFail($idPregunta)->delete()){
            $this->eliminarOpciones($idPregunta);
        }
    }
    public function eliminarPreguntas($idCategoria){

        $preguntas = PreguntasCategoria::where('categoria_id' ,$idCategoria)->get(['id']);
        foreach ($preguntas as $key => $pregunta) {
           $this->eliminarOpciones($pregunta->id);
            $pregunta->delete();
        }
        
    }

    public function eliminarOpciones($idPregunta){

            $opciones =OpcionesPregunta::where('pregunta_id' , $idPregunta)->delete();

    }
}
