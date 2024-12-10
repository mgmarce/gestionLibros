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
//***********************************USOS ADMINISTRADOR***********************************//
/*
// INGRESANDO AL SISTEMA COMO ADMINISTRADOR
$admin = new Administrador(1, "Admin1", $biblioteca);

// INGRESANDO datos de autores y categorías
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
 
// LISTANDO todos libros
echo "Libros:<br>";
$biblioteca->mostrarLibros();

// ELIMINANDO libro con permiso de usuario a la base de datos (ARCHIVO JSON)
$admin->eliminar(2);

// INGRESANDO datos que se van a editar por medio del ID del libro seleccionado
$autor3 = new Autor(3, "Makoto Shinkai");
$categoria3 = new Categoria(3, "Fantasía");
$libro3 = new Libro(1, "Weathering with You", $autor3, $categoria3);

// EDITANDO libro con permiso de usuario a la base de datos (ARCHIVO JSON)
$admin->editar(1, $libro3); 

//LISTANDO todos los prestamos de todos los usuarios
$admin->listar();
*/

//***********************************USOS LECTOR***********************************//
/*
// INGRESANDO AL SISTEMA COMO LECTOR
$lector1 = new Lector(1, "Marcela Menjivar");

// LISTANDO todos libros
echo "Libros:<br>";
$biblioteca->mostrarLibros();


// INGRESANDO datos del libro a solicitar prestamo
$autor1 = new Autor(3, "Louisa May Alcott");
$categoria2 = new Categoria(1, "Romance");
$libro1 = new Libro(4, "Mujercitas", $autor1, $categoria2);

// INGRESANDO datos para solicitar prestamo del libro
$lector1->solicitarPrestamo($biblioteca, $libro1); 


// LISTANDO prestamos por solo el lector que ha ingresado al sistema
$biblioteca->librosPrestadosPorLector($lector1);
*/


//***********************************USOS PARA TODOS LOS USUARIOS***********************************//
/*
//BUSCAR POR AUTOR
$biblioteca->buscarLibroPorAutor("Edgar");


//BUSCAR PORR CATEGORIA
$biblioteca->buscarLibroPorCategoria("Roman");

//BUSCAR POR TITULO
$biblioteca->buscarLibroPorTitulo("Crep");
*/


/////CAMBIAR LA PARTE DE BUSCAR, DEBE SER POR TODOS LOS USUARIOS, ADEMAS, EL ADMIN DEBE LISTAR LOS PRESTAMOS DE TODOS
?>