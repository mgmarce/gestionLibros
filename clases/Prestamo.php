<?php

class Prestamo {
    private $libro;
    private $lector;
    private $fechaPrestamo;
    private $fechaDevolucion;

    public function __construct(Libro $libro, Lector $lector) {
        $this->libro = $libro;
        $this->lector = $lector;

        $fecha = new DateTime("now", new DateTimeZone("America/El_Salvador"));
        $this->fechaPrestamo = $fecha->format('Y-m-d H:i:s');

        $fecha->modify('+7 days');
        $this->fechaDevolucion = $fecha->format('Y-m-d H:i:s');
    }

    public function getLibro() {
        return $this->libro;
    }

    public function getLector() {
        return $this->lector;
    }

    public function getFechaPrestamo() {
        return $this->fechaPrestamo;
    }

    public function getFechaDevolucion() {
        return $this->fechaDevolucion;
    }

    public function setFechaPrestamo($fecha) {
        $this->fechaPrestamo = $fecha;
    }

    public function setFechaDevolucion($fecha) {
        $this->fechaDevolucion = $fecha;
    }

    public function getDetallesPrestamo() {
        return [
            'libro' => $this->libro->getTitulo(),
            'lector' => $this->lector->getNombre(),
            'fechaPrestamo' => $this->fechaPrestamo,
            'fechaDevolucion' => $this->fechaDevolucion,
        ];
    }
}
?>
