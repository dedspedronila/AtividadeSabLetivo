<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/componentes.php';

registrarAcesso('sobre');
renderizarCabecalho('Sobre - Contador de Acessos', 'sobre.php');
?>

<section class="row g-4">
    <div class="col-lg-6">
        <div class="cartao-destaque p-4">
            <h2 class="h3 mb-3">Sobre mim</h2>
            <p>
                Estudante de Sistemas de Informação no IFSP Votuporanga.
                Além de desenvolvedor web, sou apaixonado por tecnologia e hardware. E estou em busca de aprender novos
                frameworks.
            </p>
            <p class="mb-0">
                Alem da interface, a parte principal foi montar a contagem de acessos sem usar banco de dados,
                apenas arquivos de texto e a linguagem PHP.
            </p>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="cartao-destaque p-4">
            <h2 class="h3 mb-3">Tecnologias usadas</h2>
            <ul class="mb-0">
                <li>⚽ <strong>Fiel Torcedor:</strong> Apaixonado pelo Corinthians.</li>
                <li>💪<strong>Esportes:</strong> Focado na academia e em busca de melhorar o shape</li>
                <li>🎮 <strong>Jogos:</strong> Curto jogar alguns jogos e ouvir musica nas horas vagas.</li>
                <li>🐧 <strong>Enstuasiasta do Linux:</strong> Gosto de resolver tudo via terminal.</li>
            </ul>
        </div>
    </div>
</section>

<?php
renderizarRodape();
