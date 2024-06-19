<?php

class ResponsableV extends Persona
{
    private $rnumeroempleado;
    private $idempresa;
    private $rnumerolicencia;

    public function __construct()
    {
        parent::__construct();
        $this->rnumeroempleado = '';
        $this->rnumerolicencia = '';
        $this->idempresa = '';
    }

    public function cargar($doc, $nombre, $apellido, $rnumeroempleado = null, $rnumerolicencia = null, $idempresa = null)
    {
        parent::cargar($doc, $nombre, $apellido);
        $this->setRnumeroempleado($rnumeroempleado);
        $this->setRnumerolicencia($rnumerolicencia);
        $this->setIdempresa($idempresa);
    }

    public function getIdempresa()
    {
        return $this->idempresa;
    }

    public function setIdempresa($idempresa)
    {
        $this->idempresa = $idempresa;
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
        $consultaPersona = 'SELECT * FROM responsable WHERE rdocumento='.$dni;
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

    public function listarSinAsignacion($idEmpresa)
    {
        $base = new BaseDatos();
        $consulta = '
    SELECT r.rdocumento, p.nombre, p.apellido, r.rnumeroempleado, r.rnumerolicencia
    FROM responsable r
    INNER JOIN persona p ON r.rdocumento = p.documento
    LEFT JOIN viaje v ON r.rdocumento = v.rdocumento
    WHERE v.rdocumento IS NULL AND r.idempresa IN (SELECT idempresa FROM empresa AS e WHERE e.idempresa = '.$idEmpresa.')';
        $resp = [];
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                while ($row2 = $base->Registro()) {
                    $responsable = new ResponsableV();
                    $responsable->cargar(
                        $row2['rdocumento'],
                        $row2['nombre'],
                        $row2['apellido'],
                        $row2['rnumeroempleado'],
                        $row2['rnumerolicencia']
                    );
                    $resp[] = $responsable;
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }

        return $resp;
    }

    public function verificacionNoRepetir()
    {
        $base = new BaseDatos();
        $resp = false;
        $consultaVerificacion = 'SELECT * FROM responsable WHERE (rnumeroempleado = '.$this->getRnumeroempleado().' OR rnumerolicencia = '.$this->getRnumerolicencia().') ';

        if ($base->Iniciar() && $base->Ejecutar($consultaVerificacion)) {
            if ($base->Registro()) {
                $resp = true;
            }
        } else {
            $this->setmensajeoperacion($base->getError())."\n";
        }

        return $resp;
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($this->verificarDatos() && !$this->verificacionNoRepetir()) {
            if (parent::insertar()) {
                $consultaInsertar = 'INSERT INTO responsable (rdocumento, rnumeroempleado, idempresa, rnumerolicencia) VALUES ('.$this->getDoc().', '.$this->getRnumeroempleado().', '.$this->getIdempresa().', '.$this->getRnumerolicencia().')';
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
                             SET rnumeroempleado='".$this->getRnumeroempleado()."', 
                                 rnumerolicencia='".$this->getRnumerolicencia()."' 
                             WHERE rdocumento='".$this->getDoc()."'";
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
            $consultaBorra = 'DELETE FROM responsable WHERE rdocumento='.$this->getDoc();
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

    public function verificarDatos()
    {
        $resp = false;
        $numEmpl = $this->getRnumeroempleado();
        $numLic = $this->getRnumerolicencia();
        $idemp = $this->getIdempresa();
        if ($numEmpl != null && !is_numeric($numEmpl) || $numLic != null && is_numeric($numLic) || $idemp != null && is_numeric($idemp)) {
            $resp = true;
        }

        return $resp;
    }

    public function __toString()
    {
        $msj = parent::__toString();
        $msj .= "\nNúmero de Empleado: ".$this->getRnumeroempleado()."\n";
        $msj .= 'Numero de Licencia: '.$this->getRnumerolicencia()."\n";

        return $msj;
    }
}
