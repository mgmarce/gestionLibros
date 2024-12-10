<?php
interface CRUD {
    public function agregar($item);
    public function editar($id, $item);
    public function eliminar($id);
    public function listar();
}
?>
