<?php
require_once 'Libro.php';

class Biblioteca {
    private $libros = [];
    private $archivo = 'libros.json';

    public function __construct() {
        $this->cargarLibrosDesdeJSON();
    }

    // Cargar libros desde el archivo JSON
    private function cargarLibrosDesdeJSON() {
        if (file_exists($this->archivo)) {
            $datos = file_get_contents($this->archivo);
            $librosArray = json_decode($datos, true);

            if ($librosArray) {
                foreach ($librosArray as $libroData) {
                    $autor = new Autor($libroData['autor']['id'], $libroData['autor']['nombre']);
                    $categoria = new Categoria($libroData['categoria']['id'], $libroData['categoria']['nombre']);
                    $libro = new Libro($libroData['id'], $libroData['titulo'], $autor, $categoria);

                    if (!$libroData['disponible']) {
                        $libro->prestar(); // Marcar como no disponible si aplica
                    }

                    $this->libros[$libro->getId()] = $libro;
                }
            }
        }
    }

    // Guardar libros en el archivo JSON
    private function guardarLibrosEnJSON() {
        $librosArray = [];
        foreach ($this->libros as $libro) {
            $librosArray[] = [
                'id' => $libro->getId(),
                'titulo' => $libro->getTitulo(),
                'autor' => [
                    'id' => $libro->getAutor()->getId(),
                    'nombre' => $libro->getAutor()->getNombre(),
                ],
                'categoria' => [
                    'id' => $libro->getCategoria()->getId(),
                    'nombre' => $libro->getCategoria()->getNombre(),
                ],
                'disponible' => $libro->isDisponible(),
            ];
        }

        file_put_contents($this->archivo, json_encode($librosArray, JSON_PRETTY_PRINT));
    }

    public function agregarLibro(Libro $libro) {
        $this->libros[$libro->getId()] = $libro;
        $this->guardarLibrosEnJSON();
        //echo "Libro '{$libro->getTitulo()}' agregado y guardado en JSON.\n";
    }

    public function eliminarLibro($id) {
        if (isset($this->libros[$id])) {
            unset($this->libros[$id]);
            $this->guardarLibrosEnJSON();
            echo "Libro con ID {$id} eliminado y JSON actualizado.\n";
            return true;
        }
        echo "Libro con ID {$id} no encontrado.\n";
        return false;
    }

    // Modificar detalles de un libro
    public function editarLibro($id, $nuevoTitulo, Autor $nuevoAutor, Categoria $nuevaCategoria) {
        if (isset($this->libros[$id])) {
            $libro = $this->libros[$id];
            $libro->setTitulo($nuevoTitulo);
            $libro->setAutor($nuevoAutor);
            $libro->setCategoria($nuevaCategoria);
            $this->guardarLibrosEnJSON();
            echo "Libro con ID {$id} modificado y guardado en JSON.\n";
        } else {
            echo "Libro con ID {$id} no encontrado para editar.\n";
        }
    }

    // Mostrar libros disponibles
    public function mostrarLibrosDisponibles() {
        if (empty($this->libros)) {
            echo "No hay libros disponibles.<br>";
        } else {
            foreach ($this->libros as $libro) {
                echo "ID: {$libro->getId()} - Título: {$libro->getTitulo()} - Autor: {$libro->getAutor()->getNombre()} - Categoría: {$libro->getCategoria()->getNombre()} - " . ($libro->isDisponible() ? "Disponible" : "Prestado") . "<br>";
            }
        }
    }
    
}
?>
