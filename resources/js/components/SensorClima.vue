<template>
    <div class="container text-center">
        <el-row>
            <el-card class="box-card">
                <h2>Informações do Sensor Pai</h2>
                <p><strong>ID: </strong> {{sensorPai.id}}</p>
                <p><strong>Nome: </strong> {{sensorPai.nome}}</p>
                <p><strong>Marca: </strong> {{sensorPai.marca}}</p>
                <p><strong>Modelo: </strong> {{sensorPai.modelo}}</p>
                <p><strong>Fabricação: </strong> {{sensorPai.dataFabricacao}}</p>
                <p><strong>Instalação: </strong> {{sensorPai.dataInstalacao}}</p>
            </el-card>
        </el-row>

        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <h2 class="card-title"> INFORMAÇÕES DO CLIMA </h2>
                </div>
                <el-row type="flex" class="row-bg" justify="space-between">
                  <el-col :span="6">
                    <div class="grid-content bg-purple">
                    
                    </div>
                  </el-col>
                  <el-col :span="6">
                    <div class="grid-content bg-purple-light">
                    </div>
                  </el-col>
                  <el-col :span="6">
                    <div class="grid-content bg-purple">
                      <el-input
                      placeholder="Pesquisar"
                      v-model="search"
                      prefix-icon="el-icon-search">
                      </el-input>
                    </div>
                  </el-col>
                </el-row>

              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                {{dadosDosSensores}}
              <!-- <el-table
                style="width: 100%"
                :data="dadosDosSensores"
                border>
              
                <el-table-column
                  prop="data"
                  label="Data"
                  width="180">
                </el-table-column>
                <el-table-column
                  prop="precipitacao"
                  label="Precipitação"
                  width="180">
                </el-table-column>
                <el-table-column
                  prop="temperatura"
                  label="Temperatura"
                  width="180">
                </el-table-column>
                <el-table-column
                  prop="umidadeDoAr"
                  label="Umidade do Ar"
                  width="180">
                </el-table-column>
                <el-table-column
                  prop="vento"
                  label="Vento"
                  width="180">
                </el-table-column>
                <el-table-column
                  prop="radiacao"
                  label="Radiação"
                  width="180">
                </el-table-column>
                <el-table-column
                  prop="pressao"
                  label="Pressão"
                  sortable
                  width="180">
                </el-table-column>
                <el-table-column
                  prop="insolacao"
                  label="Insolação"
                  sortable
                  width="180">
                </el-table-column>
              
              </el-table> -->
                
              </div><!-- /.card-body -->
            </div><!-- /.card -->
          </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
        
    </div><!-- /.container -->
</template>

<script>
    export default {
        data(){
          return {
            editmode: false,
            sensorPai: {},
            dadosDosSensores: {},
            sensores: [],
            search: '',
            // Create a new form instance
            form: new Form({
              id: '',
              nome: '',
              marca: '',
              modelo: '',
              dataFabricacao: '',
              dataInstalacao: '',
              unidade: ''
            }),
            rules: {
              nome: [
                { required: true, message: 'Por favor insira um nome', trigger: 'blur' },
                { min: 3, max: 60, message: 'Certeza que esse é o nome certo?', trigger: 'blur' }
                ],
              marca: [
                { required: true, message: 'Por favor insira um nome', trigger: 'blur' },
                { min: 1, max: 60, message: 'Certeza que esse é o nome certo?', trigger: 'blur' }
                ],
              modelo: [
                { required: true, message: 'Por favor insira um nome', trigger: 'blur' },
                { min: 1, max: 60, message: 'Certeza que esse é o nome certo?', trigger: 'blur' }
                ],
              unidade: [
                { required: true, message: 'Por favor insira um nome', trigger: 'blur' }
                ],
              dataFabricacao: [
                { required: true, message: 'Por favor insira um nome', trigger: 'blur' }
                ]
            }

          }
        },
        methods: {
            carregaInformacoesDoSensorPai(id){
                axios.get("api/sensor/"+id).then(({ data }) => (this.sensorPai = data));
            },
            carregaInformacoesDoDados(id){
                axios.get("api/carrega_informacoes_dos_sensores_de_clima/"+id).then(({ data }) => (this.dadosDosSensores = data));
            },
          loadSensores(){
            axios.get("api/sensor").then(({ data }) => (this.sensores = data.data));
          },
          abrirModalSensor(){
            this.editmode = false;
            this.form.reset();
            $('#modalSensor').modal('show');
          },
          createSensor(){
            this.$Progress.start();
            this.form.post('api/sensor')
            //Sucesso
            .then(()=>{
              Fire.$emit('AtualizaLista');
              $('#modalSensor').modal('hide');
              toast({
                type: 'success',
                title: 'User Created in successfully'
              });
              this.$Progress.finish();
            })
            //Falha
            .catch(()=>{
              this.$Progress.fail();
              toast({
                type: 'error',
                title: 'Erro Ao criar'
              })
            })
          },
          editModal(cliente){
            this.editmode = true;
            this.form.reset();
            $('#modalSensor').modal('show');
            this.form.fill(cliente);
          },
          updateSensor(){
            this.$Progress.start();
            this.form.put('api/sensor/'+this.form.id)
            .then(()=>{
              Fire.$emit('AtualizaLista');
              $('#modalSensor').modal('hide');
              toast({
                type: 'success',
                title: 'User Updated in successfully'
              });
              this.$Progress.finish();
            })
            .catch(()=>{
              toast({
                type: 'error',
                title: 'Erro Ao Editar'
              })
              this.$Progress.fail();
            });
          },
          deleteSensor(id){
            Swal({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {

              if (result.value) {
                //Send request to the serve
                this.form.delete('api/sensor/'+id).then(()=>{
                  Fire.$emit('AtualizaLista');
                    Swal(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                    )
                }).catch(()=>{
                  Swal("Failed!","There was something wronge.","warning");
                });
              }
            });
          }
        },
        created() {
          this.carregaInformacoesDoSensorPai(this.$route.params.id);
          this.carregaInformacoesDoDados(this.$route.params.id);
        }
    };
</script>

<style>
.card-title{
    display: block;
    margin: 0px auto;
}
.box-card{
    margin-top: 40px;
}
.el-form{
  margin-top: 25px;
  padding: 0px 15px;
}
.el-form-item__label{
  line-height: 5px;
}
.el-date-editor.el-input, .el-date-editor.el-input__inner {
    width: -webkit-fill-available;
}
</style>
