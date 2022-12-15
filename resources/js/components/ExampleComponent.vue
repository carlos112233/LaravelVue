<template>
  <div class="card">
    <div class="card-header">
      User List &nbsp;&nbsp;&nbsp;
      <!-- Button trigger modal -->
      <button
        type="button"
        class="btn btn-primary"
        data-toggle="modal"
        data-target="#exampleModal"
        @click="create()"
      >
        <i class="fa fa-user-plus" aria-hidden="true"></i>
      </button>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover table-bordered" id="sampleTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Date</th>
              <th>Acctions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td>{{ user.id }}</td>
              <td>{{ user.name }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.created_at |formatDate }}</td>
              <td>
                <button
                  class="btn btn-info btn-sm"
                  data-toggle="modal"
                  @click="showDetails(user)"
                  data-target="#info"
                >
                  <i class="fa fa-info" style="font-size: 20px"></i>
                </button>
                <button
                  class="btn btn-primary btn-sm"
                  data-toggle="modal"
                  @click="editUser(user)"
                  data-target="#exampleModal"
                >
                  <i class="fa fa-pencil" aria-hidden="true" style="font-size: 20px"></i>
                </button>
                <button class="btn btn-danger btn-sm" @click="deleteUser(user)">
                  <i class="fa fa-trash" style="font-size: 20px"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">{{ title }}</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form>
            <div class="modal-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleInputEmail1"
                  aria-describedby="emailHelp"
                  v-model="dataUser.name"
                  required
                />
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  v-model="dataUser.email"
                  required
                />
              </div>
              <div class="form-group">
                <label for="password">password</label>
                <input
                  type="password"
                  class="form-control"
                  id="password"
                  required
                  v-model="dataUser.password"
                />
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
              >
                Close
              </button>
              <button
                type="submit"
                class="btn btn-primary"
                @click.prevent="createUsers"
                v-if="btnCrear"
              >
                Create
              </button>
              <button
                type="submit"
                class="btn btn-primary"
                @click.prevent="editUsers"
                v-if="btnEdit"
              >
                Submit
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="info"
      tabindex="-1"
      aria-labelledby="infoLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="infoLabel">{{ title }}</h5>
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
            <div class="table-resonsive">
              <table class="table table-hover table-border table-striped">
                <tbody>
                  <tr>
                    <th scope="row">Id</th>
                    <td>{{ info.id }}</td>
                  </tr>
                  <tr>
                    <th scope="row">Name</th>
                    <td>{{ info.name }}</td>
                  </tr>
                  <tr>
                    <th scope="row">Email</th>
                    <td>{{ info.email }}</td>
                  </tr>
                  <tr>
                    <th scope="row">creation date</th>
                    <td>{{ info.created_at |formatDate }}</td>
                  </tr>
                  <tr>
                    <th scope="row">update date</th>
                    <td>{{ info.updated_at |formatDate}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button
              type="submit"
              class="btn btn-primary"
              @click.prevent="createUsers"
              v-if="btnCrear"
            >
              OK
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment';

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('MM/DD/YYYY hh:mm')
    }
});
export default {
  mounted() {
    this.getUsers();
  },
  data() {
    return {
      users: [],
      dataUser: { name: "", email: "", password: "" },
      title: "",
      btnEdit: false,
      btnCrear: false,
      idUser: "",
      info: { id: "",  name: "", email: "",updated_at: "", created_at: "" },
    };
  },
  methods: {
    table() {
      this.$nextTick(() => {
        $("#sampleTable").DataTable({
          dom: "Bfrtip",
          order: [[0, "desc"]],
          buttons: [
            {
              extend: "copyHtml5",
              text: "<i class='fa fa-files-o' style='font-size:20px'></i> Copy",
              titleAttr: "Copy",
              className: "btn btn-secondary",
            },
            {
              extend: "excelHtml5",
              text: "<i class='fa fa-file-excel-o' aria-hidden='true' style='font-size:20px'></i>Excel",
              titleAttr: "Excel",
              className: "btn btn-success",
            },
            {
              extend: "pdfHtml5",
              text: "<i class='fa fa-file-pdf-o' aria-hidden='true' style='font-size:20px'></i>PDF",
              titleAttr: "PDF",
              className: "btn btn-danger",
            },
            {
              extend: "csvHtml5",
              text: "<i class='fa fa-table'  style='font-size:20px'></i> CSV",
              titleAttr: "CSV",
              className: "btn btn-info",
            },
            {
              extend: "print",
              text: "<i class='fa fa-print' aria-hidden='true' style='font-size:20px'></i> Print",
              titleAttr: "Print",
              className: "btn btn-secondary",
            },
          ],
        });
      });
    },
    getUsers() {
      axios.get("users_list").then((res) => {
        this.users = res.data;
        $("#sampleTable").DataTable().destroy();
        this.table();
      });
    },
    createUsers() {
      axios
        .post("create_user", this.dataUser)
        .then((res) => {
          this.getUsers();
          swal("Geat!", "user has been created successfully!", "success");
          $("#exampleModal .close").click();
        })
        .catch(function (error) {
          var arrayerror = Object.values(error.response.data.errors);
          arrayerror.forEach((element) =>
            swal("error", String(element) + "!", "error")
          );
        });
    },
    editUsers() {
      axios
        .put("edit_user/" + this.idUser, this.dataUser)
        .then((res) => {
          this.idUser = "";
          this.getUsers();
          swal("Geat!", "user has been Edited successfully!", "success");
          $("#exampleModal .close").click();
        })
        .catch(function (error) {
          var arrayerror = Object.values(error.response.data.errors);
          arrayerror.forEach((element) =>
            swal("error", String(element) + "!", "error")
          );
        });
    },
    deleteUser(datos) {
      swal({
        title: "Are you sure you want to delete this user " + datos.name + "?",
        text: "Once deleted, you will not be able to get the user back!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          axios
            .delete("delete_user/" + datos.id)
            .then((res) => {
              this.getUsers();
            })
            .catch(function (error) {
              var arrayerror = Object.values(error.response.data.errors);
              arrayerror.forEach((element) =>
                swal("error", String(element) + "!", "error")
              );
            });
          swal("the user was successfully removed!", {
            icon: "success",
          });
        } else {
          swal("Your user is safe!");
        }
      });
    },
    showDetails(datos) {
      this.title = "Info";
      this.info.id = datos.id;
      this.info.name = datos.name;
      this.info.email = datos.email;
      this.info.created_at = datos.created_at;
      this.info.updated_at = datos.updated_at;
    },
    create() {
      this.title = "New User";
      this.btnCrear = true;
      this.btnEdit = false;
      this.dataUser = { name: "", email: "", password: "" };
    },
    editUser(datos) {
      this.title = "Edit User";
      this.btnCrear = false;
      this.btnEdit = true;
      this.dataUser = {
        name: datos.name,
        email: datos.email,
        password: datos.password,
      };
      this.idUser = datos.id;
    },
  },
};
</script>
