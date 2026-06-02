<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymControl — A Academia que Evolui com Você</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --dark: #0d0f12;
            --surface: #161a1f;
            --border: #2a323c;
            --accent: #c8f135;
            --accent2: #a8d020;
            --text: #e8ecf0;
            --muted: #7a8794;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { background: var(--dark); color: var(--text); font-family: 'Barlow', sans-serif; }

        /* ── NAVBAR ── */
        .gym-nav {
            background: rgba(13,15,18,.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 14px 0;
            position: sticky; top: 0; z-index: 100;
        }
        .nav-logo { font-family: 'Barlow Condensed', sans-serif; font-size: 24px; font-weight: 800; color: var(--text); text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .nav-logo-icon { width: 34px; height: 34px; background: var(--accent); border-radius: 7px; display: flex; align-items: center; justify-content: center; }
        .nav-logo-icon i { color: #0d0f12; font-size: 16px; }
        .nav-logo span { color: var(--accent); }
        .nav-link-gym { color: var(--muted) !important; font-size: 14px; font-weight: 500; padding: 6px 14px !important; transition: color .15s; }
        .nav-link-gym:hover { color: var(--text) !important; }
        .btn-nav-admin { background: var(--accent); color: #0d0f12; font-weight: 700; border: none; padding: 8px 20px; border-radius: 8px; font-family: 'Barlow', sans-serif; font-size: 14px; text-decoration: none; transition: background .15s; }
        .btn-nav-admin:hover { background: var(--accent2); color: #0d0f12; }
        .navbar-toggler { border-color: var(--border); }
        .navbar-toggler-icon { filter: invert(.6); }

        /* ── HERO ── */
        .hero {
            min-height: 90vh; display: flex; align-items: center;
            position: relative; overflow: hidden;
            background: linear-gradient(135deg, #0d0f12 0%, #141820 50%, #0a1008 100%);
        }
        .hero-grid {
            position: absolute; inset: 0;
            background-image: linear-gradient(var(--border) 1px, transparent 1px), linear-gradient(90deg, var(--border) 1px, transparent 1px);
            background-size: 60px 60px; opacity: .3;
        }
        .hero-glow {
            position: absolute; width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(200,241,53,.12) 0%, transparent 70%);
            top: -100px; right: -100px; pointer-events: none;
        }
        .hero-tag {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(200,241,53,.1); border: 1px solid rgba(200,241,53,.3);
            color: var(--accent); font-size: 12px; font-weight: 700;
            padding: 6px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px;
            margin-bottom: 20px;
        }
        .hero h1 {
            font-family: 'Barlow Condensed', sans-serif; font-size: clamp(52px, 8vw, 96px);
            font-weight: 800; line-height: .95; margin-bottom: 24px;
        }
        .hero h1 span { color: var(--accent); }
        .hero-desc { font-size: 18px; color: var(--muted); max-width: 520px; line-height: 1.7; margin-bottom: 36px; }
        .btn-hero-primary { background: var(--accent); color: #0d0f12; font-weight: 700; border: none; padding: 14px 32px; border-radius: 10px; font-size: 16px; font-family: 'Barlow', sans-serif; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: background .15s, transform .1s; }
        .btn-hero-primary:hover { background: var(--accent2); color: #0d0f12; transform: translateY(-2px); }
        .btn-hero-ghost { background: transparent; color: var(--text); font-weight: 600; border: 1px solid var(--border); padding: 14px 28px; border-radius: 10px; font-size: 16px; font-family: 'Barlow', sans-serif; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: border-color .15s, transform .1s; }
        .btn-hero-ghost:hover { border-color: var(--muted); color: var(--text); transform: translateY(-2px); }
        .hero-stats { display: flex; gap: 36px; margin-top: 48px; }
        .hero-stat-num { font-family: 'Barlow Condensed', sans-serif; font-size: 36px; font-weight: 800; color: var(--accent); line-height: 1; }
        .hero-stat-label { font-size: 12px; color: var(--muted); text-transform: uppercase; letter-spacing: .8px; font-weight: 600; }

        /* ── SECTION ── */
        .section { padding: 96px 0; }
        .section-tag { display: inline-block; background: rgba(200,241,53,.1); border: 1px solid rgba(200,241,53,.3); color: var(--accent); font-size: 11px; font-weight: 700; padding: 5px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1.2px; margin-bottom: 16px; }
        .section-title { font-family: 'Barlow Condensed', sans-serif; font-size: clamp(36px, 5vw, 56px); font-weight: 800; line-height: 1.05; margin-bottom: 16px; }
        .section-title span { color: var(--accent); }
        .section-desc { font-size: 17px; color: var(--muted); line-height: 1.7; max-width: 540px; }

        /* ── FEATURES ── */
        .features-bg { background: var(--surface); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }
        .feature-card { background: var(--dark); border: 1px solid var(--border); border-radius: 12px; padding: 28px; height: 100%; transition: border-color .2s, transform .2s; }
        .feature-card:hover { border-color: rgba(200,241,53,.4); transform: translateY(-4px); }
        .feature-icon { width: 48px; height: 48px; border-radius: 10px; background: rgba(200,241,53,.1); display: flex; align-items: center; justify-content: center; margin-bottom: 18px; }
        .feature-icon i { color: var(--accent); font-size: 22px; }
        .feature-title { font-family: 'Barlow Condensed', sans-serif; font-size: 20px; font-weight: 700; margin-bottom: 10px; }
        .feature-desc { font-size: 14px; color: var(--muted); line-height: 1.65; }

        /* ── PLANS ── */
        .plan-card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 32px; height: 100%; position: relative; transition: transform .2s; }
        .plan-card:hover { transform: translateY(-4px); }
        .plan-card.featured { border-color: var(--accent); background: rgba(200,241,53,.04); }
        .plan-badge-top { position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: var(--accent); color: #0d0f12; font-size: 11px; font-weight: 800; padding: 4px 16px; border-radius: 20px; text-transform: uppercase; letter-spacing: .8px; white-space: nowrap; }
        .plan-name { font-family: 'Barlow Condensed', sans-serif; font-size: 24px; font-weight: 800; margin-bottom: 8px; }
        .plan-price { font-family: 'Barlow Condensed', sans-serif; font-size: 52px; font-weight: 800; color: var(--accent); line-height: 1; }
        .plan-price small { font-size: 16px; color: var(--muted); font-weight: 400; }
        .plan-duration { font-size: 13px; color: var(--muted); margin-top: 4px; }
        .plan-divider { border-color: var(--border); margin: 20px 0; }
        .plan-feature { display: flex; align-items: center; gap: 10px; font-size: 14px; margin-bottom: 10px; }
        .plan-feature i { color: var(--accent); font-size: 15px; }
        .btn-plan { width: 100%; padding: 12px; border-radius: 10px; font-weight: 700; font-size: 15px; font-family: 'Barlow', sans-serif; margin-top: 20px; border: none; transition: all .15s; }
        .btn-plan-primary { background: var(--accent); color: #0d0f12; }
        .btn-plan-primary:hover { background: var(--accent2); }
        .btn-plan-outline { background: transparent; color: var(--text); border: 1px solid var(--border) !important; }
        .btn-plan-outline:hover { border-color: var(--muted) !important; }

        /* ── CTA ── */
        .cta-section { background: linear-gradient(135deg, rgba(200,241,53,.08) 0%, rgba(200,241,53,.02) 100%); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 96px 0; text-align: center; }

        /* ── FOOTER ── */
        footer { background: var(--surface); border-top: 1px solid var(--border); padding: 40px 0; }
        .footer-logo { font-family: 'Barlow Condensed', sans-serif; font-size: 22px; font-weight: 800; color: var(--text); }
        .footer-logo span { color: var(--accent); }
        .footer-desc { font-size: 13px; color: var(--muted); margin-top: 8px; max-width: 260px; }
        .footer-link { color: var(--muted); font-size: 13px; text-decoration: none; display: block; margin-bottom: 8px; transition: color .15s; }
        .footer-link:hover { color: var(--text); }
        .footer-heading { font-size: 11px; font-weight: 700; color: var(--text); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 14px; }
        .footer-bottom { margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border); font-size: 12px; color: var(--muted); }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="gym-nav">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ url('/') }}" class="nav-logo">
                <div class="nav-logo-icon"><i class="bi bi-lightning-fill"></i></div>
                Gym<span>Control</span>
            </a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-lg-flex align-items-center gap-2 justify-content-end" id="navMenu">
                <a href="#recursos" class="nav-link-gym nav-link">Recursos</a>
                <a href="#planos" class="nav-link-gym nav-link">Planos</a>
                <a href="#contato" class="nav-link-gym nav-link">Contato</a>
                <a href="{{ route('admin.dashboard') }}" class="btn-nav-admin ms-2">
                    <i class="bi bi-grid-fill"></i> Painel Admin
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="hero-grid"></div>
    <div class="hero-glow"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero-tag">
                    <i class="bi bi-lightning-fill"></i> Sistema Completo de Gestão
                </div>
                <h1>
                    GERENCIE SUA<br>
                    <span>ACADEMIA</span><br>
                    SEM ESFORÇO
                </h1>
                <p class="hero-desc">
                    Controle alunos, treinos, matrículas, progresso e frequência em um único painel. Tudo integrado, simples e rápido.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="btn-hero-primary">
                        <i class="bi bi-grid-fill"></i> Acessar Painel
                    </a>
                    <a href="#recursos" class="btn-hero-ghost">
                        <i class="bi bi-play-circle"></i> Ver Recursos
                    </a>
                </div>
                <div class="hero-stats">
                    <div>
                        <div class="hero-stat-num">5</div>
                        <div class="hero-stat-label">Módulos</div>
                    </div>
                    <div style="width:1px;background:var(--border)"></div>
                    <div>
                        <div class="hero-stat-num">100%</div>
                        <div class="hero-stat-label">REST API</div>
                    </div>
                    <div style="width:1px;background:var(--border)"></div>
                    <div>
                        <div class="hero-stat-num">∞</div>
                        <div class="hero-stat-label">Alunos</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-flex justify-content-end">
                {{-- MINI DASHBOARD PREVIEW --}}
                <div style="background:var(--surface);border:1px solid var(--border);border-radius:16px;padding:20px;width:340px;transform:rotate(2deg)">
                    <div style="display:flex;gap:8px;margin-bottom:16px">
                        <div style="width:10px;height:10px;border-radius:50%;background:#f87171"></div>
                        <div style="width:10px;height:10px;border-radius:50%;background:#fbbf24"></div>
                        <div style="width:10px;height:10px;border-radius:50%;background:#36d399"></div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px">
                        <div style="background:var(--dark);border:1px solid var(--border);border-radius:10px;padding:14px">
                            <div style="font-size:10px;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px">Alunos</div>
                            <div style="font-family:'Barlow Condensed',sans-serif;font-size:28px;font-weight:800;color:var(--accent)">128</div>
                        </div>
                        <div style="background:var(--dark);border:1px solid var(--border);border-radius:10px;padding:14px">
                            <div style="font-size:10px;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px">Treinos</div>
                            <div style="font-family:'Barlow Condensed',sans-serif;font-size:28px;font-weight:800;color:#60a5fa">47</div>
                        </div>
                    </div>
                    <div style="background:var(--dark);border:1px solid var(--border);border-radius:10px;padding:14px;margin-bottom:10px">
                        <div style="font-size:11px;color:var(--muted);margin-bottom:10px">Frequência Semanal</div>
                        <div style="display:flex;align-items:flex-end;gap:6px;height:50px">
                            @foreach([70,90,55,80,60,40,20] as $h)
                                <div style="flex:1;height:{{ $h }}%;background:{{ $h > 60 ? 'var(--accent)' : 'var(--border)' }};border-radius:3px 3px 0 0"></div>
                            @endforeach
                        </div>
                    </div>
                    <div style="background:rgba(200,241,53,.08);border:1px solid rgba(200,241,53,.2);border-radius:8px;padding:10px;font-size:12px;color:var(--accent)">
                        <i class="bi bi-check-circle-fill me-1"></i> 5 matrículas hoje
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FEATURES --}}
<section class="section features-bg" id="recursos">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-tag">Recursos</div>
            <h2 class="section-title">TUDO QUE SUA <span>ACADEMIA</span> PRECISA</h2>
            <p class="section-desc mx-auto">Sistema completo para gerenciar todos os aspectos da sua academia em um só lugar.</p>
        </div>
        <div class="row g-4">
            @php
                $features = [
                    ['bi-people-fill','Gestão de Alunos','Cadastre e gerencie todos os alunos com suas matrículas, planos e histórico completo.'],
                    ['bi-clipboard-check-fill','Treinos Personalizados','Monte treinos específicos para cada aluno com objetivos bem definidos.'],
                    ['bi-graph-up-arrow','Acompanhamento de Progresso','Registre peso, gordura corporal e massa muscular para acompanhar a evolução do aluno.'],
                    ['bi-tag-fill','Planos Flexíveis','Crie planos com preços e durações personalizadas para diferentes perfis de alunos.'],
                    ['bi-calendar-check-fill','Controle de Frequência','Registre e visualize a frequência dos alunos com histórico completo de presença.'],
                ];
            @endphp
            @foreach($features as $f)
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi {{ $f[0] }}"></i></div>
                        <div class="feature-title">{{ $f[1] }}</div>
                        <div class="feature-desc">{{ $f[2] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PLANS --}}
<section class="section" id="planos">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-tag">Planos</div>
            <h2 class="section-title">PLANOS DE <span>EXEMPLO</span></h2>
            <p class="section-desc mx-auto">Configure os planos da sua academia diretamente pelo painel administrativo.</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="plan-card">
                    <div class="plan-name">Mensal</div>
                    <div class="plan-price">R$ 99<small>/mês</small></div>
                    <div class="plan-duration">30 dias de acesso</div>
                    <hr class="plan-divider">
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Acesso à academia</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Avaliação física</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Treino personalizado</div>
                    <div class="plan-feature" style="color:var(--muted)"><i class="bi bi-x-circle" style="color:var(--muted)"></i> Aulas coletivas</div>
                    <a href="{{ route('admin.planos.index') }}" class="btn btn-plan btn-plan-outline">Gerenciar Planos</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="plan-card featured">
                    <div class="plan-badge-top">Mais Popular</div>
                    <div class="plan-name">Trimestral</div>
                    <div class="plan-price">R$ 249<small>/trim.</small></div>
                    <div class="plan-duration">90 dias de acesso</div>
                    <hr class="plan-divider">
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Acesso à academia</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Avaliação física</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Treino personalizado</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Aulas coletivas</div>
                    <a href="{{ route('admin.planos.index') }}" class="btn btn-plan btn-plan-primary">Gerenciar Planos</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="plan-card">
                    <div class="plan-name">Anual</div>
                    <div class="plan-price">R$ 799<small>/ano</small></div>
                    <div class="plan-duration">365 dias de acesso</div>
                    <hr class="plan-divider">
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Acesso à academia</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Avaliação física mensal</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Treino personalizado</div>
                    <div class="plan-feature"><i class="bi bi-check-circle-fill"></i> Aulas coletivas</div>
                    <a href="{{ route('admin.planos.index') }}" class="btn btn-plan btn-plan-outline">Gerenciar Planos</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section" id="contato">
    <div class="container">
        <div class="section-tag">Comece agora</div>
        <h2 class="section-title">PRONTO PARA <span>GERENCIAR</span><br>SUA ACADEMIA?</h2>
        <p class="section-desc mx-auto mb-4" style="text-align:center">Acesse o painel administrativo e comece a cadastrar seus alunos, planos e treinos agora mesmo.</p>
        <a href="{{ route('admin.dashboard') }}" class="btn-hero-primary">
            <i class="bi bi-grid-fill"></i> Acessar o Painel Admin
        </a>
    </div>
</section>

{{-- FOOTER --}}
<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="footer-logo">Gym<span>Control</span></div>
                <p class="footer-desc">Sistema completo de gestão para academias. Simples, rápido e eficiente.</p>
            </div>
            <div class="col-6 col-lg-2">
                <div class="footer-heading">Sistema</div>
                <a href="{{ route('admin.dashboard') }}" class="footer-link">Dashboard</a>
                <a href="{{ route('admin.matriculas.index') }}" class="footer-link">Alunos</a>
                <a href="{{ route('admin.treinos.index') }}" class="footer-link">Treinos</a>
                <a href="{{ route('admin.planos.index') }}" class="footer-link">Planos</a>
            </div>
            <div class="col-6 col-lg-2">
                <div class="footer-heading">Admin</div>
                <a href="{{ route('admin.progresso.index') }}" class="footer-link">Progresso</a>
                <a href="{{ route('admin.frequencias.index') }}" class="footer-link">Frequências</a>
            </div>
        </div>
        <div class="footer-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span>© {{ date('Y') }} GymControl. Todos os direitos reservados.</span>
            <span>Desenvolvido com Laravel + Bootstrap 5</span>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
