<?php

class Persona
{
    private $documento;
    private $nombre;
    private $apellido;

    private $mensajeoperacion;

    public function __construct()
    {
        $this->documento = "";
        $this->nombre = "";
        $this->apellido = "";
    }

    public function cargar($doc, $nombre, $apellido)
    {
        $this->setDoc($doc);
        $this->setNombre($nombre);
        $this->setApellido($apellido);
    }

    // getters
    public function getDoc()
    {
        return $this->documento;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    // setters
    public function setDoc($doc)
    {
        $this->documento = $doc;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
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
        $consultaPersona = "SELECT * FROM persona WHERE documento=" . $dni;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersona)) {
                if ($row2 = $base->Registro()) {
                    $this->setDoc($dni);
                    $this->setNombre($row2['nombre']);
                    $this->setApellido($row2['apellido']);
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
        $consultaPersonas = "SELECT * FROM persona ";
        if ($condicion != "") {
            $consultaPersonas = $consultaPersonas . ' WHERE ' . $condicion;
        }
        $consultaPersonas .= " ORDER BY apellido ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersonas)) {
                $arrayPersona = array();
                while ($row2 = $base->Registro()) {

                    $doc = $row2['documento'];
                    $nombre = $row2['nombre'];
                    $apellido = $row2['apellido'];
                    $perso = new Persona();
                    $perso->cargar($doc, $nombre, $apellido);
                    array_push($arrayPersona, $perso);
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
        $consultaInsertar = "INSERT INTO persona(documento, apellido, nombre) 
				            VALUES (" . $this->getDoc() . ",'" . $this->getApellido() . "','" . $this->getNombre() . "')";
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
        $consultaModifica = "UPDATE persona SET apellido='" . $this->getApellido() . "',nombre='" . $this->getNombre() . "' WHERE documento=" . $this->getDoc();
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
            $consultaBorra = "DELETE FROM persona WHERE documento=" . $this->getDoc();
            if ($base->Ejecutar($consultaBorra)) {
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
        $msj = "Nombre: " . $this->getNombre() . "\n";
        $msj .= "Apellido: " . $this->getApellido() . "\n";
        $msj .= "Numero Documento: " . $this->getDoc() . "\n";
        return $msj;
    }
}
