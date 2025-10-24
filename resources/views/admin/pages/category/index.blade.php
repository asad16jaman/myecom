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
                                    <input type="text" name="title" v-model="title" id="category_title"
                                        placeholder="Type Category Title" class="form-control form-control-sm">
                                    <p class="text-danger">@{{ errors?.title }}</p>
                                </div>

                                <label for="category_slug" class="col-md-2 col-sm-4">Slug</label>
                                <div class="col-md-4 col-sm-8">
                                    <input type="text" name="slug" v-model="slug" id="category_slug" placeholder="Type Slgu"
                                        class="form-control form-control-sm">
                                    <p class="text-danger">@{{ errors?.slug }}</p>
                                </div>

                                <label for="category_status" class="col-md-2 col-sm-4">Status</label>
                                <div class="col-md-4 col-sm-8">
                                    <select name="status" v-model="status" id="" class="form-select form-control-sm">
                                        <option value="active">Active</option>
                                        <option value="inactive">InActive</option>
                                    </select>
                                    <p class="text-danger"></p>
                                </div>

                                <label for="imageInput" class="col-md-2 col-sm-4">Image</label>
                                <div class="col-md-4 col-sm-8  d-flex justify-content-between">
                                    <div>
                                        <input type="file" name="img" id="imageInput" class="form-control form-control-sm">
                                        <p class="text-danger">JPG,JPEG,PNG (500px X 500px)</p>
                                        <p class="text-danger">@{{ errors?.img }}</p>
                                    </div>
                                    <div style="width:60px;height:60px">
                                        <img id="previewImage" class="img-fluid"
                                            src="{{ asset('assets/admin/img/no-img.png') }}" alt="">
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

    </div>
@endsection

@push('script')
    <script>

        const imageInput = document.getElementById('imageInput');
        const previewImage = document.getElementById('previewImage');
        imageInput.addEventListener('change', function () {
            let file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function (e) {
                    previewImage.src = e.target.result
                }
            }
        });
        

        Vue.createApp({
            data() {
                return {

                    errors:{
                        title:null,
                        slug:null,
                        img:null
                    }
                }
            },
            methods: {
            
                async saveData(e) {
                    let data = new FormData(e.target);
                    let res = await axios.post('/api/store', data, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });
                    let validation_error = res.data.errors;
                   
                    for(error in validation_error){
                        this.errors[error] = validation_error[error][0]
                    }

                }




            }
        }).mount('#app')




    </script>
@endpush