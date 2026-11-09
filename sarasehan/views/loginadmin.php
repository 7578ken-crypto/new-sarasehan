<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Portal Kelas</title>
    <style>
        :root { --primary: #3b82f6; --danger: #ef4444; --bg: #0f172a; --border: #334155; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', system-ui, sans-serif; }
        body { background: var(--bg); color: #f8fafc; min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 1rem; }
        .login-card { background: #1e293b; border: 1px solid var(--border); border-radius: 16px; padding: 2.5rem; width: 100%; max-width: 400px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3); text-align: center; }
        .login-card h2 { margin-bottom: 0.5rem; font-size: 1.6rem; color: #fff; }
        .login-card p { color: #94a3b8; font-size: 0.85rem; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1.2rem; text-align: left; }
        .form-group label { display: block; font-size: 0.85rem; margin-bottom: 0.4rem; color: #cbd5e1; font-weight: 600; }
        .form-group input { width: 100%; padding: 10px 14px; background: #0f172a; border: 1px solid var(--border); border-radius: 8px; color: #fff; outline: none; font-size: 0.95rem; }
        .form-group input:focus { border-color: var(--primary); }
        .btn-submit { width: 100%; padding: 12px; background: var(--primary); border: none; border-radius: 8px; color: #fff; font-weight: 700; cursor: pointer; transition: 0.2s; }
        .btn-submit:hover { background: #2563eb; }
        .error-msg { color: var(--danger); font-size: 0.85rem; margin-bottom: 1rem; text-align: left; }
        .back-link { display: inline-block; margin-top: 1.2rem; color: #94a3b8; font-size: 0.85rem; text-decoration: none; }
        .back-link:hover { color: #fff; }
        .hidden { display: none !important; }
    </style>
</head>
<body>

    <div class="login-card">
        <h2>Administrator</h2>
        <p>Masukan kredensial untuk mengelola data website</p>

        <form id="form-login">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password">
            </div>
            <p id="error-msg" class="error-msg hidden">Username atau password salah!</p>
            <button type="submit" class="btn-submit">Login Ke Panel Admin</button>
        </form>

        <a href="home" class="back-link">← Kembali ke Halaman Utama</a>
    </div>

    <script>
        document.getElementById('form-login').onsubmit = (e) => {
            e.preventDefault();
            const u = document.getElementById('username').value;
            const p = document.getElementById('password').value;

            if (u === 'admin' && p === 'admin123') {
                localStorage.setItem('is_admin', 'true');
                window.location.href = 'home';
            } else {
                document.getElementById('error-msg').classList.remove('hidden');
            }
        };
    </script>
</body>
</html>