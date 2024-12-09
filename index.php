<?php
include_once('clases/Biblioteca.php');
include_once('clases/Libro.php');
include_once('clases/Usuario.php');
include_once('clases/Prestamo.php');


$biblioteca = new Biblioteca();

$libro1 = new Libro(1, "El Quijote", "Cervantes", "Novela");
$usuario1 = new Usuario(1, "Juan Pérez");

$biblioteca->agregarLibro($libro1);
$biblioteca->registrarUsuario($usuario1);

$biblioteca->prestarLibro(1, 1, "2024-07-01");
