<?php

class Pasajero extends Persona
{
   
    private $ptelefono;
    private $idviaje;

    public function __constructor()
    {
        parent::__construct();
        $this->ptelefono = "";
        $this->idviaje = "";
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

    public function __toString()
    {
        $msj = "\n»»»»««««\n";
        $msj .= parent::__toString();
        $msj .= "Telefono: " . $this->getPtelefono() . "\n";
        $msj .= "id Viaje: " . $this->getIdviaje() . "\n";
        return $msj;
    }



}
