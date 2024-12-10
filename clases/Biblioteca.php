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
                        $libro->prestar(); // Marcar como prestado
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
        //echo "Libro '{$libro->getTitulo()}' agregado y guardado en JSON.";
    }

    public function eliminarLibro($id) {
        if (isset($this->libros[$id])) {
            unset($this->libros[$id]);
            $this->guardarLibrosEnJSON();
            echo "Libro con ID {$id} eliminado y JSON actualizado.<br>";
            return true;
        }
        echo "Libro con ID {$id} no encontrado.<br>";
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

    private function obtenerLibroPorId($id) {
        foreach ($this->libros as $libro) {
            if ($libro->getId() == $id) {
                return $libro;
            }
        }
        return null;
    }

    // Mostrar libros disponibles
    public function mostrarLibros() {
        if (empty($this->libros)) {
            echo "<strong>No hay libros.</strong><br>";
        } else {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Título</th><th>Autor</th><th>Categoría</th><th>Disponibilidad</th></tr>";
            foreach ($this->libros as $libro) {
                echo "<tr>";
                echo "<td>{$libro->getId()}</td>";
                echo "<td>{$libro->getTitulo()}</td>";
                echo "<td>{$libro->getAutor()->getNombre()}</td>";
                echo "<td>{$libro->getCategoria()->getNombre()}</td>";
                echo "<td>" . ($libro->isDisponible() ? "Disponible" : "Prestado") . "</td>";
                echo "</tr>";
            }
            echo "</table>";
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

    public function prestarLibro(Libro $libro, Lector $lector) {
    
        if (!$this->verificarDisponibilidad($libro->getId())) {
            echo "El libro '{$libro->getTitulo()}' ya está prestado.<br>";
            return false;
        }

        $libro->prestar();
        $prestamo = new Prestamo($libro, $lector);
        $this->prestamos[] = $prestamo;
    
        $this->libros[$libro->getId()] = $libro;
        $this->guardarLibrosEnJSON();
        $this->guardarPrestamosEnJSON();
    
        echo "Libro '{$libro->getTitulo()}' prestado correctamente.<br>";
        return true;
    
    }

    private function verificarDisponibilidad($idLibro) {
        if (isset($this->libros[$idLibro])) {
            return $this->libros[$idLibro]->isDisponible();
        }
        echo "El libro con ID {$idLibro} no existe en la biblioteca.<br>";
        return false;
    }
    
    // Mostrar todos los préstamos
    public function mostrarPrestamos() {
        $prestamos = json_decode(file_get_contents($this->archivoPrestamos), true);
        if (empty($prestamos)) {
            echo "<strong>No hay préstamos registrados.</strong><br>";
        } else {
            echo "<table border='1'>";
            echo "<tr><th>ID Libro</th><th>Lector</th><th>Fecha de Préstamo</th><th>Fecha de Devolución</th></tr>";
            foreach ($prestamos as $prestamo) {
                echo "<tr>";
                echo "<td>{$prestamo['libroId']}</td>";
                echo "<td>{$prestamo['lectorNombre']}</td>";
                echo "<td>{$prestamo['fechaPrestamo']}</td>";
                echo "<td>{$prestamo['fechaDevolucion']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    

    public function buscarLibroPorAutor($autorNombre) {
        $resultados = [];
        foreach ($this->libros as $libro) {
            if (strpos(strtolower($libro->getAutor()->getNombre()), strtolower($autorNombre)) !== false) {
                $resultados[] = $libro;
            }
        }
    
        if (empty($resultados)) {
            echo "<strong>No se encontraron libros de autor '{$autorNombre}'.</strong><br>";
        } else {
            echo "<strong><br>Libros por el autor: ".$autorNombre."</strong>";
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Título</th><th>Autor</th><th>Categoría</th><th>Disponibilidad</th></tr>";
            foreach ($resultados as $libro) {
                echo "<tr>";
                echo "<td>{$libro->getId()}</td>";
                echo "<td>{$libro->getTitulo()}</td>";
                echo "<td>{$libro->getAutor()->getNombre()}</td>";
                echo "<td>{$libro->getCategoria()->getNombre()}</td>";
                echo "<td>" . ($libro->isDisponible() ? "Disponible" : "Prestado") . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    

    public function buscarLibroPorCategoria($categoriaNombre) {
        $resultados = [];
        foreach ($this->libros as $libro) {
            if (strpos(strtolower($libro->getCategoria()->getNombre()), strtolower($categoriaNombre)) !== false) {
                $resultados[] = $libro;
            }
        }
    
        if (empty($resultados)) {
            echo "<strong>No se encontraron libros de autor '{$categoriaNombre}'.</strong><br>";
        } else {
            echo "<strong><br>Libros de la categoria: ".$categoriaNombre."</strong>";
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Título</th><th>Autor</th><th>Categoría</th><th>Disponibilidad</th></tr>";
            foreach ($resultados as $libro) {
                echo "<tr>";
                echo "<td>{$libro->getId()}</td>";
                echo "<td>{$libro->getTitulo()}</td>";
                echo "<td>{$libro->getAutor()->getNombre()}</td>";
                echo "<td>{$libro->getCategoria()->getNombre()}</td>";
                echo "<td>" . ($libro->isDisponible() ? "Disponible" : "Prestado") . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

    public function buscarLibroPorTitulo($titulo) {
        $resultados = [];
        foreach ($this->libros as $libro) {
            if (strpos(strtolower($libro->getTitulo()), strtolower($titulo)) !== false) {
                $resultados[] = $libro;
            }
        }
    
        if (empty($resultados)) {
            echo "<strong>No se encontraron libros de autor '{$titulo}'.</strong><br>";
        } else {
            echo "<strong><br>Libros por el titulo: ".$titulo."</strong>";
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Título</th><th>Autor</th><th>Categoría</th><th>Disponibilidad</th></tr>";
            foreach ($resultados as $libro) {
                echo "<tr>";
                echo "<td>{$libro->getId()}</td>";
                echo "<td>{$libro->getTitulo()}</td>";
                echo "<td>{$libro->getAutor()->getNombre()}</td>";
                echo "<td>{$libro->getCategoria()->getNombre()}</td>";
                echo "<td>" . ($libro->isDisponible() ? "Disponible" : "Prestado") . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }

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

    public function librosPrestadosPorLector(Lector $lector) {
        // Cargar los préstamos desde el archivo JSON
        $prestamos = json_decode(file_get_contents($this->archivoPrestamos), true);
        $librosPrestados = [];
        if (!empty($prestamos)) {
            foreach ($prestamos as $prestamoData) {
                $libro = $this->obtenerLibroPorId($prestamoData['libroId']);
                if ($prestamoData['lectorId'] == $lector->getId()) {
                    // Crear un arreglo con los datos del préstamo
                    $librosPrestados[] = [
                        'titulo' => $libro->getTitulo(),
                        'fechaPrestamo' => $prestamoData['fechaPrestamo'],
                        'fechaDevolucion' => isset($prestamoData['fechaDevolucion']) ? $prestamoData['fechaDevolucion'] : 'No devuelto aún'
                    ];
                }
            }
        }
    
        // Si no se encontraron libros prestados
        if (empty($librosPrestados)) {
            echo "No hay libros prestados por el lector '{$lector->getNombre()}'.<br>";
        } else {
            // Mostrar en formato tabla
            echo "<strong><br>Libros prestados por el lector '{$lector->getNombre()}'.</strong><br>";
            echo "<table border='1'>";
            echo "<tr><th>Título</th><th>Fecha de Préstamo</th><th>Fecha de Devolución</th></tr>";
            foreach ($librosPrestados as $libro) {
                echo "<tr>";
                echo "<td>{$libro['titulo']}</td>";
                echo "<td>{$libro['fechaPrestamo']}</td>";
                echo "<td>{$libro['fechaDevolucion']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    
        return $librosPrestados;
    }
    
    
    
    
}
?>
