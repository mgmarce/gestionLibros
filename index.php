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


// Crear autores y categorías
$autor1 = new Autor(1, "Edgar Allan Poe");
$categoria1 = new Categoria(1, "Terror");
$categoria2 = new Categoria(2, "Misterio");
// Crear libros
$libro1 = new Libro(1, "El cuervo", $autor1, $categoria1);
$libro2 = new Libro(2, "El gato negro", $autor1, $categoria2);

// Administrador agrega libros
$admin = new Administrador(1, "Admin1", $biblioteca);
$admin->agregar($libro1);
$admin->agregar($libro2); 

echo "Libros disponibles:<br>";
$biblioteca->mostrarLibrosDisponibles();

echo "<br>Editando libro con ID 1...<br>";
$biblioteca->editarLibro(2, "La mascara de la muerte roja", new Autor(1, "Edgard Allan Poe"), new Categoria(1, "Misterio"));

echo "Eliminando libro con ID 2...<br>";
$biblioteca->eliminarLibro(1);




?>
