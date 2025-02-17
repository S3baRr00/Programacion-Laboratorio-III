<?php
require_once "./controladores/controladorUsuario.php";
require_once "./controladores/controladorRegistro.php";
require_once "./clases/usuario.php";
require_once "./clases/GenericDao.php";
date_default_timezone_set("America/Argentina/Buenos_Aires");

$caso= $_SERVER["REQUEST_METHOD"];
$Usuarios= new controladorUsuario("./usuarios.txt");
$registros= new controladorRegistro("./info.log");
$casePostman=null;
switch ($caso){
    case "POST":
    
        if (isset($_POST["caso"])) {
            switch($_POST["caso"]) {
                case "cargarUsuario":
                
                if(isset($_POST["nombre"]) && isset($_POST["legajo"]) && isset($_POST["email"]) && 
                isset($_POST["clave"]) && isset($_FILES["fotoUno"]) && isset($_FILES["fotoDos"]))
                {
                    $Usuarios->cargarUsuario($_POST["nombre"], $_POST["legajo"], $_POST["email"], $_POST["clave"], $_FILES["fotoUno"], $_FILES["fotoDos"]);
                }
                else
                {
                    echo "faltan parametros.";
                }
                
                break;
            case "modificarUsuario":
                if (isset($_POST["legajo"])){
                    $Usuarios->modificarUsuario($_POST["legajo"], $_POST, $_FILES);
                } 
                else 
                {
                    echo "completar el espacio de legajo";
                }
            }
        }
        else
        {
            echo "cargar el parametro 'caso'";
        }
        break;
    case "GET":
    if (isset($_GET["caso"])) {
        switch($_GET["caso"]) {
            case "login":
            
            if(isset($_GET["legajo"]) && isset($_GET["clave"]))
            {
                echo $Usuarios->login($_GET["legajo"], $_GET["clave"]);
            }
            else
            {
                echo "faltan parametros.";
            }
            
            break;
            case "verUsuarios":
            $Usuarios->mostrar();
            break;
            case "verUsuario":
            if(isset($_GET["legajo"]))
            {
                $Usuarios->mostrar($_GET["legajo"]);
            }
            else
            {
                echo "ingrese el legajo del usuario que quiera mostrar";
            }
            break;
            case "logs":
            if(isset($_GET["fecha"]))
            {
                $registros->mostrarRegistros($_GET["fecha"]);
            }
            else
            {
                echo "ingresar una fecha";
            }
        }
    }
    else
    {
        echo "cargar el parametro 'caso'";
    }
    break;
    }

    if($caso == "POST")
    {
        $casePostman = $_POST["caso"];
    }
    else
    {
        $casePostman = $_GET["caso"];
    }
    $registros->cargarRegistro($caso,$casePostman);


?>