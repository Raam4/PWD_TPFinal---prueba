<?php
include_once("../../configuracion.php");
$data = data_submitted();
$objSess = new Session();
if($objSess->activa()) {
    $param['user'] = $objSess->getUsuario();
    $param['roles'] = $objSess->getRoles();
    $param['rolactivo'] = $objSess->getRolActivo();
    $perfil = Maker::perfil($param);
    $menu = Maker::menu($param['rolactivo']);
}else{
    header('location:../public/login.php');
    exit();
}
include_once("../estructura/header.php");
$nmimg = md5($param['user']['usnombre'].$param['user']['idusuario']);
?>
<style type="text/css">
    .avatar{
        width:200px;
        height:200px;
    }
</style>
<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h1>Mis Datos</h1>
        </div>
        <div class="card-body row">
            <div class="col">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <img id="avatar" src="../../Utiles/findImg.php?nombre=<?=$nmimg?>" class="avatar img-circle img-thumbnail" alt="avatar">
                                <hr>
                                <h6>Editar foto de perfil:</h6>
                                <input type="file" id="usimg" name="usimg" class="form-control">
                            </div>
                        </div>
                    <!-- edit form column -->
                    <div class="col-md-9 personal-info">
                        <form id="misDatos" class="form-horizontal" role="form">
                            <input type="hidden" id="idusuario" name="idusuario" value="<?=$param['user']['idusuario']?>">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Nombre de Usuario</label>
                                <div class="col-lg-7">
                                    <input class="form-control" id="usnombre" name="usnombre" type="text" value="<?=$param['user']['usnombre']?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Fecha de Nacimiento</label>
                                <div class="col-lg-7">
                                    <input class="form-control" id="usfecnac" name="usfecnac" type="date" value="<?=$param['user']['usfecnac']?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Contraseña</label>
                                <div class="col-lg-7">
                                    <input class="form-control" id="uspass" name="uspass"type="password" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Telefono:</label>
                                <div class="col-lg-7">
                                    <input class="form-control" id="ustelefono" name="ustelefono" type="text" value="<?=$param['user']['ustelefono']?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Email:</label>
                                <div class="col-lg-7">
                                    <input class="form-control" id="usmail" name="usmail" type="text" value="<?=$param['user']['usmail']?>" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-warning"><i class="fa fa-save"></i> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../js/port_md5.js"></script>
<script>
$(document).ready(function(){
    //agregar validacion de la imagen de perfil aparte
    //la pass no es necesaria, pero habria que validar con un regex
    $("form#misDatos").validate({
        rules: {
            ustelefono: {
                rangelength: [6, 13],
                number: true,
            },
            usmail: {
                pattern: /^(?:[^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*|"[^\n"]+")@(?:[^<>()[\].,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,63}$/i,
            },
        },
        messages: {
            ustelefono: {
                required: "El campo es obligatorio",
                number: "Ingrese solo números, sin 0 ni 15",
                rangelength: 'La cantidad de números es inválida',
            },
            usmail: {
                required: "El campo es obligatorio",
                pattern: "Ingrese una direccion de correo valida",
            },
        },
        submitHandler: function() {
        var data = {
            'idusuario': $('#idusuario').val(),
            'ustelefono': $('#ustelefono').val(),
            'usmail': $('#usmail').val()
        }
        if($('#uspass').val() != ''){
            data.pass = md5($('#uspass').val());
        }
        $.ajax({
            method: 'POST',
            url: '../accion/public/accionMisDatos.php',
            data: data,
            type: 'json',
            success: function(){
                toastr.success('Los datos fueron actualizados!');
            }
        });
        return false;
        }
    });
    $('#usimg').on('click', function(){
        if(confirm('Desea modificar su imagen de perfil?')){
            var formData = new FormData();
            var img =  $('#usimg')[0].files[0];
            formData.append('imagen', img);
            formData.append('idusuario', $('#idusuario').val());
            formData.append('usnombre', $('#usnombre').val());
            $.ajax({
                method: 'POST',
                url: '../accion/public/accionCambioImg.php',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(locimg){
                    $('#avatar').attr('src', JSON.parse(locimg));
                    toastr.success('Imagen de perfil modificada con éxito!');
                }
            });
        }else{
            $(this).val('');
        }
    });
});
</script>
<?php include_once("../estructura/footer.php"); ?>