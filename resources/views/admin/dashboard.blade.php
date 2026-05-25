@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('topbar-action')
    <button class="btn btn-gym-primary btn-sm" onclick="loadDashboard()">
        <i class="bi bi-arrow-clockwise"></i> Atualizar
    </button>
@endsection

@section('content')
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon accent"><i class="bi bi-people-fill"></i></div>
            <div class="stat-value" id="stat-alunos">—</div>
            <div class="stat-label">Matrículas Ativas</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-clipboard-check-fill"></i></div>
            <div class="stat-value" id="stat-treinos">—</div>
            <div class="stat-label">Treinos</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-activity"></i></div>
            <div class="stat-value" id="stat-exercicios">—</div>
            <div class="stat-label">Exercícios</div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon red"><i class="bi bi-tag-fill"></i></div>
            <div class="stat-value" id="stat-planos">—</div>
            <div class="stat-label">Planos</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="gym-card">
            <div class="gym-card-header">
                <div>
                    <div class="gym-card-title">Matrículas Recentes</div>
                    <div class="gym-card-subtitle">Últimas registradas</div>
                </div>
                <a href="{{ route('admin.matriculas.index') }}" class="btn btn-gym-ghost btn-sm">Ver todas</a>
            </div>
            <div class="table-responsive">
                <table class="gym-table">
                    <thead><tr><th>Aluno</th><th>Plano</th><th>Início</th><th>Status</th></tr></thead>
                    <tbody id="dash-matriculas">
                        <tr><td colspan="4" class="text-center py-4" style="color:var(--gym-muted)">Carregando...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="gym-card h-100">
            <div class="gym-card-header">
                <div class="gym-card-title">Frequência Semanal</div>
            </div>
            <div class="gym-card-body">
                <div class="d-flex align-items-flex-end gap-2" style="height:100px;align-items:flex-end">
                    @foreach(['Seg','Ter','Qua','Qui','Sex','Sáb','Dom'] as $i => $dia)
                        <div class="d-flex flex-column align-items-center flex-fill gap-1">
                            <div class="freq-bar-js flex-fill w-100" data-day="{{ $i }}"
                                style="background:var(--gym-border);border-radius:3px 3px 0 0;min-height:4px;transition:height .3s"></div>
                            <span style="font-size:9px;color:var(--gym-muted);font-weight:700">{{ $dia }}</span>
                        </div>
                    @endforeach
                </div>
                <hr style="border-color:var(--gym-border)">
                <div style="font-size:11px;color:var(--gym-muted);text-transform:uppercase;letter-spacing:.8px;font-weight:700">Total de Frequências</div>
                <div style="font-family:'Barlow Condensed',sans-serif;font-size:32px;font-weight:800" id="dash-freq-total">—</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="gym-card">
            <div class="gym-card-header">
                <div class="gym-card-title">Exercícios Recentes</div>
                <a href="{{ route('admin.exercicios.index') }}" class="btn btn-gym-ghost btn-sm">Ver todos</a>
            </div>
            <div class="gym-card-body" id="dash-exercicios">
                <div style="color:var(--gym-muted);font-size:13px">Carregando...</div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="gym-card">
            <div class="gym-card-header">
                <div class="gym-card-title">Progresso dos Alunos</div>
                <a href="{{ route('admin.progresso.index') }}" class="btn btn-gym-ghost btn-sm">Ver tudo</a>
            </div>
            <div class="gym-card-body" id="dash-progresso">
                <div style="color:var(--gym-muted);font-size:13px">Carregando...</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function fmtDate(d) { if (!d) return '—'; try { return new Date(d).toLocaleDateString('pt-BR'); } catch { return d; } }
