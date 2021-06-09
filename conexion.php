<?php 

    class conexion{
        private $usuario = "root";
        private $pass = "";
        private $db ="baanco";
        private $host = "localhost";
        private $con;

        public function __construct(){
            $this->con = new mysqli($this->host,$this->usuario,$this->pass,$this->db);
        }

        public function obtenerDatos($sql){
            $dt = $this->con->query($sql);
            $datos = mysqli_fetch_all($dt,MYSQLI_ASSOC);
            return $datos;
        }

        public function ejecutarDatos($sql){
            $datos = $this->con->query($sql);
            return $datos;
        }
    }
?>