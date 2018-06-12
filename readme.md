# School - API

## Objetivo
 - Criar um sistema para realizar toda a gestão de alunos matriculados.

## Grupos com Acesso

* Aluno
* Responsáveis (Pais de Aluno)
* Professores
* Administrador (Diretor de todas as escolas)

## Cadastros

* Escolas
* Pais
* Professores
* Matérias
* Alunos
* Notificações
* Transporte
  - Veículos
  - Motoristas
  - Rotas
* Classes
  - Matricula
  - Frequência
  - Notas
  - Atividades
  - Provas
* Calendário
  - Calendário letivo(por classe ou por escola)


## Regra de negócio

* CADASTRO

  Antes de cadastrar um aluno, a Mãe do Aluno de estar cadastrada.
  Uma mãe pode ter filhos de pais diferentes.

* CLASSES
  Opção duplicar classes e criar novas com o mesmo perfil(função será utilizada no final do ano), assim já deixar pré-matriculado os alunos aprovados da classe anterior.
  Frequência e Notas: Deverá haver um período para o lançamento de notas, se acaso o professorar não lançar a nota ou frequencia dentro do período, então deverá solicitar ao superior para abrir o período para lançamento.
  Associar Classes a Matérias, podendo selecionar os professores inscritos para aquela matéria e valindando se o professor não associado para outra classe ou escola no período selecionado.
  Associar Professor a Matérias;
  Tratar a questão de professor substituto;

* MATRÍCULA
  Pode-se matricular um aluno em uma classe, OU, matricular vários de uma só vez, ou seja, no final do ano, os alunos aprovados poderão se migrados do 3º para o 4º ano.

* TRANSPORTE
  Criar rotas de transporte.
  Associar estudantes a rotas

* PROFESSORES
  Lançamento de faltas, afastamento e atestados

## Dashboard

* Widget
  - Total de Estudantes
  - Total de Professores
  - Gráfico
      - Linha(mês corrente): Alunos Presentes x Alunos com Falta por dia
  - Eventos
      - Próximos Eventos
  - Grid:
      - Alunos com Maiores Notas
      - Alunos com Maior Frequência
      - Alunos com Pior Frequência
      - Aniversariantes da Semana
      - Professores com falta

### Dependencies
  - php 7.2
  - mysql 5.7
  - redis

### Como instalar

[Vídeo](https://www.youtube.com/watch?v=RHxsmFYcmIc)

```shell
composer create-project emtudo/school-api
cd school-api
php artisan jwt:generate
```

Configure o arquivo `.env`  antes de executar o comando abaixo para criar as tabelas do banco de dados:

```shell
php artisan migrator
```

### Como testar

```shell
php artisan serve
```

### Admin (Padrão)

- username: admin@user.com
- password: abc123
