<template>
  <div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="d-flex">
            <div class="mr-auto p-2">
              <h1 class="font-weight-bold text-secondary">Tipos</h1>
            </div>
            <div class="p-2">
              <a href="/">
                <button type="button" class="btn btn-light">Tarefas</button></a
              >
            </div>
            <div class="p-2">
              <button
                type="button"
                class="btn btn-primary"
                data-toggle="modal"
                data-target="#criarTipo"
              >
                +Criar Tipo
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-10 bg_white">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Nome</th>
                <th scope="col">Ação</th>
              </tr>
            </thead>
            <tbody v-for="tipo in tipos" v-bind:key="tipo.nome">
              <tr>
                <td>{{ tipo.id }}</td>
                <td>{{ tipo.nome }}</td>

                <td>
                  <button
                    type="button"
                    data-toggle="modal"
                    data-target="#editTipo"
                    @click="editTipo(tipo)"
                    class="btn btn-primary"
                  >
                    Editar
                  </button>
                  <button
                    type="button"
                    data-toggle="modal"
                    data-target="#excluirTipoModal"
                    @click="deletandoTipo(tipo.id)"
                    class="btn btn-danger"
                  >
                    Excluir
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modal Excluir Tipo-->
    <div
      class="modal fade"
      id="excluirTipoModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="excluirTipoModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="excluirTipoModalLabel">
              Excluir Tipo
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">Deseja realmente excluir este tipo ?</div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Cancelar
            </button>
            <button
              type="button"
              class="btn btn-danger"
              @click="deleteTipo()"
            >
              Excluir
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Editar Tipo-->
    <div
      class="modal fade"
      id="editTipo"
      tabindex="-1"
      role="dialog"
      aria-labelledby="excluirTipoModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="excluirTipoModalLabel">
              Editar Tipo
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label>Nome</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="tipo_editing.nome"
                />
              </div>
              
              
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Cancelar
            </button>
            <button
              type="button"
              @click="editTipoApi()"
              class="btn btn-success"
            >
              Salvar
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Criar Tipo -->
    <div
      class="modal fade"
      id="criarTipo"
      tabindex="-1"
      role="dialog"
      aria-labelledby="excluirTipoModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Adicionar tipo</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label>Descrição</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="tipo_creating.nome"
                />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Cancelar
            </button>
            <button type="button" @click="creatTask()" class="btn btn-success">
              Salvar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tipos: [],
      tipo_creating: { nome: '' },
      tipo_editing: { id: "", nome: '' },
      tipo_deleting: { id: "" },
    };
  },
  mounted() {
   
    axios
      .get("./api/show/tipos")
      .then((response) => (this.tipos = response.data));
  },
  methods: {
    
    editTipo(value) {
      this.tipo_editing.id = String(value.id);
      this.tipo_editing.nome = String(value.nome);
      
    },

    editTipoApi() {
      axios
        .put("./api/update/tipos/" + this.tipo_editing.id, {
          nome: this.tipo_editing.nome
        })
        .then(function (response) {
          location.reload();
          console.log("Atualizado: " + response);
        })
        .catch(function (error) {
          console.log("Erro: " + error);
        });
    },
    creatTask() {
      axios
        .post("./api/create/tipos", {
          nome: this.tipo_creating.nome
        })
        .then(function (response) {
          location.reload();
          console.log("Sucesso: " + response);
        })
        .catch(function (error) {
          console.log("Erro: " + error);
        });
    },
    deletandoTipo(id) {
      this.tipo_deleting.id = id;
    },
    deleteTipo() {
      axios 
        .delete("./api/delete/tipos/" + this.tipo_deleting.id)
        .then(function (response) {
          location.reload();
          console.log("Deletado: " + response);
        })
        .catch(function (error) {
          console.log("Erro: " + error);
        });
    },
  },
};
</script>

<style>
body {
  background: #d9d9db;
}
.bg_white {
  background: #ffff;
  padding: 10px;
}
</style>
