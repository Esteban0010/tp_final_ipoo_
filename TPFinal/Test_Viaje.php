<?php

include_once 'Persona.php';
include_once 'Pasajero.php';
include_once 'ResponsableV.php';
include_once 'Empresa.php';
include_once 'Viaje.php';
include_once 'db.php';

while (true) {
    echo "\nBienvenido, damos inicio al sistema de RosquitaS.A.\n";
    echo "Software gestor de viajes para empresas de transporte\n";
    echo "\nMenú:\n";
    echo "1) Crear/agregar empresa\n";
    echo "2) Crear un viaje\n";
    echo "3) Modificar informacion del viaje\n";
    echo "4) Ver datos del viaje\n";
    echo "5) Modificar pasajero\n";
    echo "6) Agregar pasajero\n";
    echo "7) Eliminar datos\n";
    echo "8) Salir\n"; // terminar
    $opcion = readline('Ingrese la opción deseada: ');
    switch ($opcion) {
        case '1':
            echo "Primero corroboremos que la empresa no exista\n";
            $idEmpresa = readline('Ingrese el id de la empresa: ');
            $empresa = new Empresa();
            if ($empresa->Buscar($idEmpresa)) {
                echo 'El id ingresado ya pertenece a una empresa.';
                echo 'Nombre de la empresa existente: '.$empresa->getEnombre()."\n";
            } else {
                echo "Perfecto! La empresa no existe. Puede creerla ahora.\n";
                $nombreEmpresa = readline('Ingrese el nombre de la empresa: ');
                $direccionEmpresa = readline('Ingrese la dirección de la empresa: ');
                $empresa->cargar(null, $nombreEmpresa, $direccionEmpresa);
                if ($empresa->insertar()) {
                    echo "Empresa creada con éxito.\n";
                    echo 'El ID otorgado es: '.$empresa->getIdempresa()."\n";
                } else {
                    echo 'Ocurrió un error:'.$empresa->getmensajeoperacion()."\n";
                }
            }
            break;
        case '2':
            echo "Un viaje debe pertenecer a una empresa, por favor asigne el ID correspondiente\n";
            $empresa = new Empresa();
            $idEmpresa = readline('Ingrese el id de la empresa: ');
            if (!$empresa->Buscar($idEmpresa)) {
                echo "Empresa no encontrada. Finalizando el proceso.\n";

                break;
            }
            echo 'Empresa encontrada : '.$empresa->getEnombre().' ID: '.$empresa->getIdempresa()."\n";

            echo "Ingrese los datos del responsable:\n";
            $numEmpleado = readline('Ingrese el N° de empleado: ');
            $numLicencia = readline('Ingrese el N° de licencia: ');
            $nroDocResponsableV = readline('Ingrese el N° de documento: ');
            $nombreResponsableV = readline('Ingrese el nombre: ');
            $apellidoResponsableV = readline('Ingrese el apellido: ');

            $nuevoResponsable = new ResponsableV();
            $nuevoResponsable->cargar($nroDocResponsableV, $nombreResponsableV, $apellidoResponsableV, $numEmpleado, $numLicencia, $empresa);
            if (!$nuevoResponsable->insertar()) {
                echo 'Ocurrió un error al crear el responsable: '.$nuevoResponsable->getmensajeoperacion()."\n";

                return;
            }
            echo "El responsable fue creado exitosamente.\n";

            echo "Ahora, ingrese los datos del viaje:\n";
            $destino = readline('Ingrese el destino del nuevo viaje: ');
            $maxPasajeros = readline('Ingrese la cantidad máxima de pasajeros del nuevo viaje: ');
            $costoDelViaje = readline('Ingrese el costo del viaje: ');

            $viaje = new Viaje();
            $viaje->cargar(null, $destino, $maxPasajeros, $empresa, $nuevoResponsable, $costoDelViaje);
            if ($viaje->insertar()) {
                echo "Viaje creado exitosamente.\n";
                echo 'id viaje:'.$viaje->getCodIdviaje();
            } else {
                echo 'Ocurrió un error: '.$viaje->getmensajeoperacion();
            }
            break;
        case '3':
            $idViaje = readline('Ingrese el ID VIAJE que desea modificar: ');
            $viaje = new Viaje();
            if ($viaje->Buscar($idViaje)) {
                echo "\nDesea modificar:\n";
                echo "1) Modificar destino del viaje\n";
                echo "2) Modificar maximo de pasajeros del viaje\n";
                echo "3) Modificar responsable del viaje\n";
                echo "4) Modificar costos del viaje\n";
                echo "5) Modificar Empresa\n";
                echo "6) Volver al menu anterior\n";
                $opcion = readline('Ingrese la opción deseada: ');
                switch ($opcion) {
                    case 1:
                        echo 'Este es el destino actual del viaje: '.$viaje->getVdestino()."\n";
                        $viaje->setVdestino(readline('Ingrese el destino del viaje: '));
                        $viaje->modificar();
                        echo 'Se cambió correctamente a '.$viaje->getVdestino().'🟢';
                        break;
                    case 2:
                        echo 'Esta es la cantidad maxima actual del viaje: '.$viaje->getVcantmaxpasajeros()."\n";
                        $viaje->setVcantmaxpasajeros(readline('Ingrese cantidad maxima de pasajeros del viaje: '));
                        $viaje->modificar();
                        echo 'Se cambió correctamente a '.$viaje->getVcantmaxpasajeros().'🟢';
                        break;
                    case 3:
                        $numDocResponsable = readline("Ingrese el DNI del responsable al que desea cambiarle los datos:\n");
                        $responsableV = new ResponsableV();

                        if ($responsableV->BuscarEnViaje('rdocumento = '.$numDocResponsable.' AND '.$numDocResponsable.' IN(SELECT rdocumento FROM viaje WHERE idviaje ='.$idViaje.')', $numDocResponsable)) {
                            echo "¿Qué información desea modificar del responsable del responsable?\n";
                            echo "1) El número del empleado\n";
                            echo "2) El número de licencia\n";
                            echo "3) El nombre\n";
                            echo "4) El apellido\n";
                            echo "5) Todos los datos\n";
                            echo '6) Exit';
                            $eleccion = trim(fgets(STDIN));
                        } else {
                            echo 'El responsable no existe o no pertenece a este viaje';
                            $eleccion = 6;
                        }
                        switch ($eleccion) {
                            case 1:
                                echo $responsableV->getRnumeroempleado()." es el número de responsable \n";
                                echo "Se cambiará a: \n";
                                $nuevoNumEmpleado = trim(fgets(STDIN));
                                $responsableV->setRnumeroempleado($nuevoNumEmpleado);
                                $responsableV->modificar();
                                echo 'Se cambió correctamente a '.$responsableV->getRnumeroempleado()."🟢 \n";
                                break;
                            case 2:
                                echo $responsableV->getRnumerolicencia()." es el numero de licencia del responsable \n";
                                echo "Se cambiará a: \n";
                                $nuevoNumLicencia = trim(fgets(STDIN));
                                $responsableV->setRnumerolicencia($nuevoNumLicencia);
                                $responsableV->modificar();
                                echo 'Se cambió correctamente a '.$responsableV->getRnumerolicencia()."🟢 \n";
                                break;
                            case 3:
                                echo $responsableV->getNombre()." es el nombre del responsable \n";
                                echo "Se cambiará a: \n";
                                $nuevoNombre = trim(fgets(STDIN));
                                $responsableV->setNombre($nuevoNombre);
                                $responsableV->modificar();
                                echo 'Se cambió correctamente a '.$responsableV->getNombre()." 🟢 \n";
                                break;
                            case 4:
                                echo $responsableV->getApellido()." es el apellido de empleado \n";
                                echo "Se cambiará a: \n";
                                $nuevoApellido = trim(fgets(STDIN));
                                $responsableV->setApellido($nuevoApellido);
                                $responsableV->modificar();
                                echo 'Se cambió correctamente a '.$responsableV->getApellido()."🟢\n";
                                break;
                            case 5:
                                echo $responsableV->getRnumeroempleado()." es el número de responsable \n";
                                $responsableV->Buscar($numDocResponsable);
                                echo "Se cambiará a: \n";
                                $nuevoNumEmpleado = trim(fgets(STDIN));
                                $responsableV->setRnumeroempleado($nuevoNumEmpleado);
                                $responsableV->modificar();
                                echo 'Se cambió correctamente a '.$responsableV->getRnumeroempleado()."🟢\n";
                                echo $responsableV->getRnumerolicencia()." es el numero de licencia del responsable \n";
                                echo "Se cambiará a: \n";
                                $nuevoNumLicencia = trim(fgets(STDIN));
                                $responsableV->setRnumerolicencia($nuevoNumLicencia);
                                $responsableV->modificar();
                                echo 'Se cambió correctamente a '.$responsableV->getRnumerolicencia()."🟢\n";
                                echo $responsableV->getNombre()." es el nombre del responsable \n";
                                echo "Se cambiará a: \n";
                                $nuevoNombre = trim(fgets(STDIN));
                                $responsableV->setNombre($nuevoNombre);
                                $responsableV->modificar();
                                echo 'Se cambió correctamente a '.$responsableV->getNombre()."🟢\n";
                                echo $responsableV->getApellido()." es el apellido de empleado \n";
                                echo "Se cambiará a: \n";
                                $nuevoApellido = trim(fgets(STDIN));
                                $responsableV->setApellido($nuevoApellido);
                                $responsableV->modificar();
                                echo 'Se cambió correctamente a '.$responsableV->getApellido()."🟢\n";
                                break;
                            case 6:
                                break;
                            default:
                                echo "Opción incorrecta, por favor ingrese una opción válida🟢\n";
                                break;
                        }
                        break;
                    case 4:
                        echo 'Este es el Costo actual del viaje: '.$viaje->getVimporte()."\n";
                        $viaje->setVimporte(readline('Ingrese el nuevo costo del viaje: '));
                        $viaje->modificar();
                        echo 'Se cambió correctamente a '.$viaje->getVimporte()."🟢\n";
                        break;
                    case 5:
                        $idEmpresa = readline('Ingrese el ID EMPRESA: ');
                        $empresa = new Empresa();
                        if ($empresa->Buscar($idEmpresa)) {
                            echo "Qué información desea modificar de la empresa?\n";
                            echo "1) El nombre\n";
                            echo "2) La dirección\n";
                            echo "3) Todos los datos\n";
                            $opcion = readline('Ingrese la opción deseada: ');
                        }
                        switch ($opcion) {
                            case 1:
                                echo 'El nombre actual de la empresa es: '.$empresa->getEnombre()."\n";
                                echo "Se cambiará a :\n";
                                $nuevoNombre = trim(fgets(STDIN));
                                $empresa->setEnombre($nuevoNombre);
                                $empresa->modificar();
                                echo "El nombre de la empresa se cambió correctamente 🟢\n";
                                break;
                            case 2:
                                echo 'La dirección actual de la empresa es '.$empresa->getEdireccion()."\n";
                                echo "Se cambiará a :\n";
                                $nuevaDire = trim(fgets(STDIN));
                                $empresa->setEdireccion($nuevaDire);
                                $empresa->modificar();
                                echo "La dirección de la empresa se cambió correctamente 🟢\n";
                                break;
                            case 3:
                                echo 'El nombre actual de la empresa es '.$empresa->getEnombre()."\n";
                                echo "Se cambiará a :\n";
                                $nuevoNombre = trim(fgets(STDIN));
                                $empresa->setEnombre($nuevoNombre);
                                $empresa->modificar();
                                echo "El nombre de la empresa se cambió correctamente 🟢\n";
                                echo 'La dirección actual de la empresa es '.$empresa->getEdireccion()."\n";
                                echo "Se cambiará a :\n";
                                $nuevaDire = trim(fgets(STDIN));
                                $empresa->setEdireccion($nuevaDire);
                                echo "La dirección de la empresa se cambió correctamente 🟢\n";
                                $empresa->modificar();
                                break;
                        }
                        // no break
                    case 6:
                        echo "Regresando al menú principal\n";
                        break;
                    default:
                        echo "Opción inválida. Por favor, seleccione una opción válida.\n";
                        break;
                }
            }
            break;

        case '4':
            echo "Ingrese el id del viaje\n";
            $id = trim(fgets(STDIN));
            $viaje = new Viaje();
            if ($viaje->Buscar($id)) {
                echo $viaje;
            }
            break;
        case '5':
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
                        echo 'El nombre actual es: '.$pasajero->getNombre()."\n";
                        echo "Se cambiará a: \n";
                        $nuevoNombre = trim(fgets(STDIN));
                        $pasajero->setNombre($nuevoNombre);
                        $pasajero->modificar();
                        echo 'Se cambió correctamente a '.$pasajero->getNombre()."\n";
                        break;
                    case 2:
                        echo 'El apellido actual es: '.$pasajero->getApellido()."\n";
                        echo "Se cambiará a: \n";
                        $nuevoApellido = trim(fgets(STDIN));
                        $pasajero->setNombre($nuevoApellido);
                        $pasajero->modificar();
                        echo 'Se cambió correctamente a '.$pasajero->getApellido()."\n";
                        break;
                    case 3:
                        echo 'El teléfono actual es: '.$pasajero->getTelefono()."\n";
                        echo "Se cambiará a: \n";
                        $nuevoTelefono = trim(fgets(STDIN));
                        $pasajero->setTelefono($nuevoTelefono);
                        $pasajero->modificar();
                        echo 'Se cambió correctamente a '.$pasajero->getTelefono()."\n";
                        break;
                    case 4:
                        echo 'El nombre actual es: '.$pasajero->getNombre()."\n";
                        echo "Se cambiará a: \n";
                        $nuevoNombre = trim(fgets(STDIN));
                        $pasajero->setNombre($nuevoNombre);
                        $pasajero->modificar();
                        echo 'Se cambió correctamente a '.$pasajero->getNombre()."\n";

                        echo 'El apellido actual es: '.$pasajero->getApellido()."\n";
                        echo "Se cambiará a: \n";
                        $nuevoApellido = trim(fgets(STDIN));
                        $pasajero->setNombre($nuevoApellido);
                        $pasajero->modificar();
                        echo 'Se cambió correctamente a '.$pasajero->getApellido()."\n";

                        echo 'El teléfono actual es: '.$pasajero->getTelefono()."\n";
                        echo "Se cambiará a: \n";
                        $nuevoTelefono = trim(fgets(STDIN));
                        $pasajero->setTelefono($nuevoTelefono);
                        $pasajero->modificar();
                        echo 'Se cambió correctamente a '.$pasajero->getTelefono()."\n";
                        break;
                    default:
                        echo "Opción incorrecta, por favor ingrese una opción válida\n";
                        break;
                }
            } else {
                echo "No se encontró ningún pasajero con ese número de documento. \n";
            }
            break;
        case '6':
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

                    // $persona = new Persona();
                    // if (!$persona->Buscar($documento)) {
                    //     $persona->cargar($documento, $nombre, $apellido);
                    //     if (!$persona->insertar()) {
                    //         echo "Error al agregar la persona.\n";
                    //         exit; // romper
                    //     }
                    // }
                    $pasajero = new Pasajero();
                    $pasajero->cargar($documento, $nombre, $apellido, $viaje, $telefono);

                    if ($pasajero->insertar()) {
                        echo "Pasajero cargado correctamente.\n";
                    } else {
                        echo "Ocurrió un error: Numero documento repetido o vacio\n";
                    }
                } else {
                    echo "No hay más pasajes disponibles para la venta.\n";
                }
            } else {
                echo "Viaje no encontrado.\n";
            }
            break;
        case '7':
            echo "Que dato desea borrar?\n";
            echo "1) Eliminar viaje\n";
            echo "2) Eliminar empresa\n";
            echo "3) Eliminar responsable del viaje\n";
            echo "4) Eliminar pasajero\n";
            $rpta = trim(fgets(STDIN))."\n";
            switch ($rpta) {
                case '1':
                    echo "Ingrese el ID del viaje a eliminar:\n";
                    $id = trim(fgets(STDIN));
                    echo "¿Esta seguro que desea eliminar los datos de viaje? s/n \n";
                    $rta = trim(fgets(STDIN));
                    if ($rta == 's') {
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
                    } else {
                        echo "No han sido eliminado datos del sistema. \n";
                    }
                    break;
                case '2':
                    echo "Ingrese el ID de la empresa:\n";
                    $idEMpresa = trim(fgets(STDIN));
                    echo "¿Esta seguro que desea eliminar los datos de Empresa? s/n \n";
                    $rta = trim(fgets(STDIN));
                    if ($rta == 's') {
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
                    } else {
                        echo "No han sido eliminado datos del sistema. \n";
                    }
                    break;
                case '3':
                    echo "Ingrese el número de documento del responsable:\n";
                    $rdoc = trim(fgets(STDIN));
                    echo "¿Esta seguro que desea eliminar los datos del responsable? s/n \n";
                    $rta = trim(fgets(STDIN));
                    if ($rta == 's') {
                        $objRespV = new ResponsableV();
                        if ($objRespV->Buscar('rdocumento ='.$rdoc, $rdoc)) {
                            if ($objRespV->eliminar()) {
                                echo "Responsable eliminado con éxito.\n";
                            } else {
                                echo "Ocurrió un error al intentar borrar al responsable.\n";
                            }
                        } else {
                            echo "No existe responsable con ese documento en este viaje.\n";
                        }
                    } else {
                        echo "No han sido eliminado datos del sistema. \n";
                    }
                    break;
                case '4':
                    echo "Ingrese el documento del pasajero:\n";
                    $pdoc = trim(fgets(STDIN));
                    echo "¿Esta seguro que desea eliminar los datos del pasajero? s/n \n";
                    $rta = trim(fgets(STDIN));
                    if ($rta == 's') {
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
                    } else {
                        echo "No han sido eliminado datos del sistema. \n";
                    }
            }
            break;
        case '8':
            exit;
            break;
        default:
            echo "Opción inválida. Por favor, seleccione una opción válida.\n";
            break;
    }
}
