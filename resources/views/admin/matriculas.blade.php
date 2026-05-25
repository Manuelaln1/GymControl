@extends('layouts.app')
@section('title', 'Alunos & Matrículas')
@section('page-title', 'Alunos & Matrículas')

@section('topbar-action')
    <button class="btn btn-gym-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalMatricula" onclick="resetForm('matricula')">
        <i class="bi bi-plus-lg"></i> Nova Matrícula
    </button>
@endsection

@section('content')
<div class="gym-card">
    <div class="gym-card-header">
        <div>
            <div class="gym-card-title">Matrículas</div>
            <div class="gym-card-subtitle">Todos os alunos cadastrados</div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="gym-table">
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Plano</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="table-matriculas">
                <tr><td colspan="6" class="text-center py-4" style="color:var(--gym-muted)"><div class="spinner-border spinner-border-sm me-2"></div>Carregando...</td></tr>
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL --}}
<div class="modal fade gym-modal" id="modalMatricula" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="matricula-modal-title">Nova Matrícula</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="matricula-id">
                <div class="row g-3">
                    <div class="col-6">
                        <label class="gym-form-label">ID do Aluno</label>
                        <input type="number" class="form-control gym-input" id="matricula-user" placeholder="1">
                    </div>
                    <div class="col-6">
                        <label class="gym-form-label">Plano</label>
                        <select class="form-control gym-input" id="matricula-plano"></select>
                    </div>
                    <div class="col-6">
                        <label class="gym-form-label">Data Início</label>
                        <input type="date" class="form-control gym-input" id="matricula-inicio">
                    </div>
                    <div class="col-6">
                        <label class="gym-form-label">Data Fim</label>
                        <input type="date" class="form-control gym-input" id="matricula-fim">
                    </div>
                    <div class="col-12">
                        <label class="gym-form-label">Status</label>
                        <select class="form-control gym-input" id="matricula-status">
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                            <option value="suspenso">Suspenso</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-gym-ghost" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-gym-primary" onclick="saveMatricula()">Salvar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function fmtDate(d){if(!d)return'—';try{return new Date(d).toLocaleDateString('pt-BR')}catch{return d}}
function statusBadge(s){const m={ativo:'success',active:'success',inativo:'danger',inactive:'danger',suspenso:'warning'};return`<span class="gym-badge badge-${m[s]||'info'}">${s||'—'}</span>`}
function resetForm(f){document.getElementById(f+'-id').value='';document.getElementById(f+'-modal-title').textContent='Nova Matrícula';}

async function loadMatriculas(){
    const [data,planos]=await Promise.all([fetch('/api/matriculas').then(r=>r.json()),fetch('/api/planos').then(r=>r.json())]).catch(()=>[[],[]]);
    if(Array.isArray(planos)){
        document.getElementById('matricula-plano').innerHTML=planos.map(p=>`<option value="${p.id}">${p.nome}</option>`).join('');
    }
    if(!Array.isArray(data)){return;}
    document.getElementById('table-matriculas').innerHTML=data.map(m=>`
        <tr>
            <td><strong>${m.user?m.user.name:'Aluno #'+m.user_id}</strong></td>
            <td style="color:var(--gym-muted)">${m.plano?m.plano.nome:'#'+m.plano_id}</td>
            <td style="color:var(--gym-muted)">${fmtDate(m.data_inicio)}</td>
            <td style="color:var(--gym-muted)">${fmtDate(m.data_fim)}</td>
            <td>${statusBadge(m.status)}</td>
            <td>
                <div class="d-flex gap-2">
                    <button class="btn btn-gym-ghost btn-sm" onclick='editMatricula(${JSON.stringify(m)})'><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-gym-danger btn-sm" onclick="delMatricula(${m.id})"><i class="bi bi-trash"></i></button>
                </div>
            </td>
        </tr>`).join('')||'<tr><td colspan="6" class="text-center py-4" style="color:var(--gym-muted)">Nenhuma matrícula encontrada</td></tr>';
}

function editMatricula(m){
    document.getElementById('matricula-id').value=m.id;
    document.getElementById('matricula-modal-title').textContent='Editar Matrícula';
    document.getElementById('matricula-user').value=m.user_id;
    document.getElementById('matricula-plano').value=m.plano_id;
    document.getElementById('matricula-inicio').value=m.data_inicio;
    document.getElementById('matricula-fim').value=m.data_fim;
    document.getElementById('matricula-status').value=m.status;
    new bootstrap.Modal(document.getElementById('modalMatricula')).show();
}

async function saveMatricula(){
    const id=document.getElementById('matricula-id').value;
    const body={user_id:document.getElementById('matricula-user').value,plano_id:document.getElementById('matricula-plano').value,data_inicio:document.getElementById('matricula-inicio').value,data_fim:document.getElementById('matricula-fim').value,status:document.getElementById('matricula-status').value};
    const r=await fetch('/api/matriculas'+(id?'/'+id:''),{method:id?'PUT':'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},body:JSON.stringify(body)});
    if(r.ok){bootstrap.Modal.getInstance(document.getElementById('modalMatricula')).hide();showToast('Matrícula salva!');loadMatriculas();}
    else showToast('Erro ao salvar','error');
}

async function delMatricula(id){
    if(!confirm('Remover esta matrícula?'))return;
    const r=await fetch('/api/matriculas/'+id,{method:'DELETE',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content}});
    if(r.ok){showToast('Removida!');loadMatriculas();}
}

loadMatriculas();
</script>
@endpush
