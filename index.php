<?php
require_once 'clases/Libro.php';
require_once 'clases/Autor.php';
require_once 'clases/Categoria.php';
require_once 'clases/Biblioteca.php';
require_once 'clases/Administrador.php';
require_once 'clases/Lector.php';
require_once 'clases/Prestamo.php';

//Crear biblioteca (carga desde JSON si existe)
$biblioteca = new Biblioteca();

// INGRESANDO AL SISTEMA COMO ADMINISTRADOR
$admin = new Administrador(1, "Admin1", $biblioteca);

//***********************************USOS ADMINISTRADOR***********************************//
/* // INGRESANDO datos de autores y categorías
$autor1 = new Autor(1, "Edgar Allan Poe");
$autor2 = new Autor(2, "Stephenie Meyer");
$categoria1 = new Categoria(1, "Romance");
$categoria2 = new Categoria(2, "Terror");

// INGRESANDO datos de libros
$libro1 = new Libro(1, "El cuervo", $autor1, $categoria2);
$libro2 = new Libro(2, "Crepusculo", $autor2, $categoria1);

// AGREGANDO libros con permiso de usuario a la base de datos (ARCHIVO JSON)
$admin->agregar($libro1);
$admin->agregar($libro2); 

// LISTANDO libros disponibles
echo "Libros disponibles:<br>";
$biblioteca->mostrarLibros();

// ELIMINANDO libro con permiso de usuario a la base de datos (ARCHIVO JSON)
$admin->eliminar(2);

// INGRESANDO datos que se van a editar por medio del ID del libro seleccionado
$autor3 = new Autor(3, "Makoto Shinkai");
$categoria3 = new Categoria(3, "Fantasía");
$libro3 = new Libro(1, "Weathering with You", $autor3, $categoria3);

// EDITANDO libro con permiso de usuario a la base de datos (ARCHIVO JSON)
$admin->editar(1, $libro3);*/



/* 
//USOS ADMINISTRADOR

echo "Libros disponibles:<br>";
$biblioteca->mostrarLibrosDisponibles();

echo "<br>Editando libro con ID 1...<br>";
$biblioteca->editarLibro(1, "La mascara de la muerte roja", new Autor(1, "Edgard Allan Poe"), new Categoria(1, "Misterio"));

echo "Eliminando libro con ID 2...<br>";
$biblioteca->eliminarLibro(2);

$autor1 = new Autor(1, "Gabriel García Márquez");
$categoria1 = new Categoria(1, "Novela");

$libro1 = new Libro(1, "Cien años de soledad", $autor1, $categoria1);

// Crear instancias de lectores (que son usuarios)
$lector1 = new Lector(1, "Juan Pérez");
$lector2 = new Lector(2, "Marcela");

// Crear la biblioteca y agregar el libro
$biblioteca->agregarLibro($libro1);

// Lector 1 solicita un préstamo
$lector1->solicitarPrestamo($biblioteca, $libro1);  // Debería marcar el libro como prestado

// Mostrar todos los préstamos registrados
//$biblioteca->mostrarPrestamos();
$lector2->solicitarPrestamo($biblioteca, $libro1); 

//BUSCAR PORR AUTOR
$librosPorAutor = $biblioteca->buscarLibroPorAutor("Gabriel García Márquez");
echo "\nLibros por Gabriel García Márquez:<br>";
foreach ($librosPorAutor as $libro) {
    echo " - {$libro->getTitulo()}<br>";
}


$librosPorTitulo = $biblioteca->buscarLibroPorTitulo("Cien años");
echo "\nLibros con título 'Cien años':\n";
foreach ($librosPorTitulo as $libro) {
    echo " - {$libro->getTitulo()}\n";
}

$lector1 = new Lector(1, "Juan Pérez");

$prestamos = $biblioteca->librosPrestadosPorLector($lector1);
foreach ($prestamos as $prestamo) {
    echo "Libro: {$prestamo['titulo']}, Fecha de préstamo: {$prestamo['fechaPrestamo']}, Fecha de devolución: {$prestamo['fechaDevolucion']}<br>";
}*/


?>
