<?php
include_once 'Persona.php';
include_once 'Pasajero.php';
include_once 'ResponsableV.php';
include_once 'Empresa.php';
include_once 'Viaje.php';
include_once 'db.php';

while (true) {
    echo "\nMenú:\n";
    echo "1. Cargar informacion del viaje\n";
    echo "2. Modificar informacion del viaje\n";
    echo "3. Ver datos del viaje\n";
    echo "4. Modificar Pasajero\n";
    echo "5. Agregar Pasajero\n";
    echo "7. Salir\n";
    $opcion = readline("Ingrese la opción deseada: ");

    switch ($opcion) {
        case '1':

            $idEmpresa = readline("Ingrese el id de la empresa: ");
            $nombreEmpresa = readline("Ingrese el nombre de la empresa: ");
            $direccionEmpresa = readline("Ingrese la dirección de la empresa: ");
            $empresa = new Empresa();
            $empresa->cargar($idEmpresa,$nombreEmpresa, $direccionEmpresa);
            $empresa->insertar();


            $nroDocResponsableV = readline("Ingrese el numero de documento empleado del responsable del nuevo viaje: ");
            $numEmpleado = readline("Ingrese el numero de empleado del responsable del nuevo viaje: ");
            $numLicencia = readline("Ingrese el numero de licencia del responsable del nuevo viaje: ");
            $nombreResponsableV = readline("Ingrese el Nombre del responsable del nuevo viaje: ");
            $apellidoResponsableV  = readline("Ingrese el apellido del responsable del nuevo viaje: ");
            $personaResponsableV= new Persona();
            $personaResponsableV->insertar();
            $personaResponsableV->cargar($nroDocResponsableV, $nombreResponsableV, $apellidoResponsableV);
            $nuevoResponsable = new ResponsableV();
            $nuevoResponsable->cargar($nroDocResponsableV, $nombreResponsableV, $apellidoResponsableV, $numEmpleado, $numLicencia);
            $nuevoResponsable->insertar();
            print_r($nuevoResponsable);

            $codigo = readline("Ingrese el codigo del nuevo viaje: ");
            $destino = readline("Ingrese el destino del nuevo viaje: ");
            $maxPasajeros = readline("Ingrese la cantidad maxima de pasajeros del nuevo viaje: ");            
            $costoDelViaje = readline("Ingrese el costo del viaje: ");

            $pasajerosArray = [];
            $viaje = new Viaje();
            $viaje->cargar($codigo, $destino, $maxPasajeros,$empresa, $nuevoResponsable, $costoDelViaje);
            $viaje->insertar();
            break;
        case '2':
            // while (true) {
            //     echo "\nDesea modificar:\n";
            //     echo "1. Modificar codigo del viaje\n";
            //     echo "2. Modificar destino del viaje\n";
            //     echo "3. Modificar maximo de pasajeros del viaje\n";
            //     echo "4. Modificar responsable del viaje\n";
            //     echo "5. Modificar costos del viaje\n";
            //     echo "6. Modificar Empresa\n";
            //     echo "7. Volver al menu anterior\n";
            //     $opcion = readline("Ingrese la opción deseada: ");
            //     switch ($opcion) {
            //         case '1':
            //             echo "Este es el codigo actual del viaje: " . $viaje->getCodigo() . "\n";
            //             $viaje->setCodigo(readline("Ingrese el codigo del nuevo viaje: "));
            //             $viaje->modificar();
            //             break;
            //         case '2':
            //             echo "Este es el Destino actual del viaje: " . $viaje->getDestino() . "\n";
            //             $viaje->setDestino(readline("Ingrese el destino del viaje: "));
            //             $viaje->modificar();
            //             break;
            //         case '3':
            //             echo "Esta es la cantidad maxima actual del viaje: " . $viaje->getMaxPasajeros() . "\n";
            //             $viaje->setMaxPasajeros(readline("Ingrese la cantidad maxima de pasajeros del viaje: "));
            //             $viaje->modificar();
            //             break;
            //         case '4':
            //             echo "Qué información desea modificar del responsable del viaje?\n";
            //             echo "1- El número de empleado\n";
            //             echo "2- El número de licencia\n";
            //             echo "3- El nombre\n";
            //             echo "4- El apellido\n";
            //             echo "5- Todos los datos\n";
            //             $opcion = trim(fgets(STDIN));
            //             modificarResponsableViaje($viaje, $opcion);
            //             break;
            //         case '5':
            //             echo "Este es el Costo actual del viaje: " . $viaje->getCosto() . "\n";
            //             $viaje->setCosto(readline("Ingrese el nuevo costo del viaje: "));
            //             $viaje->modificar();
            //             break;
            //         case '6':
            //             echo "Qué información desea modificar de la empresa?\n";
            //             echo "1- El ID\n";
            //             echo "2- El nomnbre\n";
            //             echo "3- La dirección\n";
            //             echo "4- Todos los datos\n";
            //             $eleccion = trim(fgets(STDIN));
            //             modificarEmpresa($viaje, $eleccion);
            //             break 2;
            //         case '7':
            //             echo "Regresando al menú principal...\n";
            //             break 2;
            //         default:
            //             echo "Opción inválida. Por favor, seleccione una opción válida.\n";
            //             break;
            //     }
            // }
            // break;
        case '3':
            // echo "Ingrese el id del viaje\n";
            // $id = trim(fgets(STDIN));
            // $viaje->listar($id);
            // break;

        case '4':
            // echo "Ingrese el número de documento del pasajero al que desea cambiarle los datos:\n";
            // $numDocPasajero = trim(fgets(STDIN));
            // $pasajeros= $viaje->getPasajerosArray();
            // $pasajeroIndice =  $viaje->existePasajero($numDocPasajero);
            // if ($pasajeroIndice != -1) {
            //     $unPasajero = $pasajeros[$pasajeroIndice]; 
            //     echo "Qué dato quiere modificar?\n";
            //     echo "1- Nombre\n";
            //     echo "2- Apellido\n";
            //     echo "3- Número de teléfono\n";
            //     echo "4- Todos los datos \n";
            //     $eleccion = trim(fgets(STDIN));
            //     switch($eleccion){
            //         case 1:
            //             echo "El nombre actual es: ". $unPasajero->getNombre() . "\n";
            //             echo "Se cambiará a: \n";
            //             $nuevoNombre = trim(fgets(STDIN));
            //             $unPasajero->setNombre($nuevoNombre);
            //             $unPasajero->modificar();
            //             echo "Se cambió correctamente a ". $unPasajero->getNombre() . "\n";
            //         break;
            //         case 2:
            //             echo "El apellido actual es: ". $unPasajero->getApellido() . "\n";
            //             echo "Se cambiará a: \n";
            //             $nuevoApellido = trim(fgets(STDIN));
            //             $unPasajero->setNombre($nuevoApellido);                        
            //             $unPasajero->modificar();
            //             echo "Se cambió correctamente a ". $unPasajero->getApellido() . "\n";
            //         break;
            //         case 3:
            //             echo "El teléfono actual es: ". $unPasajero->getTelefono() . "\n";
            //             echo "Se cambiará a: \n";
            //             $nuevoTelefono = trim(fgets(STDIN));
            //             $unPasajero->setTelefono($nuevoTelefono);
            //             $unPasajero->modificar();
            //             echo "Se cambió correctamente a ". $unPasajero->getTelefono() . "\n";
            //         break;
            //         case 4:
            //             echo "El nombre actual es: ". $unPasajero->getNombre() . "\n";
            //             echo "Se cambiará a: \n";
            //             $nuevoNombre = trim(fgets(STDIN));
            //             $unPasajero->setNombre($nuevoNombre);
            //             $unPasajero->modificar();
            //             echo "Se cambió correctamente a ". $unPasajero->getNombre() . "\n";
                        
            //             echo "El apellido actual es: ". $unPasajero->getApellido() . "\n";
            //             echo "Se cambiará a: \n";
            //             $nuevoApellido = trim(fgets(STDIN));
            //             $unPasajero->setNombre($nuevoApellido);
            //             $unPasajero->modificar();
            //             echo "Se cambió correctamente a ". $unPasajero->getApellido() . "\n";

            //             echo "El teléfono actual es: ". $unPasajero->getTelefono() . "\n";
            //             echo "Se cambiará a: \n";
            //             $nuevoTelefono = trim(fgets(STDIN));
            //             $unPasajero->setTelefono($nuevoTelefono);
            //             $unPasajero->modificar();
            //             echo "Se cambió correctamente a ". $unPasajero->getTelefono() . "\n";
            //         break;
            //         default: 
            //         echo "Opción incorrecta, por favor ingrese una opción válida\n";
            //         break;
            //     }
            // }else {
            //     echo "No se encontró ningún pasajero con ese número de documento. \n";

            // }
            // break;
        case '5':
            // if ($viaje->hayPasajesDisponibles()) {
            //     while (true) {
            //         echo "\nDesea Agregar:\n";
            //         echo "1. Pasajero estandar\n";
            //         echo "2. Pasajero VIP\n";
            //         echo "3. Pasajero con necesidades especiales\n";
            //         echo "4. Volver al menu anterior\n";
            //         $opcion = readline("Ingrese la opción deseada: ");
            //         $nombre = readline("Nombre del pasajero: ");
            //         $apellido = readline("Apellido del pasajero: ");
            //         $documento = readline("Número de documento del pasajero: ");
            //                 $telefono = readline("Teléfono del pasajero: ");
            //                 $asiento = (count($viaje->getPasajerosArray()) + 1);
            //                 $ticket = readline("Ingrese el numero de ticket:");
            //                 $persona = new Persona();
            //                 $persona->cargar($documento, $nombre, $apellido, $telefono);
            //                 $persona->insertar();
            //                 $pasajero = new Pasajero();
            //                 $pasajero->cargar($documento, $nombre, $apellido, $telefono, $asiento, $ticket, $viaje);
            //                 $pasajero->insertar();
            //         switch ($opcion) {
            //             case '1':
            //                 $pasajeroEstandar = new PasajeroEstandar($nombre, $apellido, $documento, $telefono, $asiento, $ticket);
            //                 if ($viaje->venderPasaje($pasajero)) {
            //                     echo "Pasajero agregado al viaje con exito.\n";
            //                 } else {
            //                     echo "El pasajero ya existe en este viaje.\n";
            //                 }
            //                 break;
            //             case '2':
            //                 $numeroDeViajeroFrecuente = readline("Ingrese el numero de viajero frecuente: ");
            //                 $millas = readline("Ingrese la cantidad de millas de viajero frecuente:");
            //                 $pasajero = new PasajeroVip($nombre, $apellido, $documento, $telefono, $asiento, $ticket, $numeroDeViajeroFrecuente, $millas);
            //                 if ($viaje->venderPasaje($pasajero)) {
            //                     echo "Pasajero agregado al viaje con exito.\n";
            //                 } else {
            //                     echo "El pasajero ya existe en este viaje.\n";
            //                 }
            //                 break;
            //             case '3':
            //                 $silla = readline("El pasajero utiliza silla de ruedas? responda con True/False");
            //                 $asistencia = readline("El Pasajero necesita asistencia para el embarque o desembarque? responda con True/False");
            //                 $comida = readline("El pasajero requiere comida especial? responda con True/False");
            //                 $pasajero = new PasajeroConNecesidades($nombre, $apellido, $documento, $telefono, $asiento, $ticket, $silla, $asistencia, $comida);
            //                 if ($viaje->venderPasaje($pasajero)) {
            //                     echo "Pasajero agregado al viaje con exito.\n";
            //                 } else {
            //                     echo "El pasajero ya existe en este viaje.\n";
            //                 }
            //                 break;
            //             case '4':
            //                 echo "Regresando al menú principal...\n";
            //                 break 2;
            //             default:
            //                 echo "Opción inválida. Por favor, seleccione una opción válida.\n";
            //                 break;
            //         }
            //     }
            // } else {
            //     echo "No hay mas pasajes disponibles para la venta.\n";
            // }
            // break;
        case '6':
            echo "Saliendo del programa...\n";
            exit;
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