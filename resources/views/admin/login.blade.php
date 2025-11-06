<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
@php
    $company = false
@endphp
<body class="flex items-center justify-center min-h-screen bg-white px-4">
<div class="flex flex-col-reverse md:flex-row w-full max-w-[840px] bg-white shadow-2xl rounded-2xl overflow-hidden">    <!-- Left image section -->
    <div class="w-full md:w-1/2 bg-gray-50 flex items-center justify-center p-6">
      <img src="{{ asset('assets/admin/img/login.png') }}" alt="login illustration" class="w-full max-w-xs">
    </div>
    <!-- Right form section -->
    <div class="w-full md:w-1/2 p-10 flex flex-col justify-center">
      <!-- Logo -->
      <div class="flex justify-center mb-3">
        <img src="{{ ($company && $company->logo) ? asset('storage').'/'.$company->logo :'https://i.ibb.co/zfHgkR4/logo.png' }}" alt="BD Color Logo" style="width:120px;height:auto">
      </div>

      <h2 class="text-2xl font-semibold text-center text-gray-700 mb-3">Sign in into your account!</h2>
        @if(session()->exists('danger'))
            <p class="text-center" style="color:red">{{ session('danger') }}</p>
        @endif
      <form action="" method="POST" class="space-y-5">
        @csrf
        <input
          type="text"
          placeholder="Username"
          name="username"
          class="w-full px-4 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400"
          required
        />
        <input
          type="password"
          placeholder="Password"
          name="password"
          class="w-full px-4 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-400"
          required
        />
        <button
          type="submit"
          class="px-3 bg-green-500 hover:bg-green-600 text-white font-semibold py-1 rounded-md transition"
        >
          Login
        </button>
      </form>

      <p class="text-center text-sm text-gray-400 mt-6">Copyright © 2025 {{ optional($company)->name }}</p>
    </div>
  </div>
  @if(session()->exists('danger'))
            <script>
              //Notify
              let message = @json( session('danger'));
              let type = 'danger';
              let iconClass = {
                danger: 'fa fa-times-circle'
            };
              $.notify({
                icon: iconClass[type],
                message
              },{
                type,
                placement: {
                  from: "top",
                  align: "center"
                },
                time: 1000,
              });
            </script>

      @endif

</body>
</html>