@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('topbar-action')
<button class="btn btn-gym-primary btn-sm" onclick="loadDashboard()"><i class="bi bi-arrow-clockwise"></i> Atualizar</button>
@endsection
@section('content')
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-4"><div class="stat-card"><div class="stat-icon accent"><i class="bi bi-people-fill"></i></div><div class="stat-value" id="stat-alunos">-</div><div class="stat-label">Matriculas Ativas</div></div></div>
    <div class="col-6 col-xl-4"><div class="stat-card"><div class="stat-icon green"><i class="bi bi-clipboard-check-fill"></i></div><div class="stat-value" id="stat-treinos">-</div><div class="stat-label">Treinos</div></div></div>
    <div class="col-6 col-xl-4"><div class="stat-card"><div class="stat-icon red"><i class="bi bi-tag-fill"></i></div><div class="stat-value" id="stat-planos">-</div><div class="stat-label">Planos</div></div></div>
</div>
<div class="row g-4 mb-4">
    <div class="col-lg-8"><div class="gym-card"><div class="gym-card-header"><div><div class="gym-card-title">Matriculas Recentes</div><div class="gym-card-subtitle">Ultimas registradas</div></div><a href="{{ route('admin.matriculas.index') }}" class="btn btn-gym-ghost btn-sm">Ver todas</a></div><div class="table-responsive"><table class="gym-table"><thead><tr><th>Aluno</th><th>Plano</th><th>Inicio</th><th>Status</th></tr></thead><tbody id="dash-matriculas"><tr><td colspan="4" class="text-center py-4">Carregando...</td></tr></tbody></table></div></div></div>
    <div class="col-lg-4"><div class="gym-card h-100"><div class="gym-card-header"><div class="gym-card-title">Frequencia Semanal</div></div><div class="gym-card-body"><div class="d-flex align-items-flex-end gap-2" style="height:100px;align-items:flex-end">@foreach(['Seg','Ter','Qua','Qui','Sex','Sab','Dom'] as $i => $dia)<div class="d-flex flex-column align-items-center flex-fill gap-1"><div class="freq-bar-js flex-fill w-100" data-day="{{ $i }}" style="background:var(--gym-border);border-radius:3px 3px 0 0;min-height:4px;transition:height .3s"></div><span style="font-size:9px;color:var(--gym-muted);font-weight:700">{{ $dia }}</span></div>@endforeach</div><hr style="border-color:var(--gym-border)"><div class="stat-label">Total de Frequencias</div><div style="font-family:'Barlow Condensed',sans-serif;font-size:32px;font-weight:800" id="dash-freq-total">-</div></div></div></div>
</div>
<div class="gym-card"><div class="gym-card-header"><div class="gym-card-title">Progresso dos Alunos</div><a href="{{ route('admin.progresso.index') }}" class="btn btn-gym-ghost btn-sm">Ver tudo</a></div><div class="gym-card-body" id="dash-progresso"><div style="color:var(--gym-muted);font-size:13px">Carregando...</div></div></div>
@endsection
@push('scripts')
<script>
function fmtDate(d){if(!d)return'-';try{return new Date(d).toLocaleDateString('pt-BR')}catch{return d}}
function statusBadge(s){const m={ativo:'success',inativo:'danger',suspenso:'warning'};return`<span class="gym-badge badge-${m[s]||'info'}">${s||'-'}</span>`}
async function loadDashboard(){
    const api=path=>fetch('/api'+path).then(r=>r.json()).catch(()=>[]);
    const [matriculas,treinos,planos,frequencias,progresso]=await Promise.all([api('/matriculas'),api('/treinos'),api('/planos'),api('/frequencias'),api('/progresso')]);
    if(Array.isArray(matriculas)){document.getElementById('stat-alunos').textContent=matriculas.filter(m=>m.status==='ativo').length;document.getElementById('dash-matriculas').innerHTML=matriculas.slice(0,5).map(m=>`<tr><td><strong>${m.user?m.user.name:'Aluno #'+m.user_id}</strong></td><td>${m.plano?m.plano.nome:'#'+m.plano_id}</td><td>${fmtDate(m.data_inicio)}</td><td>${statusBadge(m.status)}</td></tr>`).join('')||'<tr><td colspan="4" class="text-center py-3">Nenhuma matricula</td></tr>';}
    if(Array.isArray(treinos))document.getElementById('stat-treinos').textContent=treinos.length;
    if(Array.isArray(planos))document.getElementById('stat-planos').textContent=planos.length;
    if(Array.isArray(frequencias)){document.getElementById('dash-freq-total').textContent=frequencias.length;const max=Math.max(10,frequencias.length);document.querySelectorAll('.freq-bar-js').forEach((b,i)=>{b.style.height=Math.max(8,Math.min(100,Math.round((frequencias.length/7)*(1-i*.08)/max*700)))+'%';b.style.background=i<5?'var(--gym-accent)':'var(--gym-border)';});}
    if(Array.isArray(progresso))document.getElementById('dash-progresso').innerHTML=progresso.slice(0,4).map(p=>`<div class="d-flex align-items-center gap-3 mb-3"><div style="font-size:12px;color:var(--gym-muted);width:140px">${p.aluno?p.aluno.name:'Aluno #'+p.user_id}</div><div class="flex-grow-1"><div style="height:4px;background:var(--gym-border);border-radius:4px"><div style="height:100%;width:${Math.min(100,Math.round((p.massa_muscular_kg||0)*2))}%;background:var(--gym-accent);border-radius:4px"></div></div></div><div style="font-size:12px;font-weight:600">${p.peso_kg||'-'}kg</div></div>`).join('')||'<div class="empty-state"><p>Sem registros</p></div>';
}
loadDashboard();
</script>
@endpush
