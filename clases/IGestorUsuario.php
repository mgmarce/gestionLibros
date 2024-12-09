<?php

interface IGestorUsuario {
    public function registrarUsuario($usuario);
    public function buscarUsuario($id);
}