@extends('admin.layout.app')
@section('title', "Admin Page")
@push('style')
  <style>
  </style>
@endpush

@section('content')
  <div class="page-inner" id="app">
    @include('admin.partial.breadcrmp', ['var1' => "USER", 'var2' => 'CREATE'])
    <div class="row">
      <div class="col-12">
        <form action="" method="post" @submit.prevent="saveUser">
          <div class="card">
            <div class="card-header bg-secondary text-white">
              <div class="card-title text-white"> <i class="fas fa-user"></i> User Create Form</div>
            </div>
            <div class="card-body">
              <div class="row">

                <label for="username" class="col-md-2 col-sm-4">User Name</label>
                <div class="col-md-4 col-sm-8 mb-2">
                  <input type="text" name="username" v-model="form_data.username" id="username"
                    placeholder="Type Your User Name" class="form-control form-control-sm">
                  <p class="text-danger" v-if="invalid_msg.username" v-html="invalid_msg.username"></p>
                </div>

                <label for="email" class="col-md-2 col-sm-4">Email</label>
                <div class="col-md-4 col-sm-8">
                  <input type="email" name="email" v-model="form_data.email" id="email" placeholder="Type Your Email"
                    class="form-control form-control-sm">
                  <p class="text-danger" v-if="invalid_msg.email" v-html="invalid_msg.email"></p>
                </div>

                <label for="password" class="col-md-2 col-sm-4" v-if="!isUpdate.status">Password</label>
                <div class="col-md-4 col-sm-8" v-if="!isUpdate.status">
                  <input type="password" name="password" v-model="form_data.password" id="password"
                    placeholder="Type Your Password" class="form-control form-control-sm">
                  <p class="text-danger" v-if="invalid_msg.password" v-html="invalid_msg.password"></p>
                </div>

                <label for="password_confirmation" v-if="!isUpdate.status" class="col-md-2 col-sm-4">Confirm
                  Password</label>
                <div class="col-md-4 col-sm-8" v-if="!isUpdate.status">
                  <input type="password" name="password_confirmation" v-model="form_data.password_confirmation"
                    id="password_confirmation" placeholder="Confirm Your Password" class="form-control form-control-sm">
                </div>
              </div>
            </div>
            <div class="card-action d-flex justify-content-end">
              <button class="btn btn-sm btn-danger me-3" type="button" @click="resetThisForm">Cancel</button>
              <button class="btn btn-sm btn-success" type="submit">@{{ isUpdate.status ? "Update" : "Submit" }}</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Users Table</div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="display table table-striped table-hover basic_thead_bg">
                <thead>
                  <tr>
                    <th>SL NO</th>
                    <th>UserName</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody>
                  <tr v-for="(data,ind) in datas">
                    <td>@{{ ind+1 }}</td>
                    <td>@{{ data.username }}</td>
                    <td>@{{ data.email }}</td>
                    <td>@{{ data.type }}</td>
                    <td>@{{ data.status }}</td>
                    <td>
                      <button @click="updateUser(data.id)">
                        <i class="fas fa-edit iconsize"></i>
                      </button>
                      <button @click="deleteData(data.id)">
                        <i class="fas fa-trash-alt iconsize text-danger"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>

@endsection

@push('script')
  <script>

function loder_open() {
            let loader = document.getElementById('loder');
            loader.classList.remove('l-d-none');
            loader.classList.add('l-d-block')
        }
        function loder_close() {
            let loader = document.getElementById('loder');
            loader.classList.remove('l-d-block');
            loader.classList.add('l-d-none')
        }

    // createApp
    Vue.createApp({
      data() {
        return {
          form_data: {
            username: "",
            email: "",
            password: "",
            password_confirmation: ""

          },
          invalid_msg: {
            username: false,
            email: false,
            password: false

          },
          datas: [],
          isUpdate: {
            status: false,
            id: null
          }
        }
      },
      methods: {
        async saveUser(e) {
          if (this.isUpdate.status) {
            let updat_data = {
              email: this.form_data.email,
              username: this.form_data.username
            }
            let data = await axios.post(`/api/store-user/${this.isUpdate.id}/update`, updat_data, {
              'Content-Type': "application/json"
            })
            let res = data.data;
            if (res.status == false) {
              let errorMessage = res.message
              this.invalid_msg = {
                ...errorMessage
              }
            }else{
              this.resetThisForm();
              this.datas = res.users,
              this.datas = res.users,
                this.invalid_msg = {
                  username: false,
                  email: false,
                  password: false
                }
                this.isUpdate = {
                  status:false,
                  id:null
                }
            }
          } else {
            let data = await axios.post('/api/store-user', this.form_data, {
              'Content-Type': "application/json"
            })
            let res = data.data;
            if (res.status == false) {
              let errorMessage = res.message
              this.invalid_msg = {
                ...errorMessage
              }
            } else {
              this.resetThisForm();
              this.datas = res.users,
                this.invalid_msg = {
                  username: false,
                  email: false,
                  password: false
                }
            }
          }
        },
        resetThisForm() {
          this.form_data.username = "";
          this.form_data.email = '';
          this.form_data.password = '';
          this.form_data.password_confirmation = '';
          this.isUpdate.status = false
          this.isUpdate.id = null
        },
        deleteData(id) {
          swal({
            title: "Are you sure?",
            text: "You Want To Delete this!",
            type: "warning",
            buttons: {
              cancel: {
                visible: true,
                text: "No, cancel!",
                className: "btn btn-danger",
              },
              confirm: {
                text: "Yes, delete it!",
                className: "btn btn-success",
              },
            },
          }).then((willDelete) => {

            console.log(willDelete)

            if (willDelete) {

              axios.post(`/api/user/${id}/delete`)
                .then(res => {
                  if (res.data.status) {
                    let data = this.datas.filter(ele => {
                      return ele.id != id
                    })
                    this.datas = data;
                    swal(res.data.message, {
                      icon: "success",
                      buttons: {
                        confirm: {
                          className: "btn btn-success",
                        },
                      },
                    });
                  } else {
                    swal(res.data.message, {
                      buttons: {
                        confirm: {
                          className: "btn btn-success",
                        },
                      },
                    });
                  }
                })
                .catch(res => {
                  console.log(res)
                })

            } else {
            }
          });
        },
        updateUser(id) {
          this.isUpdate.status = true;
          this.isUpdate.id = id;
          let data = this.datas.find(ele => {
            return ele.id == id
          })
          this.form_data.username = data.username;
          this.form_data.email = data.email
        }
      },
      watch: {
        // datas change hole automatic ei function call hobe
        datas: {
          deep: true, // array/object er nested data change detect korar jonno
          handler() {

          }
        }
      },

      async mounted() {
        let pp = await axios.get('/api/allusers');
        this.datas = pp.data.datas;
        loder_close()
      },

      updated() {}

    }).mount("#app")
  </script>
@endpush