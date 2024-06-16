<?php

include_once 'Persona.php';
include_once 'Pasajero.php';
include_once 'ResponsableV.php';
include_once 'Empresa.php';
include_once 'Viaje.php';
include_once 'db.php';

while (true) {
    echo "\nMenú:\n";
    echo "1) Cargar informacion del viaje\n";
    echo "2) Modificar informacion del viaje\n";
    echo "3) Ver datos del viaje\n";
    echo "4) Modificar pasajero\n";
    echo "5) Agregar pasajero\n";
    echo "6) Eliminar datos\n";
    echo "7) Salir\n";
    $opcion = readline('Ingrese la opción deseada: ');

    switch ($opcion) {
        case '1':
            $idEmpresa = readline('Ingrese el id de la empresa: ');
            $empresa = new Empresa();
            if ($empresa->Buscar($idEmpresa)) {
                echo 'El id ingresado ya pertenece a una empresa.';
            } else {
                $nombreEmpresa = readline('Ingrese el nombre de la empresa: ');
                $direccionEmpresa = readline('Ingrese la dirección de la empresa: ');
                $empresa->cargar(null, $nombreEmpresa, $direccionEmpresa);
                $empresa->insertar();
            }

            $nuevoResponsable = new ResponsableV();
            $nroDocResponsableV = readline('Ingrese el numero de documento empleado del responsable del nuevo viaje: ');
            if ($nuevoResponsable->Buscar($nroDocResponsableV)) {
                echo 'Ah ingresado el un responsable ya existente.';
            } else {
                $numEmpleado = readline('Ingrese el numero de empleado del responsable del nuevo viaje: ');
                $numLicencia = readline('Ingrese el numero de licencia del responsable del nuevo viaje: ');
                $nombreResponsableV = readline('Ingrese el Nombre del responsable del nuevo viaje: ');
                $apellidoResponsableV = readline('Ingrese el apellido del responsable del nuevo viaje: ');
                $nuevoResponsable->cargar($nroDocResponsableV, $nombreResponsableV, $apellidoResponsableV, $numEmpleado, $numLicencia);
                $nuevoResponsable->insertar();
            }
            $destino = readline('Ingrese el destino del nuevo viaje: ');
            $maxPasajeros = readline('Ingrese la cantidad máxima de pasajeros del nuevo viaje: ');
            $costoDelViaje = readline('Ingrese el costo del viaje: ');
            $viaje = new Viaje();
            $viaje->cargar(null, $destino, $maxPasajeros,$empresa, $nuevoResponsable, $costoDelViaje);
            $viaje->insertar();
            print_r($viaje);
            
            break;
        case '2':
            $idViaje = readline("Ingrese el ID VIAJE que desea modificar: ");
            $viaje = new Viaje();
            if ($viaje->Buscar($idViaje)) {
                echo "\nDesea modificar:\n";
                echo "1) Modificar destino del viaje\n";
                echo "2) Modificar maximo de pasajeros del viaje\n";
                echo "3) Modificar responsable del viaje\n";
                echo "4) Modificar costos del viaje\n";
                echo "5) Modificar Empresa\n";
                echo "6) Volver al menu anterior\n";
                $opcion = readline("Ingrese la opción deseada: ");
            }

            switch ($opcion) {
                case '1':
                    echo "Este es el destino actual del viaje: " . $viaje->getVdestino() . "\n";
                    $viaje->setVdestino(readline("Ingrese el destino del viaje: "));
                    $viaje->modificar();
                    echo "Se cambió correctamente a " . $viaje->getVdestino() . "🟢";
                    break;
                case '2':
                    echo "Esta es la cantidad maxima actual del viaje: " . $viaje->getVcantmaxpasajeros() . "\n";
                    $viaje->setVcantmaxpasajeros(readline("Ingrese cantidad maxima de pasajeros del viaje: "));
                    $viaje->modificar();
                    echo "Se cambió correctamente a " . $viaje->getVcantmaxpasajeros() . "🟢";
                    break;
                case '3':
                    $numDocResponsable = readline("Ingrese el DNI del responsable al que desea cambiarle los datos:\n");
                    $responsableV = new ResponsableV();
                    $persona = new Persona();

                    if ($responsableV->Buscar($numDocResponsable) && $persona->Buscar($numDocResponsable)) {
                        echo "¿Qué información desea modificar del responsable del responsable?\n";
                        echo "1) El número del responsable\n";
                        echo "2) El número de licencia\n";
                        echo "3) El nombre\n";
                        echo "4) El apellido\n";
                        echo "5) Todos los datos\n";
                        $eleccion = trim(fgets(STDIN));
                    }
                    switch ($eleccion) {
                        case 1:
                            echo $responsableV->getRnumeroempleado() . " es el número de responsable \n";
                            $persona->Buscar($numDocResponsable);
                            echo "Se cambiará a: \n";
                            $nuevoNumEmpleado = trim(fgets(STDIN));
                            $responsableV->setRnumeroempleado($nuevoNumEmpleado);
                            $responsableV->modificar();
                            echo "Se cambió correctamente a " . $responsableV->getRnumeroempleado() . "🟢 \n";
                            break;
                        case 2:
                            echo $responsableV->getRnumerolicencia() . " es el numero de licencia del responsable \n";
                            echo "Se cambiará a: \n";
                            $nuevoNumLicencia = trim(fgets(STDIN));
                            $responsableV->setRnumerolicencia($nuevoNumLicencia);
                            $responsableV->modificar();
                            echo "Se cambió correctamente a " . $responsableV->getRnumerolicencia() . "🟢 \n";
                            break;

                        case 3:
                            echo $persona->getNombre() . " es el nombre del responsable \n";
                            echo "Se cambiará a: \n";
                            $nuevoNombre = trim(fgets(STDIN));
                            $persona->setNombre($nuevoNombre);
                            $persona->modificar();
                            echo "Se cambió correctamente a " . $persona->getNombre() . " 🟢 \n";
                            break;
                        case 4:

                            echo $persona->getApellido() . " es el apellido de empleado \n";
                            echo "Se cambiará a: \n";
                            $nuevoApellido = trim(fgets(STDIN));
                            $persona->setApellido($nuevoApellido);
                            $persona->modificar();
                            echo "Se cambió correctamente a " . $persona->getApellido() . "🟢\n";
                            break;
                        case 5:
                            echo $responsableV->getRnumeroempleado() . " es el número de responsable \n";
                            $persona->Buscar($numDocResponsable);
                            echo "Se cambiará a: \n";
                            $nuevoNumEmpleado = trim(fgets(STDIN));
                            $responsableV->setRnumeroempleado($nuevoNumEmpleado);
                            $responsableV->modificar();
                            echo "Se cambió correctamente a " . $responsableV->getRnumeroempleado() . "🟢\n";

                            echo $responsableV->getRnumerolicencia() . " es el numero de licencia del responsable \n";
                            echo "Se cambiará a: \n";
                            $nuevoNumLicencia = trim(fgets(STDIN));
                            $responsableV->setRnumerolicencia($nuevoNumLicencia);
                            $responsableV->modificar();
                            echo "Se cambió correctamente a " . $responsableV->getRnumerolicencia() . "🟢\n";

                            echo $persona->getNombre() . " es el nombre del responsable \n";
                            echo "Se cambiará a: \n";
                            $nuevoNombre = trim(fgets(STDIN));
                            $persona->setNombre($nuevoNombre);
                            $persona->modificar();
                            echo "Se cambió correctamente a " . $persona->getNombre() . "🟢\n";

                            echo $persona->getApellido() . " es el apellido de empleado \n";
                            echo "Se cambiará a: \n";
                            $nuevoApellido = trim(fgets(STDIN));
                            $persona->setApellido($nuevoApellido);
                            $persona->modificar();
                            echo "Se cambió correctamente a " . $responsableV->getApellido() . "🟢\n";
                            break;
                        default:
                            echo "Opción incorrecta, por favor ingrese una opción válida🟢\n";
                            break;
                    }
                    break;

                case '4':
                    echo "Este es el Costo actual del viaje: " . $viaje->getVimporte() . "\n";
                    $viaje->setVimporte(readline("Ingrese el nuevo costo del viaje: "));
                    $viaje->modificar();
                    echo "Se cambió correctamente a " . $viaje->getVimporte() . "🟢\n";
                    break;
                case '5':
                    $idEmpresa = readline("Ingrese el ID EMPRESA: ");
                    $empresa = new Empresa();
                    if ($empresa->Buscar($idEmpresa)) {
                        echo "Qué información desea modificar de la empresa?\n";
                        echo "1) El nombre\n";
                        echo "2) La dirección\n";
                        echo "3) Todos los datos\n";
                        $opcion = readline("Ingrese la opción deseada: ");
                    }
                    switch ($opcion) {
                        case 1:
                            echo "El nombre actual de la empresa es: " . $empresa->getEnombre() . "\n";
                            echo "Se cambiará a :\n";
                            $nuevoNombre = trim(fgets(STDIN));
                            $empresa->setEnombre($nuevoNombre);
                            $empresa->modificar();
                            echo "El nombre de la empresa se cambió correctamente 🟢\n";
                            break;
                        case 2:
                            echo "La dirección actual de la empresa es " . $empresa->getEdireccion() . "\n";
                            echo "Se cambiará a :\n";
                            $nuevaDire = trim(fgets(STDIN));
                            $empresa->setEdireccion($nuevaDire);
                            $empresa->modificar();
                            echo "La dirección de la empresa se cambió correctamente 🟢\n";
                            break;
                        case 3:

                            echo "El nombre actual de la empresa es " . $empresa->getEnombre() . "\n";
                            echo "Se cambiará a :\n";
                            $nuevoNombre = trim(fgets(STDIN));
                            $empresa->setEnombre($nuevoNombre);
                            $empresa->modificar();
                            echo "El nombre de la empresa se cambió correctamente 🟢\n";

                            echo "La dirección actual de la empresa es " . $empresa->getEdireccion() . "\n";
                            echo "Se cambiará a :\n";
                            $nuevaDire = trim(fgets(STDIN));
                            $empresa->setEdireccion($nuevaDire);
                            echo "La dirección de la empresa se cambió correctamente 🟢\n";
                            $empresa->modificar();
                            break;
                    }

                case '6':
                    echo "Regresando al menú principal...\n";
                    break;
                default:
                    echo "Opción inválida. Por favor, seleccione una opción válida.\n";
                    break;
            }
            break;
        case '3':
            echo "Ingrese el id del viaje\n";
            $id = trim(fgets(STDIN));
            $viaje = new Viaje();
            $resultado = $viaje->mostrarViaje($id);
            echo $resultado;
            break;

        case '4':
            $numDocPasajero = readline("Ingrese el número de documento del pasajero al que desea cambiarle los datos:\n");
            $pasajero = new Pasajero();
            $pasajero->Buscar($numDocPasajero);
            if ($pasajero) {
                echo "Qué dato quiere modificar?\n";
                echo "1) Nombre\n";
                echo "2) Apellido\n";
                echo "3) Número de teléfono\n";
                echo "4) Todos los datos \n";
                $eleccion = trim(fgets(STDIN));
                switch ($eleccion) {
                    case 1:
                        echo 'El nombre actual es: ' . $pasajero->getNombre() . "\n";
                        echo "Se cambiará a: \n";
                        $nuevoNombre = trim(fgets(STDIN));
                        $pasajero->setNombre($nuevoNombre);
                        $pasajero->modificar();
                        echo 'Se cambió correctamente a ' . $pasajero->getNombre() . "\n";
                        break;
                    case 2:
                        echo 'El apellido actual es: ' . $pasajero->getApellido() . "\n";
                        echo "Se cambiará a: \n";
                        $nuevoApellido = trim(fgets(STDIN));
                        $pasajero->setNombre($nuevoApellido);
                        $pasajero->modificar();
                        echo 'Se cambió correctamente a ' . $pasajero->getApellido() . "\n";
                        break;
                    case 3:
                        echo 'El teléfono actual es: ' . $pasajero->getTelefono() . "\n";
                        echo "Se cambiará a: \n";
                        $nuevoTelefono = trim(fgets(STDIN));
                        $pasajero->setTelefono($nuevoTelefono);
                        $pasajero->modificar();
                        echo 'Se cambió correctamente a ' . $pasajero->getTelefono() . "\n";
                        break;
                    case 4:
                        echo 'El nombre actual es: ' . $pasajero->getNombre() . "\n";
                        echo "Se cambiará a: \n";
                        $nuevoNombre = trim(fgets(STDIN));
                        $pasajero->setNombre($nuevoNombre);
                        $pasajero->modificar();
                        echo 'Se cambió correctamente a ' . $pasajero->getNombre() . "\n";

                        echo 'El apellido actual es: ' . $pasajero->getApellido() . "\n";
                        echo "Se cambiará a: \n";
                        $nuevoApellido = trim(fgets(STDIN));
                        $pasajero->setNombre($nuevoApellido);
                        $pasajero->modificar();
                        echo 'Se cambió correctamente a ' . $pasajero->getApellido() . "\n";

                        echo 'El teléfono actual es: ' . $pasajero->getTelefono() . "\n";
                        echo "Se cambiará a: \n";
                        $nuevoTelefono = trim(fgets(STDIN));
                        $pasajero->setTelefono($nuevoTelefono);
                        $pasajero->modificar();
                        echo 'Se cambió correctamente a ' . $pasajero->getTelefono() . "\n";
                        break;
                    default:
                        echo "Opción incorrecta, por favor ingrese una opción válida\n";
                        break;
                }
            } else {
                echo "No se encontró ningún pasajero con ese número de documento. \n";
            }
            break;
        case '5':
            echo "\nIngrese Id de viaje al que desea agregar pasajero:\n";
            $idViaje = trim(fgets(STDIN));
            $viaje = new Viaje();
            if ($viaje->Buscar($idViaje)) {
                $viaje->getColPasajerosBD($idViaje);
                $cantPasajeros = count($viaje->getColObjPasajeros());
                $capMax = $viaje->getVcantmaxpasajeros();
                if ($capMax > $cantPasajeros) {
                    $nombre = readline('Nombre del pasajero: ');
                    $apellido = readline('Apellido del pasajero: ');
                    $documento = readline('Número de documento del pasajero: ');
                    $telefono = readline('Teléfono del pasajero: ');
                    $persona = new Persona();
                    $persona->cargar($documento, $nombre, $apellido);
                    $persona->insertar();
                    $pasajero = new Pasajero();
                    $pasajero->cargar($documento, $nombre, $apellido, $idViaje, $telefono);
                    $pasajero->insertar();
                } else {
                    echo "No hay más pasajes disponibles para la venta.\n";
                }
            } else {
                echo "Viaje no encontrado.\n";
            }
            break;
        case '6':
            echo "Que dato desea borrar?\n";
            echo "IMPORTANTE! Una vez que se elimine no hay posibilidad de recuperar los datos. Manejar con cuidado.\n";
            echo "1) Eliminar viaje\n";
            echo "2) Eliminar empresa\n";
            echo "3) Eliminar responsable del viaje\n";
            echo "4) Eliminar pasajero\n";
            $rpta = trim(fgets(STDIN)) . "\n";
            switch ($rpta) {
                case '1':
                    echo "Ingrese el ID del viaje a eliminar:\n";
                    $id = trim(fgets(STDIN));
                    $viaje = new Viaje();
                    if ($viaje->Buscar($id)) {
                        if ($viaje->eliminar()) {
                            echo "Eliminado con éxito\n";
                        } else {
                            echo "Error al eliminar el viaje.\n";
                        }
                    } else {
                        echo "Viaje no encontrado\n";
                    }
                    break;
                case '2':
                    echo "Ingrese el ID de la empresa:\n";
                    $idEMpresa = trim(fgets(STDIN));
                    $empresa = new Empresa();
                    if ($empresa->Buscar($idEMpresa)) {
                        if ($empresa->eliminar()) {
                            echo "Empresa eliminada con éxito.\n";
                        } else {
                            echo "Error al eliminar la empresa.\n";
                        }
                    } else {
                        echo "Empresa no encontrada\n";
                    }
                    break;
                case '3':
                    echo "Ingrese el número de documento del responsable:\n";
                    $rdoc = trim(fgets(STDIN));
                    $objRespV = new ResponsableV();
                    if ($objRespV->Buscar($rdoc)) {
                        if ($objRespV->eliminar()) {
                            echo "Responsable eliminado con éxito.\n";
                        } else {
                            echo "Ocurrió un error al intentar borrar al responsable.\n";
                        }
                    } else {
                        echo "No existe responsable con ese documento.\n";
                    }
                    break;
                case '4':
                    echo "Ingrese el documento del pasajero:\n";
                    $pdoc = trim(fgets(STDIN));
                    $objPasajero = new Pasajero();
                    if ($objPasajero->Buscar($pdoc)) {
                        if ($objPasajero->eliminar()) {
                            echo "Pasajero eliminado con éxito.\n";
                        } else {
                            echo "Ocurrió un error al intentar borrar al pasajero.\n";
                        }
                    } else {
                        echo "No se encontró un pasajero con ese documento en el viaje.\n";
                    }
                    break;
            }
            break;
        default:
            echo "Opción inválida. Por favor, seleccione una opción válida.\n";
            break;
    }
}
// function modificarResponsableViaje($viaje, $opcion){
//     switch($opcion){
//         case 1:
//             echo $viaje->getObjResponsable()->getNumEmpleado() . "es el número de empleado \n";
//             echo "Se cambiará a: \n";
//             $nuevoNumEmpleado = trim(fgets(STDIN));
//             $viaje->getObjResponsable()->setNumEmpleado($nuevoNumEmpleado);
//             $viaje->getObjResponsable()->modificar();
//             $viaje->modificar();
//             echo "Se cambió correctamente a " . $viaje->responsable->getNumEmpleado() . "\n";
//         break;
//         case 2:
//             echo $viaje->getObjResponsable()->getNumLicencia() . "es el número de empleado \n";
//             echo "Se cambiará a: \n";
//             $nuevoNumLicencia = trim(fgets(STDIN));
//             $viaje->getObjResponsable()->setNumLicencia($nuevoNumLicencia);
//             $viaje->getObjResponsable()->modificar();
//             $viaje->modificar();
//             echo "Se cambió correctamente a " . $viaje->responsable->getNumLicencia() . "\n";
//         break;
//         case 3:
//             echo $viaje->getObjResponsable()->getNombre() . "es el número de empleado \n";
//             echo "Se cambiará a: \n";
//             $nuevoNombre = trim(fgets(STDIN));
//             $viaje->getObjResponsable()->setNombre($nuevoNombre);
//             $viaje->getObjResponsable()->modificar();
//             $viaje->modificar();
//             echo "Se cambió correctamente a " . $viaje->getObjResponsable()->getNombre() . "\n";
//         break;
//         case 4:
//             echo $viaje->getObjResponsable()->getApellido() . "es el número de empleado \n";
//             echo "Se cambiará a: \n";
//             $nuevoApellido = trim(fgets(STDIN));
//             $viaje->getObjResponsable()->setNumLicencia($nuevoApellido);
//             $viaje->getObjResponsable()->modificar();
//             $viaje->modificar();
//             echo "Se cambió correctamente a " . $viaje->getObjResponsable()->getApellido() . "\n";
//         break;
//         case 5:
//             echo $viaje->getObjResponsable()->getNumEmpleado() . "es el número de empleado \n";
//             echo "Se cambiará a: \n";
//             $nuevoNumEmpleado = trim(fgets(STDIN));
//             $viaje->getObjResponsable()->setNumEmpleado($nuevoNumEmpleado);
//             echo "Se cambió correctamente a " . $viaje->responsable->getNumEmpleado() . "\n";

