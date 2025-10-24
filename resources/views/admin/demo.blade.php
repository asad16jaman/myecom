@extends('admin.layout.app')
@section('title',"Admin Page")
@push('style')
<style>
    
</style>
@endpush

@section('content')
    <div class="page-inner" id="app">
        @include('admin.partial.breadcrmp', ['var1' => "USER", 'var2' => 'CREATE'])
    </div>
@endsection

@push('script')
<script>
    
</script>
@endpush