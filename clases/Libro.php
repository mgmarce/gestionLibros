<?php

class Libro {
    private $id;
    private $titulo;
    private $autor;
    private $categoria;
    private $disponible;

    public function __construct($id, $titulo, Autor $autor, Categoria $categoria) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->categoria = $categoria;
        $this->disponible = true;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getAutor() {
        return $this->autor;
    }

    public function setAutor(Autor $autor) {
        $this->autor = $autor;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function setCategoria(Categoria $categoria) {
        $this->categoria = $categoria;
    }

    public function getId() {
        return $this->id;
    }

    public function isDisponible() {
        return $this->disponible;
    }

    public function prestar() {
        $this->disponible = false;
    }

    public function devolver() {
        $this->disponible = true;
    }
}
?>
