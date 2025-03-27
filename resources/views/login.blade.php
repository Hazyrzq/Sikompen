<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sikompen Teknik Informatika PNJ</title>
    <!--favicon-->
    <link rel="icon" href="{{ asset('assets/images/favicon-32x32.png')}}" type="image/png" />
    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css')}}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .animated-gradient {
            background: linear-gradient(-45deg, #064e3b, #10b981);
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translate(0, 0px); }
            50% { transform: translate(0, 15px); }
            100% { transform: translate(0, -0px); }
        }
    </style>
</head>

<body class="animated-gradient min-h-screen flex items-center justify-center p-4">
    <!-- Animated Background -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-1/2 -left-1/2 w-full h-full floating opacity-30">
            <div class="absolute w-72 h-72 bg-emerald-600 rounded-full filter blur-3xl"></div>
        </div>
        <div class="absolute -bottom-1/2 -right-1/2 w-full h-full floating opacity-30" style="animation-delay: -2s;">
            <div class="absolute w-72 h-72 bg-green-800 rounded-full filter blur-3xl"></div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="w-full max-w-4xl flex rounded-xl shadow-2xl overflow-hidden">
        <!-- Left Side - Image -->
        <div class="hidden lg:block w-1/2 relative bg-white bg-opacity-10">
            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
            <img src="{{ asset('assets/images/login-images/Admin.jpg')}}" alt="Login Illustration" class="w-full h-full object-cover">
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 glass-effect p-6">
            <!-- Logo and Title -->
            <div class="text-center mb-6">
                <div class="mx-auto mb-3">
                    <img src="{{ asset('assets/images/login-images/logoPNJ.png')}}" alt="Logo" class="w-20 h-20 object-contain mx-auto">
                </div>
                <h1 class="text-2xl font-bold text-white mb-1">Login</h1>
                <p class="text-gray-200 text-sm">Masukkan kredensial Anda</p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                
                <!-- NIP Input -->
                <div class="space-y-1">
                    <label for="kode_user" class="block text-sm font-medium text-white">
                        <i class="fas fa-id-card mr-2"></i>NIP
                    </label>
                    <div class="relative">
                        <input type="text" id="kode_user" name="kode_user" required
                            class="w-full px-3 py-2 bg-white bg-opacity-20 border border-emerald-300 text-white placeholder-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition duration-200"
                            placeholder="Masukkan NIP">
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-1">
                    <label for="password" class="block text-sm font-medium text-white">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <div class="relative" id="show_hide_password">
                        <input type="password" id="password" name="password" required
                            class="w-full px-3 py-2 bg-white bg-opacity-20 border border-emerald-300 text-white placeholder-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-transparent transition duration-200"
                            placeholder="Masukkan password">
                        <a href="javascript:;" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-300 hover:text-white transition duration-200">
                            <i class="bx bx-hide"></i>
                        </a>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-white text-emerald-700 py-2.5 rounded-lg font-semibold shadow-lg hover:bg-gray-100 transition duration-200">
                    <i class="bx bxs-lock-open mr-2"></i>Login
                </button>
                
                <!-- Forgot Password -->
                <div class="text-center mt-4">
                    <a href="{{ route('forgetPasswordUser') }}" class="text-gray-200 hover:text-white text-sm transition duration-200">
                        Lupa Password?
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
    <!--Password Show & Hide JS -->
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(Session::has('alert-success'))
    <script>
        const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'success',
                title: '{{ Session::get('alert-success') }}'
            });
    </script>
    @endif
    @if(Session::has('alert-infostatus'))
    <script>
        const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'info',
                title: '{{ Session::get('alert-infostatus') }}'
            });
    </script>
    @endif
    @if(Session::has('alert-successedit'))
    <script>
        const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'error',
                title: '{{ Session::get('alert-error') }}'
            });
    </script>
    @endif
    @if(Session::has('alert-error'))
    <script>
        const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'error',
                title: '{{ Session::get('alert-error') }}'
            });
    </script>
    @endif
</body>
</html>