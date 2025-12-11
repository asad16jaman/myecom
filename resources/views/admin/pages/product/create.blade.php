@extends('admin.layout.app')
@section('title', "Create Sub Category")
@push('style')
    <style>
    </style>
@endpush

@section('content')

    <div class="page-inner" id="app">
        @include('admin.partial.breadcrmp', ['var1' => "Product", 'var2' => 'CREATE'])
        <div class="row">
            <div class="col-12">
                <form action="" method="post" @submit.prevent="saveData">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <div class="card-title text-white"> <i class="fas fa-user"></i>Product Create Form</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label for="category_name" class="col-md-1 col-12">Name*</label>
                                <div class="col-md-3 col-12 mb-2">
                                    <input type="text" v-model="formValue.name" name="name" id="category_name"
                                        placeholder="Type  Name" class="form-control form-control-sm mb-2">
                                    <p class="text-danger">@{{ errors?.name }}</p>
                                </div>

                                <label for="old_price" class="col-md-1 col-12">Old Price</label>
                                <div class="col-md-3 col-12 mb-2">
                                    <input type="number" v-model="formValue.old_price" name="old_price" id="old_price"
                                        placeholder="Type  Old Price" class="form-control form-control-sm mb-2">
                                    <p class="text-danger">@{{ errors?.old_price }}</p>
                                </div>

                                <label for="price" class="col-md-1 col-12">Price</label>
                                <div class="col-md-3 col-12 mb-2">
                                    <input type="number" v-model="formValue.price" name="price" id="price"
                                        placeholder="Type  Old Price" class="form-control form-control-sm mb-2">
                                    <p class="text-danger">@{{ errors?.price }}</p>
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

                                <label for="subcategory_id" class="col-md-1 col-12 mb-2 g-0">Sub Category*</label>
                                <div class="col-md-3 col-12 mb-2">
                                    <select name="subcategory_id" v-model="formValue.subcategory_id" id="subcategory_id" class="form-select form-select-sm">
                                        <option value="">--Select Sub Category--</option>
                                        @foreach ($subcategory as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                     <p>@{{ errors?.subcategory_id }}</p>
                                </div>

                                 <label for="brand_id" class="col-md-1 col-12 mb-2">Brand*</label>
                                <div class="col-md-3 col-12 mb-2">
                                    <select name="brand_id" v-model="formValue.brand_id" id="brand_id" class="form-select form-select-sm">
                                        <option value="">--Select Brand--</option>
                                        @foreach ($brands as $brnd)
                                            <option value="{{ $brnd->id }}">{{ $brnd->name }}</option>
                                        @endforeach
                                    </select>
                                     <p>@{{ errors?.brand_id }}</p>
                                </div>

                               <label for="sort_description" class="col-md-1 col-12">S.Dscrpt.</label>
                                <div class="col-md-5 col-12 mb-2">
                                    <textarea name="sort_description" class="form-control form-control-sm" id="sort_description" placeholder="Type Sort Description">@{{ formValue.sort_description }}</textarea>
                                    <p class="text-danger">@{{ errors?.sort_description }}</p>
                                </div>

                                <label for="additional_description" class="col-md-1 col-12">Addi.Dscrpt.</label>
                                <div class="col-md-5 col-12 mb-2">
                                    <textarea name="additional_description" class="form-control form-control-sm" id="additional_description" placeholder="Type Additional Description">@{{ formValue.additional_description }}</textarea>
                                    <p class="text-danger">@{{ errors?.additional_description }}</p>
                                </div>

                                <div class="col-md-6 col-12 mb-2">
                                    <label for="description" class="">Description</label>
                                    <textarea name="description" class="form-control" rows="6"
                                        id="description"></textarea>
                                </div>

                                <div class="col-md-6 col-12 mb-2">
                                   <table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-4">
                                    <thead>
                                        <tr>
                                            <th>Size</th>
                                            <th>Price</th>
                                            <th>
                                                <button class="btn btn-warning p-1 py-0 text-white btn-sm" @click.stop.prevent="addsize()">+</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(itm,ind) in formValue.sizecontainer" :key="ind">
                                            <td>
                                                <input type="text" placeholder="Type Size" name="size" v-model="formValue.sizecontainer[ind].size" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <input type="number" placeholder="Type Price" name="price" v-model="formValue.sizecontainer[ind].price" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                <button class="btn btn-danger p-1 py-0 text-white btn-sm" @click.stop.prevent="deletesize(ind)">-</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                   </table>
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
                        <div class="card-title text-white">Product Table</div>
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
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
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
                        subcategory_id: '',
                        brand_id: '',
                        sort_description:'',
                        additional_description:'',
                        sizecontainer:[]
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

                addsize(){
                    this.formValue.sizecontainer.push({'size':'','price':0})
                },
                deletesize(index){
                   this.formValue.sizecontainer.splice(index,1)
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
                        this.notify_message("succesfully kkk")
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
                

            },

            watch: {
                async searcevalue(newVal){
                    let get_datas = await axios.get(`/api/search_subcategory/${newVal}`);
                   this.datas =  get_datas.data.datas
                }
            },
            computed: {
               
            },

            async mounted() {
                ClassicEditor
                .create(document.querySelector('#description'), {
                })
                .catch(error => {
                    console.error('CKEditor Error:', error);
                });
                let datas = await axios.get('/api/admin-all_subcagegory');
                this.datas = datas.data.datas;
                loder_close();

            }
        }).mount('#app')


    </script>
@endpush