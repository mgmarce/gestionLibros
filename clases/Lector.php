<?php
require_once 'Usuario.php';

class Lector extends Usuario {

    public function __construct($id, $nombre) {
        parent::__construct($id, $nombre);
    }

    public function getRol() { return "Lector"; }

    // Método para solicitar un préstamo de un libro en la biblioteca
    public function solicitarPrestamo(Biblioteca $biblioteca, Libro $libro) {
        $biblioteca->prestarLibro($libro, $this);
    }

    
}
?>
