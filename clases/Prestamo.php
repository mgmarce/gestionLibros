<?php

class Prestamo {
    private $idLibro;
    private $idUsuario;
    private $fechaPrestamo;
    private $fechaDevolucion;

    public function __construct($idLibro, $idUsuario, $fechaDevolucion) {
        $this->idLibro = $idLibro;
        $this->idUsuario = $idUsuario;
        $this->fechaPrestamo = date("Y-m-d");
        $this->fechaDevolucion = $fechaDevolucion;
    }
}
