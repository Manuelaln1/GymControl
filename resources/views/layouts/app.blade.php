<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GymControl — @yield('title', 'Painel')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --gym-dark:    #0d0f12;
            --gym-surface: #161a1f;
            --gym-surface2:#1e242b;
            --gym-border:  #2a323c;
            --gym-accent:  #c8f135;
            --gym-accent2: #a8d020;
            --gym-text:    #e8ecf0;
            --gym-muted:   #7a8794;
            --sidebar-w:   230px;
            --topbar-h:    60px;
        }

        body { background: var(--gym-dark); color: var(--gym-text); font-family: 'Barlow', sans-serif; }

        /* ── SIDEBAR ── */
        #sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--gym-surface);
            border-right: 1px solid var(--gym-border);
            position: fixed; top: 0; left: 0; z-index: 200;
            display: flex; flex-direction: column;
            transition: transform .25s ease;
        }
        .sidebar-logo {
            padding: 20px 18px;
            border-bottom: 1px solid var(--gym-border);
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }
        .logo-icon {
            width: 36px; height: 36px; border-radius: 8px;
            background: var(--gym-accent); display: flex;
            align-items: center; justify-content: center;
        }
        .logo-icon i { color: #0d0f12; font-size: 18px; }
        .logo-name { font-family: 'Barlow Condensed', sans-serif; font-size: 22px; font-weight: 700; color: var(--gym-text); }
        .logo-name span { color: var(--gym-accent); }

        .sidebar-section {
            font-size: 10px; font-weight: 700; color: var(--gym-muted);
            letter-spacing: 1.5px; text-transform: uppercase;
            padding: 14px 18px 4px;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 18px; font-size: 14px; color: var(--gym-muted);
            text-decoration: none; transition: background .15s, color .15s;
            position: relative; border-radius: 0;
        }
        .sidebar-link i { font-size: 16px; width: 18px; text-align: center; }
        .sidebar-link:hover { background: var(--gym-surface2); color: var(--gym-text); }
        .sidebar-link.active { color: var(--gym-accent); background: rgba(200,241,53,.08); }
        .sidebar-link.active::before {
            content: ''; position: absolute; left: 0; top: 6px; bottom: 6px;
            width: 3px; background: var(--gym-accent); border-radius: 0 3px 3px 0;
        }
        .sidebar-badge {
            margin-left: auto; background: var(--gym-accent); color: #0d0f12;
            font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 20px;
        }
        .sidebar-footer {
            margin-top: auto; padding: 16px 18px;
            border-top: 1px solid var(--gym-border);
            display: flex; align-items: center; gap: 10px;
        }
        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: rgba(200,241,53,.15); border: 1.5px solid var(--gym-accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: var(--gym-accent); flex-shrink: 0;
        }
        .user-name { font-size: 13px; font-weight: 600; color: var(--gym-text); }
        .user-role { font-size: 11px; color: var(--gym-muted); }
        .academy-box { margin: 14px 18px 4px; padding: 12px; background: rgba(200,241,53,.08); border: 1px solid rgba(200,241,53,.18); border-radius: 8px; }
        .academy-label { font-size: 10px; font-weight: 700; color: var(--gym-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 3px; }
        .academy-name { font-size: 14px; font-weight: 700; color: var(--gym-accent); line-height: 1.2; word-break: break-word; }
        .logout-button { margin-left: auto; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; padding: 0; }

        /* ── TOPBAR ── */
        #topbar {
            height: var(--topbar-h); background: var(--gym-surface);
            border-bottom: 1px solid var(--gym-border);
            position: fixed; top: 0; left: var(--sidebar-w);
            right: 0; z-index: 100;
            display: flex; align-items: center; padding: 0 24px; gap: 14px;
        }
        .topbar-title { font-family: 'Barlow Condensed', sans-serif; font-size: 20px; font-weight: 700; flex: 1; }
        .topbar-search {
            display: flex; align-items: center; gap: 8px;
            background: var(--gym-surface2); border: 1px solid var(--gym-border);
            border-radius: 8px; padding: 7px 12px; width: 220px;
        }
        .topbar-search i { color: var(--gym-muted); font-size: 14px; }
        .topbar-search input {
            background: none; border: none; outline: none; color: var(--gym-text);
            font-size: 13px; width: 100%; font-family: 'Barlow', sans-serif;
        }
        .topbar-search input::placeholder { color: var(--gym-muted); }
        #sidebar-toggle { display: none; }

        /* ── MAIN CONTENT ── */
        #main-content {
            margin-left: var(--sidebar-w);
            padding-top: var(--topbar-h);
            min-height: 100vh;
        }
        .page-content { padding: 28px; }

        /* ── CARDS ── */
        .gym-card {
            background: var(--gym-surface); border: 1px solid var(--gym-border);
            border-radius: 12px; overflow: hidden;
        }
        .gym-card-header {
            padding: 16px 20px; border-bottom: 1px solid var(--gym-border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .gym-card-title { font-family: 'Barlow Condensed', sans-serif; font-size: 17px; font-weight: 700; margin: 0; }
        .gym-card-subtitle { font-size: 11px; color: var(--gym-muted); text-transform: uppercase; letter-spacing: .8px; font-weight: 600; margin: 0; }
        .gym-card-body { padding: 20px; }

        /* ── STAT CARDS ── */
        .stat-card {
            background: var(--gym-surface); border: 1px solid var(--gym-border);
            border-radius: 12px; padding: 20px; position: relative; overflow: hidden;
        }
        .stat-icon { width: 38px; height: 38px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; font-size: 17px; }
        .stat-icon.accent { background: rgba(200,241,53,.15); color: var(--gym-accent); }
        .stat-icon.green  { background: rgba(54,211,153,.15); color: #36d399; }
        .stat-icon.blue   { background: rgba(96,165,250,.15); color: #60a5fa; }
        .stat-icon.red    { background: rgba(248,113,113,.15); color: #f87171; }
        .stat-value { font-family: 'Barlow Condensed', sans-serif; font-size: 34px; font-weight: 700; line-height: 1; margin-bottom: 4px; }
        .stat-label { font-size: 11px; color: var(--gym-muted); text-transform: uppercase; letter-spacing: .8px; font-weight: 600; }

        /* ── TABLES ── */
        .gym-table { width: 100%; border-collapse: collapse; }
        .gym-table thead th {
            font-size: 10px; font-weight: 700; color: var(--gym-muted);
            text-transform: uppercase; letter-spacing: 1px;
            padding: 10px 16px; border-bottom: 1px solid var(--gym-border); white-space: nowrap;
        }
        .gym-table tbody td { padding: 13px 16px; font-size: 13px; border-bottom: 1px solid var(--gym-border); vertical-align: middle; color: var(--gym-text); }
        .gym-table tbody tr:last-child td { border-bottom: none; }
        .gym-table tbody tr:hover td { background: var(--gym-surface2); }

        /* ── BADGES ── */
        .gym-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .badge-success { background: rgba(54,211,153,.15); color: #36d399; }
        .badge-danger  { background: rgba(248,113,113,.15); color: #f87171; }
        .badge-warning { background: rgba(251,191,36,.15);  color: #fbbf24; }
        .badge-info    { background: rgba(96,165,250,.15);  color: #60a5fa; }
        .badge-accent  { background: rgba(200,241,53,.15);  color: var(--gym-accent); }

        /* ── BUTTONS ── */
        .btn-gym-primary { background: var(--gym-accent); color: #0d0f12; border: none; font-weight: 700; font-family: 'Barlow', sans-serif; }
        .btn-gym-primary:hover { background: var(--gym-accent2); color: #0d0f12; }
        .btn-gym-ghost { background: var(--gym-surface2); color: var(--gym-muted); border: 1px solid var(--gym-border); font-family: 'Barlow', sans-serif; }
        .btn-gym-ghost:hover { border-color: #4a5563; color: var(--gym-text); }
        .btn-gym-danger { background: rgba(248,113,113,.12); color: #f87171; border: 1px solid rgba(248,113,113,.25); font-family: 'Barlow', sans-serif; }
        .btn-gym-danger:hover { background: rgba(248,113,113,.22); }

        /* ── FORMS ── */
        .gym-form-label { font-size: 11px; font-weight: 700; color: var(--gym-muted); text-transform: uppercase; letter-spacing: .8px; margin-bottom: 5px; }
        .gym-input {
            background: var(--gym-surface2) !important; border: 1px solid var(--gym-border) !important;
            border-radius: 8px !important; color: var(--gym-text) !important;
            font-family: 'Barlow', sans-serif; font-size: 14px;
        }
        .gym-input:focus { border-color: var(--gym-accent) !important; box-shadow: 0 0 0 3px rgba(200,241,53,.12) !important; outline: none; }
        .gym-input option { background: var(--gym-surface2); }
        .aluno-autocomplete { position: relative; }
        .aluno-autocomplete-list {
            display: none; position: absolute; top: calc(100% + 4px); left: 0; right: 0;
            z-index: 1060; max-height: 190px; overflow-y: auto;
            background: var(--gym-surface2); border: 1px solid var(--gym-border);
            border-radius: 8px; box-shadow: 0 10px 24px rgba(0,0,0,.3);
        }
        .aluno-autocomplete-list.show { display: block; }
        .aluno-autocomplete-item {
            width: 100%; padding: 9px 12px; border: 0; border-bottom: 1px solid var(--gym-border);
            background: transparent; color: var(--gym-text); text-align: left; font-size: 13px;
        }
        .aluno-autocomplete-item:last-child { border-bottom: 0; }
        .aluno-autocomplete-item:hover, .aluno-autocomplete-item:focus { background: rgba(200,241,53,.1); color: var(--gym-accent); outline: none; }
        .aluno-autocomplete-empty { padding: 9px 12px; color: var(--gym-muted); font-size: 13px; }

        /* ── MODALS ── */
        .gym-modal .modal-content { background: var(--gym-surface); border: 1px solid var(--gym-border); border-radius: 14px; color: var(--gym-text); }
        .gym-modal .modal-header { border-bottom: 1px solid var(--gym-border); padding: 18px 22px; }
        .gym-modal .modal-title { font-family: 'Barlow Condensed', sans-serif; font-size: 20px; font-weight: 700; }
        .gym-modal .modal-footer { border-top: 1px solid var(--gym-border); padding: 14px 22px; }
        .gym-modal .btn-close { filter: invert(1) brightness(.6); }

        /* ── TOAST ── */
        .toast-container { z-index: 9999; }
        .gym-toast { background: var(--gym-surface); border: 1px solid var(--gym-border); color: var(--gym-text); border-radius: 10px; min-width: 240px; }

        /* ── PLAN CARDS ── */
        .plan-card { background: var(--gym-surface2); border: 1px solid var(--gym-border); border-radius: 12px; padding: 20px; height: 100%; }
        .plan-card.featured { border-color: var(--gym-accent); background: rgba(200,241,53,.06); }
        .plan-price { font-family: 'Barlow Condensed', sans-serif; font-size: 32px; font-weight: 700; color: var(--gym-accent); }

        /* ── EMPTY STATE ── */
        .empty-state { padding: 48px; text-align: center; color: var(--gym-muted); }
        .empty-state i { font-size: 36px; display: block; margin-bottom: 12px; }

        /* ── MOBILE ── */
        @media (max-width: 991px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
            #topbar { left: 0; }
            #main-content { margin-left: 0; }
            #sidebar-toggle { display: flex; }
            .topbar-search { display: none; }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<nav id="sidebar">
    <a href="{{ url('/') }}" class="sidebar-logo">
        <div class="logo-icon"><i class="bi bi-lightning-fill"></i></div>
        <span class="logo-name">Gym<span>Control</span></span>
    </a>

    @auth
        <div class="academy-box">
            <div class="academy-label">Academia</div>
            <div class="academy-name">{{ auth()->user()->academia->nome ?? 'Academia sem nome' }}</div>
        </div>
    @endauth

    <div class="overflow-auto flex-grow-1">
        <div class="sidebar-section">Principal</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('admin.matriculas.index') }}" class="sidebar-link {{ request()->routeIs('admin.matriculas*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Alunos / Matrículas
            <span class="sidebar-badge" id="badge-matriculas">—</span>
        </a>

        <div class="sidebar-section">Treinos</div>
        <a href="{{ route('admin.treinos.index') }}" class="sidebar-link {{ request()->routeIs('admin.treinos*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-check-fill"></i> Treinos
        </a>
        <a href="{{ route('admin.progresso.index') }}" class="sidebar-link {{ request()->routeIs('admin.progresso*') ? 'active' : '' }}">
            <i class="bi bi-graph-up-arrow"></i> Progresso
        </a>

        <div class="sidebar-section">Financeiro</div>
        <a href="{{ route('admin.planos.index') }}" class="sidebar-link {{ request()->routeIs('admin.planos*') ? 'active' : '' }}">
            <i class="bi bi-tag-fill"></i> Planos
        </a>
        <a href="{{ route('admin.frequencias.index') }}" class="sidebar-link {{ request()->routeIs('admin.frequencias*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check-fill"></i> Frequências
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}</div>
        <div>
            <div class="user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
            <div class="user-role">{{ ucfirst(auth()->user()->tipo ?? 'Administrador') }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="ms-auto">
            @csrf
            <button type="submit" class="btn btn-gym-ghost btn-sm logout-button" title="Sair">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </form>
    </div>
</nav>

{{-- TOPBAR --}}
<header id="topbar">
    <button id="sidebar-toggle" class="btn btn-gym-ghost btn-sm me-2" onclick="document.getElementById('sidebar').classList.toggle('open')">
        <i class="bi bi-list fs-5"></i>
    </button>
    <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
    @auth
        <span class="gym-badge badge-accent d-none d-md-inline-flex">
            <i class="bi bi-building"></i> {{ auth()->user()->academia->nome ?? 'Academia' }}
        </span>
    @endauth
    <div class="topbar-search">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Buscar..." id="global-search">
    </div>
    <button class="btn btn-gym-ghost btn-sm" onclick="window.location.reload()">
        <i class="bi bi-arrow-clockwise"></i>
    </button>
    @yield('topbar-action')
</header>

{{-- OVERLAY MOBILE --}}
<div id="sidebar-overlay" style="display:none;position:fixed;inset:0;z-index:199;background:rgba(0,0,0,.6)"
     onclick="document.getElementById('sidebar').classList.remove('open');this.style.display='none'"></div>

{{-- MAIN --}}
<main id="main-content">
    <div class="page-content">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" style="background:rgba(54,211,153,.1);border:1px solid rgba(54,211,153,.3);color:#36d399;border-radius:10px">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter:invert(1) brightness(.6)"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3" style="background:rgba(248,113,113,.1);border:1px solid rgba(248,113,113,.3);color:#f87171;border-radius:10px">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter:invert(1) brightness(.6)"></button>
            </div>
        @endif

        @yield('content')
    </div>
</main>

{{-- TOAST CONTAINER --}}
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="gym-toast" class="toast gym-toast align-items-center" role="alert">
        <div class="d-flex">
            <div class="toast-body" id="gym-toast-body">Mensagem</div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" style="filter:invert(1) brightness(.6)"></button>
        </div>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let alunosMatriculados = [];

    async function loadAlunosAutocomplete() {
        alunosMatriculados = await fetch('/api/alunos-matriculados').then(r => r.json()).catch(() => []);
        document.querySelectorAll('[data-aluno-autocomplete]').forEach(renderAlunoAutocomplete);
    }

    function normalizarTexto(texto) {
        return texto.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
    }

    function renderAlunoAutocomplete(input) {
        const list = input.parentElement.querySelector('.aluno-autocomplete-list');
        if (!list) return;

        const termo = normalizarTexto(input.value);
        const matches = alunosMatriculados.filter(aluno => normalizarTexto(aluno.name).includes(termo));
        list.innerHTML = '';

        if (!matches.length) {
            const empty = document.createElement('div');
            empty.className = 'aluno-autocomplete-empty';
            empty.textContent = 'Nenhum aluno encontrado';
            list.appendChild(empty);
        }

        matches.forEach(aluno => {
            const option = document.createElement('button');
            option.type = 'button';
            option.className = 'aluno-autocomplete-item';
            option.textContent = aluno.name;
            option.addEventListener('mousedown', event => {
                event.preventDefault();
                input.value = aluno.name;
                list.classList.remove('show');
            });
            list.appendChild(option);
        });

        list.classList.add('show');
    }

    function alunoIdPorNome(inputId) {
        const nome = normalizarTexto(document.getElementById(inputId).value);
        const aluno = alunosMatriculados.find(item => normalizarTexto(item.name) === nome);
        if (!aluno) showToast('Selecione um aluno matriculado pelo nome.', 'error');
        return aluno ? aluno.id : null;
    }

    document.querySelectorAll('[data-aluno-autocomplete]').forEach(input => {
        input.addEventListener('focus', () => renderAlunoAutocomplete(input));
        input.addEventListener('input', () => renderAlunoAutocomplete(input));
        input.addEventListener('blur', () => setTimeout(() => input.parentElement.querySelector('.aluno-autocomplete-list')?.classList.remove('show'), 100));
    });

    // Mobile sidebar overlay
    document.getElementById('sidebar-toggle')?.addEventListener('click', () => {
        const open = document.getElementById('sidebar').classList.contains('open');
        document.getElementById('sidebar-overlay').style.display = open ? 'block' : 'none';
    });

    // Global search
    document.getElementById('global-search')?.addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });

    // Toast helper
    function showToast(msg, type = 'success') {
        const el = document.getElementById('gym-toast');
        const body = document.getElementById('gym-toast-body');
        const icon = type === 'success' ? '✅' : '❌';
        body.innerHTML = `${icon} ${msg}`;
        el.style.borderColor = type === 'success' ? 'rgba(54,211,153,.4)' : 'rgba(248,113,113,.4)';
        new bootstrap.Toast(el, { delay: 3000 }).show();
    }

    // Load badge
    fetch('/api/matriculas').then(r => r.json()).then(data => {
        const ativos = data.filter ? data.filter(m => m.status === 'ativo').length : data.length;
        document.getElementById('badge-matriculas').textContent = ativos || data.length || 0;
    }).catch(() => { document.getElementById('badge-matriculas').textContent = ''; });

    loadAlunosAutocomplete();
</script>

@stack('scripts')
</body>
</html>
