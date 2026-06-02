<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PharmaPOS</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root { --primary: #10b981; --sidebar-bg: #1e293b; --bg-body: #f8fafc; }
        body { height: 100vh; background-color: var(--bg-body); display: flex; align-items: center; justify-content: center; }
        .login-card { width: 100%; max-width: 400px; background: #fff; padding: 40px; border-radius: 24px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
        .brand-logo { width: 64px; height: 64px; background: var(--primary); color: #fff; border-radius: 18px; display: flex; align-items: center; justify-content: center; font-size: 30px; margin: 0 auto 20px; }
        .form-control-custom { width: 100%; padding: 12px 16px 12px 45px; background: #f1f5f9; border: 2px solid transparent; border-radius: 12px; }
        .btn-login { width: 100%; padding: 14px; background: var(--sidebar-bg); color: #fff; border: none; border-radius: 12px; font-weight: 700; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand-logo"><i class="fa-solid fa-staff-snake"></i></div>
        <div class="text-center mb-4">
            <h2 class="fw-bold">PharmaPOS</h2>
            <p class="text-muted small">Sistem Manajemen Inventori & Kasir</p>
        </div>
        <form action="{{ url('/login') }}" method="POST" id="loginForm">
            @csrf
            <div class="mb-3 position-relative">
                <label class="small fw-bold text-muted mb-1">Username</label>
                <input type="text" name="username" class="form-control-custom" placeholder="Username" required>
                <i class="fa-solid fa-user position-absolute" style="left: 16px; bottom: 15px; color: #94a3b8;"></i>
            </div>
            <div class="mb-4 position-relative">
                <label class="small fw-bold text-muted mb-1">Password</label>
                <input type="password" name="password" class="form-control-custom" placeholder="••••••••" required>
                <i class="fa-solid fa-lock position-absolute" style="left: 16px; bottom: 15px; color: #94a3b8;"></i>
            </div>
            <button type="submit" class="btn-login">Masuk <i class="fa-solid fa-arrow-right-to-bracket ms-2"></i></button>
        </form>
    </div>

    @if(session('error'))
    <script>
        Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}" });
    </script>
    @endif
</body>
</html>