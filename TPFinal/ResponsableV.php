<?php

class ResponsableV extends Persona
{
    private $rnumeroempleado;

    private $rnumerolicencia;

    public function __construct()
    {
        parent::__construct();
        $this->rnumeroempleado = "";
        $this->rnumerolicencia = "";

    }

    public function cargar($doc, $nombre, $apellido,  $rnumeroempleado = null, $rnumerolicencia = null)
    {
        parent::cargar($doc, $nombre, $apellido);
        $this->setRnumeroempleado($rnumeroempleado);// ********************
        $this->setRnumerolicencia($rnumerolicencia);
    }

    public function getRnumeroempleado()
    {
        return $this->rnumeroempleado;
    }

    public function setRnumeroempleado($value)
    {
        $this->rnumeroempleado = $value;
    }

    public function getRnumerolicencia()
    {
        return $this->rnumerolicencia;
    }

    public function setRnumerolicencia($value)
    {
        $this->rnumerolicencia = $value;
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
        $consultaPersona = "SELECT * FROM responsable WHERE rdocumento=" . $dni;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersona)) {
                if ($row2 = $base->Registro()) {
                    parent::Buscar($dni);
                    $this->setRnumeroempleado($row2['rnumeroempleado']);
                    $this->setRnumerolicencia($row2['rnumerolicencia']);
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
        $consultaPersonas = "SELECT * FROM responsable ";
        if ($condicion != "") {
            $consultaPersonas = $consultaPersonas . ' WHERE ' . $condicion;
        }
        $consultaPersonas .= " ORDER BY rnumeroempleado,rnumerolicencia ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersonas)) {
                $arrayPersona = array();
                while ($row2 = $base->Registro()) {
                    $obj = new ResponsableV();
                    $obj->Buscar($row2["rdocumento"]);
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
        if (parent::insertar()) {
            $consultaInsertar = "INSERT INTO responsable(rdocumento,rnumeroempleado,rnumerolicencia) 
            VALUES (" . $this->getDoc() . ", '" . $this->getRnumeroempleado() . "', '" . $this->getRnumerolicencia() . "')";
            
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaInsertar)) {
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
        $consultaModifica = "UPDATE responsable SET rnumeroempleado='" . $this->getRnumeroempleado() . "' rnumerolicencia=" . $this->getRnumeroempleado() . "' WHERE rdocumento=" . $this->getDoc();
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

    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consultaBorra = "DELETE FROM responsable WHERE rdocumento=" . $this->getDoc();
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
        $msj .= "\nNúmero de Empleado: " . $this->getRnumeroempleado() . "\n";
        $msj .= "Numero de Licencia: " . $this->getRnumerolicencia() . "\n";

        return $msj;
    }
}
