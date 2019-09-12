<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Meus Experimentos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Experimento: {{experimentoPai.nome}}</li>
                  </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                          <img class="profile-user-img img-fluid img-circle"
                               src="/img/experimento.png"
                               alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{experimentoPai.nome}}</h3>

                        <ul class="list-group list-group-unbordered mb-3">
                          <li class="list-group-item">
                            <p><b>Categoria</b></p>
                            <p>{{experimentoPai.categoria}}</p>
                          </li>
                          <li class="list-group-item">
                            <p><b>Tipo de Dados</b></p>
                            <p>{{experimentoPai.tipoDado}}</p>
                          </li>
                          <li class="list-group-item">
                            <p><b>Criação</b></p>
                            <p>{{experimentoPai.created_at}}</p>
                          </li>
                        </ul>

                        <button v-show="experimentoPai.estado === 'Em preparação'" class="btn btn-warning btn-lg btn-block" type="submit">Em preparação</button>
                        <button v-show="experimentoPai.estado === 'Em andamento'" class="btn btn-warning btn-lg btn-block" type="submit">Em andamento</button>
                        <button v-show="experimentoPai.estado === 'Concluído'" class="btn btn-success btn-lg btn-block" type="submit">Concluído</button>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
                    <!-- About Me Box -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Sobre</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <strong><i class="fas fa-book"></i> Descrição</strong>

                    <p class="text-muted">
                      Tratamento ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.
                    </p>

                    <hr>

                    <strong><i class="fas fa-map-marker-alt"></i> Localização</strong>

                    <p class="text-muted">Nome do Piquete</p>

                    <hr>

                    <strong><i class="fas fa-male"></i> Responsável</strong>

                    <p class="text-muted">Lorem ipsum dolor sit amet.</p>

                    <hr>

                    <strong><i class="fas fa-bookmark"></i> Notas</strong>

                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                  </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!--/col-md-3 --> 
            <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#categoriaDoTratamento" data-toggle="tab">Detalhes</a></li>
                  <li class="nav-item"><a class="nav-link" href="#linhaDoTempo" data-toggle="tab">Histórico</a></li>
                  <li class="nav-item"><a class="nav-link" href="#configuracoesExperimento" data-toggle="tab">Configurações</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">

                  <div class="active tab-pane" id="categoriaDoTratamento">
                    <TratamentoFaixa :experimentoFaixa="experimentoFaixa" :experimentoPai="experimentoPai"></TratamentoFaixa>
                  </div><!-- /.tab-pane -->

                  <div class="tab-pane" id="linhaDoTempo">
                    <TratamentoHistorico></TratamentoHistorico>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="configuracoesExperimento">
                    <form class="form-horizontal">
                        <h3>Opções de Configurações</h3>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                              <button type="submit" class="btn btn-danger">Salvar</button>
                            </div>
                        </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
        </div><!--/row -->

    </div><!--/container -->
</template>

<script>
import TratamentoFaixa from './TratamentoFaixa';
import TratamentoHistorico from './TratamentoHistorico';
    export default {
        components: { TratamentoFaixa, TratamentoHistorico },
        data(){
            return {
            editmode: false,
            experimentoPai: {},
            experimentoFaixa: {},
            experimentoBloco: {},
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
            carregaInformacoesDoExperimento(id){
                axios.get("api/experimento/"+id).then(({ data }) => (this.experimentoPai = data));
            },
            carregaInformacoesDoExperimentoFaixa(id){
                axios.get("api/carrega_informacoes_do_experimento_faixa/"+id).then(({ data }) => (this.experimentoFaixa = data));
            },
        },
        created() {
            console.log('Componente Único Tratamento montado.');
            this.carregaInformacoesDoExperimento(this.$route.params.id);
            this.carregaInformacoesDoExperimentoFaixa(this.$route.params.id);
            Fire.$on('AtualizaInformacoesDoTratamento',() => {
              this.carregaInformacoesDoExperimentoFaixa(this.$route.params.id);
            });
        }
    };
</script>
