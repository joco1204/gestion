<template>
 <div>

     <div class="breadcrumb">
        <div class="col-lg-6">
        
        <h1>Valoración</h1>
        </div>


    </div>
   

    <div class="separator-breadcrumb border-top"></div>
          <div  class="col-lg-12">
           <!--TABS-->     
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="escala-valoracion-tab" data-toggle="tab" href="#escalaValoracion" role="tab" aria-controls="escalaValoracion" aria-selected="true"><i class="fas fa-chart-bar"></i> Escala de valoración</a>
                   </li>
                   <li class="nav-item">
                    <a class="nav-link" id="preguntas-valoracion-tab" data-toggle="tab" href="#preguntasValoracion" role="tab" aria-controls="preguntasValoracion" aria-selected="false"><i class="fas fa-question-circle"></i> Preguntas de valoración</a>
                  </li>
              </ul>

              <div class="tab-content" id="myTabContent">
                <!--contenido tab escala valoracion-->
                <div class="tab-pane fade show active" id="escalaValoracion" role="tabpanel" aria-labelledby="escala-valoracion-tab">
                  
                  <form  @submit.prevent ="saveEscalas">
                  <div class="col-md-12" v-for = "escala in escalas" id="escala">
                    <div class="row">
                        <div class="col-lg-2">
                          <label for="nombre"> Nombre escala</label>
                          <h5><strong >{{escala.nombre}}</strong></h5>
                        </div>
                        <div class="col-lg-2">
                          <label for="color">Color</label>
                          <input type="color" class="form-control" name="color" v-model="escala.color">
                        </div>
                        <div v-if="escala.nombre == 'Moderado'" class="col-lg-3">
                          <input type="hidden"  v-model="escala.porcentaje" name="porcentaje">
                        </div>
                        <div v-else  class="col-lg-3 ">
                          <label for="porcentaje">Porcentaje %</label>
                           <input type="number" class="form-control" v-model="escala.porcentaje" name="porcentaje" min="0" max="100" placeholder="porcentaje" required>
                        </div>
                        

                        <div class="col-lg-4">
                          <label for="porcentaje">Cantidad de casillas de disminucion</label>
                          <Multiselect
                            v-model="escala.cantidad_casillas_id"
                             v-bind="selectCantidad"
                        ></Multiselect>
                        </div>

                     </div>

                    <hr>
                  
                  </div>
                  <div v-if="escalas.length > 0"class="col-lg-12">
                    
                       <div align="center">
                         <button  type="submit" class="btn btn-primary" >Guardar cambios <i class="fas fa-save"></i>
                      </button>
                       </div>
                  
                  </div>
                  </form>


                </div>
                <!--contenido tab preguntas valoracion-->
                <div class="tab-pane fade" id="preguntasValoracion" role="tabpanel" aria-labelledby="preguntas-valoracion-tab">

                <form  @submit.prevent ="saveEdit" id="form">

                  <div class="col-lg-12 text-right">
                    <button  @click="abrirModal(1 , 0 ,0);" type="button" class="btn btn-warning" >
                        <i class="fas fa-plus"></i> Agregar Categoria
                    </button>
                                      
                  </div>
                  <br>
                  <div class="col-md-12" v-for = "categoria in categorias" id="categorias">
                  <br>
                  <!--accordion categorias-->
                  <div class="accordion" :id="'accordionCategoria'+categoria.id">
                    <div class="card">
                      <div class="card-header" :id="'headCategoria'+categoria.id">
                          <div class="row">
                            <div class="col-lg-9">
                              <input v-if="editar == categoria.id" v-model="categoria.nombre" type="text" id="nombre" name="nombre" class="form-control" required>

                             <h5 v-else><strong>{{categoria.nombre}}</strong></h5>

                            </div>
                            <div class="col-lg-3 text-right">
                              <a  @click="activarEdicion(categoria.id);"style='color:white'   class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                              <button type="button" @click=" eliminarCategoria(categoria.id)"class="btn btn-primary btn-sm"> <i class="fas fa-trash-alt"></i></button>
                            </div>
                          </div>
                      </div>

                      <div :id="categoria.id"  class="collapse" :aria-labelledby="'headCategoria'+categoria.id" :data-parent="'#accordionCategoria'+categoria.id">
                      <div class="card-body">
                      <div class="col-md-12" v-for = "pregunta in categoria.preguntas" id="preguntas"> 
                      <!--accordion preguntas-->
                      <div class="accordion" :id="'accordionPregunta'+pregunta.id">
                      <div class="card">
                        <div class="card-header" :id="'headPregunta'+pregunta.id">
                          <div class="row">
                            <div class="col-lg-9">
                              <input v-if="editarpregunta == categoria.id+'+'+pregunta.id " v-model="pregunta.nombre" type="text" id="nombre" name="nombre" class="form-control" required>

                              <h5 v-else><strong>{{pregunta.nombre}}</strong></h5>
                            </div>
                            <div class="col-lg-3 text-right">
                               <a  @click="activarEdicionPregunta(categoria.id , pregunta.id);"style='color:white'   class="btn btn-primary btn-sm"> <i class="fas fa-edit"></i></a>
                                <button type="button" @click="eliminarPregunta(pregunta.id)" class="btn btn-primary btn-sm"> <i class="fas fa-trash-alt"></i></button>
                            </div>
                          </div>
                        </div>

                        <div :id="'pregunta'+pregunta.id"  class="collapse" :aria-labelledby="'headPregunta'+pregunta.id" 
                        :data-parent="'#accordionPregunta'+pregunta.id">
                        <div class="card-body">
                          <div class="col-md-12" v-for = "opcion in pregunta.opciones" id="opciones ">
                              <div class="row">
                                <div class="col-lg-6">
                                  <input v-if="editaropcion === pregunta.id+'+'+opcion.id" v-model="opcion.nombre" type="text" id="nombre" name="nombre" class="form-control" required>
                                  <h6 v-else><strong>{{opcion.nombre}}</strong></h6>
                                </div>
                                <div class="col-lg-3">
                                 <input v-if="editaropcion === pregunta.id+'+'+opcion.id" v-model="opcion.porcentaje" type="number" step="any" id="nombre" name="nombre" class="form-control" required>
                                 <h6 v-else><strong>{{opcion.porcentaje}}%</strong></h6>
                                </div>
                                <div class="col-lg-3 text-right">
                                  <a  @click="activarEdicionOpcion(pregunta.id , opcion.id);"style='color:white'   class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i></a>
                                    <button  type="button" @click="eliminarOpcion(opcion.id);"class="btn btn-primary btn-sm"> <i class="fas fa-trash-alt"></i></button>
                                </div>
                              </div>
                              <br>
                          </div>
                          <br>
                      <button  @click="abrirModal(3 ,0 , pregunta.id);" type="button" class="btn btn-primary btn-sm"> <i class="fas fa-plus-circle"></i> Agregar opcion</button>
                          </div>
                        </div>
                        </div>
                       </div>
                      </div>
                      <br>
                      <button  @click="abrirModal(2,categoria.id , 0);" type="button" class="btn btn-primary btn-sm"> <i class="fas fa-plus-circle"></i> Agregar pregunta</button>
                     </div>
                    </div>
                   </div>
                  </div>
                 </div>
                 
                 <div v-if="categorias.length > 0"class="col-lg-12">
                  <hr>
                   <div align="center">
                     <button  type="submit" class="btn btn-primary" >Guardar cambios <i class="fas fa-save"></i>
                  </button>
                   </div>
                  
                 </div>
                  
                </form>
                  
                </div>





                <!-- The Modal -->
    <div class="modal" :class="{mostrar: modal}">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">{{tituloModal}}</h4>
            <button @click="cerrarModal();"  type="button" class="close" data-dismiss="modal">
              &times;
            </button>
          </div>
          <!-- Modal body -->
                    <div class="modal-body">
                      <div class="tab-pane fade active show" id="homePIll" role="tabpanel" aria-labelledby="home-icon-pill">  
                            <form  @submit.prevent ="save" id="form">
                                     <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="nombre">Nombre :</label>
                                                <input v-model="model.nombre" type="text" id="nombre" name="nombre" class="form-control" required>
                                            </div>
                                        </div>
                                        <div v-if="model.id == 3"class="col-md-12">
                                            <div class="form-group">
                                                <label for="porcentaj">porcentaje:</label>
                                                <input v-model="model.porcentaje" type="number" id="porcentaje" step="any" name="porcentaje" class="form-control"  required>
                                            </div>
                                        </div>
   
                                      </div>
                                        <hr>
                                        <div align="right">
                                          <button @click="cerrarModal();" type="button" class="btn btn-secondary"data-dismiss="modal">
                                            Cancelar <i class="fas fa-window-close"></i>
                                          </button>

                                          <button  type="submit" class="btn btn-primary" >
                                            Guardar <i class="fas fa-save"></i>
                                          </button>

                                           
                                        </div>

                             </form>               
                       </div>
                    </div>
        </div>
      </div>
    </div>  
              </div>
          </div>
                    
               
  </div>
     

