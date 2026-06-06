@extends('layouts.app')
@section('title','Progresso')
@section('page-title','Progresso dos Alunos')
@section('topbar-action')
<button class="btn btn-gym-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalProgresso" onclick="resetForm()"><i class="bi bi-plus-lg"></i> Novo Registro</button>
@endsection
@section('content')
<div class="gym-card"><div class="gym-card-header"><div class="gym-card-title">Registros de Progresso</div></div><div class="table-responsive"><table class="gym-table">
    <thead><tr><th>Aluno</th><th>Peso (kg)</th><th>Gordura (%)</th><th>Massa Muscular (kg)</th><th>Avaliado em</th><th>Acoes</th></tr></thead>
    <tbody id="table-progresso"><tr><td colspan="6" class="text-center py-4">Carregando...</td></tr></tbody>
</table></div></div>
<div class="modal fade gym-modal" id="modalProgresso" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title" id="progresso-modal-title">Novo Registro</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body"><input type="hidden" id="progresso-id"><div class="row g-3">
        <div class="col-12 aluno-autocomplete"><label class="gym-form-label">Aluno</label><input type="text" class="form-control gym-input" id="progresso-aluno" data-aluno-autocomplete placeholder="Digite o nome do aluno"><div class="aluno-autocomplete-list"></div></div>
        <div class="col-6"><label class="gym-form-label">Peso (kg)</label><input type="number" step="0.1" class="form-control gym-input" id="progresso-peso"></div>
        <div class="col-6"><label class="gym-form-label">Gordura (%)</label><input type="number" step="0.1" class="form-control gym-input" id="progresso-gordura"></div>
        <div class="col-6"><label class="gym-form-label">Massa Muscular (kg)</label><input type="number" step="0.1" class="form-control gym-input" id="progresso-massa"></div>
        <div class="col-6"><label class="gym-form-label">Data da Avaliacao</label><input type="date" class="form-control gym-input" id="progresso-data"></div>
        <div class="col-12"><label class="gym-form-label">Observacoes</label><textarea class="form-control gym-input" id="progresso-obs" rows="2"></textarea></div>
    </div></div>
    <div class="modal-footer"><button class="btn btn-gym-ghost" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-gym-primary" onclick="saveProgresso()">Salvar</button></div>
</div></div></div>
@endsection
@push('scripts')
<script>
function resetForm() {
    ['progresso-id','progresso-aluno','progresso-peso','progresso-gordura','progresso-massa','progresso-data','progresso-obs'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('progresso-data').value = new Date().toISOString().slice(0, 10);
    document.getElementById('progresso-modal-title').textContent = 'Novo Registro';
}

function fmtDate(d) {
    if (!d) return '-';
    try { return new Date(d).toLocaleDateString('pt-BR'); } catch { return d; }
}

function progressoErrorMessage(payload) {
    if (payload?.errors) return Object.values(payload.errors).flat()[0] || 'Erro ao salvar.';
    return payload?.message || 'Erro ao salvar.';
}

async function loadProgresso() {
    const table = document.getElementById('table-progresso');
    const response = await fetch('/api/progresso', { headers: { 'Accept': 'application/json' } }).catch(() => null);

    if (!response || !response.ok) {
        table.innerHTML = '<tr><td colspan="6" class="text-center py-4">Nao foi possivel carregar os registros</td></tr>';
        return;
    }

    const data = await response.json().catch(() => []);
    if (!Array.isArray(data)) return;

    table.innerHTML = data.map(p => `<tr><td><strong>${p.aluno ? p.aluno.name : 'Aluno #' + p.user_id}</strong></td><td>${p.peso_kg ? p.peso_kg + ' kg' : '-'}</td><td>${p.gordura_corporal_pct ? p.gordura_corporal_pct + '%' : '-'}</td><td>${p.massa_muscular_kg ? p.massa_muscular_kg + ' kg' : '-'}</td><td>${fmtDate(p.avaliado_em)}</td><td><div class="d-flex gap-2"><button class="btn btn-gym-ghost btn-sm" onclick='editProgresso(${JSON.stringify(p)})'><i class="bi bi-pencil"></i></button><button class="btn btn-gym-danger btn-sm" onclick="delProgresso(${p.id})"><i class="bi bi-trash"></i></button></div></td></tr>`).join('') || '<tr><td colspan="6" class="text-center py-4">Nenhum registro</td></tr>';
}

function editProgresso(p) {
    document.getElementById('progresso-id').value = p.id;
    document.getElementById('progresso-modal-title').textContent = 'Editar Registro';
    document.getElementById('progresso-aluno').value = p.aluno ? p.aluno.name : '';
    document.getElementById('progresso-peso').value = p.peso_kg || '';
    document.getElementById('progresso-gordura').value = p.gordura_corporal_pct || '';
    document.getElementById('progresso-massa').value = p.massa_muscular_kg || '';
    document.getElementById('progresso-data').value = p.avaliado_em || '';
    document.getElementById('progresso-obs').value = p.observacoes || '';
    new bootstrap.Modal(document.getElementById('modalProgresso')).show();
}

async function saveProgresso() {
    const id = document.getElementById('progresso-id').value;
    const userId = alunoIdPorNome('progresso-aluno');
    if (!userId) return;

    const body = {
        user_id: userId,
        peso_kg: document.getElementById('progresso-peso').value,
        gordura_corporal_pct: document.getElementById('progresso-gordura').value,
        massa_muscular_kg: document.getElementById('progresso-massa').value,
        avaliado_em: document.getElementById('progresso-data').value,
        observacoes: document.getElementById('progresso-obs').value
    };

    const response = await fetch('/api/progresso' + (id ? '/' + id : ''), {
        method: id ? 'PUT' : 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
        },
        body: JSON.stringify(body)
    }).catch(() => null);

    const payload = await response?.json().catch(() => null);
    if (!response || !response.ok || payload?.ok === false) {
        showToast(progressoErrorMessage(payload), 'error');
        return;
    }

    bootstrap.Modal.getInstance(document.getElementById('modalProgresso')).hide();
    showToast('Salvo!');
    await loadProgresso();
}

async function delProgresso(id) {
    if (!confirm('Remover?')) return;
    const r = await fetch('/api/progresso/' + id, {
        method: 'DELETE',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
        }
    });
    if (r.ok) {
        showToast('Removido!');
        loadProgresso();
    }
}
loadProgresso();
</script>
@endpush
