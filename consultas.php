<?php 
    include 'conexion.php';

    class Consultas{
        private $con;
        private $user;
        private $nivel;

        /**
         * Constructor de la clase
         */
        public function __construct(){
            $this->con = new conexion();
        }

        /**
         * Funcion que consulta el listado de usuarios activos
         */
        public function consultaUsuarios(){
            $sql = "SELECT * FROM usuario WHERE estado = '1'";
            $datos = $this->con->obtenerDatos($sql);
            return $datos;
        }

        /**
         * Funcion que consulta usuario en especifico
         * @param varchar $usuario contiene el usuario a consultar
         */
        public function consultaUsuarioSolo($usuario){

            $sql = "SELECT * FROM usuario WHERE usuario LIKE '%$usuario%'";
            $datos = $this->con->obtenerDatos($sql);
            return $datos;
        }

        /**
         * Funcion que consulta la informacion de un solo usuario
         * @param int $idUsuario contiene el id del usuario a consultar
         */
        public function consultaDatosSolo($idUsuario){

            $sql = "SELECT * FROM usuario WHERE id = '$idUsuario'";
            $datos = $this->con->obtenerDatos($sql);
            return $datos;
        }

        /**
         * Funcion que recarga dinero a un usuario seleccionado
         * @param int $idUser Contiene el usuario a recargar
         * @param double $valor contiene el valor a sumar
         */
        public function recargaDinero($idUser,$valor){
            $sql = "UPDATE usuario SET saldo = saldo + $valor WHERE id = '$idUser'";
            $datos = $this->con->ejecutarDatos($sql);
            return $datos;
        }

        /** 
         * Funcion que hace una trasferencia entre dos personas
         * @param varchar $usuarioT Contiene el usuario que envia el dinero
         * @param varchar $usuarioR Contiene el usuario que recibe el dinero
         * @param double $valor contiene el valor de la transferencia
         */
        public function transferencia($usuarioT,$usuarioR,$valor){
            $sql = "UPDATE usuario SET saldo = saldo + $valor WHERE id = '$usuarioR'";
            $datos = $this->con->ejecutarDatos($sql);

            if($datos == '1'){
                $sql1 = "UPDATE usuario SET saldo = saldo - $valor WHERE id = '$usuarioT'";
                $total = $this->con->ejecutarDatos($sql1);

                return $total;
            }else{
                return '0';
            }
        }
    }
?>