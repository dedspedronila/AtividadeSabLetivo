<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Trabalho T1 - Contador de Acessos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        min-height: 100vh;
        margin: 0;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(180deg, #f4f5f7 0%, #e9edf1 100%);
        color: #243447;
    }

    .pagina {
        max-width: 1280px;
        margin: 0 auto;
        padding: 16px 12px 8px;
    }

    .titulo-principal {
        margin-bottom: 18px;
        text-align: center;
        font-size: clamp(2rem, 3vw, 2.8rem);
        font-weight: 700;
        color: #243447;
    }

    .painel-conteudo {
        min-height: 72vh;
        background: #eef1f4;
        border: 1px solid #d8dee6;
        box-shadow: 0 14px 40px rgba(53, 72, 91, 0.08);
        overflow: hidden;
    }

    .coluna-perfil {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 72vh;
        padding: 48px 24px;
        background: rgba(255, 255, 255, 0.5);
    }

    .perfil-aluno {
        text-align: center;
    }

    .foto-aluno {
        width: min(270px, 72vw);
        aspect-ratio: 1 / 1;
        object-fit: cover;
        border-radius: 50%;
        border: 6px solid #a95512;
        box-shadow: 0 12px 24px rgba(54, 64, 78, 0.12);
        margin-bottom: 22px;
    }

    .nome-aluno {
        margin: 0;
        font-size: clamp(1.8rem, 2.4vw, 2.5rem);
        font-weight: 700;
        color: #243447;
    }

    .coluna-links {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 72vh;
        padding: 48px 28px;
        border-left: 2px solid #d8dee6;
    }

    .area-links {
        width: min(100%, 420px);
        text-align: center;
    }

    .titulo-links {
        margin-bottom: 24px;
        font-size: clamp(1.8rem, 2vw, 2.2rem);
        font-weight: 700;
    }

    .lista-links {
        display: grid;
        gap: 14px;
    }

    .botao-link {
        display: block;
        padding: 14px 18px;
        border: 1px solid #d7dde5;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.72);
        color: #33485c;
        font-size: 1rem;
        text-decoration: none;
        transition: transform 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease;
    }

    .botao-link:hover {
        transform: translateY(-2px);
        background: #ffffff;
        box-shadow: 0 10px 20px rgba(50, 69, 89, 0.08);
        color: #243447;
    }

    @media (max-width: 767.98px) {
        .pagina {
            padding-inline: 10px;
        }

        .painel-conteudo {
            min-height: auto;
        }

        .coluna-perfil,
        .coluna-links {
            min-height: auto;
            padding: 36px 20px;
        }

        .coluna-links {
            border-left: none;
            border-top: 2px solid #d8dee6;
        }
    }
    </style>
</head>

<body>
    <main class="pagina">
        <h1 class="titulo-principal">Servidor Web da disciplina de VTPDWE2 2026/01</h1>

        <div class="container-fluid painel-conteudo">
            <div class="row">
                <section class="col-md-4 coluna-perfil">
                    <div class="perfil-aluno">
                        <img src="deds.jpeg" alt="Foto do Aluno" class="foto-aluno">
                        <h2 class="nome-aluno">André Luiz Pedronila Filho</h2>
                    </div>
                </section>

                <section class="col-md-8 coluna-links">
                    <div class="area-links">
                        <h2 class="titulo-links">Links</h2>
                        <div class="lista-links">
                            <a class="botao-link" href="./Busca CEP/index.php">Praticando Busca CEP</a>
                            <a class="botao-link" href="inicio.php">Trabalho 1 - Contador de Acessos</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
</body>

</html>
