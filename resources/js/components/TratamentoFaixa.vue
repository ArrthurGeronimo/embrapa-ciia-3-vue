<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div v-if="experimentoFaixa.length < 1" class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="jumbotron">
                            <h2>Seu Tratamento Está Incompleto</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut volutpat lectus a urna accumsan, sed commodo elit tincidunt. Mauris elementum lacus at nulla ultricies volutpat. Nulla iaculis odio sit amet lectus mattis, et accumsan leo finibus. Etiam posuere, augue nec porta facilisis, dolor purus sodales nunc, et fermentum nulla velit in massa.</p>
                            <button @click="openModal" type="button" class="btn btn-primary btn-lg">Adicionar Informações</button>    
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="experimentoFaixaModal" tabindex="-1" role="dialog" aria-labelledby="experimentoFaixaModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 v-show="!editmode" class="modal-title" id="experimentoFaixaModalLabel">Adicionando Informações ao seu Tratamento</h5>
                    <h5 v-show="editmode" class="modal-title" id="experimentoFaixaModalLabel">Atualizando Informações do seu Tratamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form @submit.prevent="editmode ? updateExperimentoFaixa() : createExperimentoFaixa()">
                  <div class="modal-body">
                    <!-- FORM -->
                    <!-- QUANTIDADE DE TRATAMENTOS -->
                    <div class="form-group">
                        <label>Quantidade de Tratamentos</label>
                      <input v-model="form.quantidadeTratamentos" type="number" name="quantidadeTratamentos" placeholder="Quantidade de Tratamentos" 
                        class="form-control" :class="{ 'is-invalid': form.errors.has('quantidadeTratamentos') }">
                      <has-error :form="form" field="quantidadeTratamentos"></has-error>
                    </div>
                    <!-- QUANTIDADE DE REPETIÇÕES -->
                    <div class="form-group">
                        <label>Quantidade de Repetiçõe</label>
                      <input v-model="form.quantidadeRepeticoes" type="number" name="quantidadeRepeticoes" placeholder="Quantidade de Repetições" 
                        class="form-control" :class="{ 'is-invalid': form.errors.has('quantidadeRepeticoes') }">
                      <has-error :form="form" field="quantidadeRepeticoes"></has-error>
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
            <div v-if="experimentoFaixa.length > 0" class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Informações sobre a Categoria Faixa</h3>
                                    <div class="card-tools">
                                        <button class="btn btn-success" @click="editModal(experimentoFaixa)">Editar Informações <i class="fas fa-pen"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-12">
                                        <div class="info-box">
                                          <span class="info-box-icon bg-info"><i class="fas fa-th-large"></i></span>
                                          <div class="info-box-content">
                                            <span class="info-box-text">Quantidade de Tratamentos</span>
                                            <span class="info-box-number">{{ experimentoFaixa[0].quantidadeTratamentos }}</span>
                                          </div><!-- /.info-box-content -->
                                        </div><!-- /.info-box -->
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-12">
                                        <div class="info-box">
                                          <span class="info-box-icon bg-info"><i class="fas fa-sitemap"></i></span>
                                          <div class="info-box-content">
                                            <span class="info-box-text">Quantidade de Repetições</span>
                                            <span class="info-box-number">{{ experimentoFaixa[0].quantidadeRepeticoes }}</span>
                                          </div><!-- /.info-box-content -->
                                        </div><!-- /.info-box -->
                                    </div>
                                    </div>
        
                                </div>
                            </div>
                        </div>
                    </div><!--/row (Informações) -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Desenho</h3>
                                    <div class="card-tools">
                                        <button class="btn btn-success" @click="editModal(experimentoFaixa)">Editar <i class="fas fa-pen"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    
<draggable :list="list" class="dragArea">
                <div v-for="element in list">{{element.name}}</div>
             </draggable>
    
                                </div>
                            </div>
                        </div>
                    </div><!--/row (Desenho) -->
            </div>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable';
    export default {
        components: {
            draggable,
        },
        props: ['experimentoPai', 'experimentoFaixa'],
        data(){
            return {
            editmode: false,
            teste_id: '2',
            list:[{name:"John"}, 
                {name:"Joao"}, 
                {name:"Jean"} ],
            form: new Form({
              id: '',
              experimento_id: '',
              quantidadeTratamentos: '',
              quantidadeRepeticoes: ''
            })
          }
        },
        methods: {
            openModal(){
                this.editmode = false;
                this.form.reset();
                $('#experimentoFaixaModal').modal('show');
                Fire.$emit('AdicionaIdDoExperimentoNoFormulario');
            },
            createExperimentoFaixa(){
                this.$Progress.start();
                this.form.post('api/experimento_faixa')
                //Sucesso
                .then(()=>{
                  Fire.$emit('AtualizaInformacoesDoTratamento');
                  $('#experimentoFaixaModal').modal('hide');
                  toast({
                    type: 'success',
                    title: 'As Informações foram adicionadas com sucesso!'
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
            editModal(experimentoFaixa){
                this.editmode = true;
                this.form.reset();
                $('#experimentoFaixaModal').modal('show');
                this.form.fill(experimentoFaixa[0]);
             },
             updateExperimentoFaixa(){
                this.$Progress.start();
                this.form.put('api/experimento_faixa/'+this.form.id)
                .then(()=>{
                  Fire.$emit('AtualizaInformacoesDoTratamento');
                  $('#experimentoFaixaModal').modal('hide');
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
              add: function(){
                this.list.push({name:'Juan'});
            },
            replace: function(){
                this.list=[{name:'Edgard'}]
            }
        },
        created() {
            console.log('Componente Tratamento Faixa montado.');
            Fire.$on('AdicionaIdDoExperimentoNoFormulario',() => {
              this.form.experimento_id = this.experimentoPai.id;
            });
        }
    };
</script>

<style>
.btn-adicionar-informacoes{
    display: block;
    margin: 25px auto;
}
</style>