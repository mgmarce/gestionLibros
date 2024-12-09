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
/*
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

*/


//***********************************USOS LECTOR***********************************//
// LISTANDO todos libros
/*echo "Libros:<br>";
$biblioteca->mostrarLibros();

// INGRESANDO AL SISTEMA COMO LECTOR
$lector1 = new Lector(1, "Marcela Menjivar");
// INGRESANDO datos del libro a solicitar prestamo
$autor1 = new Autor(1, "Edgar Allan Poe");
$categoria2 = new Categoria(2, "Terror");
$libro1 = new Libro(3, "El gato negro", $autor1, $categoria2);

// INGRESANDO datos para solicitar prestamo del libro
$lector1->solicitarPrestamo($biblioteca, $libro1); 


// LISTANDO prestamos por solo el lector que ha ingresado al sistema
$prestamos = $biblioteca->librosPrestadosPorLector($lector1);
foreach ($prestamos as $prestamo) {
    echo "Libro: {$prestamo['titulo']}, Fecha de préstamo: {$prestamo['fechaPrestamo']}, Fecha de devolución: {$prestamo['fechaDevolucion']}<br>";
}*/



//***********************************USOS PARA TODOS LOS USUARIOS***********************************//
/*
//BUSCAR PORR AUTOR
$librosPorAutor = $biblioteca->buscarLibroPorAutor("Edgar Allan Poe");
echo "<br>Libros por Gabriel García Márquez:<br>";
foreach ($librosPorAutor as $libro) {
    echo " - {$libro->getTitulo()}<br>";
}

//BUSCAR PORR TITULO
$librosPorTitulo = $biblioteca->buscarLibroPorTitulo("Crep");
echo "<br>Libros con título 'Crep':<br>";
foreach ($librosPorTitulo as $libro) {
    echo " - {$libro->getTitulo()}<br>";
}

//BUSCAR PORR CATEGORIA
$librosPorTitulo = $biblioteca->buscarLibroPorCategoria("Roman");
echo "<br>Libros de cateogira 'Roman':<br>";
foreach ($librosPorTitulo as $libro) {
    echo " - {$libro->getTitulo()}<br>";
}
*/


/////CAMBIAR LA PARTE DE BUSCAR, DEBE SER POR TODOS LOS USUARIOS, ADEMAS, EL ADMIN DEBE LISTAR LOS PRESTAMOS DE TODOS
?>
