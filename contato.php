<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/componentes.php';

registrarAcesso('contato');
renderizarCabecalho('Contato - Contador de Acessos', 'contato.php');
?>

<section class="row g-4">
    <div class="col-lg-7">
        <div class="cartao-destaque p-4">
            <h2 class="h3 mb-3">Contato</h2>
            <p>
                Esta pagina fecha o conjunto principal do trabalho. Ela tambem entra no contador de acessos
                e ajuda a demonstrar como os dados ficam distribuidos entre as paginas.
            </p>
            <p class="mb-0">
                Se este fosse um site real, aqui poderiam ficar formulario, redes sociais, email e outras informacoes de contato.
            </p>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="cartao-destaque p-4">
            <h2 class="h4 mb-3">Informacoes</h2>
            <ul class="mb-0">
                <li>Aluno: André Luiz Pedronila Filho</li>
                <li>Disciplina: VTPDWE2</li>
                <li>Semestre: 2026/01</li>
                <li>Pagina usada no contador de acessos</li>
            </ul>
        </div>
    </div>
</section>

<?php
renderizarRodape();
