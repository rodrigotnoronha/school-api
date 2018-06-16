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

[Vídeo de instalação](https://www.youtube.com/watch?v=RHxsmFYcmIc)

[Vídeo demonstração](https://www.youtube.com/watch?v=QXI84A-QnUA&t=136s)

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


### Rotas

| Method    | URI                                                                  | Name                                 | Action                                                                                   | Middleware                                          |
|-----------|----------------------------------------------------------------------|--------------------------------------|------------------------------------------------------------------------------------------|-----------------------------------------------------|
| GET\|HEAD  | /                                                                    | web::                                | Emtudo\Units\Core\Http\Controllers\WelcomeController@index                               | Closure                                             |
| POST      | auth/login                                                           | auth::login                          | Emtudo\Units\Auth\Http\Controllers\LoginController@login                                 | api,Closure                                         |
| POST      | auth/password/email                                                  | auth::forgot                         | Emtudo\Units\Auth\Http\Controllers\ForgotPasswordController@sendResetLinkEmail           | api,Closure                                         |
| POST      | auth/password/reset                                                  | auth::reset                          | Emtudo\Units\Auth\Http\Controllers\ResetPasswordController@reset                         | api,Closure                                         |
| POST      | auth/refresh                                                         | auth::refresh                        | Emtudo\Units\Auth\Http\Controllers\LoginController@refresh                               | api,Closure                                         |
| GET\|HEAD  | responsible/users/students                                           | responsible_users::                  | Emtudo\Units\Responsible\Users\Http\Controllers\StudentController@index                  | api,auth,responsible,Closure                        |
| PUT       | responsible/users/students/{user}                                    | responsible_users::                  | Emtudo\Units\Responsible\Users\Http\Controllers\StudentController@update                 | api,auth,responsible,Closure                        |
| GET\|HEAD  | responsible/users/students/{user}                                    | responsible_users::                  | Emtudo\Units\Responsible\Users\Http\Controllers\StudentController@show                   | api,auth,responsible,Closure                        |
| PUT       | responsible/users/users/me                                           | responsible_users::                  | Emtudo\Units\Responsible\Users\Http\Controllers\UserController@updateMe                  | api,auth,responsible,Closure                        |
| GET\|HEAD  | responsible/users/users/me                                           | responsible_users::                  | Emtudo\Units\Responsible\Users\Http\Controllers\UserController@showMe                    | api,auth,responsible,Closure                        |
| DELETE    | responsible/users/users/{user}/documents/{kind}                      | responsible_users::                  | Emtudo\Units\Responsible\Users\Http\Controllers\UserController@destroyDocument           | api,auth,responsible,Closure                        |
| GET\|HEAD  | responsible/users/users/{user}/documents/{kind}                      | responsible_users::                  | Emtudo\Units\Responsible\Users\Http\Controllers\UserController@getDocumetByKind          | api,auth,responsible,Closure                        |
| GET\|HEAD  | responsible/users/{student}/groups/{group}/frequencies/month/{month} | responsible_users::                  | Emtudo\Units\Responsible\Users\Http\Controllers\FrequencyController@getByGroup           | api,auth,responsible,responsible_of_student,Closure |
| GET\|HEAD  | responsible/users/{student}/groups/{group}/grades                    | responsible_users::                  | Emtudo\Units\Responsible\Users\Http\Controllers\GradeController@getByGroup               | api,auth,responsible,responsible_of_student,Closure |
| GET\|HEAD  | school/calendars/calendars                                           | school_calendars::calendars.index    | Emtudo\Units\School\Calendars\Http\Controllers\CalendarController@index                  | api,auth,admin,Closure                              |
| POST      | school/calendars/calendars                                           | school_calendars::calendars.store    | Emtudo\Units\School\Calendars\Http\Controllers\CalendarController@store                  | api,auth,admin,Closure                              |
| GET\|HEAD  | school/calendars/calendars/{calendar}                                | school_calendars::calendars.show     | Emtudo\Units\School\Calendars\Http\Controllers\CalendarController@show                   | api,auth,admin,Closure                              |
| PUT\|PATCH | school/calendars/calendars/{calendar}                                | school_calendars::calendars.update   | Emtudo\Units\School\Calendars\Http\Controllers\CalendarController@update                 | api,auth,admin,Closure                              |
| DELETE    | school/calendars/calendars/{calendar}                                | school_calendars::calendars.destroy  | Emtudo\Units\School\Calendars\Http\Controllers\CalendarController@destroy                | api,auth,admin,Closure                              |
| GET\|HEAD  | school/calendars/events                                              | school_calendars::events.index       | Emtudo\Units\School\Calendars\Http\Controllers\EventController@index                     | api,auth,admin,Closure                              |
| POST      | school/calendars/events                                              | school_calendars::events.store       | Emtudo\Units\School\Calendars\Http\Controllers\EventController@store                     | api,auth,admin,Closure                              |
| GET\|HEAD  | school/calendars/events/{event}                                      | school_calendars::events.show        | Emtudo\Units\School\Calendars\Http\Controllers\EventController@show                      | api,auth,admin,Closure                              |
| PUT\|PATCH | school/calendars/events/{event}                                      | school_calendars::events.update      | Emtudo\Units\School\Calendars\Http\Controllers\EventController@update                    | api,auth,admin,Closure                              |
| DELETE    | school/calendars/events/{event}                                      | school_calendars::events.destroy     | Emtudo\Units\School\Calendars\Http\Controllers\EventController@destroy                   | api,auth,admin,Closure                              |
| GET\|HEAD  | school/calendars/school_days/holidays_from_year/{year}               | school_calendars::                   | Emtudo\Units\School\Calendars\Http\Controllers\SchoolDayController@holidaysFromYear      | api,auth,admin,Closure                              |
| GET\|HEAD  | school/calendars/school_days/holidays_in_current_year                | school_calendars::                   | Emtudo\Units\School\Calendars\Http\Controllers\SchoolDayController@holidaysInCurrentYear | api,auth,admin,Closure                              |
| PUT       | school/calendars/school_days/toggle                                  | school_calendars::                   | Emtudo\Units\School\Calendars\Http\Controllers\SchoolDayController@toggle                | api,auth,admin,Closure                              |
| POST      | school/calendars/two_months                                          | school_calendars::store              | Emtudo\Units\School\Calendars\Http\Controllers\TwoMonthController@store                  | api,auth,admin,Closure                              |
| GET\|HEAD  | school/calendars/two_months                                          | school_calendars::index              | Emtudo\Units\School\Calendars\Http\Controllers\TwoMonthController@index                  | api,auth,admin,Closure                              |
| GET\|HEAD  | school/calendars/two_months/{two_month}                              | school_calendars::show               | Emtudo\Units\School\Calendars\Http\Controllers\TwoMonthController@show                   | api,auth,admin,Closure                              |
| PUT       | school/calendars/two_months/{two_month}                              | school_calendars::update             | Emtudo\Units\School\Calendars\Http\Controllers\TwoMonthController@update                 | api,auth,admin,Closure                              |
| POST      | school/courses/courses                                               | school_courses::courses.store        | Emtudo\Units\School\Courses\Http\Controllers\CourseController@store                      | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/courses                                               | school_courses::courses.index        | Emtudo\Units\School\Courses\Http\Controllers\CourseController@index                      | api,auth,admin,Closure                              |
| DELETE    | school/courses/courses/{course}                                      | school_courses::courses.destroy      | Emtudo\Units\School\Courses\Http\Controllers\CourseController@destroy                    | api,auth,admin,Closure                              |
| PUT\|PATCH | school/courses/courses/{course}                                      | school_courses::courses.update       | Emtudo\Units\School\Courses\Http\Controllers\CourseController@update                     | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/courses/{course}                                      | school_courses::courses.show         | Emtudo\Units\School\Courses\Http\Controllers\CourseController@show                       | api,auth,admin,Closure                              |
| POST      | school/courses/enrollments                                           | school_courses::enrollments.store    | Emtudo\Units\School\Courses\Http\Controllers\EnrollmentController@store                  | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/enrollments                                           | school_courses::enrollments.index    | Emtudo\Units\School\Courses\Http\Controllers\EnrollmentController@index                  | api,auth,admin,Closure                              |
| DELETE    | school/courses/enrollments/{enrollment}                              | school_courses::enrollments.destroy  | Emtudo\Units\School\Courses\Http\Controllers\EnrollmentController@destroy                | api,auth,admin,Closure                              |
| PUT\|PATCH | school/courses/enrollments/{enrollment}                              | school_courses::enrollments.update   | Emtudo\Units\School\Courses\Http\Controllers\EnrollmentController@update                 | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/enrollments/{enrollment}                              | school_courses::enrollments.show     | Emtudo\Units\School\Courses\Http\Controllers\EnrollmentController@show                   | api,auth,admin,Closure                              |
| POST      | school/courses/frequencies                                           | school_courses::frequencies.store    | Emtudo\Units\School\Courses\Http\Controllers\FrequencyController@store                   | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/frequencies                                           | school_courses::frequencies.index    | Emtudo\Units\School\Courses\Http\Controllers\FrequencyController@index                   | api,auth,admin,Closure                              |
| POST      | school/courses/frequencies/several                                   | school_courses::several              | Emtudo\Units\School\Courses\Http\Controllers\FrequencyController@storeSeveral            | api,auth,admin,Closure                              |
| DELETE    | school/courses/frequencies/{frequency}                               | school_courses::frequencies.destroy  | Emtudo\Units\School\Courses\Http\Controllers\FrequencyController@destroy                 | api,auth,admin,Closure                              |
| PUT\|PATCH | school/courses/frequencies/{frequency}                               | school_courses::frequencies.update   | Emtudo\Units\School\Courses\Http\Controllers\FrequencyController@update                  | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/frequencies/{frequency}                               | school_courses::frequencies.show     | Emtudo\Units\School\Courses\Http\Controllers\FrequencyController@show                    | api,auth,admin,Closure                              |
| POST      | school/courses/grades                                                | school_courses::grades.store         | Emtudo\Units\School\Courses\Http\Controllers\GradeController@store                       | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/grades                                                | school_courses::grades.index         | Emtudo\Units\School\Courses\Http\Controllers\GradeController@index                       | api,auth,admin,Closure                              |
| POST      | school/courses/grades/several                                        | school_courses::several              | Emtudo\Units\School\Courses\Http\Controllers\GradeController@storeSeveral                | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/grades/{grade}                                        | school_courses::grades.show          | Emtudo\Units\School\Courses\Http\Controllers\GradeController@show                        | api,auth,admin,Closure                              |
| PUT\|PATCH | school/courses/grades/{grade}                                        | school_courses::grades.update        | Emtudo\Units\School\Courses\Http\Controllers\GradeController@update                      | api,auth,admin,Closure                              |
| DELETE    | school/courses/grades/{grade}                                        | school_courses::grades.destroy       | Emtudo\Units\School\Courses\Http\Controllers\GradeController@destroy                     | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/groups                                                | school_courses::groups.index         | Emtudo\Units\School\Courses\Http\Controllers\GroupController@index                       | api,auth,admin,Closure                              |
| POST      | school/courses/groups                                                | school_courses::groups.store         | Emtudo\Units\School\Courses\Http\Controllers\GroupController@store                       | api,auth,admin,Closure                              |
| DELETE    | school/courses/groups/{group}                                        | school_courses::groups.destroy       | Emtudo\Units\School\Courses\Http\Controllers\GroupController@destroy                     | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/groups/{group}                                        | school_courses::groups.show          | Emtudo\Units\School\Courses\Http\Controllers\GroupController@show                        | api,auth,admin,Closure                              |
| PUT\|PATCH | school/courses/groups/{group}                                        | school_courses::groups.update        | Emtudo\Units\School\Courses\Http\Controllers\GroupController@update                      | api,auth,admin,Closure                              |
| POST      | school/courses/questions                                             | school_courses::questions.store      | Emtudo\Units\School\Courses\Http\Controllers\QuestionController@store                    | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/questions                                             | school_courses::questions.index      | Emtudo\Units\School\Courses\Http\Controllers\QuestionController@index                    | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/questions/{question}                                  | school_courses::questions.show       | Emtudo\Units\School\Courses\Http\Controllers\QuestionController@show                     | api,auth,admin,Closure                              |
| PUT\|PATCH | school/courses/questions/{question}                                  | school_courses::questions.update     | Emtudo\Units\School\Courses\Http\Controllers\QuestionController@update                   | api,auth,admin,Closure                              |
| DELETE    | school/courses/questions/{question}                                  | school_courses::questions.destroy    | Emtudo\Units\School\Courses\Http\Controllers\QuestionController@destroy                  | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/quizzes                                               | school_courses::quizzes.index        | Emtudo\Units\School\Courses\Http\Controllers\QuizController@index                        | api,auth,admin,Closure                              |
| POST      | school/courses/quizzes                                               | school_courses::quizzes.store        | Emtudo\Units\School\Courses\Http\Controllers\QuizController@store                        | api,auth,admin,Closure                              |
| DELETE    | school/courses/quizzes/{quiz}                                        | school_courses::quizzes.destroy      | Emtudo\Units\School\Courses\Http\Controllers\QuizController@destroy                      | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/quizzes/{quiz}                                        | school_courses::quizzes.show         | Emtudo\Units\School\Courses\Http\Controllers\QuizController@show                         | api,auth,admin,Closure                              |
| PUT\|PATCH | school/courses/quizzes/{quiz}                                        | school_courses::quizzes.update       | Emtudo\Units\School\Courses\Http\Controllers\QuizController@update                       | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/schedules                                             | school_courses::schedules.index      | Emtudo\Units\School\Courses\Http\Controllers\ScheduleController@index                    | api,auth,admin,Closure                              |
| POST      | school/courses/schedules                                             | school_courses::schedules.store      | Emtudo\Units\School\Courses\Http\Controllers\ScheduleController@store                    | api,auth,admin,Closure                              |
| DELETE    | school/courses/schedules/{schedule}                                  | school_courses::schedules.destroy    | Emtudo\Units\School\Courses\Http\Controllers\ScheduleController@destroy                  | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/schedules/{schedule}                                  | school_courses::schedules.show       | Emtudo\Units\School\Courses\Http\Controllers\ScheduleController@show                     | api,auth,admin,Closure                              |
| PUT\|PATCH | school/courses/schedules/{schedule}                                  | school_courses::schedules.update     | Emtudo\Units\School\Courses\Http\Controllers\ScheduleController@update                   | api,auth,admin,Closure                              |
| POST      | school/courses/skills                                                | school_courses::skills.store         | Emtudo\Units\School\Courses\Http\Controllers\SkillController@store                       | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/skills                                                | school_courses::skills.index         | Emtudo\Units\School\Courses\Http\Controllers\SkillController@index                       | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/skills/{skill}                                        | school_courses::skills.show          | Emtudo\Units\School\Courses\Http\Controllers\SkillController@show                        | api,auth,admin,Closure                              |
| PUT\|PATCH | school/courses/skills/{skill}                                        | school_courses::skills.update        | Emtudo\Units\School\Courses\Http\Controllers\SkillController@update                      | api,auth,admin,Closure                              |
| DELETE    | school/courses/skills/{skill}                                        | school_courses::skills.destroy       | Emtudo\Units\School\Courses\Http\Controllers\SkillController@destroy                     | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/subjects                                              | school_courses::subjects.index       | Emtudo\Units\School\Courses\Http\Controllers\SubjectController@index                     | api,auth,admin,Closure                              |
| POST      | school/courses/subjects                                              | school_courses::subjects.store       | Emtudo\Units\School\Courses\Http\Controllers\SubjectController@store                     | api,auth,admin,Closure                              |
| GET\|HEAD  | school/courses/subjects/{subject}                                    | school_courses::subjects.show        | Emtudo\Units\School\Courses\Http\Controllers\SubjectController@show                      | api,auth,admin,Closure                              |
| DELETE    | school/courses/subjects/{subject}                                    | school_courses::subjects.destroy     | Emtudo\Units\School\Courses\Http\Controllers\SubjectController@destroy                   | api,auth,admin,Closure                              |
| PUT\|PATCH | school/courses/subjects/{subject}                                    | school_courses::subjects.update      | Emtudo\Units\School\Courses\Http\Controllers\SubjectController@update                    | api,auth,admin,Closure                              |
| GET\|HEAD  | school/dashboard                                                     | school_dashboard::                   | Emtudo\Units\School\Dashboard\Http\Controllers\DashboardController@index                 | api,auth,admin,Closure                              |
| GET\|HEAD  | school/schools/schools                                               | school_schools::schools.index        | Emtudo\Units\School\Schools\Http\Controllers\SchoolController@index                      | api,auth,admin,Closure                              |
| POST      | school/schools/schools                                               | school_schools::schools.store        | Emtudo\Units\School\Schools\Http\Controllers\SchoolController@store                      | api,auth,admin,Closure                              |
| GET\|HEAD  | school/schools/schools/{school}                                      | school_schools::schools.show         | Emtudo\Units\School\Schools\Http\Controllers\SchoolController@show                       | api,auth,admin,Closure                              |
| DELETE    | school/schools/schools/{school}                                      | school_schools::schools.destroy      | Emtudo\Units\School\Schools\Http\Controllers\SchoolController@destroy                    | api,auth,admin,Closure                              |
| PUT\|PATCH | school/schools/schools/{school}                                      | school_schools::schools.update       | Emtudo\Units\School\Schools\Http\Controllers\SchoolController@update                     | api,auth,admin,Closure                              |
| GET\|HEAD  | school/transports/routes                                             | school_transports::routes.index      | Emtudo\Units\School\Transports\Http\Controllers\RouteController@index                    | api,auth,admin,Closure                              |
| POST      | school/transports/routes                                             | school_transports::routes.store      | Emtudo\Units\School\Transports\Http\Controllers\RouteController@store                    | api,auth,admin,Closure                              |
| DELETE    | school/transports/routes/{route}                                     | school_transports::routes.destroy    | Emtudo\Units\School\Transports\Http\Controllers\RouteController@destroy                  | api,auth,admin,Closure                              |
| PUT\|PATCH | school/transports/routes/{route}                                     | school_transports::routes.update     | Emtudo\Units\School\Transports\Http\Controllers\RouteController@update                   | api,auth,admin,Closure                              |
| GET\|HEAD  | school/transports/routes/{route}                                     | school_transports::routes.show       | Emtudo\Units\School\Transports\Http\Controllers\RouteController@show                     | api,auth,admin,Closure                              |
| POST      | school/transports/stops                                              | school_transports::stops.store       | Emtudo\Units\School\Transports\Http\Controllers\StopController@store                     | api,auth,admin,Closure                              |
| GET\|HEAD  | school/transports/stops                                              | school_transports::stops.index       | Emtudo\Units\School\Transports\Http\Controllers\StopController@index                     | api,auth,admin,Closure                              |
| GET\|HEAD  | school/transports/stops/{stop}                                       | school_transports::stops.show        | Emtudo\Units\School\Transports\Http\Controllers\StopController@show                      | api,auth,admin,Closure                              |
| PUT\|PATCH | school/transports/stops/{stop}                                       | school_transports::stops.update      | Emtudo\Units\School\Transports\Http\Controllers\StopController@update                    | api,auth,admin,Closure                              |
| DELETE    | school/transports/stops/{stop}                                       | school_transports::stops.destroy     | Emtudo\Units\School\Transports\Http\Controllers\StopController@destroy                   | api,auth,admin,Closure                              |
| GET\|HEAD  | school/transports/vehicles                                           | school_transports::vehicles.index    | Emtudo\Units\School\Transports\Http\Controllers\VehicleController@index                  | api,auth,admin,Closure                              |
| POST      | school/transports/vehicles                                           | school_transports::vehicles.store    | Emtudo\Units\School\Transports\Http\Controllers\VehicleController@store                  | api,auth,admin,Closure                              |
| DELETE    | school/transports/vehicles/{vehicle}                                 | school_transports::vehicles.destroy  | Emtudo\Units\School\Transports\Http\Controllers\VehicleController@destroy                | api,auth,admin,Closure                              |
| GET\|HEAD  | school/transports/vehicles/{vehicle}                                 | school_transports::vehicles.show     | Emtudo\Units\School\Transports\Http\Controllers\VehicleController@show                   | api,auth,admin,Closure                              |
| PUT\|PATCH | school/transports/vehicles/{vehicle}                                 | school_transports::vehicles.update   | Emtudo\Units\School\Transports\Http\Controllers\VehicleController@update                 | api,auth,admin,Closure                              |
| POST      | school/users/managers                                                | school_users::managers.store         | Emtudo\Units\School\Users\Http\Controllers\ManagerController@store                       | api,auth,admin,Closure                              |
| GET\|HEAD  | school/users/managers                                                | school_users::managers.index         | Emtudo\Units\School\Users\Http\Controllers\ManagerController@index                       | api,auth,admin,Closure                              |
| PUT\|PATCH | school/users/managers/{manager}                                      | school_users::managers.update        | Emtudo\Units\School\Users\Http\Controllers\ManagerController@update                      | api,auth,admin,Closure                              |
| GET\|HEAD  | school/users/managers/{manager}                                      | school_users::managers.show          | Emtudo\Units\School\Users\Http\Controllers\ManagerController@show                        | api,auth,admin,Closure                              |
| DELETE    | school/users/managers/{manager}                                      | school_users::managers.destroy       | Emtudo\Units\School\Users\Http\Controllers\ManagerController@destroy                     | api,auth,admin,Closure                              |
| POST      | school/users/responsibles                                            | school_users::responsibles.store     | Emtudo\Units\School\Users\Http\Controllers\ResponsibleController@store                   | api,auth,admin,Closure                              |
| GET\|HEAD  | school/users/responsibles                                            | school_users::responsibles.index     | Emtudo\Units\School\Users\Http\Controllers\ResponsibleController@index                   | api,auth,admin,Closure                              |
| DELETE    | school/users/responsibles/{responsible}                              | school_users::responsibles.destroy   | Emtudo\Units\School\Users\Http\Controllers\ResponsibleController@destroy                 | api,auth,admin,Closure                              |
| PUT\|PATCH | school/users/responsibles/{responsible}                              | school_users::responsibles.update    | Emtudo\Units\School\Users\Http\Controllers\ResponsibleController@update                  | api,auth,admin,Closure                              |
| GET\|HEAD  | school/users/responsibles/{responsible}                              | school_users::responsibles.show      | Emtudo\Units\School\Users\Http\Controllers\ResponsibleController@show                    | api,auth,admin,Closure                              |
| GET\|HEAD  | school/users/students                                                | school_users::students.index         | Emtudo\Units\School\Users\Http\Controllers\StudentController@index                       | api,auth,admin,Closure                              |
| POST      | school/users/students                                                | school_users::students.store         | Emtudo\Units\School\Users\Http\Controllers\StudentController@store                       | api,auth,admin,Closure                              |
| DELETE    | school/users/students/{student}                                      | school_users::students.destroy       | Emtudo\Units\School\Users\Http\Controllers\StudentController@destroy                     | api,auth,admin,Closure                              |
| PUT\|PATCH | school/users/students/{student}                                      | school_users::students.update        | Emtudo\Units\School\Users\Http\Controllers\StudentController@update                      | api,auth,admin,Closure                              |
| GET\|HEAD  | school/users/students/{student}                                      | school_users::students.show          | Emtudo\Units\School\Users\Http\Controllers\StudentController@show                        | api,auth,admin,Closure                              |
| POST      | school/users/teachers                                                | school_users::teachers.store         | Emtudo\Units\School\Users\Http\Controllers\TeacherController@store                       | api,auth,admin,Closure                              |
| GET\|HEAD  | school/users/teachers                                                | school_users::teachers.index         | Emtudo\Units\School\Users\Http\Controllers\TeacherController@index                       | api,auth,admin,Closure                              |
| DELETE    | school/users/teachers/{teacher}                                      | school_users::teachers.destroy       | Emtudo\Units\School\Users\Http\Controllers\TeacherController@destroy                     | api,auth,admin,Closure                              |
| GET\|HEAD  | school/users/teachers/{teacher}                                      | school_users::teachers.show          | Emtudo\Units\School\Users\Http\Controllers\TeacherController@show                        | api,auth,admin,Closure                              |
| PUT\|PATCH | school/users/teachers/{teacher}                                      | school_users::teachers.update        | Emtudo\Units\School\Users\Http\Controllers\TeacherController@update                      | api,auth,admin,Closure                              |
| GET\|HEAD  | school/users/users                                                   | school_users::users.index            | Emtudo\Units\School\Users\Http\Controllers\UserController@index                          | api,auth,admin,Closure                              |
| POST      | school/users/users                                                   | school_users::users.store            | Emtudo\Units\School\Users\Http\Controllers\UserController@store                          | api,auth,admin,Closure                              |
| GET\|HEAD  | school/users/users/me                                                | school_users::                       | Emtudo\Units\School\Users\Http\Controllers\UserController@showMe                         | api,auth,admin,Closure                              |
| PUT       | school/users/users/me                                                | school_users::                       | Emtudo\Units\School\Users\Http\Controllers\UserController@updateMe                       | api,auth,admin,Closure                              |
| GET\|HEAD  | school/users/users/{user}                                            | school_users::users.show             | Emtudo\Units\School\Users\Http\Controllers\UserController@show                           | api,auth,admin,Closure                              |
| PUT\|PATCH | school/users/users/{user}                                            | school_users::users.update           | Emtudo\Units\School\Users\Http\Controllers\UserController@update                         | api,auth,admin,Closure                              |
| DELETE    | school/users/users/{user}                                            | school_users::users.destroy          | Emtudo\Units\School\Users\Http\Controllers\UserController@destroy                        | api,auth,admin,Closure                              |
| GET\|HEAD  | school/users/users/{user}/documents/{kind}                           | school_users::                       | Emtudo\Units\School\Users\Http\Controllers\UserController@getDocumetByKind               | api,auth,admin,Closure                              |
| DELETE    | school/users/users/{user}/documents/{kind}                           | school_users::                       | Emtudo\Units\School\Users\Http\Controllers\UserController@destroyDocument                | api,auth,admin,Closure                              |
| GET\|HEAD  | settings/profile/me                                                  | settings::profile.show               | Emtudo\Units\Settings\Http\Controllers\ProfileController@show                            | api,auth,Closure                                    |
| PUT       | settings/profile/me                                                  | settings::profile.update             | Emtudo\Units\Settings\Http\Controllers\ProfileController@update                          | api,auth,Closure                                    |
| GET\|HEAD  | settings/profile/me/documents/{kind}                                 | settings::get_document               | Emtudo\Units\Settings\Http\Controllers\DocumentController@getDocumetByKind               | api,auth,Closure                                    |
| DELETE    | settings/profile/me/documents/{kind}                                 | settings::delete_document            | Emtudo\Units\Settings\Http\Controllers\DocumentController@destroy                        | api,auth,Closure                                    |
| POST      | settings/users/me/avatars                                            | settings::update_avatar              | Emtudo\Units\Settings\Http\Controllers\AvatarController@update                           | api,auth,Closure                                    |
| POST      | settings/users/me/documents                                          | settings::update_document            | Emtudo\Units\Settings\Http\Controllers\DocumentController@update                         | api,auth,Closure                                    |
| POST      | settings/users/{user}/avatars                                        | settings::update_avatar              | Emtudo\Units\Settings\Http\Controllers\AvatarController@updateUser                       | api,auth,Closure                                    |
| POST      | settings/users/{user}/documents                                      | settings::update_document            | Emtudo\Units\Settings\Http\Controllers\DocumentController@updateUser                     | api,auth,Closure                                    |
| GET\|HEAD  | student/courses/courses                                              | student_courses::courses.index       | Emtudo\Units\Student\Courses\Http\Controllers\CourseController@index                     | api,auth,Closure                                    |
| GET\|HEAD  | student/courses/courses/{course}                                     | student_courses::courses.show        | Emtudo\Units\Student\Courses\Http\Controllers\CourseController@show                      | api,auth,Closure                                    |
| GET\|HEAD  | student/courses/enrollments                                          | student_courses::enrollments.index   | Emtudo\Units\Student\Courses\Http\Controllers\EnrollmentController@index                 | api,auth,Closure                                    |
| GET\|HEAD  | student/courses/enrollments/{enrollment}                             | student_courses::enrollments.show    | Emtudo\Units\Student\Courses\Http\Controllers\EnrollmentController@show                  | api,auth,Closure                                    |
| GET\|HEAD  | student/courses/groups                                               | student_courses::groups.index        | Emtudo\Units\Student\Courses\Http\Controllers\GroupController@index                      | api,auth,Closure                                    |
| GET\|HEAD  | student/courses/groups/{group}                                       | student_courses::groups.show         | Emtudo\Units\Student\Courses\Http\Controllers\GroupController@show                       | api,auth,Closure                                    |
| GET\|HEAD  | student/courses/questions                                            | student_courses::questions.index     | Emtudo\Units\Student\Courses\Http\Controllers\QuestionController@index                   | api,auth,Closure                                    |
| GET\|HEAD  | student/courses/questions/{question}                                 | student_courses::questions.show      | Emtudo\Units\Student\Courses\Http\Controllers\QuestionController@show                    | api,auth,Closure                                    |
| GET\|HEAD  | student/courses/quizzes                                              | student_courses::quizzes.index       | Emtudo\Units\Student\Courses\Http\Controllers\QuizController@index                       | api,auth,Closure                                    |
| GET\|HEAD  | student/courses/quizzes/{quiz}                                       | student_courses::quizzes.show        | Emtudo\Units\Student\Courses\Http\Controllers\QuizController@show                        | api,auth,Closure                                    |
| GET\|HEAD  | student/courses/schedules                                            | student_courses::schedules.index     | Emtudo\Units\Student\Courses\Http\Controllers\ScheduleController@index                   | api,auth,Closure                                    |
| GET\|HEAD  | student/courses/schedules/{schedule}                                 | student_courses::schedules.show      | Emtudo\Units\Student\Courses\Http\Controllers\ScheduleController@show                    | api,auth,Closure                                    |
| GET\|HEAD  | student/schools/schools                                              | student_schools::schools.index       | Emtudo\Units\Student\Schools\Http\Controllers\SchoolController@index                     | api,auth,Closure                                    |
| GET\|HEAD  | student/schools/schools/{school}                                     | student_schools::schools.show        | Emtudo\Units\Student\Schools\Http\Controllers\SchoolController@show                      | api,auth,Closure                                    |
| GET\|HEAD  | student/transports/routes                                            | student_transports::routes.index     | Emtudo\Units\Student\Transports\Http\Controllers\RouteController@index                   | api,auth,Closure                                    |
| GET\|HEAD  | student/transports/routes/{route}                                    | student_transports::routes.show      | Emtudo\Units\Student\Transports\Http\Controllers\RouteController@show                    | api,auth,Closure                                    |
| GET\|HEAD  | student/transports/stops                                             | student_transports::stops.index      | Emtudo\Units\Student\Transports\Http\Controllers\StopController@index                    | api,auth,Closure                                    |
| GET\|HEAD  | student/transports/stops/{stop}                                      | student_transports::stops.show       | Emtudo\Units\Student\Transports\Http\Controllers\StopController@show                     | api,auth,Closure                                    |
| GET\|HEAD  | student/transports/vehicles                                          | student_transports::vehicles.index   | Emtudo\Units\Student\Transports\Http\Controllers\VehicleController@index                 | api,auth,Closure                                    |
| GET\|HEAD  | student/transports/vehicles/{vehicle}                                | student_transports::vehicles.show    | Emtudo\Units\Student\Transports\Http\Controllers\VehicleController@show                  | api,auth,Closure                                    |
| GET\|HEAD  | student/users/me/groups/{group}/frequencies/month/{month}            | student_users::                      | Emtudo\Units\Student\Users\Http\Controllers\FrequencyController@getByGroupFromMe         | api,auth,admin,Closure                              |
| GET\|HEAD  | student/users/me/groups/{group}/grades                               | student_users::                      | Emtudo\Units\Student\Users\Http\Controllers\GradeController@getByGroupFromMe             | api,auth,admin,Closure                              |
| GET\|HEAD  | student/users/users/me                                               | student_users::                      | Emtudo\Units\Student\Users\Http\Controllers\UserController@showMe                        | api,auth,admin,Closure                              |
| PUT       | student/users/users/me                                               | student_users::                      | Emtudo\Units\Student\Users\Http\Controllers\UserController@updateMe                      | api,auth,admin,Closure                              |
| DELETE    | student/users/users/{user}/documents/{kind}                          | student_users::                      | Emtudo\Units\Student\Users\Http\Controllers\UserController@destroyDocument               | api,auth,admin,Closure                              |
| GET\|HEAD  | student/users/users/{user}/documents/{kind}                          | student_users::                      | Emtudo\Units\Student\Users\Http\Controllers\UserController@getDocumetByKind              | api,auth,admin,Closure                              |
| GET\|HEAD  | student/users/{student}/groups/{group}/frequencies/month/{month}     | student_users::                      | Emtudo\Units\Student\Users\Http\Controllers\FrequencyController@getByGroup               | api,auth,admin,responsible_of_student,Closure       |
| GET\|HEAD  | student/users/{student}/groups/{group}/grades                        | student_users::                      | Emtudo\Units\Student\Users\Http\Controllers\GradeController@getByGroup                   | api,auth,admin,responsible_of_student,Closure       |
| POST      | teacher/courses/frequencies                                          | teacher_courses::frequencies.store   | Emtudo\Units\Teacher\Courses\Http\Controllers\FrequencyController@store                  | api,auth,teacher,Closure                            |
| GET\|HEAD  | teacher/courses/frequencies                                          | teacher_courses::frequencies.index   | Emtudo\Units\Teacher\Courses\Http\Controllers\FrequencyController@index                  | api,auth,teacher,Closure                            |
| POST      | teacher/courses/frequencies/several                                  | teacher_courses::several             | Emtudo\Units\Teacher\Courses\Http\Controllers\FrequencyController@storeSeveral           | api,auth,teacher,Closure                            |
| GET\|HEAD  | teacher/courses/frequencies/{frequency}                              | teacher_courses::frequencies.show    | Emtudo\Units\Teacher\Courses\Http\Controllers\FrequencyController@show                   | api,auth,teacher,Closure                            |
| PUT\|PATCH | teacher/courses/frequencies/{frequency}                              | teacher_courses::frequencies.update  | Emtudo\Units\Teacher\Courses\Http\Controllers\FrequencyController@update                 | api,auth,teacher,Closure                            |
| DELETE    | teacher/courses/frequencies/{frequency}                              | teacher_courses::frequencies.destroy | Emtudo\Units\Teacher\Courses\Http\Controllers\FrequencyController@destroy                | api,auth,teacher,Closure                            |
| POST      | teacher/courses/grades                                               | teacher_courses::grades.store        | Emtudo\Units\Teacher\Courses\Http\Controllers\GradeController@store                      | api,auth,teacher,Closure                            |
| GET\|HEAD  | teacher/courses/grades                                               | teacher_courses::grades.index        | Emtudo\Units\Teacher\Courses\Http\Controllers\GradeController@index                      | api,auth,teacher,Closure                            |
| POST      | teacher/courses/grades/several                                       | teacher_courses::several             | Emtudo\Units\Teacher\Courses\Http\Controllers\GradeController@storeSeveral               | api,auth,teacher,Closure                            |
| PUT\|PATCH | teacher/courses/grades/{grade}                                       | teacher_courses::grades.update       | Emtudo\Units\Teacher\Courses\Http\Controllers\GradeController@update                     | api,auth,teacher,Closure                            |
| DELETE    | teacher/courses/grades/{grade}                                       | teacher_courses::grades.destroy      | Emtudo\Units\Teacher\Courses\Http\Controllers\GradeController@destroy                    | api,auth,teacher,Closure                            |
| GET\|HEAD  | teacher/courses/grades/{grade}                                       | teacher_courses::grades.show         | Emtudo\Units\Teacher\Courses\Http\Controllers\GradeController@show                       | api,auth,teacher,Closure                            |
| GET\|HEAD  | teacher/courses/groups                                               | teacher_courses::groups.index        | Emtudo\Units\Teacher\Courses\Http\Controllers\GroupController@index                      | api,auth,teacher,Closure                            |
| POST      | teacher/courses/groups                                               | teacher_courses::groups.store        | Emtudo\Units\Teacher\Courses\Http\Controllers\GroupController@store                      | api,auth,teacher,Closure                            |
| GET\|HEAD  | teacher/courses/groups/{group}                                       | teacher_courses::groups.show         | Emtudo\Units\Teacher\Courses\Http\Controllers\GroupController@show                       | api,auth,teacher,Closure                            |
| PUT\|PATCH | teacher/courses/groups/{group}                                       | teacher_courses::groups.update       | Emtudo\Units\Teacher\Courses\Http\Controllers\GroupController@update                     | api,auth,teacher,Closure                            |
| DELETE    | teacher/courses/groups/{group}                                       | teacher_courses::groups.destroy      | Emtudo\Units\Teacher\Courses\Http\Controllers\GroupController@destroy                    | api,auth,teacher,Closure                            |
| GET\|HEAD  | teacher/courses/quizzes                                              | teacher_courses::quizzes.index       | Emtudo\Units\Teacher\Courses\Http\Controllers\QuizController@index                       | api,auth,teacher,Closure                            |
| POST      | teacher/courses/quizzes                                              | teacher_courses::quizzes.store       | Emtudo\Units\Teacher\Courses\Http\Controllers\QuizController@store                       | api,auth,teacher,Closure                            |
| DELETE    | teacher/courses/quizzes/{quiz}                                       | teacher_courses::quizzes.destroy     | Emtudo\Units\Teacher\Courses\Http\Controllers\QuizController@destroy                     | api,auth,teacher,Closure                            |
| PUT\|PATCH | teacher/courses/quizzes/{quiz}                                       | teacher_courses::quizzes.update      | Emtudo\Units\Teacher\Courses\Http\Controllers\QuizController@update                      | api,auth,teacher,Closure                            |
| GET\|HEAD  | teacher/courses/quizzes/{quiz}                                       | teacher_courses::quizzes.show        | Emtudo\Units\Teacher\Courses\Http\Controllers\QuizController@show                        | api,auth,teacher,Closure                            |
| GET\|HEAD  | teacher/courses/subjects                                             | teacher_courses::subjects.index      | Emtudo\Units\Teacher\Courses\Http\Controllers\SubjectController@index                    | api,auth,teacher,Closure                            |
| POST      | teacher/courses/subjects                                             | teacher_courses::subjects.store      | Emtudo\Units\Teacher\Courses\Http\Controllers\SubjectController@store                    | api,auth,teacher,Closure                            |
| GET\|HEAD  | teacher/courses/subjects/{subject}                                   | teacher_courses::subjects.show       | Emtudo\Units\Teacher\Courses\Http\Controllers\SubjectController@show                     | api,auth,teacher,Closure                            |
| DELETE    | teacher/courses/subjects/{subject}                                   | teacher_courses::subjects.destroy    | Emtudo\Units\Teacher\Courses\Http\Controllers\SubjectController@destroy                  | api,auth,teacher,Closure                            |
| PUT\|PATCH | teacher/courses/subjects/{subject}                                   | teacher_courses::subjects.update     | Emtudo\Units\Teacher\Courses\Http\Controllers\SubjectController@update                   | api,auth,teacher,Closure                            |
| GET\|HEAD  | teacher/users/students                                               | teacher_users::students.index        | Emtudo\Units\Teacher\Users\Http\Controllers\StudentController@index                      | api,auth,teacher,Closure                            |
| GET\|HEAD  | teacher/users/students/search                                        | teacher_users::students.search       | Emtudo\Units\Teacher\Users\Http\Controllers\StudentController@index                      | api,auth,teacher,Closure                            |
| GET\|HEAD  | teacher/users/students/{student}                                     | teacher_users::students.show         | Emtudo\Units\Teacher\Users\Http\Controllers\StudentController@show                       | api,auth,teacher,Closure                            |
| GET\|HEAD  | teacher/users/users/me                                               | teacher_users::                      | Emtudo\Units\Teacher\Users\Http\Controllers\UserController@showMe                        | api,auth,teacher,Closure                            |
| PUT       | teacher/users/users/me                                               | teacher_users::                      | Emtudo\Units\Teacher\Users\Http\Controllers\UserController@updateMe                      | api,auth,teacher,Closure                            |
| GET\|HEAD  | teacher/users/users/{user}/documents/{kind}                          | teacher_users::                      | Emtudo\Units\Teacher\Users\Http\Controllers\UserController@getDocumetByKind              | api,auth,teacher,Closure                            |
| POST      | tenant/change                                                        | tenant::change_tenant                | Emtudo\Units\Tenant\Http\Controllers\TenantController@changeTenant                       | api,auth,Closure                                    |
| GET\|HEAD  | tenant/notifications/last                                            | tenant::notifications.last           | Emtudo\Units\Tenant\Http\Controllers\NotificationController@last                         | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/courses                                            | search_courses::courses.index        | Emtudo\Units\Search\Courses\Http\Controllers\CourseController@index                      | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/courses/search                                     | search_courses::courses.search       | Emtudo\Units\Search\Courses\Http\Controllers\CourseController@index                      | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/courses/{course}                                   | search_courses::courses.show         | Emtudo\Units\Search\Courses\Http\Controllers\CourseController@show                       | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/enrollments                                        | search_courses::enrollments.index    | Emtudo\Units\Search\Courses\Http\Controllers\EnrollmentController@index                  | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/enrollments/search                                 | search_courses::enrollments.search   | Emtudo\Units\Search\Courses\Http\Controllers\EnrollmentController@index                  | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/enrollments/{enrollment}                           | search_courses::enrollments.show     | Emtudo\Units\Search\Courses\Http\Controllers\EnrollmentController@show                   | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/frequencies                                        | search_courses::frequencies.index    | Emtudo\Units\Search\Courses\Http\Controllers\FrequencyController@index                   | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/frequencies/search                                 | search_courses::frequencies.search   | Emtudo\Units\Search\Courses\Http\Controllers\FrequencyController@index                   | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/frequencies/{frequency}                            | search_courses::frequencies.show     | Emtudo\Units\Search\Courses\Http\Controllers\FrequencyController@show                    | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/grades                                             | search_courses::grades.index         | Emtudo\Units\Search\Courses\Http\Controllers\GradeController@index                       | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/grades/search                                      | search_courses::grades.search        | Emtudo\Units\Search\Courses\Http\Controllers\GradeController@index                       | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/grades/{grade}                                     | search_courses::grades.show          | Emtudo\Units\Search\Courses\Http\Controllers\GradeController@show                        | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/groups                                             | search_courses::groups.index         | Emtudo\Units\Search\Courses\Http\Controllers\GroupController@index                       | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/groups/search                                      | search_courses::groups.search        | Emtudo\Units\Search\Courses\Http\Controllers\GroupController@index                       | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/groups/{group}                                     | search_courses::groups.show          | Emtudo\Units\Search\Courses\Http\Controllers\GroupController@show                        | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/questions                                          | search_courses::questions.index      | Emtudo\Units\Search\Courses\Http\Controllers\QuestionController@index                    | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/questions/search                                   | search_courses::questions.search     | Emtudo\Units\Search\Courses\Http\Controllers\QuestionController@index                    | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/questions/{question}                               | search_courses::questions.show       | Emtudo\Units\Search\Courses\Http\Controllers\QuestionController@show                     | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/quizzes                                            | search_courses::quizzes.index        | Emtudo\Units\Search\Courses\Http\Controllers\QuizController@index                        | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/quizzes/search                                     | search_courses::quizzes.search       | Emtudo\Units\Search\Courses\Http\Controllers\QuizController@index                        | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/quizzes/{quiz}                                     | search_courses::quizzes.show         | Emtudo\Units\Search\Courses\Http\Controllers\QuizController@show                         | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/schedules                                          | search_courses::schedules.index      | Emtudo\Units\Search\Courses\Http\Controllers\ScheduleController@index                    | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/schedules/search                                   | search_courses::schedules.search     | Emtudo\Units\Search\Courses\Http\Controllers\ScheduleController@index                    | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/schedules/{schedule}                               | search_courses::schedules.show       | Emtudo\Units\Search\Courses\Http\Controllers\ScheduleController@show                     | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/skills                                             | search_courses::skills.index         | Emtudo\Units\Search\Courses\Http\Controllers\SkillController@index                       | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/skills/search                                      | search_courses::skills.search        | Emtudo\Units\Search\Courses\Http\Controllers\SkillController@index                       | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/skills/{skill}                                     | search_courses::skills.show          | Emtudo\Units\Search\Courses\Http\Controllers\SkillController@show                        | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/subjects                                           | search_courses::subjects.index       | Emtudo\Units\Search\Courses\Http\Controllers\SubjectController@index                     | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/subjects/search                                    | search_courses::subjects.search      | Emtudo\Units\Search\Courses\Http\Controllers\SubjectController@index                     | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/courses/subjects/{subject}                                 | search_courses::subjects.show        | Emtudo\Units\Search\Courses\Http\Controllers\SubjectController@show                      | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/transports/routes                                          | search_transports::routes.index      | Emtudo\Units\Search\Transports\Http\Controllers\RouteController@index                    | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/transports/routes/search                                   | search_transports::routes.search     | Emtudo\Units\Search\Transports\Http\Controllers\RouteController@index                    | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/transports/routes/{route}                                  | search_transports::routes.show       | Emtudo\Units\Search\Transports\Http\Controllers\RouteController@show                     | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/transports/stops                                           | search_transports::stops.index       | Emtudo\Units\Search\Transports\Http\Controllers\StopController@index                     | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/transports/stops/search                                    | search_transports::stops.search      | Emtudo\Units\Search\Transports\Http\Controllers\StopController@index                     | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/transports/stops/{stop}                                    | search_transports::stops.show        | Emtudo\Units\Search\Transports\Http\Controllers\StopController@show                      | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/transports/vehicles                                        | search_transports::vehicles.index    | Emtudo\Units\Search\Transports\Http\Controllers\VehicleController@index                  | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/transports/vehicles/search                                 | search_transports::vehicles.search   | Emtudo\Units\Search\Transports\Http\Controllers\VehicleController@index                  | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/transports/vehicles/{vehicle}                              | search_transports::vehicles.show     | Emtudo\Units\Search\Transports\Http\Controllers\VehicleController@show                   | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/users/managers                                             | search_users::managers.index         | Emtudo\Units\Search\Users\Http\Controllers\ManagerController@index                       | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/users/managers/search                                      | search_users::managers.search        | Emtudo\Units\Search\Users\Http\Controllers\ManagerController@index                       | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/users/managers/{manager}                                   | search_users::managers.show          | Emtudo\Units\Search\Users\Http\Controllers\ManagerController@show                        | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/users/responsibles                                         | search_users::responsibles.index     | Emtudo\Units\Search\Users\Http\Controllers\ResponsibleController@index                   | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/users/responsibles/search                                  | search_users::responsibles.search    | Emtudo\Units\Search\Users\Http\Controllers\ResponsibleController@index                   | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/users/responsibles/{responsible}                           | search_users::responsibles.show      | Emtudo\Units\Search\Users\Http\Controllers\ResponsibleController@show                    | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/users/students                                             | search_users::students.index         | Emtudo\Units\Search\Users\Http\Controllers\StudentController@index                       | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/users/students/search                                      | search_users::students.search        | Emtudo\Units\Search\Users\Http\Controllers\StudentController@index                       | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/users/students/{student}                                   | search_users::students.show          | Emtudo\Units\Search\Users\Http\Controllers\StudentController@show                        | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/users/teachers                                             | search_users::teachers.index         | Emtudo\Units\Search\Users\Http\Controllers\TeacherController@index                       | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/users/teachers/search                                      | search_users::teachers.search        | Emtudo\Units\Search\Users\Http\Controllers\TeacherController@index                       | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/users/teachers/{teacher}                                   | search_users::teachers.show          | Emtudo\Units\Search\Users\Http\Controllers\TeacherController@show                        | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/users/users                                                | search_users::users.index            | Emtudo\Units\Search\Users\Http\Controllers\UserController@index                          | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/users/users/search                                         | search_users::users.search           | Emtudo\Units\Search\Users\Http\Controllers\UserController@index                          | api,auth,Closure                                    |
| GET\|HEAD  | v1/search/users/users/{user}                                         | search_users::users.show             | Emtudo\Units\Search\Users\Http\Controllers\UserController@show                           | api,auth,Closure                                    |

