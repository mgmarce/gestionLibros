<?php
abstract class Usuario {
    protected $id;
    protected $nombre;

    public function __construct($id, $nombre) {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    abstract public function getRol();
}
?>
