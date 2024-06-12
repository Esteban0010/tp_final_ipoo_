<?php

class Responsable
{
    private $rnumeroempleado;
    private $rnumerolicencia;
    private $rnombre;
    private $rapellido;

    public function __construct($rnumeroempleado, $rnumerolicencia, $rnombre, $rapellido)
    {
        $this->rnumeroempleado = $rnumeroempleado;
        $this->rnumerolicencia = $rnumerolicencia;
        $this->rnombre = $rnombre;
        $this->rapellido = $rapellido;
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

    public function getRnombre()
    {
        return $this->rnombre;
    }

    public function setRnombre($value)
    {
        $this->rnombre = $value;
    }

    public function getRapellido()
    {
        return $this->rapellido;
    }

    public function setRapellido($value)
    {
        $this->rapellido = $value;
    }
}
