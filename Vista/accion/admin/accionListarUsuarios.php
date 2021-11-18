<?php 
include_once "../../../configuracion.php";
$abmUs = new AbmUsuario();
$colUsuarios = $abmUs->buscar(array());

$strhtnl="";
          $strhtnl.="<table id='listUs' class='table table-striped text-center'>
                    <thead >
                        <tr >
                            <th scope='col' class='col-1' style='width: 3%'>ID</th>
                            <th scope='col' class='col-2' style='width: 20%'>Nombre</th>
                            <th scope='col' class='col-2' style='width: 27%'>Email</th>
                            <th scope='col' class='col-2' style='width: 20%'>Contraseña</th>
                            <th scope='col' class='col-1' style='width: 5%'>Estado</th>
                            <th scope='col' class='col-3' style='width: 25%'>Acción</th>
                        </tr>
                    </thead>
                    <tbody>";

if (count($colUsuarios) > 0) {
    $strhtnl.="<tr>
    <td></td>
    <td contenteditable class='coledit ' ></td>
    <td contenteditable class='coledit' ></td>
    <td contenteditable class='coledit' ></td>
    <td><i class='fa fa-check'></i></td>
    <td><button id='altaUs' class='btn btn-info'><i class='fa fa-plus'></i> Crear</button></td>
    
    </tr>";
   foreach ($colUsuarios as $us) {
        $strhtnl.="<tr>
        <td>". $us["idusuario"]."</td>
        <td>". $us["usnombre"] ."</td>
        <td>".$us["usmail"] ."</td> 
        <td> </td>";

        if($us["usdeshabilitado"]==null){
            $strhtnl.="<td> <i class='fa fa-check'></i> </td>";
            
        }else{
            $strhtnl.="<td> <i class='fa fa-times'></i> </td>";
        }
        $strhtnl.="<td>";
        if($us["usdeshabilitado"]==null){
            $strhtnl.=" <button class='editarUs btn btn-warning' id='editarUs".$us['idusuario']."' data-id='".$us['idusuario'] ."' ><i class='fa fa-pen'></i> Editar</button>
            <button class='btn btn-success' id='confirm".$us['idusuario']."'  style='display:none' ><i class='fa fa-check'></i> Confirmar</button>
            <button class='btn btn-danger' id='cancel".$us['idusuario']."'  style='display:none' onclick='controlButton(".$us['idusuario'].",0)'><i class='fa fa-times'></i> Cancelar</button>
            <button class='borrarUs btn btn-danger' id='borrarUs".$us['idusuario']."' data-id='".$us['idusuario'] ."' ><i class='fa fa-arrow-down'></i> Baja</button>"; 
            //<a class='btn btn-outline-secondary' id='gestion".$us['idusuario']."' href='../accion/gestionRol.php?idusuario=".$us['idusuario']."' >Gestion rol</a>";

        }        
        if($us["usdeshabilitado"]!=null){
            $strhtnl.="<button class='btn btn-success' id='habilUs' data-id='".$us['idusuario'] ."' ><i class='fa fa-arrow-up'></i>  Alta</button> ";
        }       
 
}
$strhtnl.="</td></tr> </tbody>
        </table>";

}
echo $strhtnl;

?>
<style>
    .inputList{
        height: 25px;
        margin: 0px;
        padding: 0px;
        border: 0px;
        outline: none;
    }
    /* td{
        margin: 0px;
        padding: 0px;
    } */
    .dlgMod{
        padding: 10px;
        width: 40%;
        position: fixed;
        background-color: white;
        border: 2px solid royalblue;
        border-radius: 5px;
        top: 200px;
        left: 30%;
    }

</style>

