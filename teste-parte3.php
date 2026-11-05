<?php

use CentralSuporte\Armazenamento\ArmazenamentoJson;
use CentralSuporte\Servicos\GerenciadorChamados;

require_once __DIR__ . '/vendor/autoload.php';

// Cria as instâncias/objetos necessários
$armazenamento = new ArmazenamentoJson();
$gerenciador = new GerenciadorChamados($armazenamento);

// Cria um novo chamado
/* $novoChamado = $gerenciador->criar(
    'Jon Oliva',
    'Instalar editor de áudio profissional',
    'Configurar instrumentos musicais para serem utilizados com o editor de áudio'
); */

echo "<h2>Chamadados cadastrados</h2>";

echo "<pre>";
var_dump($gerenciador->listar());
echo "</pre>";

// Concluir o chamado
$gerenciador->concluir(5);

echo "<h2>Chamados concluídos</h2>";

echo "<pre>";
var_dump($gerenciador->listar());
echo "</pre>";
