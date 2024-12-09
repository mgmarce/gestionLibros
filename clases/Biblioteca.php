<?php
include_once('clases\IGestorLibro.php');
include_once('clases\IGestorUsuario.php');

class Biblioteca implements IGestorLibro, IGestorUsuario {
    private $libros = [];
    private $usuarios = [];
    private $prestamos = [];

    public function agregarLibro($libro) {
        $this->libros[] = $libro;
    }

    public function buscarLibro($titulo) {
        foreach ($this->libros as $libro) {
            if ($libro->getTitulo() === $titulo) {
                return $libro;
            }
        }
        return null;
    }

    public function eliminarLibro($id) {
        foreach ($this->libros as $key => $libro) {
            if ($libro->getId() === $id) {
                unset($this->libros[$key]);
                return true;
            }
        }
        return false;
    }

    public function registrarUsuario($usuario) {
        $this->usuarios[] = $usuario;
    }

    public function buscarUsuario($id) {
        foreach ($this->usuarios as $usuario) {
            if ($usuario->getId() === $id) {
                return $usuario;
            }
        }
        return null;
    }

    public function prestarLibro($idLibro, $idUsuario, $fechaDevolucion) {
        $libro = $this->buscarLibroPorId($idLibro);
        $usuario = $this->buscarUsuario($idUsuario);

        if ($libro && $libro->estaDisponible() && $usuario) {
            $libro->setDisponible(false);
            $prestamo = new Prestamo($idLibro, $idUsuario, $fechaDevolucion);
            $this->prestamos[] = $prestamo;
            echo "Libro prestado correctamente.";
        } else {
            echo "No se pudo realizar el préstamo.";
        }
    }

    private function buscarLibroPorId($id) {
        foreach ($this->libros as $libro) {
            if ($libro->getId() === $id) {
                return $libro;
            }
        }
        return null;
    }
}
