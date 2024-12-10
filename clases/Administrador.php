<?php
require_once 'Usuario.php';
require_once 'CRUD.php';

class Administrador extends Usuario implements CRUD {
    private $biblioteca;

    public function __construct($id, $nombre, Biblioteca $biblioteca) {
        parent::__construct($id, $nombre);
        $this->biblioteca = $biblioteca;
    }

    public function getRol() { return "Administrador"; }

    public function agregar($item) {
        if ($item instanceof Libro) {
            $this->biblioteca->agregarLibro($item);
            echo "Libro '{$item->getTitulo()}' agregado.<br>";
        }
    }

    public function eliminar($id) { $this->biblioteca->eliminarLibro($id); }

    public function editar($id, $item) {  
        if ($item instanceof Libro) {
            $this->biblioteca->editarLibro($id, $item->getTitulo(), $item->getAutor(), $item->getCategoria());
        } else {
            echo "El item no es un libro válido para editar.<br>";
        }
    }

    public function listar() {  
        //LISTA TODOS LOS PRESTAMOS REALIZADOS POR TODOS LOS LECTORES
        $this->biblioteca->mostrarPrestamos();
    }

    

}
?>
