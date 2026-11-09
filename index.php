<?php
// Importação do autoload de recursos
require_once __DIR__ . '/vendor/autoload.php';

// Importando as classes através do namespace
use CentralSuporte\Armazenamento\ArmazenamentoJson;
use CentralSuporte\Chamados\StatusChamado;
use CentralSuporte\Servicos\GerenciadorChamados;

// Criando um objeto ArmazenamentoJson
$armazenamento = new ArmazenamentoJson();

// Criando um objeto GerenciadorChamados
$gerenciador = new GerenciadorChamados($armazenamento);

// Armazenará uma possível mensagem de erro
$erro = null;

// Armazenará a lista de chamados recuperada do arquivo JSON
$chamados = [];

try {
    $chamados = $gerenciador->listar();
} catch (Exception $excecao) {
    $erro = $excecao->getMessage();
}

// echo "<pre>";
// var_dump($chamados);
// echo "</pre>";
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Central de Suporte</title>
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
                <a class="botao botao-claro" href="novo-chamado.php">Abrir chamado</a>
            </nav>
        </div>
    </header>

    <main class="largura conteudo">
        <section class="introducao">
            <p class="sobretitulo">Atendimento de TI</p>
            <h2>Chamados de suporte</h2>
            <p>Acompanhe as solicitações e consulte os detalhes de cada atendimento.</p>
        </section>


        <?php if($erro !== null): ?>
            <p class="mensagem erro" role="alert"> <?= $erro ?> </p>
        <?php endif; ?>


        <section aria-labelledby="titulo-lista">
            <div class="secao-cabecalho">
                <h3 id="titulo-lista">Solicitações</h3>
                <span class="contador">
                    <?= count($chamados) ?> <?= count($chamados) === 1 ? 'chamado' : 'chamados' ?>
                </span>
            </div>

    <?php if($erro === null): ?>

        <?php if($chamados === []): ?>
            <div class="cartao estado-vazio">
                <h4>Nenhum chamado cadastrado</h4>
                <p>Abra um chamado para iniciar um atendimento.</p>
                <a href="novo-chamado.php" class="botao botao-principal">Cadastrar chamado</a>
            </div>
        
        <?php else: ?>
            <div class="lista-chamados">
                
                <?php foreach($chamados as $chamado): ?>
                    <article class="cartao item-chamado">
                        <div class="item-conteudo">
                            <p class="identificador">Chamado #<?= $chamado->getId() ?></p>

                            <h4>
                                <a href="chamado.php?id=<?= $chamado->getId() ?>">
                                    <?= escapar($chamado->getTitulo()) ?>
                                </a>
                            </h4>

                            <p class="solicitante">
                                Solicitante: <?= escapar($chamado->getSolicitante()->getNome()) ?>
                            </p>
                        </div>

                        <span class="status <?= estilizarStatus($chamado->getStatus()) ?>">
                            <?= escapar($chamado->getStatus()->value) ?>
                        </span>
                    </article>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>
    <?php endif; ?>
        </section>
    </main>

    <footer class="rodape">
        <div class="largura">Central de Suporte <span>·</span> Projeto didático de PHP POO</div>
    </footer>
</body>

</html>
