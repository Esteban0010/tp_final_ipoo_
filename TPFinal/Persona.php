<?php
class Persona
{

    private $documento;
    private $nombre;
    private $apellido;
    private $telefono;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->documento = "";
        $this->nombre = "";
        $this->apellido = "";
        $this->telefono = "";
    }

    public function cargar($doc, $nombre, $apellido, $telefono)
    {
        $this->setDoc($doc);
        $this->setNombre($nombre);
        $this->setApellido($apellido);
        $this->setTelefono($telefono);
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

    public function getTelefono()
    {
        return $this->telefono;
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

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
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
        $consultaPersona = "SELECT * FROM persona WHERE pdocumento=" . $dni;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersona)) {
                if ($row2 = $base->Registro()) {
                    $this->setDoc($dni);
                    $this->setNombre($row2['pnombre']);
                    $this->setApellido($row2['papellido']);
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

    public function listar($condicion = "")
    {
        $arrayPersona = null;
        $base = new BaseDatos();
        $consultaPersonas = "SELECT * FROM persona ";
        if ($condicion != "") {
            $consultaPersonas = $consultaPersonas . ' WHERE ' . $condicion;
        }
        $consultaPersonas .= " ORDER BY papellido ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersonas)) {
                $arrayPersona = array();
                while ($row2 = $base->Registro()) {

                    $doc = $row2['pdocumento'];
                    $nombre = $row2['pnombre'];
                    $apellido = $row2['papellido'];
                    $telefono = $row2['ptelefono'];
                    $perso = new Persona();
                    $perso->cargar($doc, $nombre, $apellido, $telefono);
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
        $consultaInsertar = "INSERT INTO persona(pdocumento, pnombre, papellido, ptelefono) 
				            VALUES (" . $this->getDoc() . ",'" . $this->getApellido() . "','" . $this->getNombre() . "','" . $this->getTelefono() . "')";
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
        $consultaModifica = "UPDATE persona SET papellido='" . $this->getApellido() . "',pnombre='" . $this->getNombre() . "'
                           ,ptelefono='" . $this->getTelefono() . "' WHERE pdocumento=" . $this->getDoc();
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
            $consultaBorra = "DELETE FROM persona WHERE pdocumento=" . $this->getDoc();
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
        $msj .= "Telefono: " . $this->getTelefono() . "\n";
        return $msj;
    }
}
