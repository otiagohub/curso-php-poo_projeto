<?php
use CentralSuporte\Armazenamento\ArmazenamentoJson;
use CentralSuporte\Servicos\GerenciadorChamados;

require_once __DIR__ . '/vendor/autoload.php';

$armazenamento = new ArmazenamentoJson();
$gerenciador = new GerenciadorChamados($armazenamento);

$erro = null;
$nome = '';
$titulo = '';
$descricao = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    /* O operador ?? (coalescência nula) fornece uma string vazia caso
    nenhum valor tenha sido enviado/digitado. Usamos isso para evitar
    avisos de índice indefinido. */
    $nomeRecebido = $_POST['nome'] ?? '';
    $tituloRecebido = $_POST['titulo'] ?? '';
    $descricaoRecebida = $_POST['descricao'] ?? '';

    // Remoção de espaços desnecessários
    $nome = trim($nomeRecebido);
    $titulo = trim($tituloRecebido);
    $descricao = trim($descricaoRecebida);

    // Validação BACK-END dos campos obrigatórios
    if($nome === '' || $titulo === '' || $descricao === ''){
        $erro = "Preencha o nome do solicitante, o título e a descrição";
    } else {
        try {
            $gerenciador->criar($nome, $titulo, $descricao);

            // O parâmetro sucesso=1 indica que o cadastro foi realizado com sucesso
            header("location:index.php?sucesso=1");
            exit;
        } catch (Exception $excecao) {
            $erro = $excecao->getMessage();
        }
    }
}
?>
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

        <?php if($erro !== null): ?>
            <p class="mensagem erro" role="alert">
                <?= escapar($erro) ?>
            </p>
        <?php endif; ?>

        <form class="cartao formulario" method="post" action="novo-chamado.php">
            <div class="campo">
                <label for="nome">Nome do solicitante</label>
                <input value="<?= escapar($nome) ?>" id="nome" name="nome" type="text" autocomplete="name" required>
            </div>

            <div class="campo">
                <label for="titulo">Título</label>
                <input value="<?= escapar($titulo) ?>" id="titulo" name="titulo" type="text" required>
            </div>

            <div class="campo">
                <label for="descricao">Descrição</label>
                <textarea required id="descricao" name="descricao" rows="6" aria-describedby="ajuda-descricao"><?= escapar($descricao) ?></textarea>
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
