<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Meus Experimentos</li>
                  </ol>
                </nav>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tabela de Experimentos</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="openModal">Add New <i class="fas fa-plus-circle fa-fw"></i></button>
                        </div>
                    </div><!--/card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover rwd-table">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Categoria</th>
                                    <th>Tipo de Dado</th>
                                    <th>Estado</th>
                                    <th>Data de Criação</th>
                                    <th>Ações</th>
                                </tr>

                                <tr v-for="experimento in experimentos" :key="experimento.id">
                                    <td data-th="ID">{{experimento.id}}</td>
                                    <td data-th="Nome">{{experimento.nome}}</td>
                                    <td data-th="Categoria">{{experimento.categoria}}</td>
                                    <td data-th="Tipo de Dado">{{experimento.tipoDado}}</td>
                                    <td data-th="Data de Criação">
                                        <span v-show="experimento.estado === 'Em preparação'" class="badge badge-warning">{{experimento.estado}}</span>
                                        <span v-show="experimento.estado === 'Em andamento'" class="badge badge-primary">{{experimento.estado}}</span>
                                        <span v-show="experimento.estado === 'Concluído'" class="badge badge-success">{{experimento.estado}}</span>
                                    </td>
                                    <td data-th="Data de Criação">{{ experimento.created_at | myDate }}</td>
                                    <td data-th="Ações">
                                        <a href="#" @click="editModal(experimento)">
                                            <i class="fa fa-edit blue"></i>
                                        </a>
                                        /
                                        <a href="#" @click="deleteExperimento(experimento.id)">
                                            <i class="fa fa-trash red"></i>
                                        </a>
                                        /
                                        <router-link :to="{ name: 'experimento', params: { id: experimento.id } }"><i class="fa fa-eye indigo"></i></router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!--/card-body -->
                </div><!--/card -->
            </div> <!--/col-md-12 -->
        </div> <!--/row -->


      <!-- Modal -->
        <div class="modal fade" id="experimentoModal" tabindex="-1" role="dialog" aria-labelledby="experimentoModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 v-show="!editmode" class="modal-title" id="experimentoModalLabel">Novo Experimento</h5>
                <h5 v-show="editmode" class="modal-title" id="experimentoModalLabel">Atualizar Experimento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form @submit.prevent="editmode ? updateExperimento() : createExperimento()">
              <div class="modal-body">
                <!-- FORM -->
                  <!-- NOME -->
                <div class="form-group">
                  <input v-model="form.nome" type="text" name="nome" placeholder="Nome do Experimento" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('nome') }">
                  <has-error :form="form" field="nome"></has-error>
                </div>
                  <!-- TYPE -->
                <div class="form-group">
                  <select name="categoria" v-model="form.categoria" class="form-control" :class="{ 'is-invalid': form.errors.has('categoria') }">
                    <option value="">Selecione a Categoria do Experimento</option>
                    <option value="Blocos ao Acaso">Blocos ao Acaso</option>
                    <option value="Inteiramente Casualizado">Inteiramente Casualizado</option>
                    <option value="Faixa">Faixa</option>
                    <option value="Fatorial">Fatorial</option>
                  </select>
                  <has-error :form="form" field="categoria"></has-error>
                </div>
                  <!-- TYPE -->
                <div class="form-group">
                  <select name="tipoDado" v-model="form.tipoDado" class="form-control" :class="{ 'is-invalid': form.errors.has('tipoDado') }">
                    <option value="">Selecione o Tipo de Dado Gerado</option>
                    <option value="Animal">Animal</option>
                    <option value="Árvore">Árvore</option>
                    <option value="Cultura">Cultura</option>
                    <option value="Doença">Doença</option>
                    <option value="Forrageira">Forrageira</option>
                    <option value="Praga">Praga</option>
                    <option value="Solo">Solo</option>                   
                  </select>
                  <has-error :form="form" field="tipoDado"></has-error>
                </div>
                <!-- /FORM -->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button v-show="editmode" type="submit" class="btn btn-success">Atualizar</button>
                <button v-show="!editmode" type="submit" class="btn btn-primary">Criar</button>
              </div>
              </form>
            </div>
          </div>
        </div> <!--/modal -->  

    </div> <!--/container -->