//             echo $viaje->getObjResponsable()->getNumLicencia() . "es el número de empleado \n";
//             echo "Se cambiará a: \n";
//             $nuevoNumLicencia = trim(fgets(STDIN));
//             $viaje->getObjResponsable()->setNumLicencia($nuevoNumLicencia);
//             echo "Se cambió correctamente a " . $viaje->responsable->getNumLicencia() . "\n";

//             echo $viaje->getObjResponsable()->getNombre() . "es el número de empleado \n";
//             echo "Se cambiará a: \n";
//             $nuevoNombre = trim(fgets(STDIN));
//             $viaje->getObjResponsable()->setNombre($nuevoNombre);
//             echo "Se cambió correctamente a " . $viaje->getObjResponsable()->getNombre() . "\n";

//             echo $viaje->getObjResponsable()->getApellido() . "es el número de empleado \n";
//             echo "Se cambiará a: \n";
//             $nuevoApellido = trim(fgets(STDIN));
//             $viaje->getObjResponsable()->setNumLicencia($nuevoApellido);
//             echo "Se cambió correctamente a " . $viaje->getObjResponsable()->getApellido() . "\n";
//             $viaje->getObjResponsable()->modificar();
//             $viaje->modificar();
//         break;
//         default:
//             echo "Opción incorrecta, por favor ingrese una opción válida\n";
//         break;
//     }
// }
// function modificarEmpresa($viaje, $eleccion){
//     switch($eleccion){
//         case 1:
//             echo "El ID actual de la empresa es ". $viaje->objEmpresa->getId()."\n";
//             echo "Se cambiará a :\n";
//             $nuevoIdEmpresa = trim(fgets(STDIN));
//             $viaje->getObjEmpresa()->setId($nuevoIdEmpresa);
//             $viaje->getObjEmpresa()->modificar();
//             $viaje->modificar();
//             echo "El ID de la empresa se cambió correctamente\n";
//         break;
//         case 2:
//             echo "El nombre actual de la empresa es ". $viaje->objEmpresa->getNombre()."\n";
//             echo "Se cambiará a :\n";
//             $nuevoNombre = trim(fgets(STDIN));
//             $viaje->getObjEmpresa()->setNombre($nuevoNombre);
//             $viaje->getObjEmpresa()->modificar();
//             $viaje->modificar();
//             echo "El nombre de la empresa se cambió correctamente\n";
//         break;
//         case 3:
//             echo "La dirección actual de la empresa es ". $viaje->objEmpresa->getDireccion()."\n";
//             echo "Se cambiará a :\n";
//             $nuevaDir = trim(fgets(STDIN));
//             $viaje->getObjEmpresa()->setDireccion($nuevaDir);
//             $viaje->getObjEmpresa()->modificar();
//             $viaje->modificar();
//             echo "La dirección de la empresa se cambió correctamente\n";
//         break;
//         case 4:
//             echo "El ID actual de la empresa es ". $viaje->objEmpresa->getId()."\n";
//             echo "Se cambiará a :\n";
//             $nuevoIdEmpresa = trim(fgets(STDIN));
//             $viaje->getObjEmpresa()->setId($nuevoIdEmpresa);
//             echo "El nuevo ID de la empresa se cambió correctamente\n";

//             echo "El nombre actual de la empresa es ". $viaje->objEmpresa->getNombre()."\n";
//             echo "Se cambiará a :\n";
//             $nuevoNombre = trim(fgets(STDIN));
//             $viaje->getObjEmpresa()->setNombre($nuevoNombre);
//             echo "El nombre de la empresa se cambió correctamente\n";

//             echo "La dirección actual de la empresa es ". $viaje->objEmpresa->getDireccion()."\n";
//             echo "Se cambiará a :\n";
//             $nuevaDir = trim(fgets(STDIN));
//             $viaje->getObjEmpresa()->setDireccion($nuevaDir);
//             echo "La dirección de la empresa se cambió correctamente\n";
//             $viaje->getObjEmpresa()->modificar();
//             $viaje->modificar();
//         break;
//     }
// }
