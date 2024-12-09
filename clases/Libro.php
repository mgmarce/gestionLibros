<?php
include_once('clases\EntidadBase.php');

class Libro extends EntidadBase {
    private $titulo;
    private $autor;
    private $categoria;
    private $disponible;

    public function __construct($id, $titulo, $autor, $categoria) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->categoria = $categoria;
        $this->disponible = true;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setDisponible($estado) {
        $this->disponible = $estado;
    }

    public function estaDisponible() {
        return $this->disponible;
    }
}
