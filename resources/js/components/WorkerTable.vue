<template>
  <div class="table-responsive">
    <div class="container row">
      <div class="col-3">
        <div class="mb-3">
          <a
            class="btn waves-effect waves-light btn-primary btn-outline-primary"
            :href="tempDenomination+'/create'"
            ><i class="ti-plus"></i>Agregar</a
          >
        </div>
      </div>
      <div class="col-9">
        <div class="row container">
          <div class="col-10">
            <div class="row">
              <div class="col-md-10">
                <div class="form-group">
                  <input
                    v-on:keyup.enter="getWorker"
                    v-on:keyup.delete="restoreWorkerList"
                    v-model="search"
                    v-on:click.right.stop="disableRightButton($event)"
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Folio o nombre"
                    required
                  />
                  <label class="text-danger" role="alert"
                    >{{ searchResult }}
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-2">
            <form method="POST" :action="'reset'+tempDenomination">
              <input type="hidden" name="_token" :value="csrf" />
              <button
                type="submit"
                class="
                  btn
                  waves-effect waves-light
                  btn-primary btn-outline-primary
                "
              >
                RESETEAR
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Tabajador</th>
          <th>Estatus</th>
          <th>NSS</th>
          <th>Credencial</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="worker in this.workers.data" :key="worker.id">
          <th scope="row">{{ worker.id }}</th>
          <td>{{ worker.worker }}</td>
          <td>
            <span v-if="worker.active" class="bg-info text-white p-2">{{
              "Activo"
            }}</span>
            <span v-else class="bg-danger text-white p-2">{{
              "No activo"
            }}</span>
          </td>
          <td>{{ worker.nss }}</td>
          <td>
            <form class="form-material" action="/Pdf" method="POST">
              <input type="hidden" name="denomination" :value="denomination" />
              <input type="hidden" name="name" :value="worker.id" />
              <input type="hidden" name="_token" :value="csrf" />
              <button
                type="submit"
                class="btn waves-effect waves-light btn-success"
              >
                <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
              </button>
            </form>
          </td>
          <td>
            <a
              class="btn waves-effect waves-light btn-danger"
              :href="tempDenomination+'/' + worker.id + '/edit'"
              ><i class="icofont icofont-pencil-alt-1"></i
            ></a>
            <button
              @click="deleteWorker(worker.id)"
              class="btn waves-effect waves-light btn-success"
            >
              <i class="icofont icofont-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item">
          <button class="page-link" href="#" aria-label="Previous" @click="pagination(workers.prev_page_url)">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </button>
        </li>
        <li v-for="(link, index) in links" :key="index">
            <button class="page-link" @click="pagination(link.url)">{{link.label}}</button>
        </li>
        <li class="page-item">  
          <button class="page-link" href="#" aria-label="Next" @click="pagination(workers.next_page_url)">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </button>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
import { AMDelete, AMError, AMSuccess } from "../alert/alert";
const MIN_CHARS_PER_INPUT_SEARCH = 1;
const BASE_URL = "/Worker?page=1";
export default {
  props: {
    denomination:String,
  },
  data() {
    return {
      workers: {},
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
      search: "",
      searchResult: "",
      containsAnyResult: false,
      links:[],
      lastUrl:"",
      tempDenomination:"",
    };
  },
  methods: {
    disableRightButton: function (event) {
      if (event) {
        event.preventDefault();
      }
    },
    getUrl(page){
      return `${page}&denomination=${this.denomination}`;
    },
    newLinks(){
      this.links = this.workers.links;
      //delete previous button
      this.links.shift();
      //delete next button
      this.links.pop();

    },
    async getWorkers(url) {
      const response = await axios.get(url);
      this.workers = response.data;
      this.newLinks();
      
    },
    pagination(url){
      if(url === null){
        return;
      }
      this.lastUrl = this.getUrl(url);
      this.getWorkers(this.lastUrl);
    },
    deleteWorker(id) {
      let _this = this;
      AMDelete(function () {

        axios
          .post(`/${_this.tempDenomination}/`+ id, {
            _method: "delete",
            _token: _this.csrf,
          })
          .then((result) => {
            AMSuccess("Se elimino correctamente");
            _this.getWorkers(_this.lastUrl);
          })
          .catch((error) => {
            if (error.response.status == 404) {
              AMError("No se pudo eliminar, verifique sus datos");
            }
          });
      });
    },
    restoreWorkerList() {
      if (this.containsAnyResult) {
        this.getWorkers(this.lastUrl);
        this.containsAnyResult = false;
      }
    },
    getWorker() {
      let _this = this;
      if (this.search === "") {
        this.searchResult = "El campo se encuentra vacio";
        return;
      }
      if (this.search.length <= MIN_CHARS_PER_INPUT_SEARCH) {
        this.searchResult = "El debe contener más de dos caracteres";
        return;
      }
      axios
        .get("/Worker/" + this.search, {
          params: {
            denomination: _this.denomination,
          },
        })
        .then((response) => {
          if (response.data.length !== 0) {
            _this.workers = response;
            _this.containsAnyResult = true;
          } else {
            this.searchResult = "No se encontro el resultado";
          }
        })
        .catch((e) => {
          this.searchResult =
            "Revisa tus datos, son incorrectos, el nombre debe ser completo";
        });
    },
  },
  created() {
    this.lastUrl = this.getUrl(BASE_URL);
    this.tempDenomination = this.denomination.toLowerCase();
    this.getWorkers(this.lastUrl);
  },
};
</script>
