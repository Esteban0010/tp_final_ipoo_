<?php


class Empresa
{
    private $idempresa;
    private $enombre;
    private $edireccion;

    public function __construct()
    {
        $this->idempresa = "";
        $this->enombre = "";
        $this->edireccion = "";
    }

    /**
     * Get the value of idempresa
     */
    public function getIdempresa()
    {
        return $this->idempresa;
    }

    /**
     * Set the value of idempresa
     *
     * @return  self
     */
    public function setIdempresa($idempresa)
    {
        $this->idempresa = $idempresa;
    }

    /**
     * Get the value of enombre
     */
    public function getEnombre()
    {
        return $this->enombre;
    }

    /**
     * Set the value of enombre
     *
     * @return  self
     */
    public function setEnombre($enombre)
    {
        $this->enombre = $enombre;
    }

    /**
     * Get the value of edireccion
     */
    public function getEdireccion()
    {
        return $this->edireccion;
    }

    /**
     * Set the value of edireccion
     *
     * @return  self
     */
    public function setEdireccion($edireccion)
    {
        $this->edireccion = $edireccion;
    }


    public function __toString()
    {
        $msj = "ID Empresa: " . $this->getIdempresa() . "\n";
        $msj .= "Nombre Empresa: " . $this->getEnombre() . "\n";
        $msj .= "Dirección Empresa: " . $this->getEdireccion() . "\n";
        return  $msj;
    }
}
