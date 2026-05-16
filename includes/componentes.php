<?php

declare(strict_types=1);

require_once __DIR__ . '/funcoes.php';

function renderizarCabecalho(string $tituloPagina, string $paginaAtual): void
{
    $paginas = [
        'inicio.php' => 'Inicio',
        'sobre.php' => 'Sobre',
        'contato.php' => 'Contato',
        'logs.php' => 'Logs de Acesso',
    ];
    ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($tituloPagina) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        min-height: 100vh;
        background: linear-gradient(180deg, #f3f5f7 0%, #e5ebf0 100%);
        color: #243447;
    }

    .topo-pagina {
        background: rgba(255, 255, 255, 0.88);
        border: 1px solid #d7dde5;
        border-radius: 18px;
        box-shadow: 0 14px 30px rgba(50, 69, 89, 0.08);
    }

    .menu-paginas .nav-link {
        color: #30475b;
        font-weight: 600;
        border-radius: 999px;
        padding: 10px 16px;
    }

    .menu-paginas .nav-link.active,
    .menu-paginas .nav-link:hover {
        background: #30475b;
        color: #fff;
    }

    .conteudo-pagina {
        background: rgba(255, 255, 255, 0.88);
        border: 1px solid #d7dde5;
        border-radius: 18px;
        box-shadow: 0 14px 30px rgba(50, 69, 89, 0.08);
    }

    .rodape {
        color: #4c6073;
        font-size: 0.95rem;
    }

    .cartao-destaque {
        border: 1px solid #dde3ea;
        border-radius: 16px;
        background: #f7f9fb;
        height: 100%;
    }

    .tabela-logs td,
    .tabela-logs th {
        vertical-align: middle;
    }
    </style>
</head>

<body>
    <div class="container py-4">
        <header class="topo-pagina p-4 mb-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                <div>
                    <h1 class="h3 mb-1">Trabalho 1 - Contador de Acessos</h1>
                    <p class="mb-0 text-secondary">Atividade da disciplina de VTPDWE2 2026/01</p>
                </div>

                <nav class="menu-paginas">
                    <ul class="nav flex-wrap gap-2 justify-content-center">
                        <?php foreach ($paginas as $arquivo => $rotulo): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $paginaAtual === $arquivo ? 'active' : '' ?>"
                                href="<?= htmlspecialchars($arquivo) ?>">
                                <?= htmlspecialchars($rotulo) ?>
                            </a>
                        </li>
                        <?php endforeach; ?>

                        <?php if (estaAutenticado()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logs.php?sair=1">Sair</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="conteudo-pagina p-4 p-lg-5">
            <?php
}

function renderizarRodape(): void
{
    ?>
        </main>

        <footer class="rodape text-center py-4">
            André Luiz Pedronila Filho | andre.pedronila@aluno.ifsp.edu.br
        </footer>
    </div>
</body>

</html>
<?php
}
