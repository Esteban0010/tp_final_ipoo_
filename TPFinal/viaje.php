<?php

class Viaje
{
    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $idEmpresa;
    private $rnumeroempleado;
    private $rdocumento;
    private $vimporte;
    public function __constructor()
    {
        /** SE ponen los autoincrement*/
        $this->idviaje = "";
        $this->vdestino = "";
        $this->vcantmaxpasajeros = "";
        $this->idEmpresa = "";
        $this->rnumeroempleado;
        $this->rdocumento = "";
        $this->vimporte = "";
    }

    public function getIdviaje()
    {
        return $this->idviaje;
    }

    public function setIdviaje($value)
    {
        $this->idviaje = $value;
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


    public function getRnumeroempleado()
    {
        return $this->rnumeroempleado;
    }

    public function setRnumeroempleado($value)
    {
        $this->rnumeroempleado = $value;
    }

    public function getVimporte()
    {
        return $this->vimporte;
    }

    public function setVimporte($value)
    {
        $this->vimporte = $value;
    }


    /**
     * Get the value of idEmpresa
     */
    public function getIdEmpresa()
    {
        return $this->idEmpresa;
    }

    /**
     * Set the value of idEmpresa
     *
     * @return  self
     */
    public function setIdEmpresa($idEmpresa)
    {
        $this->idEmpresa = $idEmpresa;
    }

    /**
     * Get the value of rdocumento
     */
    public function getRdocumento()
    {
        return $this->rdocumento;
    }

    /**
     * Set the value of rdocumento
     *
     * @return  self
     */
    public function setRdocumento($rdocumento)
    {
        $this->rdocumento = $rdocumento;
    }

    public function __toString()
    {
        $msj = "ID VIAJE: " . $this->getIdviaje() . "\n";
        $msj .= "Destino: " . $this->getVdestino() .  "\n";
        $msj .= "Cantidad Maxima Pasajeros: " . $this->getVcantmaxpasajeros() .  "\n";
        $msj .= "ID EMPRESA: " . $this->getIdEmpresa() .  "\n";
        $msj .= "Numero Empleado: " . $this->getRnumeroempleado() .  "\n";
        $msj .= "DNI responsable: " . $this->getRdocumento() .  "\n";
        $msj .= "Importe del Viaje: " . $this->getVimporte() .  "\n";
        return $msj;
    }

    /**
     * Recupera los datos de un viaje por ID
     * @param int $id
     * @return boolean true en caso de encontrar los datos, false en caso contrario 
     */
    public function Buscar($id)
    {
        $base = new BaseDatos();
        $consultaviaje = "Select * from viaje where idviaje=" . $id;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaviaje)) {
                if ($row2 = $base->Registro()) {
                    $objetoEmpresa = new Empresa();
                    $objetoEmpresa->Buscar($row2['idempresa']); //tiene que ser igual a la BD
                    $objetoResponsable = new Responsable();
                    $objetoResponsable->Buscar($row2['rnumeroempleado']);
                    $this->getCodigo($id);
                    $this->setDestino($row2['vdestino']);
                    $this->setMaxPasajero($row2['vcantmaxpasajeros']);
                    $this->setObjEmpresa($objetoEmpresa);
                    $this->setObjResponsable($objetoResponsable);
                    $this->setCosto($row2['vimporte']);
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
    // 	public function Buscar($dni)
    // 	{
    // 		$base = new BaseDatos();
    // 		$consultaPersona = "Select * from persona where nrodoc=" . $dni;
    // 		$resp = false;
    // 		if ($base->Iniciar()) {
    // 			if ($base->Ejecutar($consultaPersona)) {
    // 				if ($row2 = $base->Registro()) {
    // 					$this->setIdPersona($row2['idpersona']);
    // 					$this->setNrodoc($dni);
    // 					$this->setNombre($row2['nombre']);
    // 					$this->setApellido($row2['apellido']);
    // 					$this->setEmail($row2['email']);
    // 					$resp = true;
    // 				}
    // 			} else {
    // 				$this->setmensajeoperacion($base->getError());
    // 			}
    // 		} else {
    // 			$this->setmensajeoperacion($base->getError());
    // 		}
    // 		return $resp;
    // 	}

    public function listar($condicion = "")
    {
        $arregloviaje = null;
        $base = new BaseDatos();
        $consultaviajes = "Select * from viaje ";
        if ($condicion != "") {
            $consultaviajes = $consultaviajes . ' where ' . $condicion;
        }
        $consultaviajes .= " order by vdestino ";
        //echo $consultaviajes;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaviajes)) {
                $arregloviaje = array();
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
        $consultaInsertar = "INSERT INTO viaje(idviaje, vdestino, vcantmaxpasajeros,  idempresa, rnumeroempleado, vimporte) 
				VALUES (" . $this->getCodigo() . ",'" . $this->getDestino() . "','" . $this->getMaxPasajeros() . "','" . $this->getObjEmpresa()->getId() . "','" . $this->getObjResponsable()->getNumeroEmpleado() . "','" . $this->getCosto() . "')";

        if ($base->Iniciar()) {

            if ($base->Ejecutar($consultaInsertar)) {

                $resp =  true;
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
        $consultaModifica = "UPDATE viaje SET vdestino='" . $this->getDestino() . "',idempresa='" . $this->getObjEmpresa()->getId() . "'
                           ,rnumeroempleado='" . $this->getObjResponsable()->getNumeroEmpleado() . "' WHERE idviaje=" . $this->getCodigo();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaModifica)) {
                $resp =  true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }
}
