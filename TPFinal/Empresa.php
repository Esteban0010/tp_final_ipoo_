<?php

class Empresa
{
    private $idempresa;
    private $enombre;
    private $edireccion;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idempresa = '';
        $this->enombre = '';
        $this->edireccion = '';
    }

    public function cargar($idempresa, $enombre, $edireccion)
    {
        $this->setIdempresa($idempresa);
        $this->setEnombre($enombre);
        $this->setEdireccion($edireccion);
    }

    // getters
    public function getIdempresa()
    {
        return $this->idempresa;
    }

    public function getEnombre()
    {
        return $this->enombre;
    }

    public function getEdireccion()
    {
        return $this->edireccion;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    // setters
    public function setIdempresa($idempresa)
    {
        $this->idempresa = $idempresa;
    }

    public function setEnombre($enombre)
    {
        $this->enombre = $enombre;
    }

    public function setEdireccion($edireccion)
    {
        $this->edireccion = $edireccion;
    }

    public function setmensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function Buscar($idempresa)
    {
        $base = new BaseDatos();
        $consultaViaje = 'SELECT * FROM empresa WHERE idempresa = ' . $idempresa;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViaje)) {
                if ($row2 = $base->Registro()) {
                    $this->cargar($idempresa, $row2['enombre'], $row2['edireccion']);
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
        $arrViaje = null;
        $base = new BaseDatos();
        $consultaViajes = 'SELECT * FROM empresa ';
        if ($condicion != '') {
            $consultaViajes = $consultaViajes . ' WHERE ' . $condicion;
        }
        $consultaViajes .= ' ORDER BY idempresa ';
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViajes)) {
                $arregloEmpresa = [];
                while ($row2 = $base->Registro()) {
                    $idempresa = $row2['idempresa'];
                    $enombre = $row2['enombre'];
                    $edireccion = $row2['edireccion'];
                    $empresa = new Empresa();
                    $empresa->cargar($idempresa, $enombre, $edireccion);
                    array_push($arregloEmpresa, $empresa);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }

        return $arrViaje;
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $nombre = $this->getEnombre();
        $direccion = $this->getEdireccion();

        $consultaInsertar = "INSERT INTO empresa(enombre, edireccion)
        VALUES ('{$nombre}', '{$direccion}')";

        if ($base->Iniciar()) {

            if ($idEmpresa = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setIdempresa($idEmpresa);
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
        $consultaModifica = "UPDATE empresa
                             SET enombre='" . $this->getEnombre() . "',edireccion='" . $this->getEdireccion() . "' WHERE idempresa=" . $this->getIdempresa();
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
            $consultaBorra = 'DELETE FROM empresa WHERE idempresa=' . $this->getIdempresa();
            if ($base->Ejecutar($consultaBorra)) {
                $resp = true;
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
        $msj = 'ID EMPRESA: ' . $this->getIdempresa() . "\n";
        $msj .= 'Nombre : ' . $this->getEnombre() . "\n";
        $msj .= 'Dirección : ' . $this->getEdireccion() . "\n";

        return $msj;
    }
}
