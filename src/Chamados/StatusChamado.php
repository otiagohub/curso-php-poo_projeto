<?php

namespace CentralSuporte\Chamados;

enum StatusChamado: string
{
    case ABERTO = 'Aberto';
    case CONCLUIDO = 'Concluído';
}