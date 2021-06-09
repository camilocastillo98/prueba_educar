/**
 * Funcion que consulta la totalidad de usuarios
 */
function consultaU(){

    $.ajax({
        url:'controlador.php',
        type:'POST',
        data:'accion=consultaUsuario',
        dataType:'json',
        beforeSend: function(){
            $("#ConsultaUsuario").hide(1000);
            $("#usuarioSolo").hide(1000);
            $("#listUsuarios").show(1000);
        },
        success: function(data) {
            $("#listUsuarios").html(data.html);
        }
    });
}

/**
 * Funcion que muestra div para consultar usuario
 */
function muestraBusqUsuario(){
    $("#listUsuarios").hide(1000);
    $("#ConsultaUsuario").show(1000);
}

function consultaUsuario(){
    var usuario = $("#usuarioEsp").val();

    $.ajax({
        url:'controlador.php',
        type:'POST',
        data:'accion=consultaUsuarioSolo&usuario='+usuario,
        dataType:'json',
        success: function(data) {
            $("#selectUsuarioList").html(data.html);
        }
    });
}

/**
 * Funcion que consulta la informacion para un solo usuario
 */
function muestraUsuarioSolo(idUsuario){

    $.ajax({
        url:'controlador.php',
        type:'POST',
        data:'accion=muestraUsuarioSolo&idUsuario='+idUsuario,
        dataType:'json',
        success: function(data) {
            $("#usuarioSolo").show(1000);
            $("#usuarioSolo").html(data.html);
        }
    });
}

/**
 * Funcion qu recarga dinero a un usuario seleccionado
 */
function recarga(){

    var valor = $('input:radio[name=radioAccion]:checked').val();
    if(valor == undefined){
        alert('Seleccione el usuario a recargar');
    }else{
        $("#valorRecarga").show(1000);
        $("#divTrasnferenciaE").hide(1000);
    }
}

/**
 * Funcion que valida si el valor ingresado es numerico
 */
function soloNumeros(e)
{
	var key = window.Event ? e.which : e.keyCode
	return ((key >= 48 && key <= 57) || (key==8))
}

/**
 * Funcion que recarga el saldo de una persona
 * @param idUsuario contiene el id del usuario a recargar
 */
function recargaFinal(idUsuario){
 
    var usuario = $('input:radio[name=radioAccion]:checked').val();
    var valor = $('#valorRecargaF').val();

    $.ajax({
        url:'controlador.php',
        type:'POST',
        data:'accion=recargaSaldo&idUser='+usuario+'&valor='+valor,
        dataType:'json',
        success: function(data) {
            if(data.cantidad == '1'){
                alert('Recarga Exitosa!');
                location.reload(1000);
            }else{
                alert('Ocurrio un error intente nuevamente');
            }
        }
    });
}

/** 
 * Funcion que muestra campos para hacer transferencia
 */
function transferencia(){
    $("#divTrasnferenciaE").show(1000);
    $("#valorRecarga").hide(1000);
}


/**
 * Funcion que realiza transferencia
 */
function realizaTransferencia(){

    var usuarioT = $("#usuarioEnvio").val();
    var usuarioR = $("#usuarioReceptor").val();
    var valor    = $("#valorTransferencia").val();

    if(usuarioT == ''){
        alert('Seleccione el usuario el cual hara la transferencia');
    }else if(usuarioR == ''){
        alert('Seleccione el usuario el cual recibira la transferencia');
    }else if(valor == ''){
        alert('Digite el valor de la transferencia');
    }else{
        $.ajax({
            url:'controlador.php',
            type:'POST',
            data:'accion=transferencia&usuarioT='+usuarioT+'&usuarioR='+usuarioR+'&valor='+valor,
            dataType:'json',
            success: function(data) {
                if(data.cantidad != '0'){
                    alert('Transferencia Exitosa!');
                    location.reload(1000);
                }else{
                    alert('Ocurrio un error intente nuevamente');
                }
            }
        });       
    }
}