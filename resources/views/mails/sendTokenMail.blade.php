<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
</head>
<body>
    <h1>Olá, {{ $dados['username'] }}</h1>
    <p>Este é o token para voce acessar sua conta: {{ $dados['token'] }}</p>
</body>
</html>
