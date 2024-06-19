<?php

class Viaje
{
    private $idCodviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $objEmpresa;
    private $objResponsableV;
    private $vimporte;
    private $mensajeoperacion;
    private $colObjPasajeros;

    public function __construct()
    {
        $this->idCodviaje = '';
        $this->vdestino = '';
        $this->vcantmaxpasajeros = '';
        $this->objEmpresa = '';
        $this->objResponsableV = '';
        $this->vimporte = '';
        $this->colObjPasajeros = [];
    }

    public function cargar($idCodviaje, $vdestino, $vcantmaxpasajeros, $objEmpresa, $objResponsableV, $vimporte)
    {
        if ($idCodviaje != null) {
            $this->setCodIdviaje($idCodviaje);
        }
        $this->setVdestino($vdestino);
        $this->setVcantmaxpasajeros($vcantmaxpasajeros);
        $this->setObjEmpresa($objEmpresa);
        $this->setObjResponsableV($objResponsableV);
        $this->setVimporte($vimporte);
    }

    public function getColObjPasajeros()
    {
        return $this->colObjPasajeros;
    }

    public function setColObjPasajeros($colObjPasajeros)
    {
        $this->colObjPasajeros = $colObjPasajeros;
    }

    public function getCodIdviaje()
    {
        return $this->idCodviaje;
    }

    public function setCodIdviaje($idCodviaje)
    {
        $this->idCodviaje = $idCodviaje;
    }

    public function getVdestino()
    {
        return $this->vdestino;
    }

    public function setVdestino($value)
    {
        $this->vdestino = $value;
    }

    public function getVcantmaxpasajeros()
    {
        return $this->vcantmaxpasajeros;
    }

    public function setVcantmaxpasajeros($value)
    {
        $this->vcantmaxpasajeros = $value;
    }

    public function getVimporte()
    {
        return $this->vimporte;
    }

    public function setVimporte($value)
    {
        $this->vimporte = $value;
    }

    public function getObjEmpresa()
    {
        return $this->objEmpresa;
    }

    public function setObjEmpresa($objEmpresa)
    {
        $this->objEmpresa = $objEmpresa;
    }

    public function getObjResponsableV()
    {
        return $this->objResponsableV;
    }

    public function setObjResponsableV($objResponsableV)
    {
        $this->objResponsableV = $objResponsableV;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    public function setmensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function getColPasajerosBD($id)
    {
        $base = new BaseDatos();
        $consultaviaje = 'SELECT * ,p.ptelefono FROM pasajero AS p  INNER JOIN persona AS per  ON p.pdocumento = per.documento WHERE idviaje=' . $id;
        $resp = false;

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaviaje)) {
                $pasajeros = [];
                while ($row2 = $base->Registro()) {
                    $pasajero = new Pasajero();
                    $doc = $row2['documento'];
                    $nombre = $row2['nombre'];
                    $apellido = $row2['apellido'];
                    $telefono = $row2['ptelefono'];
                    $pasajero->cargar($doc, $nombre, $apellido, $id, $telefono);

                    $pasajeros[] = $pasajero;
                }
                $this->setColObjPasajeros($pasajeros);
                $resp = true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }

