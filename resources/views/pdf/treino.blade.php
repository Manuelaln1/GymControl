<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Treino</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            padding: 30px;
        }

        h1{
            color: #111827;
            margin-bottom: 25px;
            text-align: center;
        }

        .card{
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .item{
            margin-bottom: 20px;
        }

        .label{
            font-weight: bold;
            color: #374151;
            margin-bottom: 6px;
        }

        .value{
            color: #111827;
            line-height: 1.5;
            white-space: normal;
        }
    </style>
</head>

<body>

    <h1>{{ $treino->nome }}</h1>

<div class="card">

    <div class="item">
        <div class="label">Aluno</div>
        <div class="value">
            {{ $treino->aluno->name ?? '—' }}
        </div>
    </div>

    <div class="item">
        <div class="label">Objetivo</div>
        <div class="value">
            {!! nl2br(e($treino->objetivo ?? '—')) !!}
        </div>
    </div>

    <div class="item">
        <div class="label">Observações</div>
        <div class="value">
            {!! nl2br(e($treino->observacoes ?? '—')) !!}
        </div>
    </div>

    <div class="item">
        <div class="label">Status</div>
        <div class="value">
            {{ $treino->ativo ? 'Ativo' : 'Inativo' }}
        </div>
    </div>

</div>

</body>
</html>