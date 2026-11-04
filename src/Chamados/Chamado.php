<?php

namespace CentralSuporte\Chamados;

use CentralSuporte\Usuarios\Usuario;
use Exception;

class Chamado
{
    private int $id;
    private string $titulo;
    private string $descricao;
    private Usuario $solicitante;
    private StatusChamado $status;

    public function __construct(
        int $id, string $titulo, string $descricao,
        Usuario $solicitante, StatusChamado $status = StatusChamado::ABERTO
        )
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->solicitante = $solicitante;
        $this->status = $status;
    }

    public function getId():int
    {
        return $this->id;
    }

    public function getTitulo():string
    {
        return $this->titulo;
    }

    public function getDescricao():string
    {
        return $this->descricao;
    }

    public function getSolicitante(): Usuario
    {
        return $this->solicitante;
    }

    public function getStatus(): StatusChamado
    {
        return $this->status;
    }

    public function concluir(): void
    {
        // Antes de concluir, verifica se o chamado já está concluído
        if($this->status === StatusChamado::CONCLUIDO){
            // Se estiver, lança uma exceção para impedir a operação
            throw new Exception("Este chamado já está concluído");
        }

        // Se o chamado ainda estiver aberto, altera seu status
        $this->status = StatusChamado::CONCLUIDO;
    }

}