        return $resp;
    }

    /**
     * Recupera los datos de un viaje por ID.
     *
     * @param int $id
     *
     * @return bool true en caso de encontrar los datos, false en caso contrario
     */
    public function Buscar($id)
    {
        $base = new BaseDatos();
        $consultaviaje = 'SELECT * FROM viaje WHERE idviaje=' . $id;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaviaje)) {
                if ($row2 = $base->Registro()) {
                    $objetoEmpresa = new Empresa();
                    $objetoEmpresa->Buscar($row2['idempresa']);
                    $objetoResponsable = new ResponsableV();
                    $objetoResponsable->Buscar($row2['rdocumento']);
                    $this->setCodIdviaje($id);
                    $this->setVdestino($row2['vdestino']);
                    $this->setVcantmaxpasajeros($row2['vcantmaxpasajeros']);
                    $this->setObjEmpresa($objetoEmpresa);
                    $this->setObjResponsableV($objetoResponsable);
                    $this->setVimporte($row2['vimporte']);
                    $resp = true;
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }

        return $resp;
    }

    public function listar($condicion = '')
    {
        $arregloviaje = null;
        $base = new BaseDatos();
        $consultaviajes = 'SELECT * FROM viaje ';
        if ($condicion != '') {
            $consultaviajes = $consultaviajes . ' where ' . $condicion;
        }
        $consultaviajes .= ' order by vdestino ';
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaviajes)) {
                $arregloviaje = [];
                while ($row2 = $base->Registro()) {
                    $IdViaje = $row2['idviaje'];
                    $Destino = $row2['vdestino'];
                    $CantMaxPas = $row2['vcantmaxpasajeros'];
                    $IdEmpresa = $row2['idempresa'];
                    $RNumEmp = $row2['rnumeroempleado'];
                    $Importe = $row2['vimporte'];

                    $viaje = new viaje();
                    $viaje->cargar($IdViaje, $Destino, $CantMaxPas, $IdEmpresa, $RNumEmp, $Importe);
                    array_push($arregloviaje, $viaje);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }

        return $arregloviaje;
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = $consultaInsertar = "INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, rdocumento, vimporte) VALUES ('" . $this->getVdestino() . "', " . $this->getVcantmaxpasajeros() . ", " . $this->getObjEmpresa()->getIdempresa() . ", " . $this->getObjResponsableV()->getRnumeroempleado() . ", " . $this->getObjResponsableV()->getDoc() . ", " . $this->getVimporte() . ")";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaInsertar)) {
                $id = $base->lastInsertId();
                $this->setCodIdviaje($id);
                $resp = true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }

        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $consultaModifica = "UPDATE viaje 
                SET rnumeroempleado='" . $this->getObjResponsableV() . "', 
                    vdestino='" . $this->getVdestino() . "', 
                    vcantmaxpasajeros='" . $this->getVcantmaxpasajeros() . "' 
                WHERE idviaje=" . $this->getCodIdviaje();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaModifica)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }

        return $resp;
    }

    public function eliminarPasajerosPorViaje($idViaje)
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consultaBorraPasajeros = "DELETE FROM pasajero WHERE idviaje=" . $idViaje;
            if ($base->Ejecutar($consultaBorraPasajeros)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    // si eliminamos el vijae, debemos eliminar los pasajeros
    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        $idViaje = $this->getCodIdviaje();
        if ($this->eliminarPasajerosPorViaje($idViaje)) {
            if ($base->Iniciar()) {
                $consultaBorra = "DELETE FROM viaje WHERE idviaje=" . $idViaje;
                if ($base->Ejecutar($consultaBorra)) {
                    $resp = true;
                } else {
                    $this->setmensajeoperacion($base->getError());
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        }
        return $resp;
    }

    // para mostrar todos los viajes
    /*public function mostrarViaje($idViaje)
    {
        $viajes = $this->listar("idviaje = " . $idViaje);
        if ($viajes != null) {
            $resultado = "";
            foreach ($viajes as $viaje) {
                $resultado .= $viaje->__toString() . "\n"; // acceder toString para retornar valor ensrguida
            }
        } else {
            $resultado = "Sin viajes";
        }
        return $resultado;
    }*/


    public function cadena($array)
    {
        $cadena = "";
        foreach ($array as $value) {
            $cadena .= $value;
        }
        return $cadena;
    }

    public function __toString()
    {
        $msj = "********************************************* \n";
        $msj .= 'ID VIAJE: ' . $this->getCodIdviaje() . "\n";
        $msj .= 'Destino: ' . $this->getVdestino() . "\n";
        $msj .= 'Importe del Viaje: ' . $this->getVimporte() . "\n";
        $msj .= 'Cantidad Maxima Pasajeros: ' . $this->getVcantmaxpasajeros() . "\n";
        $msj .= "\nEmpresa: \n" . $this->getObjEmpresa() . "\n";
        $msj .= "Responsable: \n" . $this->getObjResponsableV() . "\n";
        $msj .= "Pasajeros: \n" . $this->cadena($this->getColObjPasajeros()) . "\n";
        $msj .= "********************************************* \n";
        return $msj;
    }
}
