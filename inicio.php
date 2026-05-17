<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/componentes.php';

registrarAcesso('inicio');
renderizarCabecalho('Inicio - Contador de Acessos', 'inicio.php');
?>

<section class="row g-4 align-items-center">
    <div class="col-lg-7">
        <span class="badge text-bg-secondary mb-3">Pagina inicial</span>
        <h2 class="display-6 fw-bold">Bem-vindo ao meu mini site da disciplina</h2>
        <p class="lead text-secondary">
            Esta pagina faz parte do Trabalho 1 e registra automaticamente cada visualizacao usando PHP e arquivos de texto.
        </p>
        <p>
            Aqui eu reuni algumas paginas com um tema simples sobre minha rotina de estudos, interesses e formas de contato.
	    O objetivo principal deste trabalho e mostrar a navegacao entre paginas e o funcionamento do contador de acessos.
	SENHA:senha_da_nasa
        </p>
    </div>

    <div class="col-lg-5">
        <div class="cartao-destaque p-4">
            <h3 class="h4">O que foi feito</h3>
            <ul class="mb-0">
                <li>Menu para navegar entre as paginas do trabalho</li>
                <li>Contador individual por pagina</li>
                <li>Registro com data, hora, IP e navegador</li>
                <li>Area protegida para consultar os logs</li>
            </ul>
        </div>
    </div>
</section>

<?php
renderizarRodape();
