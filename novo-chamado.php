<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Novo chamado | Central de Suporte</title>
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

        <section class="introducao">
            <p class="sobretitulo">Nova solicitação</p>
            <h2>Abrir chamado</h2>
            <p>Conte para a equipe de suporte o que precisa de ajuda.</p>
        </section>

        <form class="cartao formulario" method="post" action="novo-chamado.php">
            <div class="campo">
                <label for="nome">Nome do solicitante</label>
                <input id="nome" name="nome" type="text" autocomplete="name">
            </div>

            <div class="campo">
                <label for="titulo">Título</label>
                <input id="titulo" name="titulo" type="text">
            </div>

            <div class="campo">
                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" rows="6" aria-describedby="ajuda-descricao"></textarea>
                <span class="ajuda" id="ajuda-descricao">Descreva o que aconteceu e quando o problema começou.</span>
            </div>

            <div class="acoes">
                <a class="botao botao-secundario" href="index.php">Cancelar</a>
                <button class="botao botao-principal" type="submit">Cadastrar chamado</button>
            </div>
        </form>
    </main>

    <footer class="rodape">
        <div class="largura">Central de Suporte <span>·</span> Projeto didático de PHP POO</div>
    </footer>
</body>

</html>
