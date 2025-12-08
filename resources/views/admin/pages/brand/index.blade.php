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
                                <label for="category_name" class="col-md-1 col-12">Name*</label>
                                <div class="col-md-3 col-12 mb-2">
                                    <input type="text" v-model="formValue.name" name="name" id="category_name"
                                        placeholder="Type  Name" class="form-control form-control-sm mb-2">
                                    <p class="text-danger">@{{ errors?.name }}</p>
                                </div>
                                <label for="category_slug" class="col-md-1 col-12 mb-2">Slug*</label>
                                <div class="col-md-3 col-12 mb-2">
                                    <input type="text" v-model="slug" name="slug" readonly id="slug"
                                        placeholder="Type Slgu" class="form-control form-control-sm mb-2">
                                </div>
                                <label for="category_slug" class="col-md-1 col-12 mb-2 g-0">Category*</label>
                                <div class="col-md-3 col-12 mb-2">
                                    <select name="category_id" v-model="formValue.category_id" id="" class="form-select form-select-sm">
                                        <option value="">--Select Category--</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                        @endforeach
                                    </select>
                                     <p>@{{ errors?.category_id }}</p>
                                </div>
                                <label for="meta_title" class="col-md-1 col-12">M. Title</label>
                                <div class="col-md-3 col-12 mb-2">
                                    <input type="text" name="meta_title" v-model="formValue.meta_title" id="meta_title"
                                        placeholder="Type Meta Title" class="form-control form-control-sm mb-2">
                                    <p class="text-danger">@{{ errors?.meta_title }}</p>
                                </div>
                                <label for="meta_keyword" class="col-md-1 col-12 g-0">M_Keyword</label>
                                <div class="col-md-3 col-12 mb-2">
                                    <input type="text" name="meta_keyword" v-model="formValue.meta_keyword" id="meta_keyword"
                                        placeholder="Type Meta Keyword" class="form-control form-control-sm mb-2">
                                    <p class="text-danger">@{{ errors?.meta_keyword }}</p>
                                </div>
                               <label for="meta_description" class="col-md-1 col-12">M. Des</label>
                                <div class="col-md-3 col-12 mb-2">
                                    <textarea name="meta_description" class="form-control form-control-sm" id="meta_description" placeholder="Type Meta Description">@{{ formValue.meta_description }}</textarea>
                                    <p class="text-danger">@{{ errors?.meta_description }}</p>
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
                            <input type="text" v-model="searcevalue" placeholder="Search By Name" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display table table-border table-hover basic_thead_bg">
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>M.Title</th>
                                        <th>M.Key</th>
                                        <th>M.Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data,ind) in datas">
                                        <td>@{{ ind+1 }}</td>
                                        <td>@{{ data.name }}</td>
                                        <td>@{{ data.category.title }}</td>
                                        <td>@{{ data.meta_title }}</td>
                                        <td>@{{ data.meta_keyword }}</td>
                                        <td>@{{ data.meta_description }}</td>
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
                        name: '',
                        category_id: '',
                        meta_title:'',
                        meta_keyword:'',
                        meta_description:''
                    },
                    errors: {},
                    isEdit: {
                        status: false,
                        id: null
                    },
                    searcevalue : ''
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
                   
                    this.formValue= {
                        name: null,
                        category_id: '',
                        meta_title:null,
                        meta_keyword:null,
                        meta_description:''
                    },
                    
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
                        res = await axios.post(`/api/subcategory/${editId}/update`, data)
                        if(res.data.status == true){
                            this.notify_message(res.data.message)
                            this.isEdit = {
                                status: false,
                                id: null
                            }
                        }
                        
                    } else {
                        res = await axios.post('/api/subcategory/store', data)
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
                        ...editData
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

            },

            watch: {
                async searcevalue(newVal){
                    let get_datas = await axios.get(`/api/search_subcategory/${newVal}`);
                   this.datas =  get_datas.data.datas
                }
            },
            computed: {
                slug() {
                    return this.formValue.name
                        ? this.formValue.name.trim().split(' ').join('-').toLowerCase()
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