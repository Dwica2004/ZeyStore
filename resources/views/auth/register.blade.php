<!-- resources/views/auth/register.blade.php -->

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ZeyStore</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .glassmorphism {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-400 via-indigo-500 to-purple-500 min-h-screen flex items-center justify-center p-4">
    <div class="container mx-auto">
        <div class="max-w-md w-full mx-auto glassmorphism p-6 sm:p-8 shadow-lg">
            <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-center text-white">Register</h2>
            <form action="{{ route('register.submit') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-white text-sm font-medium mb-2">Name</label>
                    <input type="text" name="name" id="name" class="w-full px-3 py-2 bg-white bg-opacity-20 border border-white border-opacity-30 rounded-md text-white placeholder-white placeholder-opacity-70" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-white text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" id="email" class="w-full px-3 py-2 bg-white bg-opacity-20 border border-white border-opacity-30 rounded-md text-white placeholder-white placeholder-opacity-70" required>
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-white text-sm font-medium mb-2">Phone</label>
                    <input type="text" name="phone" id="phone" class="w-full px-3 py-2 bg-white bg-opacity-20 border border-white border-opacity-30 rounded-md text-white placeholder-white placeholder-opacity-70">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-white text-sm font-medium mb-2">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-3 py-2 bg-white bg-opacity-20 border border-white border-opacity-30 rounded-md text-white placeholder-white placeholder-opacity-70" required>
                </div>
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-white text-sm font-medium mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 bg-white bg-opacity-20 border border-white border-opacity-30 rounded-md text-white placeholder-white placeholder-opacity-70" required>
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-between">
                    <button type="submit" class="w-full sm:w-auto bg-white text-indigo-600 px-6 py-2 rounded-md font-semibold hover:bg-opacity-90 transition duration-300 mb-4 sm:mb-0">Register</button>
                    <p>Sudah punya akun? <a href="{{ route('login') }}" class="text-sm text-white hover:underline"> Login</a></p>
                </div>
            </form>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
