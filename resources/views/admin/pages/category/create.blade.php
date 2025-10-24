@extends('admin.layout.app')
@section('title', "Create Category")
@push('style')
    <style>

    </style>
@endpush

@section('content')

    <div class="page-inner" id="app">
        @include('admin.partial.breadcrmp', ['var1' => "CATEGORY", 'var2' => 'CREATE'])
        <div class="row">
            <div class="col-12">
                <form action="" method="post" @submit.prevent="saveData">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <div class="card-title text-white"> <i class="fas fa-user"></i> Category Create Form</div>
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
                                    <select name="status" id="" class="form-select form-control-sm">
                                        <option value="active" selected>Active</option>
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
                            </div>
                        </div>
                        <div class="card-action d-flex justify-content-end">
                            <button class="btn btn-sm btn-danger me-3" type="button">Cancel</button>
                            <button class="btn btn-sm btn-success" type="submit">Submit</button>
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
        Vue.createApp({
            data() {
                return {
                    datas: [],
                    formValue: {
                        title: null,
                        status: 'active',
                    },
                    errors: {
                        title: null,
                        status: null,
                        img: null,
                        slug: null
                    },
                    isEdit: {
                        status: false,
                        id: null
                    },
                    previewImage: "{{ asset('assets/admin/img/no-img.png') }}"

                }
            },
            methods: {
                async saveData(e) {
                    let data = new FormData(e.target);

                    let res = await axios.post('/api/category/store', data, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    
                    if (res.data.status == false) {
                        let errors = res.data.errors;
                        for (key in errors) {
                            this.errors[key] = errors[key][0]
                        }
                    } else {
                        e.target.reset()
                        this.previewImage = "{{ asset('assets/admin/img/no-img.png') }}";
                        this.formValue.title = null;
                        this.datas = res.data.datas 
                    }
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
            },
            computed: {
                slug() {
                    return this.formValue.title
                        ? this.formValue.title.trim().split(' ').join('-').toLowerCase()
                        : '';
                }
            },
            async mounted() {
                let datas = await axios.get('/api/admin-all_cagegory');
                console.log(datas.data)
                this.datas = datas.data.datas
            }
        }).mount('#app')




    </script>
@endpush