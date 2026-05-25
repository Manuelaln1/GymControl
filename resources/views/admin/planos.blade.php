@extends('layouts.app')
@section('title','Planos')
@section('page-title','Planos')
@section('topbar-action')
<button class="btn btn-gym-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalPlano" onclick="resetForm()">
    <i class="bi bi-plus-lg"></i> Novo Plano
</button>
@endsection
@section('content')
<div id="plans-grid" class="row g-4">
    <div class="col-12 text-center py-5" style="color:var(--gym-muted)"><div class="spinner-border me-2"></div>Carregando planos...</div>
</div>
<div class="modal fade gym-modal" id="modalPlano" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title" id="plano-modal-title">Novo Plano</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <input type="hidden" id="plano-id">
                <div class="row g-3">
                    <div class="col-12"><label class="gym-form-label">Nome</label><input type="text" class="form-control gym-input" id="plano-nome" placeholder="Ex: Mensal Premium"></div>
                    <div class="col-6"><label class="gym-form-label">Preço (R$)</label><input type="number" step="0.01" class="form-control gym-input" id="plano-preco"></div>
                    <div class="col-6"><label class="gym-form-label">Duração (dias)</label><input type="number" class="form-control gym-input" id="plano-duracao"></div>
                    <div class="col-12"><label class="gym-form-label">Status</label><select class="form-control gym-input" id="plano-ativo"><option value="1">Ativo</option><option value="0">Inativo</option></select></div>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-gym-ghost" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-gym-primary" onclick="savePlano()">Salvar</button></div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function resetForm(){['plano-id','plano-nome','plano-preco','plano-duracao'].forEach(i=>document.getElementById(i).value='');document.getElementById('plano-modal-title').textContent='Novo Plano';}
async function loadPlanos(){
    const data=await fetch('/api/planos').then(r=>r.json()).catch(()=>[]);
    if(!Array.isArray(data)||!data.length){document.getElementById('plans-grid').innerHTML='<div class="col-12 text-center py-5" style="color:var(--gym-muted)"><i class="bi bi-tag fs-1 d-block mb-3"></i>Nenhum plano cadastrado</div>';return;}
    document.getElementById('plans-grid').innerHTML=data.map(p=>`
        <div class="col-md-6 col-xl-4">
            <div class="plan-card ${p.ativo?'featured':''}">
                ${p.ativo?'<span class="gym-badge badge-success mb-3 d-inline-flex"><i class="bi bi-check-circle-fill me-1"></i>Ativo</span>':'<span class="gym-badge badge-danger mb-3 d-inline-flex">Inativo</span>'}
                <div style="font-family:\'Barlow Condensed\',sans-serif;font-size:22px;font-weight:800;margin-bottom:8px">${p.nome}</div>
                <div class="plan-price">R$ ${parseFloat(p.preco).toFixed(2)}<small>/plano</small></div>
                <div style="font-size:13px;color:var(--gym-muted);margin-top:4px;text-transform:uppercase;letter-spacing:.5px">${p.duracao_dias} dias</div>
                <hr style="border-color:var(--gym-border);margin:18px 0">
                <div class="d-flex gap-2">
                    <button class="btn btn-gym-ghost btn-sm flex-fill" onclick='editPlano(${JSON.stringify(p)})'><i class="bi bi-pencil me-1"></i>Editar</button>
                    <button class="btn btn-gym-danger btn-sm" onclick="delPlano(${p.id})"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        </div>`).join('');
}
function editPlano(p){document.getElementById('plano-id').value=p.id;document.getElementById('plano-modal-title').textContent='Editar Plano';document.getElementById('plano-nome').value=p.nome;document.getElementById('plano-preco').value=p.preco;document.getElementById('plano-duracao').value=p.duracao_dias;document.getElementById('plano-ativo').value=p.ativo?'1':'0';new bootstrap.Modal(document.getElementById('modalPlano')).show();}
async function savePlano(){const id=document.getElementById('plano-id').value;const body={nome:document.getElementById('plano-nome').value,preco:document.getElementById('plano-preco').value,duracao_dias:document.getElementById('plano-duracao').value,ativo:document.getElementById('plano-ativo').value==='1'};const r=await fetch('/api/planos'+(id?'/'+id:''),{method:id?'PUT':'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},body:JSON.stringify(body)});if(r.ok){bootstrap.Modal.getInstance(document.getElementById('modalPlano')).hide();showToast('Plano salvo!');loadPlanos();}else showToast('Erro ao salvar','error');}
async function delPlano(id){if(!confirm('Remover este plano?'))return;const r=await fetch('/api/planos/'+id,{method:'DELETE',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content}});if(r.ok){showToast('Removido!');loadPlanos();}}
loadPlanos();
</script>
@endpush
