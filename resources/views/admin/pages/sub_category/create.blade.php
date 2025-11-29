@extends('admin.layout.app')
@section('title', "Create Sub Category")
@push('style')
    <style>

    </style>
@endpush

@section('content')

    <div class="page-inner" id="app">
        @include('admin.partial.breadcrmp', ['var1' => "SubCategory", 'var2' => 'CREATE'])
        <div class="row">
            <div class="col-12">
                <form action="" method="post" @submit.prevent="saveData">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <div class="card-title text-white"> <i class="fas fa-user"></i>Sub Category Create Form</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label for="category_title" class="col-md-2 col-sm-4">Title</label>
                                <div class="col-md-4 col-sm-8 mb-2">
                                    <input type="text" v-model="formValue.title" name="title" id="category_title"
                                        placeholder="Type Category Title" class="form-control form-control-sm">
                                    <p class="text-danger">@{{ errors?.title }}</p>
                                </div>
                                <label for="category_slug" class="col-md-2 col-sm-4">Slug</label>
                                <div class="col-md-4 col-sm-8">
                                    <input type="text" :value="slug" name="slug" readonly id="category_slug"
                                        placeholder="Type Slgu" class="form-control form-control-sm">

                                </div>
                                <label for="category_status" class="col-md-2 col-sm-4">Status</label>
                                <div class="col-md-4 col-sm-8">
                                    <select name="status" id="" v-model="formValue.status" class="form-select form-control-sm">
                                        <option value="active">Active</option>
                                        <option value="inactive">InActive</option>
                                    </select>
                                    <p class="text-danger"></p>
                                </div>

                                <label for="" class="col-md-2 col-sm-4">Image</label>
                                <div class="col-md-4 col-sm-8  d-flex justify-content-between">
                                    <div>
                                        <input type="file" @change="previewImageFunction" name="img" id="imageInput"
                                            class="form-control form-control-sm">
                                        <p class="text-danger">JPG,JPEG,PNG (500px X 500px)</p>
                                        <p class="text-danger">@{{ errors?.img }}</p>
                                    </div>
                                    <div style="width:60px;height:60px">
                                        <img id="previewImage" class="img-fluid" :src="previewImage" alt="">
                                    </div>
                                </div>

                                 <label for="" class="col-md-2 col-sm-4">SubCategory</label>
                                <div class="col-md-4 col-sm-8  d-flex justify-content-between">
                                    <select name="category" id="" class="form-select form-control-sm">
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-action d-flex justify-content-end">
                            <button class="btn btn-sm btn-danger me-3" @click="form_reset()" type="button">Cancel</button>
                            <button class="btn btn-sm btn-success" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header overflow-hidden d-flex justify-content-between bg-secondary">
                        <div class="card-title text-white">Category Table</div>
                        <div>
                            <input type="text" @change="serceTriger" placeholder="Search By Name" id="" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-border table-hover basic_thead_bg">
                                <thead>
                                    <tr>
                                        <th>SL NO</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(data,ind) in datas">
                                        <td>@{{ ind+1 }}</td>
                                        <td>
                                            <img :src="getImageUrl(data.img)" style="width: 40px;height:20px" alt="">
                                        </td>
                                        <td>@{{ data.title }}</td>
                                        <td>@{{ data.slug }}</td>
                                        <td>@{{ data.status }}</td>
                                        <td>
                                            <button @click="updateData(data.id)" class="btn-action">
                                                <i class="fas fa-edit iconsize"></i>
                                            </button>
                                            <button @click="deleteData(data.id)" class="btn-action">
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

        Vue.createApp({
            data() {
                return {
                    datas: [],
                    formValue: {
                        title: null,
                        status: 'active',
                    },
                    errors: {},
                    isEdit: {
                        status: false,
                        id: null
                    },
                    previewImage: "{{ asset('assets/admin/img/no-img.png') }}"
                }
            },
            methods: {
                notify_message(message){
                    var content = {};

                    content.message = message;
                    content.icon = "fa fa-bell";
                    $.notify(content, {
                        placement: {
                                from: 'top',
                                align: 'right',
                            },
                            time: 500,
                            delay: 0,
                    });
                },
                form_reset(){
                    this.previewImage = "{{ asset('assets/admin/img/no-img.png') }}";
                    this.formValue= {
                        title: null,
                        status: 'active',
                    }
                    this.errors = {};
                    this.isEdit = {
                        status: false,
                        id: null
                    };
                
                },
                async saveData(e) {
                    let data = new FormData(e.target);
                    loder_open()
                    let res;
                    if (this.isEdit.status) {
                        let editId = this.isEdit.id;
                        res = await axios.post(`/api/subcategory/${editId}/update`, data, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                        if(res.data.status == true){
                            this.notify_message(res.data.message)
                            this.isEdit = {
                                status: false,
                                id: null
                            }
                        }
                        
                    } else {
                        res = await axios.post('/api/subcategory/store', data, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })

                    }
                    if (res.data.status == false) {
                        let errors = res.data.errors;
                        for (key in errors) {
                            this.errors[key] = errors[key][0]
                        }
                        loder_close()
                    } else {
                        e.target.reset()
                        this.form_reset()
                        this.datas = res.data.datas;
                        loder_close();
                    }
                },
                async serceTriger(e){
                   let searchData = e.target.value;
                   let get_datas = await axios.get(`/api/search_subcategory/${searchData}`);
                //    console.log(get_datas)
                   console.log(get_datas)
                   this.datas =  get_datas.data.datas
                //    console.log(this.datas);

                },

                getImageUrl(path) {
                    return `${window.location.origin}/${path}`;
                },
                previewImageFunction(e) {
                    let file = e.target.files[0];
                    if (file) {
                        let reader = new FileReader();
                        reader.readAsDataURL(file);
                        reader.onload = (event) => {
                            this.previewImage = event.target.result;
                        };
                    }
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

                        if (willDelete) {
                            loder_open()
                            axios.delete(`/api/subcategory/${id}/destroy`)
                                .then(res => {
                                    if (res.data.status) {
                                        let newdata = this.datas.filter((ele) => {
                                            return ele.id != id
                                        })
                                        this.datas = newdata;

                                    }
                                    loder_close();
                                    swal(`${res.data.message}`, {
                                        icon: "success",
                                        buttons: {
                                            confirm: {
                                                className: "btn btn-success",
                                            },
                                        },
                                    });

                                })
                                .catch(function (error) {
                                    console.log(error);
                                });
                        } else {
                            swal("Your file is safe!", {
                                buttons: {
                                    confirm: {
                                        className: "btn btn-success",
                                    },
                                },
                            });
                        }
                    });
                },


                updateData(id) {
                    let editData = this.datas.find((ele) => {
                        if (ele.id == id) {
                            return ele;
                        }
                    })
                    this.isEdit = {
                        status: true,
                        id: id
                    };
                    this.formValue = {
                        title: editData.title,
                        status: editData.status
                    }
                    this.previewImage = this.getImageUrl(editData.img)
                },
            },
            computed: {
                slug() {
                    return this.formValue.title
                        ? this.formValue.title.trim().split(' ').join('-').toLowerCase()
                        : '';
                }
            },
            async mounted() {
                let datas = await axios.get('/api/admin-all_subcagegory');
                this.datas = datas.data.datas;
                loder_close();

            }
        }).mount('#app')


    </script>
@endpush