<?php
namespace CentralSuporte\Servicos;

use CentralSuporte\Armazenamento\ArmazenamentoJson;
use CentralSuporte\Chamados\Chamado;
use CentralSuporte\Usuarios\Usuario;
use Exception;

class GerenciadorChamados
{
    // A classe utiliza ArmazenamentoJson para carregar e salvar os dados
    private ArmazenamentoJson $armazenamento;

    // Injeção de dependência
    public function __construct(ArmazenamentoJson $armazenamento)
    {
        $this->armazenamento = $armazenamento;
    }

    // Recupera os chamados utilizando a classe de armazenamento
    public function listar(): array
    {
        return $this->armazenamento->carregar();
    }

    // Percorre a lista de chamados e procurar por aquele que possui o ID informado
    public function buscarPorId(int $id): Chamado
    {
        $chamados = $this->listar();
        
        foreach($chamados as $chamado){
            if($chamado->getId() === $id){
                return $chamado;
            }
        }

        throw new Exception("Chamado não encontrado");
    }

    // Recebe os dados necessários para criar um chamado
    public function criar(
        string $nomeDoSolicitante, string $titulo, string $descricao): Chamado
    {
        // Recupera os chamados existentes
        $chamados = $this->listar();

        // Define o primeiro ID possível
        $proximoId = 1;

        /* A cada chamado analisado, verificamos se encontramos um próximo ID
        maior que do que aquele que já tinhamos encontrado. */
        foreach($chamados as $chamado){
            $proximoId = max($proximoId, $chamado->getId() + 1);
        }

        // Cria o novo objeto Chamado, incluindo um objeto Usuario para o solicitante
        $novoChamado = new Chamado(
            $proximoId, $titulo, $descricao, 
            new Usuario($nomeDoSolicitante)
        );

        // Adiciona o novo chamado à lista de chamados
        $chamados[] = $novoChamado;

        // Salva a lista atualizada no arquivo JSON
        $this->armazenamento->salvar($chamados);

        return $novoChamado;
    }

    // Localiza o chamado pelo ID recebido e solicita que ele seja concluído
    public function concluir(int $id): void
    {
        $chamados = $this->listar();

        foreach($chamados as $chamado){
            // Verifica se o ID do chamado atual corresponde ao ID informado
            if($chamado->getId() === $id){
                // A própria classe Chamado controla a alteração do seu status
                $chamado->concluir();

                // Salva a lista com o chamado atualizado/concluído
                $this->armazenamento->salvar($chamados);

                // Encerra o loop/função após concluir o chamado
                return;
            }
        }

        // Se nenhum chamado for encontrado, lança uma exceção
        throw new Exception("Chamado não encontrado");
    }
}