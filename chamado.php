<?php
require_once __DIR__ . '/vendor/autoload.php';

use CentralSuporte\Armazenamento\ArmazenamentoJson;
use CentralSuporte\Chamados\StatusChamado;
use CentralSuporte\Servicos\GerenciadorChamados;

$armazenamento = new ArmazenamentoJson();
$gerenciador = new GerenciadorChamados($armazenamento);

/* Inicialização das variáveis
$erro -> armazenará possíveis de mensagens de erro
$chamado -> armazenará o objeto recuperado
$id -> armazenará o identificador do chamado (caso seja válido)  */
$erro = null;
$chamado = null;
$id = null;

// Recuperar o valor do identificador passado pela URL
$idInformado = $_GET['id'] ?? '';

/* Validação do identificador 
Verificamos se o valor recebido é uma string formada apenas por dígitos e se é positiva
!is_string() -> verifica se o valor não é uma string
!ctype_digit() -> verifica se a string não contém apenas dígitos
(int) -> converte o valor para número inteiro e compara com 1 impedindo ids iguais a zero
*/
if(!is_string($idInformado) || !ctype_digit($idInformado) || (int) $idInformado < 1){
    $erro = "O identificador do chamado é inválido";
} else {
    // Se o identificador for válido, garantimos e guardamos como inteiro
    $id = (int) $idInformado;

    // Busca do chamado pelo id
    try {
        // Em caso de sucesso, recebendo o objeto com os dados do chamado
        $chamado = $gerenciador->buscarPorId($id);
    } catch(Exception $excecao){
        $erro = $excecao->getMessage();
    }
}

//dump($chamado);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalhes do chamado | Central de Suporte</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>
    <header class="cabecalho">
        <div class="largura cabecalho-conteudo">
            <a class="marca" href="index.php">
                <span class="marca-icone" aria-hidden="true">CS</span>
                <h1 class="marca-nome">Central de Suporte</h1>
            </a>
            <nav>
                <a class="link-cabecalho" href="index.php">Ver chamados</a>
            </nav>
        </div>
    </header>

    <main class="largura conteudo conteudo-formulario">
        <a class="voltar" href="index.php">← Voltar para chamados</a>

    <?php if($erro !== null): ?>
        <div class="cartao estado-vazio">
            <p class="mensagem-texto"><?= escapar($erro) ?></p>
            <a href="index.php" class="botao botao-principal">Voltar para chamados</a>
        </div>

    <?php elseif($chamado !== null): ?>

        <article class="cartao detalhes">
            <header class="introducao">
                <p class="sobretitulo">Detalhes do atendimento</p>
                <h2> <?= escapar($chamado->getTitulo()) ?> </h2>
            </header>

            <div class="detalhes-topo">
                <p class="identificador">Chamado #<?= $chamado->getId() ?></p>

                <span class="status <?= estilizarStatus($chamado->getStatus()) ?>">
                    <?= escapar($chamado->getStatus()->value) ?>
                </span>
            </div>

            <dl class="informacoes">
                <div>
                    <dt>Solicitante</dt>
                    <dd> <?= escapar($chamado->getSolicitante()->getNome()) ?></dd>
                </div>

                <div>
                    <dt>Descrição</dt>
                    <dd class="descricao">
                        <!-- nl2br() transforma quebras de linha em elemento HTML <br> -->
                        <?= nl2br(escapar($chamado->getDescricao())) ?>
                    </dd>
                </div>
            </dl>

            <form method="post" action="chamado.php?id=1" class="acoes">
                <button class="botao botao-principal" type="submit">Concluir chamado</button>
            </form>
        </article>
    <?php endif; ?>
    </main>

    <footer class="rodape">
        <div class="largura">Central de Suporte <span>·</span> Projeto didático de PHP POO</div>
    </footer>
</body>

</html>
