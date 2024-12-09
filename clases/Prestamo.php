<?php
class Prestamo {
    private $id;
    private $libro;
    private $lector;
    private $fechaPrestamo;
    private $fechaDevolucion;

    public function __construct($id, Libro $libro, Lector $lector, $fechaPrestamo) {
        $this->id = $id;
        $this->libro = $libro;
        $this->lector = $lector;
        $this->fechaPrestamo = $fechaPrestamo;
        $this->fechaDevolucion = null; // No hay fecha de devolución al inicio
    }

    public function getId() { return $this->id; }
    public function getLibro() { return $this->libro; }
    public function getLector() { return $this->lector; }
    public function getFechaPrestamo() { return $this->fechaPrestamo; }
    public function getFechaDevolucion() { return $this->fechaDevolucion; }
    
    public function registrarDevolucion($fechaDevolucion) {
        $this->fechaDevolucion = $fechaDevolucion;
    }
}
?>