</template>


<script>

export default {
    data () {
        return {
         modal:0,
         tituloModal:'',
         categorias:[] ,
         editar : '',
         editarpregunta :'',
         editaropcion:'',

         datos:{
          editados:[],
          nuevos :[]

         },
         model:{
          nombre:'',
          porcentaje:'',
          categoria_id:0,
          pregunta_id:0,
          id:0
         } ,

         escalas:[],
         selectCantidad: {
              value: 18,
              placeholder: 'Seleccione la cantidad de casillas',
              searchable: true,
              required: true,
              options: []
            },
          escalasNew:{
            edit:[],

          }
       
        }
    },
    mounted() {
      this.listar();
      this.listarEscalas();
      this.listarCantidadCasillas()
    },
    methods: {

      save: function ( event) {
        this.guardarNuevo();
      },

      saveEscalas: function ( event) {
        this.guardarEscalas();
      },

      saveEdit: function ( event) {
        this.guardar();
      },
      cerrarModal(){
        this.modal=0;
      },
      async guardarNuevo(){
            try {
                await axios.post('valoracion/guardarNuevos' , this.model) ;
                swal({
                       type: "success",
                       title: "Operación exitosa",
                       text: "Datos guardados con exito",
                       buttonsStyling: false,
                       confirmButtonClass: "btn btn-lg btn-success",
                       confirmButtonText: "Cerrar"
                    }); 
              } catch (err) {
                swal({
                      type: "error",
                      title: "Error!",
                      text:"Lo sentimos ocurrio un error al guardar los datos",
                      confirmButtonText: "Cerrar",
                      buttonsStyling: false,
                      confirmButtonClass: "btn btn-lg btn-danger"
                     });
              }
        this.listar();
        this.cerrarModal();
         

      },

      async guardarEscalas(){

          //console.log(this.escalas);
          this.escalasNew.edit =this.escalas;

            try {
                 console.log(this.escalasNew.edit);
                await axios.put('valoracion/editarEscalas' , this.escalasNew) ;
                swal({
                       type: "success",
                       title: "Operación exitosa",
                       text: "Datos guardados con exito",
                       buttonsStyling: false,
                       confirmButtonClass: "btn btn-lg btn-success",
                       confirmButtonText: "Cerrar"
                    }); 
              } catch (err) {
                swal({
                      type: "error",
                      title: "Error!",
                      text:"Lo sentimos ocurrio un error al guardar los datos",
                      confirmButtonText: "Cerrar",
                      buttonsStyling: false,
                      confirmButtonClass: "btn btn-lg btn-danger"
                     });
              }
        this.listarEscalas();

         

      },

      async guardar(){

        this.datos.editados =this.categorias;

              try {
                await axios.post('valoracion' , this.datos) ;
                swal({
                       type: "success",
                       title: "Operación exitosa",
                       text: "Datos guardados con exito",
                       buttonsStyling: false,
                       confirmButtonClass: "btn btn-lg btn-success",
                       confirmButtonText: "Cerrar"
                    }); 
              } catch (err) {
                swal({
                      type: "error",
                      title: "Error!",
                      text:"Lo sentimos ocurrio un error al guardar los datos",
                      confirmButtonText: "Cerrar",
                      buttonsStyling: false,
                      confirmButtonClass: "btn btn-lg btn-danger"
                     });
              }
         
          this.listar();



      },

   
     activarEdicion(id){
      if(this.editar == id){
        this.editar ='';
        $("#"+id).toggle();

      }else{
        if(this.editar !== ''){
          $("#"+this.editar).toggle();
           this.editar = id;
           $("#"+id).toggle(); 
        }else{
         this.editar = id;
        $("#"+id).toggle(); 
        }
        
      }

     },
     activarEdicionPregunta(idCategoria , idPregunta){
      var id =idCategoria+'+'+idPregunta;
      this.editaropcion = '';
      if(this.editarpregunta == id){
        this.editarpregunta ='';
        $("#pregunta"+idPregunta).toggle();

      }else{
        if(this.editarpregunta !== ''){
          var array =this.editarpregunta.split('+');

          $("#pregunta"+array[1]).toggle();
           this.editarpregunta = id;
           $("#pregunta"+idPregunta).toggle(); 
        }else{
         this.editarpregunta = id;
        $("#pregunta"+idPregunta).toggle(); 
        }
        
      }

     },
     abrirModal(id , idCategoria, idPregunta){
        this.modal=1;
        this.limpiar();
        this.model.id = id;
        //alert(id);
        switch (id) {
            case 1:
           this.tituloModal="AGREGAR NUEVA CATEGORIA";
           break;
            case 2:
       
            this.tituloModal="AGREGAR NUEVA PREGUNTA";
            this.model.categoria_id =idCategoria;
            break;
            case 3:
            this.tituloModal="AGREGAR NUEVA OPCION";
            this.model.pregunta_id =idPregunta;
            break;
            default:

          }
      },

      limpiar(){
        this.model.nombre= '';
        this.model.porcentaje='';
        this.categoria_id=0;
        this.pregunta_id=0;
      },

     activarEdicionOpcion(idPregunta , idOpcion){
      var id =idPregunta+'+'+idOpcion;

      if(this.editaropcion == id){
        this.editaropcion ='';

      }else{
         this.editaropcion = id;
        
      }

     },
     eliminarOpcion(idOpcion){
         swal({
                    title: "Esta seguro de eliminar esta opcion?",
                    type: "warning",
                    text: "Esta acción no puede ser revertida",
                    showCancelButton: true,
                    confirmButtonColor: "#0CC27E",
                    cancelButtonColor: "#FF586B",
                    confirmButtonText: "Si, eliminar",
                    cancelButtonText: "No, cancelar",
                    confirmButtonClass: "btn btn-success mr-5",
                    cancelButtonClass: "btn btn-danger",
                    buttonsStyling: false
                }).then((result)=> {
                    if (result) {

                      axios.delete('valoracion/eliminarOpcion/' + idOpcion)
                      .then(response => {
                        swal({
                             type: "success",
                             title: "Operación exitosa",
                             text:"Opcion eliminada con exito",
                             buttonsStyling: false,
                             confirmButtonClass: "btn btn-lg btn-success",
                             confirmButtonText: "Cerrar"
                          });

                        this.listar();
                      }).catch(error => {
                        swal({
                            type: "error",
                            title: "Error!",
                            text:"Lo sentimos ocurrio un error al eliminar la opcion",
                            confirmButtonText: "Cerrar",
                            buttonsStyling: false,
                            confirmButtonClass: "btn btn-lg btn-danger"
                           });
                      });


                    
                    }
                },
                function(dismiss) {
                    // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                    if (dismiss === "cancel") {
                    }
                });

     },
     eliminarPregunta(idPregunta){
         swal({
                    title: "Esta seguro de eliminar esta pregunta?",
                    type: "warning",
                    text: "Se eliminara la pregunta y todas sus opciones ,esta acción no puede ser revertida",
                    showCancelButton: true,
                    confirmButtonColor: "#0CC27E",
                    cancelButtonColor: "#FF586B",
                    confirmButtonText: "Si, eliminar",
                    cancelButtonText: "No, cancelar",
                    confirmButtonClass: "btn btn-success mr-5",
                    cancelButtonClass: "btn btn-danger",
                    buttonsStyling: false
                }).then((result)=> {
                    if (result) {

                      axios.delete('valoracion/eliminarPregunta/' + idPregunta)
                      .then(response => {
                        swal({
                             type: "success",
                             title: "Operación exitosa",
                             text:"Pregunta eliminada con exito",
                             buttonsStyling: false,
                             confirmButtonClass: "btn btn-lg btn-success",
                             confirmButtonText: "Cerrar"
                          });

                        this.listar();
                      }).catch(error => {
                        swal({
                            type: "error",
                            title: "Error!",
                            text:"Lo sentimos ocurrio un error al eliminar la pregunta",
                            confirmButtonText: "Cerrar",
                            buttonsStyling: false,
                            confirmButtonClass: "btn btn-lg btn-danger"
                           });
                      });


                    
                    }
                },
                function(dismiss) {
                    // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                    if (dismiss === "cancel") {
                    }
                });

     },


     eliminarCategoria(idCategoria){
         swal({
                    title: "Esta seguro de eliminar esta categoria?",
                    type: "warning",
                    text: "Se eliminara la categoria y todas sus preguntas ,esta acción no puede ser revertida",
                    showCancelButton: true,
                    confirmButtonColor: "#0CC27E",
                    cancelButtonColor: "#FF586B",
                    confirmButtonText: "Si, eliminar",
                    cancelButtonText: "No, cancelar",
                    confirmButtonClass: "btn btn-success mr-5",
                    cancelButtonClass: "btn btn-danger",
                    buttonsStyling: false
                }).then((result)=> {
                    if (result) {

                      axios.delete('valoracion/' + idCategoria)
                      .then(response => {
                        swal({
                             type: "success",
                             title: "Operación exitosa",
                             text:"Categoria eliminada con exito",
                             buttonsStyling: false,
                             confirmButtonClass: "btn btn-lg btn-success",
                             confirmButtonText: "Cerrar"
                          });

                        this.listar();
                      }).catch(error => {
                        swal({
                            type: "error",
                            title: "Error!",
                            text:"Lo sentimos ocurrio un error al eliminar la categoria",
                            confirmButtonText: "Cerrar",
                            buttonsStyling: false,
                            confirmButtonClass: "btn btn-lg btn-danger"
                           });
                      });


                    
                    }
                },
                function(dismiss) {
                    // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                    if (dismiss === "cancel") {
                    }
                });

     },

     async listar(){
         await axios.get('valoracion/lista-categorias').then(res=>{
            this.categorias =res.data;
            
          });
        } ,
     async listarEscalas(){
         await axios.get('valoracion/lista-escalas').then(res=>{
            this.escalas =res.data;
            
          });
        } ,
      async listarCantidadCasillas(){
          await axios.get('/parametros/retorno-parametros-multiselect/'+5).then(res=>{
            this.selectCantidad.options = res.data;
          });


        },

    }

}
</script>
<style>
  .mostrar{
    display: list-item;
    opacity: 1;
    background: rgba(39, 42, 42 , 0.700);
  }

</style>