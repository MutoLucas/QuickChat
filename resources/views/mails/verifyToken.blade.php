<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - QuickChat</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="vh-100 bg bg-dark">
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="container col-10 col-md-4 border border-light shadow-lg bg bg-light rounded-4 p-3">
            <h1 class="text-center fs-3 mb-0">Verificação em Duas etapas</h1>
            <h2 class="text-center fs-6 mb-0">Enviamos um token para o email: <span class="text-primary">{{ $email }}</span></h2>

            @if(Session()->has('errorToken'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="height: 60px">
                <p>{{ Session('errorToken') }}</p>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form action="{{ route('auth.verify.token') }}" method="POST">
                @csrf
                <div class="input-group p-3">
                    <span class="input-group-text"><i class="bi bi-box-arrow-down-left"></i></span>
                    <input type="text" name="token" class="form-control" placeholder="Token enviado">
                    <button type="submit" class="btn btn-outline-secondary">Verificar</button>
                </div>
                <input type="hidden" name="email" value="{{ $email }}">
                <small class="ms-4">Não recebeu o Token? <a href="{{ route('auth.resend.token', ['email'=>$email]) }}">Reenviar Token</a></small>
            </form>
        </div>
    </div>
</body>
</html>