function statusBadge(s) {
    const m = { ativo:'success',active:'success',inativo:'danger',inactive:'danger',suspenso:'warning' };
    return `<span class="gym-badge badge-${m[s]||'info'}">${s||'—'}</span>`;
}
async function loadDashboard() {
    const api = (path) => fetch('/api' + path).then(r => r.json()).catch(() => []);
    const [matriculas, treinos, exercicios, planos, frequencias, progresso] = await Promise.all([
        api('/matriculas'), api('/treinos'), api('/exercicios'), api('/planos'), api('/frequencias'), api('/progresso')
    ]);
    if (Array.isArray(matriculas)) {
        document.getElementById('stat-alunos').textContent = matriculas.filter(m => m.status === 'ativo').length || matriculas.length;
        document.getElementById('dash-matriculas').innerHTML = matriculas.slice(0,5).map(m => `
            <tr>
                <td><strong>${m.user ? m.user.name : 'Aluno #'+m.user_id}</strong></td>
                <td style="color:var(--gym-muted)">${m.plano ? m.plano.nome : '#'+m.plano_id}</td>
                <td style="color:var(--gym-muted)">${fmtDate(m.data_inicio)}</td>
                <td>${statusBadge(m.status)}</td>
            </tr>`).join('') || '<tr><td colspan="4" class="text-center py-3" style="color:var(--gym-muted)">Nenhuma matrícula</td></tr>';
    }
    if (Array.isArray(treinos)) document.getElementById('stat-treinos').textContent = treinos.length;
    if (Array.isArray(exercicios)) {
        document.getElementById('stat-exercicios').textContent = exercicios.length;
        const colors = ['var(--gym-accent)','#36d399','#60a5fa','#fbbf24','#f87171'];
        document.getElementById('dash-exercicios').innerHTML = exercicios.slice(0,5).map((e,i) => `
            <div class="d-flex align-items-center gap-3 py-2 border-bottom" style="border-color:var(--gym-border)!important">
                <div style="width:8px;height:8px;border-radius:50%;background:${colors[i%colors.length]};flex-shrink:0"></div>
                <div class="flex-grow-1">
                    <div style="font-size:13px;font-weight:600">${e.nome}</div>
                    <div style="font-size:11px;color:var(--gym-muted)">${e.grupo_muscular||'—'}</div>
                </div>
                <span style="font-size:11px;background:var(--gym-surface2);border:1px solid var(--gym-border);padding:2px 10px;border-radius:20px;color:var(--gym-muted)">${e.equipamento||'—'}</span>
            </div>`).join('') || '<div class="empty-state"><i class="bi bi-activity"></i><p>Nenhum exercício</p></div>';
    }
    if (Array.isArray(planos)) document.getElementById('stat-planos').textContent = planos.length;
    if (Array.isArray(frequencias)) {
        document.getElementById('dash-freq-total').textContent = frequencias.length;
        const bars = document.querySelectorAll('.freq-bar-js');
        const max = Math.max(10, frequencias.length);
        bars.forEach((b, i) => {
            const pct = Math.max(8, Math.min(100, Math.round((frequencias.length / 7) * (1 - i * 0.08) / max * 700)));
            b.style.height = pct + '%';
            b.style.background = i < 5 ? 'var(--gym-accent)' : 'var(--gym-border)';
        });
    }
    if (Array.isArray(progresso)) {
        document.getElementById('dash-progresso').innerHTML = progresso.slice(0,4).map(p => {
            const pct = Math.min(100, Math.round((p.massa_muscular_kg||0) * 2));
            return `<div class="d-flex align-items-center gap-3 mb-3">
                <div style="font-size:12px;color:var(--gym-muted);width:110px;flex-shrink:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">${p.aluno ? p.aluno.name : 'Aluno #'+p.user_id}</div>
                <div class="flex-grow-1"><div style="height:4px;background:var(--gym-border);border-radius:4px"><div style="height:100%;width:${pct}%;background:var(--gym-accent);border-radius:4px"></div></div></div>
                <div style="font-size:12px;font-weight:600;width:45px;text-align:right">${p.peso_kg||'—'}kg</div>
            </div>`;
        }).join('') || '<div class="empty-state"><i class="bi bi-graph-up-arrow"></i><p>Sem registros</p></div>';
    }
}
loadDashboard();
</script>
@endpush
