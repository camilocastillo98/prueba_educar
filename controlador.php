<?php

include "consultas.php";

$consultas = new Consultas();

if($_POST['accion'] == "consultaUsuario"){
    $consulta = $consultas->consultaUsuarios();

    $html = '';
    $html .= '
    <br>
        <table class="table table-striped" style="text-align:center;width:100%">
            <tr>
                <td colspan="4" style="text-align:center;background-color:#E8F11B">Listado de Usuarios</td>
            </tr>
            <tr>
                <td>Usuario</td>
                <td>Cuenta</td>
                <td>Saldo</td>
                <td>Recargar</td>
            </tr>';
            foreach($consulta as $cn){
    $html .='
            <tr>
                <td>'.$cn['usuario'].'</td>
                <td>'.$cn['cuenta'].'</td>
                <td>$ '.number_format($cn['saldo']).'</td>
                <td><input type="radio" value="'.$cn['id'].'" id="accion_'.$cn['id'].'" name="radioAccion"></td>
            </tr>';
            }
    $html .='
        </table>
        <div class="col-10" style="align:right">
            <button class="btn btn-danger" onclick="recarga();">Recargar</button>
            &nbsp;
            <button class="btn btn-warning" onclick="transferencia()">Transferir</button>
        </div>
        <br>
        <div class="col-10" style="display:none" id="valorRecarga">
            <label> Cantidad</label>
            <input type="text" id="valorRecargaF" name="valorRecargaF" class="form-control" onKeyPress="return soloNumeros(event)" placeholder="$ 1234" style="width:50%" aria-label="Username" aria-describedby="basic-addon1"><i style="cursor:pointer" onclick="recargaFinal();">✓</i>
        </div>
        <div class="col-4" style="display:none" id="divTrasnferenciaE">
            <label> Usuario Envio</label>
            <select id="usuarioEnvio" class="form-control">
                <option value=""></option>';
            foreach($consulta as $c){
        $html .='
                <option value="'.$c['id'].'">'.$c['usuario'].'</option>';
            }
    $html .='
            </select>
            <br>
            <label> Usuario Receptor</label>
            <select id="usuarioReceptor" class="form-control">
                <option value=""></option>';
            foreach($consulta as $n){
        $html .='
                <option value="'.$n['id'].'">'.$n['usuario'].'</option>';
            }
    $html .='
            </select>
            <br>
            <label> Cantidad</label>
            <input type="text" id="valorTransferencia" style="width:100%" name="valorTransferencia" class="form-control" onKeyPress="return soloNumeros(event)" placeholder="$ 1234" style="width:50%" aria-label="Username" aria-describedby="basic-addon1"><u style="cursor:pointer" onclick="realizaTransferencia();">Transferir</u>
        </div>';

    echo json_encode(array('html' => $html));
}
else if($_POST['accion'] == 'consultaUsuarioSolo'){
    
    $usuario = $_POST['usuario'];
    $consulta = $consultas->consultaUsuarioSolo($usuario);

    $html = '';

        foreach($consulta as $cn){
    $html.='
            <span class="input-group-text" id="basic-addon1" >
                <i class="fa fa-user" onclick="muestraUsuarioSolo('.$cn['id'].');" style="cursor:pointer"> '.$cn['usuario'].' <i class="fa-cc-visa"> '.$cn['cuenta'].'</i></i>                                
            </span>';
        }
    echo json_encode(array('html' => $html));
}
else if($_POST['accion'] == 'muestraUsuarioSolo'){

    $id = $_POST['idUsuario'];
    $consulta = $consultas->consultaDatosSolo($id);
    
    $html = '';

    $html .= '
        <table class="table table-striped" style="text-align:center;width:100%">
            <tr>
                <td colspan="5" style="background-color:#E8F11B">Datos Usuario</td>
            </tr>
            <tr>
                <td>Usuario</td>
                <td>Cuenta</td>
                <td>Saldo</td>
                <td>Estado</td>
                <td>Fecha Registro</td>
            </tr>
            <tr>
                <td>'.$consulta[0]['usuario'].'</td>
                <td>'.$consulta[0]['cuenta'].'</td>
                <td>'.$consulta[0]['saldo'].'</td>
                <td>'.$consulta[0]['estado'].'</td>
                <td>'.$consulta[0]['fecha_registro'].'</td>
            </tr>
        </table>
    ';
    echo json_encode(array('html' => $html));
}
else if($_POST['accion'] == 'recargaSaldo'){

    $idUser = $_POST['idUser'];
    $valor  = $_POST['valor'];

    $consulta = $consultas->recargaDinero($idUser,$valor);
    
    echo json_encode(array('cantidad' => $consulta));

}
else if($_POST['accion'] == 'transferencia'){

    $usuarioT = $_POST['usuarioT'];
    $usuarioR = $_POST['usuarioR'];
    $valor    = $_POST['valor'];

    $consulta = $consultas->transferencia($usuarioT,$usuarioR,$valor);
    echo json_encode(array('cantidad' => $consulta));
}
?>