<?php

class EscolarsController
{
    //LRGA03

    public function __construct()
    {
        require_once "Models/CargaModel.php";
        require_once "Models/CarreraModel.php";
        require_once "Models/ProcesoModel.php";
        require_once "Models/ImportarModel.php";
        require_once "Models/PeriodoModel.php";
        require_once "Models/AlumnoModel.php";
    }

    public function index()
    {
        $modelo = new Escolares();
        $alumnos = $modelo->get_escolares();

        $carrera = new Carrera();
        $resultCarrera = $carrera->get_carreras();

        $proceso = new Proceso();
        $resultProcesos = $proceso->get_procesos();

        $periodo = new Periodo();
        $resultPeriodo = $periodo->get_periodos();

        $alumno = new Alumno();
        $resultAlumno = $alumno->get_estatus();


        require_once('Views/Escolares/carga.php');
    }

    //funcion que cambia el estado de activo de todos los alumnos
    public function statusA(){
        $importarModel = new ImportarModel();
        $exito = $importarModel->statusActivo();
        if ($exito) {
            header('Location: index.php?c=escolars&a=index');
            exit();
        } else {
            // Manejo de errores si la operación no fue exitosa
           // echo "Error al cambiar el estado de los alumnos.";
        }
    }

    //funcion que cambia el estado de inactivo de todos los alumnos
    public function statusI(){
        $importarModel = new ImportarModel();
        $exito = $importarModel->statusInactivo();
        if ($exito) {
            header('Location: index.php?c=escolars&a=index');
            exit();
        } else {
            // Manejo de errores si la operación no fue exitosa
            //echo "Error al cambiar el estado de los alumnos.";
        }
    }

    //funcion que registra a los alumnos de manera individual
    public function cargarAlumnoIndividual()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $matricula = $_POST['matricula'];
            $nombre = $_POST['nombre_alumno'];
            $apellidoP = $_POST['apellidoP'];
            $apellidoM = $_POST['apellidoM'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $carrera = $_POST['carrera'];
            $proceso = $_POST['proceso'];
            $periodo = $_POST['periodo'];
            $periodoSeleccionado = $_POST['periodo']; // Obtener el periodo seleccionado

            // Llama al modelo para insertar el alumno en la base de datos
            $importarModel = new ImportarModel();
            $exito = $importarModel->insertarAlumnoIndividual(
                $matricula, $nombre, $apellidoP, $apellidoM, $telefono, $correo, $carrera, $proceso, $periodo); // Pasa el periodo seleccionado

            if ($exito) {
                header('Location: index.php?c=escolars&a=index');
                exit();
            } else {
                // Manejo de errores si la operación no fue exitosa
               // echo "Error al cambiar el estado de los alumnos.";
            }
        } else {
            // Si no se ha enviado el formulario, muestra el formulario de carga individual
            $modelo = new Escolares();
            $alumnos = $modelo->get_escolares();

            $carrera = new Carrera();
            $resultCarrera = $carrera->get_carreras();

            $proceso = new Proceso();
            $resultProcesos = $proceso->get_procesos();

            $periodo = new Periodo();
            $resultPeriodo = $periodo->get_periodos();
            include 'Views/Escolares/carga.php';
        }
    }




    //LüBú 
    //Funcion para modificar el proceso y periodo del esclavo
    public function showAlumno($id){
        $alumno = new Alumno();

        $dataAlumno = $alumno->get_alumno($id);

        return $dataAlumno;
    }

    public function editAlumno(){
        $id = $_POST['idp'];
        $idPeriodo = $_POST['idPeriodop'];
        $idProceso = $_POST['idProcesop'];

        $alumno = new Alumno();
        $change = $alumno->cambiarPP($id, $idProceso, $idPeriodo);
        return $change;
    }
}