</template>

<script>
    export default {
        data(){
            return {
            editmode: false,
            experimentos: {},
            // Create a new form instance
            form: new Form({
              id: '',
              nome : '',
              categoria: '',
              tipoDado: ''
            })
          }
        },
        methods:{
            loadData(){
                axios.get("api/experimento").then(({ data }) => (this.experimentos = data));
            },
            openModal(){
                this.editmode = false;
                this.form.reset();
                $('#experimentoModal').modal('show');
            },
            createExperimento(){
                this.$Progress.start();
                this.form.post('api/experimento')
                //Sucesso
                .then(()=>{
                  Fire.$emit('AtualizaLista');
                  $('#experimentoModal').modal('hide');
                  toast({
                    type: 'success',
                    title: 'O Experimento foi criado com sucesso!'
                  });
                  this.$Progress.finish();
                })
                //Falha
                .catch(()=>{
                  this.$Progress.fail();
                  toast({
                    type: 'error',
                    title: 'Alguma coisa de errada aconteceu.'
                  })
                })
            },
            editModal(experimento){
                this.editmode = true;
                this.form.reset();
                $('#experimentoModal').modal('show');
                this.form.fill(experimento);
             },
            updateExperimento(){
                this.$Progress.start();
                this.form.put('api/experimento/'+this.form.id)
                .then(()=>{
                  Fire.$emit('AtualizaLista');
                  $('#experimentoModal').modal('hide');
                  toast({
                    type: 'success',
                    title: 'Informações do Experimento Atualizadas com Sucesso.'
                  });
                  this.$Progress.finish();
                })
                .catch(()=>{
                  toast({
                    type: 'error',
                    title: 'Erro Ao Editar o Experimento'
                  })
                  this.$Progress.fail();
                });
              },
            deleteExperimento(id){
                Swal({
                  title: 'Você tem Certeza?',
                  text: "Você não poderá reverter isso!!!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Sim, deletar experimento!'
                }).then((result) => {
                    if (result.value) {
                        //Send request to the serve
                        this.form.delete('api/experimento/'+id).then(()=>{
                          Fire.$emit('AtualizaLista');
                            Swal(
                              'Deletado!',
                              'Seu Experimento foi deletado.',
                              'success'
                            )
                        }).catch(()=>{
                          Swal("Falhou!","Alguma coisa deu errada.","warning");
                        });
                      }
                });
            }

        },
        created() {
            this.loadData();
            Fire.$on('AtualizaLista',() => {
              this.loadData();
            });
        }
    };
</script>

<style>
.breadcrumb{
    margin-top: 50px;
}
.card{
    margin-top: 30px;
}
.badge{
  padding: 0.7em !important;
}
.rwd-table {
  margin: 0;
  min-width: 300px;
}
.rwd-table th {
  display: none;
}
.rwd-table td {
  display: block;
}
.rwd-table td:first-child {
  padding-top: .5em;
}
.rwd-table td:last-child {
  padding-bottom: .5em;
}
.rwd-table td:before {
  content: attr(data-th) ": ";
  font-weight: bold;
  width: 10em;
  display: inline-block;
}
@media (min-width: 480px) {
  .rwd-table td:before {
    display: none;
  }
}
.rwd-table th, .rwd-table td {
  text-align: left;
}
@media (min-width: 480px) {
  .rwd-table th, .rwd-table td {
    display: table-cell;
    padding: .25em .5em;
  }
  .rwd-table th:first-child, .rwd-table td:first-child {
    padding-left: 0;
  }
  .rwd-table th:last-child, .rwd-table td:last-child {
    padding-right: 0;
  }
}
.rwd-table {
  overflow: hidden;
}
.rwd-table th, .rwd-table td {
  margin: .5em 1em;
}
@media (min-width: 480px) {
  .rwd-table th, .rwd-table td {
    padding: 1em !important;
  }
}

</style>
