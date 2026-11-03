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

        <section aria-labelledby="titulo-lista">
            <div class="secao-cabecalho">
                <h3 id="titulo-lista">Solicitações</h3>
                <span class="contador">3 chamados</span>
            </div>

            <div class="lista-chamados">
                <article class="cartao item-chamado">
                    <div class="item-conteudo">
                        <p class="identificador">Chamado #1</p>

                        <h4>
                            <a href="chamado.php?id=1">Computador não liga</a>
                        </h4>

                        <p class="solicitante">Solicitante: Nome da pessoa</p>
                    </div>

                    <span class="status status-aberto">Aberto</span>
                </article>
            </div>
        </section>
    </main>

    <footer class="rodape">
        <div class="largura">Central de Suporte <span>·</span> Projeto didático de PHP POO</div>
    </footer>
</body>

</html>
