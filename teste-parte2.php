<?php

use CentralSuporte\Armazenamento\ArmazenamentoJson;
use CentralSuporte\Chamados\Chamado;
use CentralSuporte\Chamados\StatusChamado;
use CentralSuporte\Usuarios\Usuario;

require_once __DIR__ . '/vendor/autoload.php';

// Criando um objeto responsável pelo Armazenamento
$armazenamento = new ArmazenamentoJson();

// Carregando os chamados do arquivo JSON
$chamados = $armazenamento->carregar();

// Criando um novo chamado
$novoChamado = new Chamado(
    4,
    'Problema com lentidão geral',
    'A máquina está travando em diversos momentos',
    new Usuario('Bernardo Augusto')
);

// Adicionando o novo chamado à lista/array de chamados existentes
$chamados[] = $novoChamado;

// Salvando todos os chamados
$armazenamento->salvar($chamados);

echo "<p>Chamados salvos com sucesso</p>";

echo "<pre>";
var_dump($chamados);
echo "</pre>";