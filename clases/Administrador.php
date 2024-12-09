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

    public function editar($id, $item) { /* Lógica de edición */ }
    public function eliminar($id) { $this->biblioteca->eliminarLibro($id); }
    public function buscar($criterio) { /* Lógica de búsqueda */ }
}
?>
