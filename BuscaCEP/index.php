<?php

use Claudsonm\CepPromise\CepPromise;
use Claudsonm\CepPromise\Exceptions\CepPromiseException;

// require_once __DIR__ . '/vendor/autoload.php';
//ou o de baixo, ambos funcionam

require 'vendor/autoload.php';

$cep      = '';
$cepFmt   = '';   // CEP formatado: 00.000-000
$address  = null; // objeto retornado pelo CepPromise
$erros    = [];   // array de erros dos provedores

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $cep = preg_replace('/\D/', '', $_POST['cep'] ?? ''); // remove o que nao for digito

    if (strlen($cep) !== 8) {
        $erros = [['message' => 'Digite exatamente 8 dígitos numéricos.']];
    } else {

        $cepFmt = substr($cep, 0, 2) . '.' . substr($cep, 2, 3) . '-' . substr($cep, 5, 3); //formata o CEP para exibição

        try {
            $address = CepPromise::fetch($cep);
        } catch (CepPromiseException $e) {
            $info  = $e->toArray();
            $erros = $info['errors'] ?? [['message' => $info['message'] ?? 'Erro desconhecido.']];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Praticando Composer - Busca CEP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <div class="container">

        <header class="page-header">

            <h1>Praticando Composer &mdash; Busca CEP com Composer</h1>

        </header>

        <form method="POST" action="" novalidate>

            <label for="cepInput">CEP:</label>

            <div class="input-row">
                <input
                
                    id="cepInput"
                    name="cep"
                    type="text"
                    class="cep-input <?= !empty($erros) ? 'cep-input--error' : '' ?>"
                    placeholder="Somente números"
                    maxlength="8"
                    inputmode="numeric"
                    value="<?= htmlspecialchars($cep) ?>"
                    autocomplete="off" />

                <button type="submit" class="btn-enviar">Enviar</button>

                <a href="" class="btn-limpar">Limpar</a>
            </div>

        </form>

        <?php if ($address): ?>
            <div class="result-card result-card--success">

                <h5 class="result-card__title">CEP: <?= htmlspecialchars($cepFmt) ?></h5>
                <p>Rua: <?= htmlspecialchars($address->street   ?? '—') ?></p>
                <p>Bairro: <?= htmlspecialchars($address->district ?? '—') ?></p>
                <p>Cidade: <?= htmlspecialchars($address->city     ?? '—') ?></p>
                <p>Estado: <?= htmlspecialchars($address->state    ?? '—') ?></p>

            </div>
        <?php endif; ?>

        <?php if (!empty($erros)): ?>
            <div class="result-card result-card--error">

                <h5 class="result-card__title">

                    CEP: <?= $cepFmt ? htmlspecialchars($cepFmt) : htmlspecialchars($cep) ?>

                </h5>

                <p class="result-card__subtitle">Detalhes do erro</p>

                <ul>
                    <?php foreach ($erros as $erro): ?>
                        
                        <li><?= htmlspecialchars($erro['message'] ?? 'Erro desconhecido.') ?></li>
                   
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>