# GymControl

Table users {
  id bigint [pk, increment]
  name varchar
  email varchar [unique]
  password varchar
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table planos {
  id bigint [pk, increment]
  nome varchar
  preco decimal(10,2)
  duracao_dias int
  ativo boolean [default: true]
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table matriculas {
  id bigint [pk, increment]
  user_id bigint
  plano_id bigint
  data_inicio date
  data_fim date
  status varchar [note: 'ativo, inativo, cancelado']
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table exercicios {
  id bigint [pk, increment]
  nome varchar
  grupo_muscular varchar [null]
  descricao text [null]
  equipamento varchar [null]
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table treinos {
  id bigint [pk, increment]
  user_id bigint
  professor_id bigint
  nome varchar
  objetivo varchar [null]
  observacoes text [null]
  pdf_caminho varchar [null]
  ativo boolean [default: true]
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
}

Table treino_exercicios {
  id bigint [pk, increment]
  treino_id bigint
  exercicio_id bigint
  series int
  repeticoes varchar
  carga_kg decimal(5,1) [null]
  descanso_segundos int [null]
  ordem int [default: 0]
  observacoes varchar [null]
  created_at timestamp
  updated_at timestamp
}

Table progresso {
  id bigint [pk, increment]
  user_id bigint
  professor_id bigint
  peso_kg decimal(5,2) [null]
  gordura_corporal_pct decimal(4,2) [null]
  massa_muscular_kg decimal(5,2) [null]
  observacoes text [null]
  avaliado_em date
  created_at timestamp
  updated_at timestamp
}

Table frequencias {
  id bigint [pk, increment]
  user_id bigint
  entrada datetime
  saida datetime [null]
  created_at timestamp
  updated_at timestamp
}

Ref: matriculas.user_id > users.id
Ref: matriculas.plano_id > planos.id
Ref: treinos.user_id > users.id
Ref: treinos.professor_id > users.id
Ref: treino_exercicios.treino_id > treinos.id
Ref: treino_exercicios.exercicio_id > exercicios.id
Ref: progresso.user_id > users.id
Ref: progresso.professor_id > users.id
Ref: frequencias.user_id > users.id


<img width="1193" height="1148" alt="Untitled (4)" src="https://github.com/user-attachments/assets/f9198c9a-e02a-48af-aab7-97d67f1a8815" />

