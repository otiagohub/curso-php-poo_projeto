<?php

/* Função auxiliar que centraliza o tratamento de textos
antes da exibição no HTML */

use CentralSuporte\Chamados\StatusChamado;

function escapar(string $texto): string
{
    /* htmlspecialchars() converte caracteres especiais em entidades HTML,
    evitando que textos sejam interpretados como código HTML ou JS. */
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function dump(mixed $valor): void
{
    echo "<pre>";
    var_dump($valor);
    echo "</pre>";
}

function estilizarStatus(StatusChamado $status): string
{
    return $status === StatusChamado::ABERTO ? 'status-aberto' : 'status-concluido';
}