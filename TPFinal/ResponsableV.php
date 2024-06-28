<?php

class ResponsableV extends Persona
{
    private $rnumeroempleado;
    private $objEmpresa;
    private $rnumerolicencia;

    public function __construct()
    {
        parent::__construct();
        $this->rnumeroempleado = '';
        $this->rnumerolicencia = '';
        $this->objEmpresa = '';
    }

    public function cargar($doc, $nombre, $apellido, $rnumeroempleado = null, $rnumerolicencia = null, $objEmpresa = null)
    {
        parent::cargar($doc, $nombre, $apellido);
        $this->setRnumeroempleado($rnumeroempleado);
        $this->setRnumerolicencia($rnumerolicencia);
        $this->setObjEmpresa($objEmpresa);
    }

    public function getObjEmpresa()
    {
        return $this->objEmpresa;
    }

    public function setObjEmpresa($objEmpresa)
    {
        $this->objEmpresa = $objEmpresa;
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

    public function Buscar($dni)
    {
        $base = new BaseDatos();
        $consultaPersona = 'SELECT * FROM responsable WHERE rdocumento = ' . $dni;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersona)) {
                if (parent::Buscar($dni)) {
                    if ($row2 = $base->Registro()) {
                        // sa
                        $this->setRnumeroempleado($row2['rnumeroempleado']);
                        $this->setRnumerolicencia($row2['rnumerolicencia']);
                        $empresa = new Empresa();
                        $empresa->Buscar($row2['idempresa']);
                        $this->setObjEmpresa($empresa);

                        $resp = true;
                    }
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }

        return $resp;
    }

    public function BuscarEnViaje($condicion = '', $dni)
    {
        $base = new BaseDatos();
        $consultaPersona = 'SELECT * FROM responsable';
        $resp = false;
        if ($condicion != '') {
            $consultaPersona = $consultaPersona . ' where ' . $condicion;
        }
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPersona)) {
                if (parent::Buscar($dni)) {
                    if ($row2 = $base->Registro()) {
                        // sa
                        $this->setRnumeroempleado($row2['rnumeroempleado']);
                        $this->setRnumerolicencia($row2['rnumerolicencia']);
                        $empresa = new Empresa();
                        $empresa->Buscar($row2['idempresa']);
                        $this->setObjEmpresa($empresa);

                        $resp = true;
                    }
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
        $array = null;
        $base = new BaseDatos();
        $consulta = "Select * from responsable ";
        if ($condicion != "") {
            $consulta = $consulta . ' where ' . $condicion;
        }
        $consulta .= " order by rnumeroempleado ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $array = array();
                while ($row2 = $base->Registro()) {
                    $obj = new ResponsableV();
                    $obj->Buscar($row2['rdocumento']);
                    array_push($array, $obj);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $array;
    }

    /***
     * nos tiene que tirar un false, si es false dps se puede agregar persona
     * si tira true, no se puede agregar
     */
    public function verificacionNoRepetir()
    {
        $base = new BaseDatos();
        $resp = false;

        $consultaVerificacionResponsable = 'SELECT * FROM responsable WHERE (rnumeroempleado = ' . $this->getRnumeroempleado() . ' OR rnumerolicencia = ' . $this->getRnumerolicencia() . ') AND idempresa = ' . $this->getObjEmpresa()->getIdempresa();

        $consultaVerificacionPersona = 'SELECT * FROM persona WHERE documento = ' . $this->getDoc();

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaVerificacionResponsable) && $base->Registro()) {
                $resp = true;
            }
            if ($base->Ejecutar($consultaVerificacionPersona) && $base->Registro()) {
                $resp = true;
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }

        return $resp;
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        if (!$this->verificacionNoRepetir()) {
            if (parent::insertar()) {
                $consultaInsertar = 'INSERT INTO responsable (rdocumento, rnumeroempleado, idempresa, rnumerolicencia) VALUES (' . $this->getDoc() . ', ' . $this->getRnumeroempleado() . ', ' . $this->getObjEmpresa()->getIdempresa() . ', ' . $this->getRnumerolicencia() . ')';
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
        $consultaModifica = "UPDATE responsable 
                             SET rnumeroempleado='" . $this->getRnumeroempleado() . "', 
                                 rnumerolicencia='" . $this->getRnumerolicencia() . "' 
                             WHERE rdocumento='" . $this->getDoc() . "'";
        if ($base->Iniciar()) {
            if (parent::modificar()) {
                if ($base->Ejecutar($consultaModifica)) {
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

    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consultaBorra = 'DELETE FROM responsable WHERE rdocumento=' . $this->getDoc();
            if (parent::eliminar()) {
                if ($base->Ejecutar($consultaBorra)) {
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
        $msj .= 'Número de Empleado: ' . $this->getRnumeroempleado() . "\n";
        $msj .= 'Numero de Licencia: ' . $this->getRnumerolicencia() . "\n";
        $msj .= 'Empresa: ' . $this->getObjEmpresa();

        return $msj;
    }
}
