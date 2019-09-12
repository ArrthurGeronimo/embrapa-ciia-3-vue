<template>
    <div class="container text-center">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <h2 class="card-title"> TABELA DOS SENSORES </h2>
                </div>
                <el-row type="flex" class="row-bg" justify="space-between">
                  <el-col :span="6">
                    <div class="grid-content bg-purple">
                    <el-button 
                    type="success"
                    @click="abrirModalSensor"
                    icon="el-icon-circle-plus-outline">Adicionar Sensor</el-button>
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

              <el-table
                style="width: 100%"
                :data="sensores"
                :default-sort = "{prop: 'created_at', order: 'descending'}"
                border>

                <el-table-column
                  prop="nome"
                  label="Nome"
                  sortable
                  width="180">
                </el-table-column>
                <el-table-column
                  prop="marca"
                  label="Marca"
                  width="180">
                </el-table-column>
                <el-table-column
                  prop="modelo"
                  label="Modelo"
                  width="180">
                </el-table-column>
                <el-table-column
                  prop="unidade"
                  label="Unidade"
                  width="180">
                </el-table-column>
                <el-table-column
                  prop="dataFabricacao"
                  label="Fabricação"
                  width="180">
                </el-table-column>
                <el-table-column
                  prop="dataInstalacao"
                  label="Instalação"
                  width="180">
                </el-table-column>
                <el-table-column
                  prop="created_at"
                  label="Cadastrado"
                  sortable
                  width="180">
                </el-table-column>
                <el-table-column
                  prop=""
                  label="Ações"
                  width="300">
                  <template slot-scope="scope">
                    <router-link :to="{ name: 'sensor_clima', params: { id: 2 } }">
                      <el-button 
                      type="primary"
                      size="small">Detalhes</el-button>
                    </router-link>
                    <el-button 
                    type="warning"
                    @click="editModal(scope.row)" 
                    size="small">Editar</el-button>
                    <el-button 
                    type="danger"
                    @click="deleteSensor(scope.row.id)"
                    size="small">Deletar</el-button>


                  </template>
                </el-table-column>
              </el-table>
                
              </div><!-- /.card-body -->
            </div><!-- /.card -->
          </div><!-- /.col-md-12 -->
        </div><!-- /.row -->

        <!-- Modal -->
        <div class="modal fade" id="modalSensor" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 v-show="!editmode" class="modal-title" id="addNewLabel">Adicionar Novo Sensor</h5>
                <h5 v-show="editmode" class="modal-title" id="addNewLabel">Atualizar Informações do Sensor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
              <!-- FORMULÁRIO -->
              <el-form :model="form" :rules="rules" ref="form">
                <!-- NOME -->
                <el-form-item label="Nome do Sensor" prop="nome">
                  <el-input v-model="form.nome" 
                  name="nome"
                  placeholder="Digite o Nome"
                  :class="{ 'is-invalid': form.errors.has('nome') }"
                  ></el-input>
                </el-form-item>

                <!-- MARCA -->
                <el-form-item label="Marca" prop="marca">
                  <el-input v-model="form.marca" 
                  name="marca" 
                  placeholder="Digite a Marca"
                  :class="{ 'is-invalid': form.errors.has('marca') }"
                  ></el-input>
                </el-form-item>

                <!-- MODELO -->
                <el-form-item label="Modelo" prop="modelo">
                  <el-input v-model="form.modelo" 
                  name="modelo" 
                  placeholder="Digite o Modelo"
                  :class="{ 'is-invalid': form.errors.has('modelo') }"
                  ></el-input>
                </el-form-item>

                <!-- UNIDADE -->
                <el-form-item label="Unidade" prop="unidade">
                  <el-input v-model="form.unidade" 
                  name="unidade" 
                  placeholder="Digite a Unidade"
                  :class="{ 'is-invalid': form.errors.has('unidade') }"
                  ></el-input>
                </el-form-item>

                <!-- dataFabricacao -->
                <el-form-item label="Data de Fabricação" prop="dataFabricacao">
                  <el-input v-model="form.dataFabricacao" 
                  name="dataFabricacao" 
                  placeholder="Digite a Data de Fabricação"
                  v-mask="'##/##/####'"
                  :class="{ 'is-invalid': form.errors.has('dataFabricacao') }"
                  ></el-input>
                </el-form-item>

                <!-- dataInstalacao -->
                <el-form-item label="Data de Instalação" prop="dataInstalacao">
                  <el-date-picker v-model="form.dataInstalacao" 
                  name="dataInstalacao"
                  type="date"
                  placeholder="Selecione a Data de Instalação"
                  format="yyyy/MM/dd"
                  value-format="yyyy-MM-dd"
                  :class="{ 'is-invalid': form.errors.has('dataInstalacao') }"
                  ></el-date-picker>
                </el-form-item>

                <!-- BOTÕES -->
                <el-form-item size="large">
                  <el-button>Cancelar</el-button>
                  <el-button v-show="!editmode" type="primary" @click="createSensor">Adicionar</el-button>
                  <el-button v-show="editmode" type="primary" @click="updateSensor">Atualizar</el-button>
                  
                </el-form-item>

              </el-form>
            </div><!-- /modal-body -->
            <div class="modal-footer">
            </div><!-- /modal-footer-->
          </div><!-- /modal-content -->
        </div>
        </div> <!--/modal -->

    </div><!-- /.container -->
</template>

<script>
    export default {
        data(){
          return {
            editmode: false,
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
          this.loadSensores();
          Fire.$on('AtualizaLista',() => {
            this.loadSensores();
          });
        }
    };
</script>

<style>
.card-title{
    display: block;
    margin: 0px auto;
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
