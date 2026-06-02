@extends('layouts.app')
@section('title','Frequencias')
@section('page-title','Frequencias')
@section('topbar-action')
<button class="btn btn-gym-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalFrequencia" onclick="resetForm()"><i class="bi bi-plus-lg"></i> Registrar</button>
@endsection
@section('content')
<div class="gym-card"><div class="gym-card-header"><div class="gym-card-title">Controle de Frequencia</div></div><div class="table-responsive"><table class="gym-table">
    <thead><tr><th>#</th><th>Aluno</th><th>Data</th><th>Acoes</th></tr></thead>
    <tbody id="table-frequencias"><tr><td colspan="4" class="text-center py-4">Carregando...</td></tr></tbody>
</table></div></div>
<div class="modal fade gym-modal" id="modalFrequencia" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Registrar Frequencia</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
    <div class="modal-body"><input type="hidden" id="frequencia-id"><div class="row g-3">
        <div class="col-6 aluno-autocomplete"><label class="gym-form-label">Aluno</label><input type="text" class="form-control gym-input" id="frequencia-aluno" data-aluno-autocomplete placeholder="Digite o nome"><div class="aluno-autocomplete-list"></div></div>
        <div class="col-6"><label class="gym-form-label">Data</label><input type="date" class="form-control gym-input" id="frequencia-data"></div>
    </div></div>
    <div class="modal-footer"><button class="btn btn-gym-ghost" data-bs-dismiss="modal">Cancelar</button><button class="btn btn-gym-primary" onclick="saveFrequencia()">Salvar</button></div>
</div></div></div>
@endsection
@push('scripts')
<script>
function resetForm(){['frequencia-id','frequencia-aluno','frequencia-data'].forEach(id=>document.getElementById(id).value='');}
function fmtDate(d){if(!d)return'-';try{return new Date(d).toLocaleDateString('pt-BR')}catch{return d}}
async function loadFrequencias(){const data=await fetch('/api/frequencias').then(r=>r.json()).catch(()=>[]);if(!Array.isArray(data))return;document.getElementById('table-frequencias').innerHTML=data.map(f=>`<tr><td>#${f.id}</td><td><strong>${f.user?f.user.name:'Aluno #'+f.user_id}</strong></td><td>${fmtDate(f.entrada)}</td><td><button class="btn btn-gym-danger btn-sm" onclick="delFrequencia(${f.id})"><i class="bi bi-trash"></i></button></td></tr>`).join('')||'<tr><td colspan="4" class="text-center py-4">Nenhuma frequencia</td></tr>';}
async function saveFrequencia(){const id=document.getElementById('frequencia-id').value;const userId=alunoIdPorNome('frequencia-aluno');if(!userId)return;const body={user_id:userId,data:document.getElementById('frequencia-data').value};const r=await fetch('/api/frequencias'+(id?'/'+id:''),{method:id?'PUT':'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},body:JSON.stringify(body)});if(r.ok){bootstrap.Modal.getInstance(document.getElementById('modalFrequencia')).hide();showToast('Registrado!');loadFrequencias();}else showToast('Erro','error');}
async function delFrequencia(id){if(!confirm('Remover?'))return;const r=await fetch('/api/frequencias/'+id,{method:'DELETE',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content}});if(r.ok){showToast('Removido!');loadFrequencias();}}
loadFrequencias();
</script>
@endpush
