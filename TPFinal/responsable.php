<?php

class Responsable extends Persona
{
    private $rnumeroempleado;
    private $rnumerolicencia;

    public function __construct()
    {
        parent::__construct();
        $this->rnumeroempleado = "";
        $this->rnumerolicencia = "";
      
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

   

    public function __toString()
    {
        $msj = parent::__toString();
        $msj .= "\nNúmero de Empleado: " . $this->getRnumeroempleado() . "\n";
        $msj .= "Numero de Licencia: " . $this->getRnumerolicencia() . "\n";

        return $msj;
    }
}
