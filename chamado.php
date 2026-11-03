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

        <article class="cartao detalhes">
            <header class="introducao">
                <p class="sobretitulo">Detalhes do atendimento</p>
                <h2>Computador não liga</h2>
            </header>

            <div class="detalhes-topo">
                <p class="identificador">Chamado #1</p>

                <span class="status status-aberto">Aberto</span>
            </div>

            <dl class="informacoes">
                <div>
                    <dt>Solicitante</dt>
                    <dd>Nome da pessoa</dd>
                </div>

                <div>
                    <dt>Descrição</dt>
                    <dd class="descricao">O computador não liga após uma queda de energia.</dd>
                </div>
            </dl>

            <form method="post" action="chamado.php?id=1" class="acoes">
                <button class="botao botao-principal" type="submit">Concluir chamado</button>
            </form>
        </article>
    </main>

    <footer class="rodape">
        <div class="largura">Central de Suporte <span>·</span> Projeto didático de PHP POO</div>
    </footer>
</body>

</html>
