<?php

use CentralSuporte\Chamados\Chamado;
use CentralSuporte\Chamados\StatusChamado;
use CentralSuporte\Usuarios\Usuario;

require_once __DIR__ . '/vendor/autoload.php';

$usuario = new Usuario("Bernardo Augusto");

echo "<pre>";
var_dump($usuario);
echo "</pre>";

echo "<br><br>";

$status = StatusChamado::ABERTO;

echo "<pre>";
var_dump($status); // acesso ao CASE
echo "</pre>";

echo "<pre>";
var_dump($status->value); // acesso ao valor associado ao CASE
echo "</pre>";

echo "<br><br>";

$chamado = new Chamado(5, 'Instalar o VSCode', 'Instalar o Visual Studio Code no computador do analista', $usuario);

echo "<pre>";
var_dump($chamado); // ABERTO
echo "</pre>";

$chamado->concluir(); // MUDANDO O STATUS DO CHAMADO

echo "<pre>";
var_dump($chamado); // CONCLUÍDO
echo "</pre>";

$chamado->concluir();
