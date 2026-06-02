@extends('layouts.app')
@section('title','Treinos')
@section('page-title','Treinos')
@section('topbar-action')
<button class="btn btn-gym-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTreino" onclick="resetForm()"><i class="bi bi-plus-lg"></i> Novo Treino</button>
@endsection
@section('content')
<div class="gym-card"><div class="gym-card-header"><div class="gym-card-title">Treinos Cadastrados</div></div><div class="table-responsive"><table class="gym-table">
    <thead><tr><th>Aluno</th><th>Nome</th><th>Objetivo</th><th>Observacoes</th><th>Status</th><th>Acoes</th></tr></thead>
    <tbody id="table-treinos"><tr><td colspan="6" class="text-center py-4">Carregando...</td></tr></tbody>
</table></div></div>
<div class="modal fade gym-modal" id="modalTreino" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title" id="treino-modal-title">Novo Treino</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body"><input type="hidden" id="treino-id"><div class="row g-3">
        <div class="col-12 aluno-autocomplete"><label class="gym-form-label">Aluno</label><input type="text" class="form-control gym-input" id="treino-aluno" data-aluno-autocomplete placeholder="Digite o nome do aluno"><div class="aluno-autocomplete-list"></div></div>
        <div class="col-12"><label class="gym-form-label">Nome do Treino</label><input type="text" class="form-control gym-input" id="treino-nome" placeholder="Ex: Treino A - Peito"></div>
        <div class="col-12"><label class="gym-form-label">Objetivo</label><input type="text" class="form-control gym-input" id="treino-objetivo" placeholder="Ex: Hipertrofia"></div>
        <div class="col-12"><label class="gym-form-label">Observacoes</label><textarea class="form-control gym-input" id="treino-obs" rows="3"></textarea></div>
        <div class="col-12"><label class="gym-form-label">Status</label><select class="form-control gym-input" id="treino-ativo"><option value="1">Ativo</option><option value="0">Inativo</option></select></div>
    </div></div>
    <div class="modal-footer"><button class="btn btn-gym-ghost" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-gym-primary" onclick="saveTreino()">Salvar</button></div>
</div></div></div>
@endsection
@push('scripts')
<script>
function resetForm(){['treino-id','treino-aluno','treino-nome','treino-objetivo','treino-obs'].forEach(id=>document.getElementById(id).value='');document.getElementById('treino-ativo').value='1';document.getElementById('treino-modal-title').textContent='Novo Treino';}
async function loadTreinos(){const data=await fetch('/api/treinos').then(r=>r.json()).catch(()=>[]);if(!Array.isArray(data))return;document.getElementById('table-treinos').innerHTML=data.map(t=>`<tr><td><strong>${t.user?t.user.name:'Aluno #'+t.user_id}</strong></td><td>${t.nome}</td><td>${t.objetivo||'-'}</td><td>${t.observacoes||'-'}</td><td>${t.ativo?'Ativo':'Inativo'}</td><td><div class="d-flex gap-2"><a class="btn btn-gym-primary btn-sm" href="/api/treinos/${t.id}/pdf" title="Exportar PDF"><i class="bi bi-file-earmark-pdf"></i></a><button class="btn btn-gym-ghost btn-sm" onclick='editTreino(${JSON.stringify(t)})'><i class="bi bi-pencil"></i></button><button class="btn btn-gym-danger btn-sm" onclick="delTreino(${t.id})"><i class="bi bi-trash"></i></button></div></td></tr>`).join('')||'<tr><td colspan="6" class="text-center py-4">Nenhum treino</td></tr>';}
function editTreino(t){document.getElementById('treino-id').value=t.id;document.getElementById('treino-modal-title').textContent='Editar Treino';document.getElementById('treino-aluno').value=t.user?t.user.name:'';document.getElementById('treino-nome').value=t.nome;document.getElementById('treino-objetivo').value=t.objetivo||'';document.getElementById('treino-obs').value=t.observacoes||'';document.getElementById('treino-ativo').value=t.ativo?'1':'0';new bootstrap.Modal(document.getElementById('modalTreino')).show();}
async function saveTreino(){const id=document.getElementById('treino-id').value;const userId=alunoIdPorNome('treino-aluno');if(!userId)return;const body={user_id:userId,nome:document.getElementById('treino-nome').value,objetivo:document.getElementById('treino-objetivo').value,observacoes:document.getElementById('treino-obs').value,ativo:document.getElementById('treino-ativo').value==='1'};const r=await fetch('/api/treinos'+(id?'/'+id:''),{method:id?'PUT':'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},body:JSON.stringify(body)});if(r.ok){bootstrap.Modal.getInstance(document.getElementById('modalTreino')).hide();showToast('Treino salvo!');loadTreinos();}else showToast('Erro ao salvar','error');}
async function delTreino(id){if(!confirm('Remover?'))return;const r=await fetch('/api/treinos/'+id,{method:'DELETE',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content}});if(r.ok){showToast('Removido!');loadTreinos();}}
loadTreinos();
</script>
@endpush
