<?php

interface IGestorLibro {
    public function agregarLibro($libro);
    public function buscarLibro($titulo);
    public function eliminarLibro($id);
}

