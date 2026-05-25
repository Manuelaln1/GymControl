@extends('layouts.app')
@section('title','Treinos')
@section('page-title','Treinos')
@section('topbar-action')
<button class="btn btn-gym-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTreino" onclick="resetForm()">
    <i class="bi bi-plus-lg"></i> Novo Treino
</button>
@endsection
@section('content')
<div class="gym-card">
    <div class="gym-card-header"><div class="gym-card-title">Treinos Cadastrados</div></div>
    <div class="table-responsive">
        <table class="gym-table">
            <thead><tr><th>Nome</th><th>Objetivo</th><th>Observações</th><th>Status</th><th>Ações</th></tr></thead>
            <tbody id="table-treinos"><tr><td colspan="5" class="text-center py-4" style="color:var(--gym-muted)"><div class="spinner-border spinner-border-sm me-2"></div>Carregando...</td></tr></tbody>
        </table>
    </div>
</div>
<div class="modal fade gym-modal" id="modalTreino" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="treino-modal-title">Novo Treino</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <input type="hidden" id="treino-id">
                <div class="row g-3">
                    <div class="col-12"><label class="gym-form-label">Nome do Treino</label><input type="text" class="form-control gym-input" id="treino-nome" placeholder="Ex: Treino A - Peito"></div>
                    <div class="col-6"><label class="gym-form-label">ID do Aluno</label><input type="number" class="form-control gym-input" id="treino-user"></div>
                    <div class="col-6"><label class="gym-form-label">ID do Professor</label><input type="number" class="form-control gym-input" id="treino-prof"></div>
                    <div class="col-12"><label class="gym-form-label">Objetivo</label><input type="text" class="form-control gym-input" id="treino-objetivo" placeholder="Ex: Hipertrofia"></div>
                    <div class="col-12"><label class="gym-form-label">Observações</label><textarea class="form-control gym-input" id="treino-obs" rows="3"></textarea></div>
                    <div class="col-12"><label class="gym-form-label">Status</label><select class="form-control gym-input" id="treino-ativo"><option value="1">Ativo</option><option value="0">Inativo</option></select></div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-gym-ghost" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-gym-primary" onclick="saveTreino()">Salvar</button></div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function resetForm(){['treino-id','treino-nome','treino-user','treino-prof','treino-objetivo','treino-obs'].forEach(i=>document.getElementById(i).value='');document.getElementById('treino-modal-title').textContent='Novo Treino';}
async function loadTreinos(){
    const data=await fetch('/api/treinos').then(r=>r.json()).catch(()=>[]);
    if(!Array.isArray(data))return;
    document.getElementById('table-treinos').innerHTML=data.map(t=>`
        <tr>
            <td><strong>${t.nome}</strong></td>
            <td style="color:var(--gym-muted)">${t.objetivo||'—'}</td>
            <td style="color:var(--gym-muted);max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">${t.observacoes||'—'}</td>
            <td>${t.ativo?'<span class="gym-badge badge-success"><i class="bi bi-circle-fill" style="font-size:7px"></i> Ativo</span>':'<span class="gym-badge badge-danger"><i class="bi bi-circle-fill" style="font-size:7px"></i> Inativo</span>'}</td>
            <td><div class="d-flex gap-2"><button class="btn btn-gym-ghost btn-sm" onclick='editTreino(${JSON.stringify(t)})'><i class="bi bi-pencil"></i></button><button class="btn btn-gym-danger btn-sm" onclick="delTreino(${t.id})"><i class="bi bi-trash"></i></button></div></td>
        </tr>`).join('')||'<tr><td colspan="5" class="text-center py-4" style="color:var(--gym-muted)">Nenhum treino</td></tr>';
}
function editTreino(t){document.getElementById('treino-id').value=t.id;document.getElementById('treino-modal-title').textContent='Editar Treino';document.getElementById('treino-nome').value=t.nome;document.getElementById('treino-user').value=t.user_id||'';document.getElementById('treino-prof').value=t.professor_id||'';document.getElementById('treino-objetivo').value=t.objetivo||'';document.getElementById('treino-obs').value=t.observacoes||'';document.getElementById('treino-ativo').value=t.ativo?'1':'0';new bootstrap.Modal(document.getElementById('modalTreino')).show();}
async function saveTreino(){const id=document.getElementById('treino-id').value;const body={nome:document.getElementById('treino-nome').value,user_id:document.getElementById('treino-user').value,professor_id:document.getElementById('treino-prof').value,objetivo:document.getElementById('treino-objetivo').value,observacoes:document.getElementById('treino-obs').value,ativo:document.getElementById('treino-ativo').value==='1'};const r=await fetch('/api/treinos'+(id?'/'+id:''),{method:id?'PUT':'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},body:JSON.stringify(body)});if(r.ok){bootstrap.Modal.getInstance(document.getElementById('modalTreino')).hide();showToast('Treino salvo!');loadTreinos();}else showToast('Erro ao salvar','error');}
async function delTreino(id){if(!confirm('Remover?'))return;const r=await fetch('/api/treinos/'+id,{method:'DELETE',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content}});if(r.ok){showToast('Removido!');loadTreinos();}}
loadTreinos();
</script>
@endpush
