<?php
abstract class Usuario {
    protected $id;
    protected $nombre;

    public function __construct($id, $nombre) {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    public function getId() {
        return $this->id; 
    }

    public function getNombre() {
        return $this->nombre;
    }

    abstract public function getRol();
}
?>
