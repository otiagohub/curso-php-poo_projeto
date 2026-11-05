<?php
namespace CentralSuporte\Armazenamento;

use CentralSuporte\Chamados\Chamado;
use CentralSuporte\Chamados\StatusChamado;
use CentralSuporte\Usuarios\Usuario;
use Exception;
use JsonException;
use ValueError;

class ArmazenamentoJson
{
    private string $caminho;

    public function __construct()
    {
        $this->caminho = __DIR__ . '/../../dados/chamados.json';
    }

    public function carregar(): array
    {
        // Verifica se o arquivo existe antes de tentar realizar a leitura
        if(!file_exists($this->caminho)){
            throw new Exception("O arquivo de dados dos chamados não foi encontrado");
        }

        // Lê todo o conteúdo do arquivo e guardando-o como uma string
        $conteudo = file_get_contents($this->caminho);

        // Se a leitura falhar, a função retorna false
        if($conteudo === false){
            throw new Exception("Não foi possível ler o arquivo de chamados");
        }

        try {
            // true: a conversão será feita como array associativo
            // 512: é o limite padrão utilizado pra profundidade
            // JSON_THROW_ON_ERROR: lança uma JsonException em caso de erro
            $dados = json_decode($conteudo, true, 512, JSON_THROW_ON_ERROR);
        } catch(JsonException $e){
            // Captura erros na conversão do JSON e apresenta uma mensagem mais adequada.
            // O segundo argumento indica que não há código de erro específico
            // O terceiro argumento preserva a exceção original como causa do novo erro
            throw new Exception("O arquivo de chamados contém JSON inválido", 0, $e);
        }

        // Verifica se o resultados é um array e se possui índices sequenciais válidos
        if(!is_array($dados) || !array_is_list($dados)){
            throw new Exception("O arquivo de chamados não contem uma lista válida");
        }

        // Preparação dos arrays que receberão dados validados
        $chamados = [];
        $ids = [];

        foreach($dados as $item) {
            /* Verifica se cada item é um array, e se possui todos os campos necessários.
            isset(): verifica se os campos existem e se não possuem valor null
            is_string(): verifica se o tipo é string
            is_int(): verifica se o tipo é inteiro
            Verifica se o id é maior que zero */
            if(
               !is_array($item) || 
               !isset($item['id'], $item['titulo'], $item['descricao'], $item['solicitante'], $item['status']) ||
               !is_string($item['titulo']) ||
               !is_string($item['descricao']) ||
               !is_string($item['solicitante']) ||
               !is_string($item['status']) ||
               !is_int($item['id']) ||
               $item['id'] < 1
            ){
                throw new Exception("Um chamado no arquivo de dados está incompleto ou inválido");
            }

            /* Verifica se o identificador já foi encontrado em outro registro */
            if(in_array($item['id'], $ids, true)){
                throw new Exception("O arquivo de chamados contém identificadores duplicados");
            }

            // Guarda o identificador para verificar os próximos registros
            $ids[] = $item['id'];

            // Conversão do texto armazenado para um CASE da Enumeração
            try {
                // StatusChamado::from() procura o case correspondente ao valor recebido
                // Se o valor não existir na Enumeração, será lançado um ValueError
                $status = StatusChamado::from($item['status']);
            } catch(ValueError $erro){
                throw new Exception("Um chamado possui um status desconhecido.", 0, $erro);
            }

            /* Reconstrução dos objetos Chamado
            Os dados verificados/validados são utilizados para criar os objetos da aplicação.
            O solicitante também é reconstruído como um objeto da classe Usuario */
            $chamados[] = new Chamado(
                $item['id'],
                $item['titulo'],
                $item['descricao'],
                new Usuario($item['solicitante']),
                $status
            );
        }

        // Retorna a lista de objetos Chamado criada a partir do JSON
        return $chamados;
    }

    public function salvar(array $chamados): void
    {
        // Array que receberá os dados em um formato adequado para gerar o JSON
        $dados = [];

        foreach($chamados as $chamado){
            /* Extrai as informações dos objetos $chamado e organiza
            os dados em arrays associativos. Note o uso dos getters
            para acessar os dados das propriedades privadas. */
            $dados[] = [
                'id' => $chamado->getId(),
                'titulo' => $chamado->getTitulo(),
                'descricao' => $chamado->getDescricao(),
                'solicitante' => $chamado->getSolicitante()->getNome(),
                'status' => $chamado->getStatus()->value,
            ];
        }

        // Conversão dos dados do PHP para JSON
        try {
            // JSON_PRETTY_PRINT organiza o conteúdo com indentação
            // JSON_UNESCAPED_UNICODE mantém caracteres como ç e ã
            // JSON_THROW_ON_ERROR: lança uma JsonException em caso de erro
            $conteudo = json_encode(
                $dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
            );
        } catch (JsonException $erro) {
            throw new Exception(
                "Não foi possível preparar os dados dos chamados para salvar", 0, $erro
            );
        }

        /* file_put_contents(): grava o conteúdo no arquivo indicado
        PHP_EOL: acrescenta uma quebra de linha ao final do JSON
        LOCK_EX: solicita um bloqueio exclusivo no momento da operação. */
        if(file_put_contents($this->caminho, $conteudo . PHP_EOL, LOCK_EX) === false){
            throw new Exception("Não foi possível salvar o arquivo de chamados");
        }
    }
}