<?php

class Pasajero extends Persona
{
   
    
    private $idviaje;
    private $mensajeoperacion;
    public function __constructor()
    {
        parent::__construct();

        $this->idviaje = "";
    }


    public function getIdviaje()
    {
        return $this->idviaje;
    }

    public function setIdviaje($value)
    {
        $this->idviaje = $value;
    }
    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}

    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}

    public function Buscar($dni)
    {
        $base = new BaseDatos();
        $consultaPersona = "SELECT * FROM pasajero WHERE pdocumento=" . $dni;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersona)) {
                if ($row2 = $base->Registro()) {
                   parent::Buscar($dni);
                    $this->setIdviaje($row2['idviaje']);//posble boolean
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


    public function listar($condicion = "")
    {
        $arrayPersona = null;
        $base = new BaseDatos();
        $consultaPersonas = "SELECT * FROM pasajero ";
        if ($condicion != "") {
            $consultaPersonas = $consultaPersonas . ' WHERE ' . $condicion;
        }
        $consultaPersonas .= " ORDER BY idviaje ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersonas)) {
                $arrayPersona = array();
                while ($row2 = $base->Registro()) {
                    $obj = new Pasajero();
                    $obj->Buscar($row2["pdocumento"]);
                    array_push($arrayPersona, $obj);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arrayPersona;
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO pasajero(pdocumento,idviaje) 
				            VALUES (" . $this->getDoc() . ",'" . $this->getIdviaje()  . "')";
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
        $consultaModifica = "UPDATE pasajero SET idviaje='" .$this->getIdviaje(). "' WHERE pdocumento=" . $this->getDoc();
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

    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consultaBorra = "DELETE FROM pasajero WHERE pdocumento=" . $this->getDoc();
            if ($base->Ejecutar($consultaBorra)) {
                if(parent::eliminar()){
                    $resp=  true;
                }
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
        $msj = "\n»»»»««««\n";
        $msj .= parent::__toString();
        $msj .= "id Viaje: " . $this->getIdviaje() . "\n";
        return $msj;
    }



}
