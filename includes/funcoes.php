<?php

declare(strict_types=1);

const CHAVE_ACESSO = 'senha_da_nasa';

function iniciarSessao(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function caminhoDados(string $arquivo): string
{
    return __DIR__ . '/../dados/' . $arquivo;
}

function paginasMonitoradas(): array
{
    return [
        'inicio' => 'Inicio',
        'sobre' => 'Sobre',
        'contato' => 'Contato',
    ];
}

function obterContadoresPadrao(): array
{
    $contadores = [];

    foreach (paginasMonitoradas() as $chave => $titulo) {
        $contadores[$chave] = [
            'titulo' => $titulo,
            'quantidade' => 0,
        ];
    }

    return $contadores;
}

function lerJson(string $arquivo, array $padrao): array
{
    $caminho = caminhoDados($arquivo);

    if (!file_exists($caminho)) {
        return $padrao;
    }

    $conteudo = file_get_contents($caminho);

    if ($conteudo === false || trim($conteudo) === '') {
        return $padrao;
    }

    $dados = json_decode($conteudo, true);

    return is_array($dados) ? $dados : $padrao;
}

function salvarJson(string $arquivo, array $dados): void
{
    $caminho = caminhoDados($arquivo);
    file_put_contents($caminho, json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
}

function lerContadores(): array
{
    $padrao = obterContadoresPadrao();
    $dados = lerJson('contadores.json', $padrao);

    foreach ($padrao as $pagina => $info) {
        if (!isset($dados[$pagina]) || !is_array($dados[$pagina])) {
            $dados[$pagina] = $info;
            continue;
        }

        $dados[$pagina]['titulo'] = $info['titulo'];
        $dados[$pagina]['quantidade'] = isset($dados[$pagina]['quantidade']) ? (int) $dados[$pagina]['quantidade'] : 0;
    }

    return $dados;
}

function salvarContadores(array $contadores): void
{
    salvarJson('contadores.json', $contadores);
}

function obterIpUsuario(): string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'IP nao identificado';
    return trim((string) $ip) !== '' ? (string) $ip : 'IP nao identificado';
}

function obterNavegadorUsuario(): string
{
    $navegador = $_SERVER['HTTP_USER_AGENT'] ?? 'Navegador nao identificado';
    return trim((string) $navegador) !== '' ? (string) $navegador : 'Navegador nao identificado';
}

function registrarLog(string $pagina): void
{
    $caminho = caminhoDados('logs.json');
    $logs = lerLogs();

    $logs[] = [
        'pagina' => paginasMonitoradas()[$pagina] ?? ucfirst($pagina),
        'data_hora' => date('d/m/Y H:i:s'),
        'ip' => obterIpUsuario(),
        'navegador' => obterNavegadorUsuario(),
    ];

    file_put_contents($caminho, json_encode($logs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
}

function lerLogs(): array
{
    return lerJson('logs.json', []);
}

function limparLogs(): void
{
    salvarJson('logs.json', []);
}

function registrarAcesso(string $pagina): void
{
    $contadores = lerContadores();

    if (!isset($contadores[$pagina])) {
        return;
    }

    $contadores[$pagina]['quantidade']++;
    salvarContadores($contadores);
    registrarLog($pagina);
}

function limparContadorPagina(string $pagina): bool
{
    $contadores = lerContadores();

    if (!isset($contadores[$pagina])) {
        return false;
    }

    $contadores[$pagina]['quantidade'] = 0;
    salvarContadores($contadores);

    return true;
}

function limparTodosContadores(): void
{
    salvarContadores(obterContadoresPadrao());
}

function totalAcessos(array $contadores): int
{
    $total = 0;

    foreach ($contadores as $item) {
        $total += (int) ($item['quantidade'] ?? 0);
    }

    return $total;
}

function contadoresOrdenados(): array
{
    $contadores = array_values(lerContadores());

    usort($contadores, static function (array $a, array $b): int {
        return $b['quantidade'] <=> $a['quantidade'];
    });

    return $contadores;
}

function estaAutenticado(): bool
{
    iniciarSessao();
    return !empty($_SESSION['autenticado_logs']);
}

function fazerLogin(string $senha): bool
{
    iniciarSessao();

    if ($senha !== CHAVE_ACESSO) {
        return false;
    }

    $_SESSION['autenticado_logs'] = true;
    return true;
}

function fazerLogout(): void
{
    iniciarSessao();
    $_SESSION = [];
    session_destroy();
}
