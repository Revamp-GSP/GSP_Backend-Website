<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Styles -->
    <style>
        /* Importing fonts from Google */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #ecf0f3; /* Changed background color */
        }

        .wrapper {
            max-width: 350px;
            min-height: 500px;
            margin: 80px auto;
            padding: 40px 30px 30px 30px;
            background-color: #E3E8ED;
            border-radius: 30px;
            box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;
        }

        .logo {
            width: 80px;
            margin: auto;
            margin-bottom: 25px;
        }

        .logo img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0px 0px 3px #5f5f5f,
                0px 0px 0px 5px #ecf0f3,
                8px 8px 15px #a7aaa7,
                -8px -8px 15px #fff;
        }

        .wrapper .name {
            font-weight: 600;
            font-size: 1.4rem;
            letter-spacing: 2px;
            padding-left: 10px;
            color: #555;
            text-align: center; /* Centering text */
        }

        .wrapper .form-field input {
            width: calc(100% - 25px); /* Adjusted input width */
            display: block;
            border: none;
            outline: none;
            background: none;
            font-size: 1.2rem;
            color: #666;
            padding: 10px 15px 10px 10px;
        }

        .wrapper .form-field {
            padding-left: 10px;
            margin-bottom: 30px;
            border-radius: 25px;
            box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;
        }

        .wrapper .form-field .fas {
            color: #555;
        }

        .wrapper .btn {
            box-shadow: none;
            width: 100%;
            height: 40px;
            background-color: #03A9F4;
            color: #fff;
            border-radius: 25px;
            box-shadow: 3px 3px 3px #b1b1b1,
                -3px -3px 3px #fff;
            letter-spacing: 1.3px;
        }

        .wrapper .btn:hover {
            background-color: #039BE5;
        }

        .wrapper a {
            text-decoration: none;
            font-size: 0.8rem;
            color: #03A9F4;
        }

        .wrapper a:hover {
            color: #039BE5;
        }

        @media(max-width: 380px) {
            .wrapper {
                margin: 40px 20px;
                padding: 40px 15px 15px 15px;
            }
        }
        /* CSS Styles */
        .error-message {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #f8d7da; /* Warna background merah untuk error */
            color: #721c24; /* Warna teks untuk error */
            border: 1px solid #f5c6cb; /* Warna border untuk error */
            padding: 20px; /* Padding untuk isi kotak pesan error */
            text-align: center; /* Teks di tengah */
            z-index: 9999; /* Pastikan pesan error di atas elemen lain */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Shadow untuk efek depth */
        }
    </style>
</head>
<body>
    @if(session('error'))
        <div class="alert alert-danger error-message">
            {{ session('error') }}
        </div>
    @endif
    <div class="wrapper">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>
        <div class="text-center mt-4 name">
            PT GSP
        </div>
        <form class="p-3 mt-3 login-form" method="POST" action="{{ route('login') }}">
            @csrf
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-field d-flex align-items-center" style="margin-top: 5px;">
                <span class="far fa-user"></span>
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>
            <div class="form-field d-flex align-items-center" style="margin-top: 30px;">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <button type="submit" class="btn mt-3" style="margin-top: 30px;">Login</button>
        </form>
    </div>
    <script>
        // Ambil pesan error dari session
        var errorMessage = "{{ session('error') }}";

        // Jika ada pesan error, tampilkan pop-up
        if (errorMessage) {
            // Buat elemen div untuk pop-up
            var errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger error-message';
            errorDiv.innerHTML = errorMessage;

            // Tambahkan pop-up ke body
            document.body.appendChild(errorDiv);

            // Hilangkan pesan error dari session agar tidak muncul kembali saat refresh
            sessionStorage.removeItem('error');
            
            // Hapus pop-up setelah beberapa detik
            setTimeout(function() {
                errorDiv.remove();
            }, 5000); // Pop-up akan hilang setelah 5 detik
        }
    </script>
</body>
</html>
