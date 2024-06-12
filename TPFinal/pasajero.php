<?php

class Pasajero
{
    private $pdocumento;
    private $pnombre;
    private $papellido;
    private $ptelefono;
    private $idviaje;

    public function __constructor($pdocumento, $pnombre, $papellido, $ptelefono, $idviaje)
    {
        $this->pdocumento = $pdocumento;
        $this->pnombre = $pnombre;
        $this->papellido = $papellido;
        $this->ptelefono = $ptelefono;
        $this->idviaje = $idviaje;
    }

    public function getPdocumento()
    {
        return $this->pdocumento;
    }

    public function setPdocumento($value)
    {
        $this->pdocumento = $value;
    }

    public function getPnombre()
    {
        return $this->pnombre;
    }

    public function setPnombre($value)
    {
        $this->pnombre = $value;
    }

    public function getPapellido()
    {
        return $this->papellido;
    }

    public function setPapellido($value)
    {
        $this->papellido = $value;
    }

    public function getPtelefono()
    {
        return $this->ptelefono;
    }

    public function setPtelefono($value)
    {
        $this->ptelefono = $value;
    }

    public function getIdviaje()
    {
        return $this->idviaje;
    }

    public function setIdviaje($value)
    {
        $this->idviaje = $value;
    }
}
