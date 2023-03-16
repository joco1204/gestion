<template>
    <div>
        <div class="breadcrumb">
            <div class="col-lg-6">
                <h1>Usuarios</h1>
            </div>
            <div class="col-lg-6 text-right">
                <button type="button" class="btn btn-warning float-right" data-toggle="modal" data-target="#crear-usuario">
                    <i class="fas fa-user-plus"></i>
                    <strong>NUEVO</strong>
                </button>
            </div>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <form
                        ref="formCrearUsuarios"
                        @submit.prevent="crearUsuarios">
                        <div class="modal fade" id="crear-usuario" tabindex="-1" role="dialog" aria-labelledby="usuariosLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="usuariosLabel">Nuevo Usuario</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="nav nav-pills" id="myPillTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active show" id="home-icon-pill" data-toggle="pill" href="#homePIll" role="tab" aria-controls="homePIll" aria-selected="false"><i class="nav-icon i-Add-User"></i>Crear Usuario</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="profile-icon-pill" data-toggle="pill" href="#profilePIll" role="tab" aria-controls="profilePIll" aria-selected="true"><i class="nav-icon i-Checked-User"></i>Asignar Rol</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myPillTabContent">
                                            <div class="tab-pane fade active show" id="homePIll" role="tabpanel" aria-labelledby="home-icon-pill">
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="nombre">Nombre*:</label>
                                                            <input type="text" name="name" id="name" v-model="usuario.name" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="descripcion">Descripción:</label>
                                                            <textarea name="descripcion" id="descripcion" v-model="usuario.descripcion" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="username">Usuario:</label>
                                                            <input type="text" id="username" name="username" v-model="usuario.username" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="correo">Correo Electrónico:</label>
                                                            <input type="email" id="correo" name="correo" v-model="usuario.correo" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="contrasena">Contraseña:</label>
                                                            <input type="password" id="contrasena" name="contrasena" v-model="usuario.password" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="confirmar_contrasena">Confirmar Contraseña:</label>
                                                            <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" v-model="confirmar_contrasena" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="expiracion">Fecha Expiración de Contraseña:</label>
                                                            <input type="date" id="expiracion" name="expiracion" v-model="usuario.expiracion" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="tab-pane fade" id="profilePIll" role="tabpanel" aria-labelledby="profile-icon-pill">
                                                <div class="row">
                                                    <div class="col-lg-12 text-center">
                                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#crear-usuario">
                                                            <i class="i-Checked-User"></i>
                                                            Asignar Rol
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" ref="cerrarModalUsuarios">Cerrar</button>
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="tabla_usuarios" class="table text-center table-hover">
                                    <thead>
                                        <tr >
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Usuario</th>
                                            <th scope="col">Correo</th>
                                            <th scope="col">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(usuario, i) in usuarios" v-bind:key="i">
                                            <td v-text="usuario.name"></td>
                                            <td v-text="usuario.email"></td>
                                            <td v-text="usuario.correo"></td>
                                            <td>
                                                <a style='color:white' class='btn btn-primary' title="Editar" v-on:click='cargarInfoUnidad(usuario)' data-toggle="modal" data-target="#modal-unidad-de-medida"><i class='fas fa-pencil-alt'></i></a>
                                                <a style='color:white' class='btn btn-primary' title="Eliminar" v-on:click="eliminar(usuario)"><i class='fas fa-times-circle'></i></a>
                                                <a style='color:white' class='btn btn-primary' title="Restablecer contraseña" v-on:click="eliminar(usuario)"><i class='fas fa-key'></i></a>
                                                <a v-if="usuario.estado==1" title="Cambiar estado" class="btn btn-primary text-white"><i class='fas fa-user-check'></i> Activo</a>
                                                <a v-else title="Cambiar estado" class="btn btn-secondary"><i class='fas fa-user-lock'></i> Inactivo</a>
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import DataTables from "datatables.net";
require( 'jszip' );
require( 'datatables.net-dt' );
require( 'datatables.net-buttons-dt' );
require( 'datatables.net-buttons/js/buttons.html5.js' );
require( 'datatables.net-buttons/js/dataTables.buttons' );
import "datatables.net-dt/css/jquery.dataTables.min.css";
import print from 'datatables.net-buttons/js/buttons.print.js'
import jszip from 'jszip/dist/jszip';
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
pdfMake.vfs = pdfFonts.pdfMake.vfs;
window.JSZip = jszip

export default {
    data () {
        return {
            usuarios: [],
            usuario:{
                name:'',
                descripcion:'',
                username:'',
                correo:'',
                password:'',
                expiracion:'',
                estado:1
            },
            confirmar_contrasena:''
        }
    },
    created(){
        
    },
    mounted() {
        this.cargarDatosTabla();
    },
    methods: {
        crearUsuarios: function(e) {
            if (this.$refs.formCrearUsuarios.checkValidity()) {
                axios
                    .post("../seguridad/usuarios/crear", {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                        form: JSON.stringify(this.form)
                        
                    })
                    .then(response => {
                        this.$refs.cerrarModalUsuarios.click();
                        swal({
                            type: "success",
                            title: "Usuario Creado Con Éxito",
                            buttonsStyling: false,
                            confirmButtonClass: "btn btn-lg btn-success",
                            confirmButtonText: "Cerrar"
                        });
                        this.verUsuarios();
                        Object.keys(this.form).forEach(key => {
                            this.form[key] = "";
                        });
                    })
                    .catch(error => {
                        swal({
                            type: "error",
                            title: "Error!",
                            text: "No se pudo guardar el usuario, por favor, guardar nuevamente",
                            confirmButtonText: "Cerrar",
                            buttonsStyling: false,
                            confirmButtonClass: "btn btn-lg btn-danger"
                        });
                    });
            }
        },
        cargarDatosTabla(){
            axios
				.get("../seguridad/usuarios/ver")
				.then(response => {
					this.usuarios = response.data;
                    $('#tabla_usuarios').DataTable().destroy()
                    this.$tablaGlobal('#tabla_usuarios')
				})
				.catch(error => {
					swal("Error", "No se pudo obtener el listado de usuarios, por favor inténtelo nuevamente", "error");
				});
        },
        
    }
}
</script>