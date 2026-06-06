@extends('layouts.auth')

@section('title', 'Entrar')

@section('content')
<div class="auth-card">
    <a href="{{ url('/') }}" class="auth-logo">
        <span class="auth-logo-icon"><i class="bi bi-lightning-fill"></i></span>
        Gym<span>Control</span>
    </a>

    <div class="auth-heading">
        <h1>Entrar no painel</h1>
        <p>Acesse a gestão da sua academia.</p>
    </div>

    <form method="POST" action="{{ route('login.store') }}" class="auth-form">
        @csrf

        <div>
            <label for="email" class="auth-label">E-mail</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" class="auth-input @error('email') is-invalid @enderror" required autofocus>
            @error('email')<div class="auth-error">{{ $message }}</div>@enderror
        </div>

        <div>
            <label for="password" class="auth-label">Senha</label>
            <input id="password" name="password" type="password" class="auth-input @error('password') is-invalid @enderror" required>
            @error('password')<div class="auth-error">{{ $message }}</div>@enderror
        </div>

        <label class="auth-check">
            <input type="checkbox" name="remember" value="1">
            <span>Lembrar acesso</span>
        </label>

        <button type="submit" class="auth-button">Entrar</button>
    </form>

    <div class="auth-switch">
        Ainda não cadastrou a academia?
        <a href="{{ route('register') }}">Criar cadastro</a>
    </div>
</div>
@endsection
