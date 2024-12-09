<?php
require_once 'Libro.php';

class Biblioteca {
    private $libros = [];
    private $prestamos = [];
    private $archivoLibros = 'libros.json';
    private $archivoPrestamos = 'prestamos.json';

    public function __construct() {
        $this->cargarLibrosDesdeJSON();
        $this->cargarPrestamosDesdeJSON();
    }

    private function cargarLibrosDesdeJSON() {
        if (file_exists($this->archivoLibros)) {
            $datos = file_get_contents($this->archivoLibros);
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

        file_put_contents($this->archivoLibros, json_encode($librosArray, JSON_PRETTY_PRINT));
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
        $libro = $this->obtenerLibroPorId($id);
        if ($libro !== null) {
            // Si el libro existe, actualizamos sus datos
            $libro->setTitulo($nuevoTitulo);
            $libro->setAutor($nuevoAutor);
            $libro->setCategoria($nuevaCategoria);
            $this->guardarLibrosEnJSON();
            echo "Libro con ID {$id} ha sido editado.<br>";
        } else {
            echo "Libro con ID {$id} no encontrado para editar.<br>";
        }
    }

    public function obtenerLibroPorId($id) {
        foreach ($this->libros as $libro) {
            if ($libro->getId() == $id) {
                return $libro;
            }
        }
        return null;
    }


    ///////////////////////////////////////////////////////////////////////

    // Mostrar libros disponibles
    public function mostrarLibros() {
        if (empty($this->libros)) {
            echo "No hay libros.<br>";
        } else {
            foreach ($this->libros as $libro) {
                echo "ID: {$libro->getId()} - Título: {$libro->getTitulo()} - Autor: {$libro->getAutor()->getNombre()} - Categoría: {$libro->getCategoria()->getNombre()} - " . ($libro->isDisponible() ? "Disponible" : "Prestado") . "<br>";
            }
        }
    }

    // Cargar préstamos desde el archivo JSON
    private function cargarPrestamosDesdeJSON() {
        if (file_exists($this->archivoPrestamos)) {
            $datos = file_get_contents($this->archivoPrestamos);
            $prestamosArray = json_decode($datos, true);

            if ($prestamosArray) {
                foreach ($prestamosArray as $prestamoData) {
                    $libro = $this->libros[$prestamoData['libroId']];
                    $lector = new Lector($prestamoData['lectorId'], $prestamoData['lectorNombre']);
                    $prestamo = new Prestamo($libro, $lector);
                    $prestamo->setFechaPrestamo($prestamoData['fechaPrestamo']);
                    $prestamo->setFechaDevolucion($prestamoData['fechaDevolucion']);
                    $this->prestamos[] = $prestamo;
                }
            }
        }
    }

    // Guardar préstamos en el archivo JSON
    private function guardarPrestamosEnJSON() {
        $prestamosArray = [];
        foreach ($this->prestamos as $prestamo) {
            $prestamosArray[] = [
                'libroId' => $prestamo->getLibro()->getId(),
                'lectorId' => $prestamo->getLector()->getId(),
                'lectorNombre' => $prestamo->getLector()->getNombre(),
                'fechaPrestamo' => $prestamo->getFechaPrestamo(),
                'fechaDevolucion' => $prestamo->getFechaDevolucion(),
            ];
        }

        file_put_contents($this->archivoPrestamos, json_encode($prestamosArray, JSON_PRETTY_PRINT));
    }

    // Prestar libro a un lector
    public function prestarLibro(Libro $libro, Lector $lector) {
        if ($libro->isDisponible()) {
            $libro->prestar();  // Marcar libro como prestado
            $prestamo = new Prestamo($libro, $lector);
            $this->prestamos[] = $prestamo;  // Registrar el préstamo
            $this->guardarLibrosEnJSON();  // Guardar el estado actualizado de los libros
            $this->guardarPrestamosEnJSON(); // Guardar los préstamos actualizados
            echo "Libro '{$libro->getTitulo()}' prestado a {$lector->getNombre()}.\n";
        } else {
            echo "El libro '{$libro->getTitulo()}' no está disponible para préstamo.\n";
        }
    }

    // Mostrar todos los préstamos
    public function mostrarPrestamos() {
        if (empty($this->prestamos)) {
            echo "No hay préstamos registrados.\n";
        } else {
            foreach ($this->prestamos as $prestamo) {
                $detalles = $prestamo->getDetallesPrestamo();
                echo "Libro: {$detalles['libro']} | Lector: {$detalles['lector']} | Fecha de Préstamo: {$detalles['fechaPrestamo']} | Fecha de Devolución: {$detalles['fechaDevolucion']}\n";
            }
        }
    }

    public function buscarLibroPorAutor($autorNombre) {
        $resultados = [];
        foreach ($this->libros as $libro) {
            if (strpos(strtolower($libro->getAutor()->getNombre()), strtolower($autorNombre)) !== false) {
                $resultados[] = $libro;
            }
        }
        return $resultados;
    }

    public function buscarLibroPorCategoria($categoriaNombre) {
        $resultados = [];
        foreach ($this->libros as $libro) {
            if (strpos(strtolower($libro->getCategoria()->getNombre()), strtolower($categoriaNombre)) !== false) {
                $resultados[] = $libro;
            }
        }
        return $resultados;
    }

    public function buscarLibroPorTitulo($titulo) {
        $resultados = [];
        foreach ($this->libros as $libro) {
            if (strpos(strtolower($libro->getTitulo()), strtolower($titulo)) !== false) {
                $resultados[] = $libro;
            }
        }
        return $resultados;
    }

    public function librosPrestadosPorLector(Lector $lector) {
        $librosPrestados = [];
        foreach ($this->prestamos as $prestamo) {
            if ($prestamo->getLector()->getId() == $lector->getId()) {
                $librosPrestados[] = [
                    'titulo' => $prestamo->getLibro()->getTitulo(),
                    'fechaPrestamo' => $prestamo->getFechaPrestamo(),
                    'fechaDevolucion' => $prestamo->getFechaDevolucion() ? $prestamo->getFechaDevolucion() : 'No devuelto aún'
                ];
            }
        }
        return $librosPrestados;
    }
    
}
?>
