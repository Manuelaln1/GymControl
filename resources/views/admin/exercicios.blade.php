@extends('layouts.app')
@section('title','Exercícios')
@section('page-title','Exercícios')
@section('topbar-action')
<button class="btn btn-gym-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalExercicio" onclick="resetForm()">
    <i class="bi bi-plus-lg"></i> Novo Exercício
</button>
@endsection
@section('content')
<div class="gym-card">
    <div class="gym-card-header"><div class="gym-card-title">Biblioteca de Exercícios</div></div>
    <div class="table-responsive">
        <table class="gym-table">
            <thead><tr><th>Nome</th><th>Grupo Muscular</th><th>Equipamento</th><th>Descrição</th><th>Ações</th></tr></thead>
            <tbody id="table-exercicios"><tr><td colspan="5" class="text-center py-4" style="color:var(--gym-muted)"><div class="spinner-border spinner-border-sm me-2"></div>Carregando...</td></tr></tbody>
        </table>
    </div>
</div>
<div class="modal fade gym-modal" id="modalExercicio" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="exercicio-modal-title">Novo Exercício</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <input type="hidden" id="exercicio-id">
                <div class="row g-3">
                    <div class="col-12"><label class="gym-form-label">Nome</label><input type="text" class="form-control gym-input" id="exercicio-nome" placeholder="Ex: Supino Reto"></div>
                    <div class="col-6"><label class="gym-form-label">Grupo Muscular</label><input type="text" class="form-control gym-input" id="exercicio-grupo" placeholder="Ex: Peito"></div>
                    <div class="col-6"><label class="gym-form-label">Equipamento</label><input type="text" class="form-control gym-input" id="exercicio-equip" placeholder="Ex: Barra"></div>
                    <div class="col-12"><label class="gym-form-label">Descrição</label><textarea class="form-control gym-input" id="exercicio-desc" rows="3" placeholder="Descreva o exercício..."></textarea></div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-gym-ghost" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-gym-primary" onclick="saveExercicio()">Salvar</button></div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function resetForm(){['exercicio-id','exercicio-nome','exercicio-grupo','exercicio-equip','exercicio-desc'].forEach(i=>document.getElementById(i).value='');document.getElementById('exercicio-modal-title').textContent='Novo Exercício';}
async function loadExercicios(){
    const data=await fetch('/api/exercicios').then(r=>r.json()).catch(()=>[]);
    if(!Array.isArray(data))return;
    document.getElementById('table-exercicios').innerHTML=data.map(e=>`
        <tr>
            <td><strong>${e.nome}</strong></td>
            <td><span class="gym-badge badge-info">${e.grupo_muscular||'—'}</span></td>
            <td style="color:var(--gym-muted)">${e.equipamento||'—'}</td>
            <td style="color:var(--gym-muted);max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">${e.descricao||'—'}</td>
            <td><div class="d-flex gap-2"><button class="btn btn-gym-ghost btn-sm" onclick='editExercicio(${JSON.stringify(e)})'><i class="bi bi-pencil"></i></button><button class="btn btn-gym-danger btn-sm" onclick="delExercicio(${e.id})"><i class="bi bi-trash"></i></button></div></td>
        </tr>`).join('')||'<tr><td colspan="5" class="text-center py-4" style="color:var(--gym-muted)">Nenhum exercício</td></tr>';
}
function editExercicio(e){document.getElementById('exercicio-id').value=e.id;document.getElementById('exercicio-modal-title').textContent='Editar Exercício';document.getElementById('exercicio-nome').value=e.nome;document.getElementById('exercicio-grupo').value=e.grupo_muscular||'';document.getElementById('exercicio-equip').value=e.equipamento||'';document.getElementById('exercicio-desc').value=e.descricao||'';new bootstrap.Modal(document.getElementById('modalExercicio')).show();}
async function saveExercicio(){const id=document.getElementById('exercicio-id').value;const body={nome:document.getElementById('exercicio-nome').value,grupo_muscular:document.getElementById('exercicio-grupo').value,equipamento:document.getElementById('exercicio-equip').value,descricao:document.getElementById('exercicio-desc').value};const r=await fetch('/api/exercicios'+(id?'/'+id:''),{method:id?'PUT':'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},body:JSON.stringify(body)});if(r.ok){bootstrap.Modal.getInstance(document.getElementById('modalExercicio')).hide();showToast('Exercício salvo!');loadExercicios();}else showToast('Erro ao salvar','error');}
async function delExercicio(id){if(!confirm('Remover?'))return;const r=await fetch('/api/exercicios/'+id,{method:'DELETE',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content}});if(r.ok){showToast('Removido!');loadExercicios();}}
loadExercicios();
</script>
@endpush
