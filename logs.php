<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/componentes.php';

iniciarSessao();

$mensagemErro = '';
$mensagemSucesso = '';

if (isset($_GET['sair'])) {
    fazerLogout();
    header('Location: logs.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['senha_acesso'])) {
    $senha = trim((string) ($_POST['senha_acesso'] ?? ''));

    if (!fazerLogin($senha)) {
        $mensagemErro = 'Chave de acesso incorreta. Tente novamente.';
    } else {
        $mensagemSucesso = 'Acesso liberado com sucesso.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
    if (!estaAutenticado()) {
        $mensagemErro = 'Tentativa de acesso indevido. Faça login para executar esta ação.';
    } else {
        $acao = (string) $_POST['acao'];
        $pagina = (string) ($_POST['pagina'] ?? '');

        if ($acao === 'limpar_pagina') {
            if (limparContadorPagina($pagina)) {
                $mensagemSucesso = 'Contador da página foi limpo com sucesso.';
            } else {
                $mensagemErro = 'Página informada é inválida.';
            }
        } elseif ($acao === 'limpar_todos') {
            limparTodosContadores();
            $mensagemSucesso = 'Todos os contadores foram zerados.';
        } elseif ($acao === 'limpar_logs') {
            limparLogs();
            $mensagemSucesso = 'O registro de logs foi apagado.';
        } else {
            $mensagemErro = 'Ação inválida.';
        }
    }
}

$autenticado = estaAutenticado();
$contadores = contadoresOrdenados();
$total = totalAcessos(lerContadores());
$logs = lerLogs();

renderizarCabecalho('Logs de Acesso', 'logs.php');
?>

<?php if (!$autenticado): ?>
    <section class="mx-auto" style="max-width: 520px;">
        <h2 class="h3 mb-3 text-center">Área protegida</h2>
        <p class="text-secondary text-center">
            Informe a chave de acesso para visualizar as estatísticas e os registros de acesso.
        </p>

        <?php if ($mensagemErro !== ''): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($mensagemErro) ?></div>
        <?php endif; ?>

        <form method="post" class="cartao-destaque p-4">
            <div class="mb-3">
                <label for="senha_acesso" class="form-label">Chave de acesso</label>
                <input type="password" class="form-control" id="senha_acesso" name="senha_acesso" required>
            </div>

            <button type="submit" class="btn btn-dark w-100">Entrar</button>
        </form>
    </section>
<?php else: ?>
    <section class="mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h2 class="h3 mb-1">Estatísticas de acesso</h2>
                <p class="text-secondary mb-0">Contagem por página, total de acessos e lista completa de registros.</p>
            </div>
        </div>
    </section>

    <?php if ($mensagemErro !== ''): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($mensagemErro) ?></div>
    <?php endif; ?>

    <?php if ($mensagemSucesso !== ''): ?>
        <div class="alert alert-success"><?= htmlspecialchars($mensagemSucesso) ?></div>
    <?php endif; ?>

    <section class="row g-4 mb-4">
        <?php foreach ($contadores as $item): ?>
            <div class="col-md-6 col-xl-4">
                <div class="cartao-destaque p-4">
                    <h3 class="h5"><?= htmlspecialchars($item['titulo']) ?></h3>
                    <p class="display-6 fw-bold mb-3"><?= (int) $item['quantidade'] ?></p>

                    <form method="post" onsubmit="return confirm('Deseja realmente limpar o contador desta página?');">
                        <input type="hidden" name="acao" value="limpar_pagina">
                        <input type="hidden" name="pagina" value="<?= array_search($item['titulo'], paginasMonitoradas(), true) ?>">
                        <button type="submit" class="btn btn-outline-danger btn-sm">Limpar contador</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="col-md-6 col-xl-4">
            <div class="cartao-destaque p-4">
                <h3 class="h5">Total de acessos</h3>
                <p class="display-6 fw-bold mb-3"><?= $total ?></p>

                <form method="post" onsubmit="return confirm('Deseja realmente zerar todos os contadores?');">
                    <input type="hidden" name="acao" value="limpar_todos">
                    <button type="submit" class="btn btn-danger btn-sm">Limpar tudo</button>
                </form>
            </div>
        </div>
    </section>

    <section class="cartao-destaque p-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
            <div>
                <h3 class="h4 mb-1">Registros de acesso</h3>
                <p class="mb-0 text-secondary">Lista com contador sequencial, página, data, IP e navegador.</p>
            </div>

            <form method="post" onsubmit="return confirm('Deseja realmente apagar todo o registro de logs?');">
                <input type="hidden" name="acao" value="limpar_logs">
                <button type="submit" class="btn btn-outline-danger">Limpar logs</button>
            </form>
        </div>

        <?php if (count($logs) === 0): ?>
            <p class="mb-0 text-secondary">Nenhum log de acesso registrado até o momento.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped tabela-logs">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Página</th>
                            <th>Data e hora</th>
                            <th>IP</th>
                            <th>Navegador</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $indice => $log): ?>
                            <tr>
                                <td><?= $indice + 1 ?></td>
                                <td><?= htmlspecialchars((string) ($log['pagina'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($log['data_hora'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($log['ip'] ?? '')) ?></td>
                                <td><?= htmlspecialchars((string) ($log['navegador'] ?? '')) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>

<?php
renderizarRodape();
