<template>
  <div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="d-flex">
            <div class="mr-auto p-2">
              <h1 class="font-weight-bold text-secondary">Tarefas</h1>
            </div>
            <div class="p-2">
              <a href="/tipo">
                <button type="button" class="btn btn-light">
                  Tipos de tarefas
                </button></a
              >
            </div>
            <div class="p-2">
              <button
                type="button"
                class="btn btn-primary"
                data-toggle="modal"
                data-target="#criarTarefa"
              >
                +Criar Tarefa
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-10 bg_white">
          <span>Filtro: </span>
          <select v-model="tipo_selected">
            <option v-for="tipo in tipos" v-bind:key="tipo.nome">
              {{ tipo.nome }}
            </option>
          </select>
          <button
          v-if="tipo_selected"
            type="button"
            class="btn btn-primary btn-sm"
            @click="showTasksFilter()"
          >
            Filtrar
          </button>
          <button
          v-if="tipo_selected"
            type="button"
            class="btn btn-secondary btn-sm"
            @click="getList()"
          >
            Limpar filtro
          </button>
        </div>
      </div>

      <div class="row justify-content-center">
        <div class="col-md-10 bg_white">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Feita</th>
                <th scope="col">Data</th>
                <th scope="col">Tipo</th>
                <th scope="col">Descrição</th>
                <th scope="col">Ação</th>
              </tr>
            </thead>
            <tbody v-for="tarefa in tarefas" :key="tarefa.id">
              <tr>
                <td>
                  <span
                    @click="changeStatus(tarefa.id, tarefa.is_ready)"
                    v-html="showIcon(tarefa.is_ready)"
                  ></span>
                </td>
                <td><input type="date" disabled v-model="tarefa.data" /></td>
                <td>{{ tarefa.tipo }}</td>
                <td>{{ tarefa.descricao }}</td>
                <td>
                  <button
                    type="button"
                    data-toggle="modal"
                    data-target="#editTarefa"
                    @click="editTarefa(tarefa)"
                    class="btn btn-primary"
                  >
                    Editar
                  </button>
                  <button
                    type="button"
                    data-toggle="modal"
                    data-target="#excluirTarefaModal"
                    @click="deletandoTarefa(tarefa.id)"
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

    <!-- Modal Excluir Tarefa-->
    <div
      class="modal fade"
      id="excluirTarefaModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="excluirTarefaModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="excluirTarefaModalLabel">
              Excluir tarefa
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
          <div class="modal-body">Deseja realmente excluir a tarefa ?</div>
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
              @click="deleteTarefa()"
            >
              Excluir
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Editar Tarefa-->
    <div
      class="modal fade"
      id="editTarefa"
      tabindex="-1"
      role="dialog"
      aria-labelledby="excluirTarefaModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="excluirTarefaModalLabel">
              Editar tarefa
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
                <label>Descrição</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="tarefa_editing.descricao"
                />
              </div>
              <div class="form-group">
                <label>Tipo de tarefa</label>
                <select v-model="tarefa_editing.tipo">
                  <option v-for="tipo in tipos" v-bind:key="tipo.nome">
                    {{ tipo.nome }}
                  </option>
                </select>
              </div>
              <div class="form-group"> 
                <label>Data limite</label>
                <input
                  type="date"
                  class="form-control"
                  v-model="tarefa_editing.data"
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
              @click="editTarefaApi()"
              class="btn btn-success"
            >
              Salvar
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Criar Tarefa -->
    <div
      class="modal fade"
      id="criarTarefa"
      tabindex="-1"
      role="dialog"
      aria-labelledby="excluirTarefaModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Adicionar tarefa</h5>
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
                  v-model="tarefa_creating.descricao"
                />
              </div>
              <div class="form-group">
                <label>Tipo de tarefa</label>
                <select v-model="tarefa_creating.tipo">
                  <option v-for="tipo in tipos" v-bind:key="tipo.nome">
                    {{ tipo.nome }}
                  </option>
                </select>
              </div>
              <div class="form-group">
                <label>Data limite</label>
                <input
                  type="date"
                  class="form-control"
                  v-model="tarefa_creating.data"
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
      tarefas: [],
      tipos: [],
      tipo_selected: null,
      tarefa_creating: { descricao: "", data: "", tipo: "" },
      tarefa_editing: { id: "", descricao: "", data: "", tipo: "" },
      tarefa_deleting: { id: "" },
    };
  },
  mounted() {
    this.getList()
    axios
      .get("./api/show/tipos")
      .then((response) => (this.tipos = response.data));
  },
  methods: {

    getList(){
      this.clearFilter()
      axios.get("./api/show").then((response) => (this.tarefas = response.data));
    },
    showTasksFilter() {
      let filter = this.tipo_selected
      axios
        .get("./api/show/filter/" + filter)
        .then((response) => (this.tarefas = response.data));
    },

    showIcon(value) {
      if (value == "done") {
        return '<i class="fa fa-check-circle fa-2x text-success" aria-hidden="true"></i>';
      } else {
        return '<i class="fa fa-circle-o fa-2x text-secondary" aria-hidden="true"></i>';
      }
    },
    changeStatus(id, status) {
      let changedStatus;
      if (status == "done") {
        changedStatus = "working";
      } else {
        changedStatus = "done";
      }

      axios
        .put("./api/update/" + id, {
          is_ready: changedStatus,
        })
        .then(function (response) {
          location.reload();
          console.log("Atualizado: " + response);
        })
        .catch(function (error) {
          console.log("Erro: " + error);
        });
    },

    editTarefa(value) {
      this.tarefa_editing.id = String(value.id);
      this.tarefa_editing.descricao = String(value.descricao);
      this.tarefa_editing.data = String(value.data);
      this.tarefa_editing.tipo = String(value.tipo);
    },

    editTarefaApi() {
      axios
        .put("./api/update/" + this.tarefa_editing.id, {
          descricao: this.tarefa_editing.descricao,
          data: this.tarefa_editing.data,
          tipo: this.tarefa_editing.tipo,
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
        .post("./api/create", {
          is_ready: "working",
          descricao: this.tarefa_creating.descricao,
          data: this.tarefa_creating.data,
          tipo: this.tarefa_creating.tipo,
        })
        .then(function (response) {
          location.reload();
          console.log("Sucesso: " + response);
        })
        .catch(function (error) {
          console.log("Erro: " + error);
        });
    },
    clearFilter(){
      this.tipo_selected = null
    },
    deletandoTarefa(id) {
      this.tarefa_deleting.id = id;
    },
    deleteTarefa() {
      axios
        .delete("./api/delete/" + this.tarefa_deleting.id)
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
