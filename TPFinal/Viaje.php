<?php

class Viaje
{
    private $idCodviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $idObjEmpresa;
    private $rnumeroempleado;
    private $objResponsableVDoc;
    private $vimporte;
    private $mensajeoperacion;

    public function __constructor()
    {
        /** SE ponen los autoincrement*/
        $this->idCodviaje = "";
        $this->vdestino = "";
        $this->vcantmaxpasajeros = "";
        $this->idObjEmpresa = "";
        $this->rnumeroempleado;
        $this->objResponsableVDoc = "";
        $this->vimporte = "";
    }

    public function cargar(){

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

    public function getIdObjEmpresa()
    {
        return $this->idObjEmpresa;
    }

    public function setIdObjEmpresa($idObjEmpresa)
    {
        $this->idObjEmpresa = $idObjEmpresa;
    }

    public function getObjResponsableDocumento()
    {
        return $this->objResponsableVDoc;
    }

    public function setObjResponsableDocumento($objResponsableVDoc)
    {
        $this->objResponsableVDoc = $objResponsableVDoc;
    }

    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
    }

    public function setmensajeoperacion($mensajeoperacion){
        $this->mensajeoperacion = $mensajeoperacion;
    }

    /**
     * Recupera los datos de un viaje por ID
     * @param int $id
     * @return boolean true en caso de encontrar los datos, false en caso contrario 
     */
    public function Buscar($id)
    {
        $base = new BaseDatos();
        $consultaviaje = "SELECT * FROM viaje WHERE idviaje=" . $id;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaviaje)) {
                if ($row2 = $base->Registro()) {
                    $objetoEmpresa = new Empresa();
                    $objetoEmpresa->Buscar($row2['idempresa']);
                    $objetoResponsable = new ResponsableV();
                    $objetoResponsable->Buscar($row2['rnumeroempleado']);
                    $this->setCodIdviaje($id);
                    $this->setVdestino($row2['vdestino']);
                    $this->setVcantmaxpasajeros($row2['vcantmaxpasajeros']);
                    $this->setIdObjEmpresa($objetoEmpresa);
                    $this->setObjResponsableDocumento($objetoResponsable);
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
				VALUES (" . $this->getCodIdviaje() . ",'" . $this->getVdestino() . "','" . $this->getVcantmaxpasajeros() . "','" . $this->getIdObjEmpresa()->getId() /* no será getIdempresa? */. "','" . $this->getObjResponsableDocumento()->getNumeroEmpleado() . "','" . $this->getVimporte() . "')";

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
        $consultaModifica = "UPDATE viaje SET vdestino='" . $this->getCodIdviaje() . "',idempresa='" . $this->getIdObjEmpresa()->getId() . "'
                           ,rnumeroempleado='" . $this->getObjResponsableDocumento()->getNumeroEmpleado() . "' WHERE idviaje=" . $this->getCodIdviaje();
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

    public function __toString()
    {
        $msj = "ID VIAJE: " . $this->getCodIdviaje() . "\n";
        $msj .= "Destino: " . $this->getVdestino() .  "\n";
        $msj .= "Cantidad Maxima Pasajeros: " . $this->getVcantmaxpasajeros() .  "\n";
        $msj .= "ID EMPRESA: " . $this->getIdObjEmpresa() .  "\n";
        $msj .= "Numero Empleado: " . $this->getRnumeroempleado() .  "\n";
        $msj .= "DNI responsable: " . $this->getObjResponsableDocumento() .  "\n";
        $msj .= "Importe del Viaje: " . $this->getVimporte() .  "\n";
        return $msj;
    }
}
