<?php

class Pasajero extends Persona
{
    private $idviaje;
    private $telefono;
    private $mensajeoperacion;

    public function __construct()
    {
        parent::__construct();
        $this->idviaje = '';
        $this->telefono = '';
    }

    public function cargar($doc, $nombre, $apellido, $idviaje = null, $telefono = null)
    {
        parent::cargar($doc, $nombre, $apellido);
        $this->setIdviaje($idviaje);
        $this->setTelefono($telefono);
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function getIdviaje()
    {
        return $this->idviaje;
    }

    public function setIdviaje($value)
    {
        $this->idviaje = $value;
    }

    public function setmensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    public function Buscar($dni)
    {
        $base = new BaseDatos();
        $consultaPersona = 'SELECT * FROM pasajero WHERE pdocumento=' . $dni;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersona)) {
                if ($row2 = $base->Registro()) {
                    parent::Buscar($dni);
                    $this->setIdviaje($row2['idviaje']);
                    $this->setTelefono($row2['ptelefono']);
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
        $arrayPersona = null;
        $base = new BaseDatos();
        $consultaPersonas = 'SELECT * FROM pasajero ';
        if ($condicion != '') {
            $consultaPersonas = $consultaPersonas . ' WHERE ' . $condicion;
        }
        $consultaPersonas .= ' ORDER BY idviaje ';
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersonas)) {
                $arrayPersona = [];
                while ($row2 = $base->Registro()) {
                    $obj = new Pasajero();
                    $obj->Buscar($row2['pdocumento']);
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


    public function verificacionNoRepetir()
    {
        $base = new BaseDatos();
        $resp = false;
        $consultaVerificacion = "SELECT * FROM pasajero AS psj WHERE psj.pdocumento = " . $this->getDoc() . "AND  idviaje = " . $this->getIdviaje();

        if ($base->Iniciar() && $base->Ejecutar($consultaVerificacion)) {
            if ($base->Registro()) {
                $resp = true;
            }
        } else {
            $this->setmensajeoperacion($base->getError()) . "\n";
        }
        return $resp;
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = 'INSERT INTO pasajero(pdocumento,idviaje,ptelefono) 
				            VALUES (' . $this->getDoc() . ",'" . $this->getIdviaje() . "', '" . $this->getTelefono() . "')";
        if (!$this->verificacionNoRepetir()) {
            if (parent::insertar()) {
                if ($base->Iniciar() && $base->Ejecutar($consultaInsertar)) {
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

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $consultaModifica = "UPDATE pasajero SET idviaje='" . $this->getIdviaje() . "', ptelefono='" . $this->getTelefono() . "' WHERE pdocumento=" . $this->getDoc();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaModifica)) {
                parent::modificar();
                $resp = true;
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
            $consultaBorra = 'DELETE FROM pasajero WHERE pdocumento=' . $this->getDoc();
            if ($base->Ejecutar($consultaBorra)) {
                if (parent::eliminar()) {
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

    public function __toString()
    {
        $msj = parent::__toString();
        $msj .= 'id Viaje: ' . $this->getIdviaje() . "\n";
        return $msj;
    }
}
