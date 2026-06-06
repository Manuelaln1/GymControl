@extends('layouts.auth')

@section('title', 'Registrar Academia')

@section('content')
<div class="auth-card auth-card-wide">
    <a href="{{ url('/') }}" class="auth-logo">
        <span class="auth-logo-icon"><i class="bi bi-lightning-fill"></i></span>
        Gym<span>Control</span>
    </a>

    <div class="auth-heading">
        <h1>Cadastrar academia</h1>
        <p>Crie a academia e o usuário administrador.</p>
    </div>

    <form method="POST" action="{{ route('register.store') }}" class="auth-form">
        @csrf

        <div class="auth-grid">
            <div>
                <label for="academia_nome" class="auth-label">Nome da academia</label>
                <input id="academia_nome" name="academia_nome" value="{{ old('academia_nome') }}" class="auth-input @error('academia_nome') is-invalid @enderror" required autofocus>
                @error('academia_nome')<div class="auth-error">{{ $message }}</div>@enderror
            </div>

            <div>
                <label for="academia_telefone" class="auth-label">Telefone</label>
                <input id="academia_telefone" name="academia_telefone" value="{{ old('academia_telefone') }}" class="auth-input @error('academia_telefone') is-invalid @enderror">
                @error('academia_telefone')<div class="auth-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div>
            <label for="academia_endereco" class="auth-label">Endereço</label>
            <input id="academia_endereco" name="academia_endereco" value="{{ old('academia_endereco') }}" class="auth-input @error('academia_endereco') is-invalid @enderror">
            @error('academia_endereco')<div class="auth-error">{{ $message }}</div>@enderror
        </div>

        <div class="auth-grid">
            <div>
                <label for="name" class="auth-label">Nome do administrador</label>
                <input id="name" name="name" value="{{ old('name') }}" class="auth-input @error('name') is-invalid @enderror" required>
                @error('name')<div class="auth-error">{{ $message }}</div>@enderror
            </div>

            <div>
                <label for="email" class="auth-label">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" class="auth-input @error('email') is-invalid @enderror" required>
                @error('email')<div class="auth-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="auth-grid">
            <div>
                <label for="password" class="auth-label">Senha</label>
                <input id="password" name="password" type="password" class="auth-input @error('password') is-invalid @enderror" required>
                @error('password')<div class="auth-error">{{ $message }}</div>@enderror
            </div>

            <div>
                <label for="password_confirmation" class="auth-label">Confirmar senha</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="auth-input" required>
            </div>
        </div>

        <button type="submit" class="auth-button">Salvar e entrar</button>
    </form>

    <div class="auth-switch">
        Já tem cadastro?
        <a href="{{ route('login') }}">Entrar</a>
    </div>
</div>
@endsection
