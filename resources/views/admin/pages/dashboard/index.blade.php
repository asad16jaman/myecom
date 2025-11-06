@extends('admin.layout.app')
@section('title',"Admin Page")
@push('style')
<style>
    
</style>
@endpush

@section('content')
    
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
    
    loder_close();
</script>
@endpush



