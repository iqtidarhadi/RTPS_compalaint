<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KPK Civil Services – Auth</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <style>
        :root {
            --primary: #3B5BDB;
            --primary-hover: #2f4ac4;
            --bg: #f8f9fa;
            --card-bg: #ffffff;
            --input-bg: #f1f3f5;
            --input-border: #e9ecef;
            --text-dark: #1a1a2e;
            --text-muted: #868e96;
            --label-color: #adb5bd;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 380px;
        }

        /* ---- CARD ---- */
        .auth-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 40px 32px 36px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.08);
        }

        /* ---- LOGO ---- */
        .logo-wrap {
            text-align: center;
            margin-bottom: 18px;
        }

        .logo-wrap img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        /* Fallback emblem when no real logo */
        .logo-emblem {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #dee2e6;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: var(--text-muted);
            background: #f8f9fa;
        }

        /* ---- HEADINGS ---- */
        .auth-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 28px;
            line-height: 1.1;
        }

        /* ---- LABELS ---- */
        .field-label {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--label-color);
            margin-bottom: 6px;
            display: block;
        }

        /* ---- INPUTS ---- */
        .form-control,
        .form-select {
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 10px;
            padding: 13px 16px;
            font-family: 'Nunito', sans-serif;
            font-size: 0.95rem;
            color: var(--text-dark);
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control::placeholder {
            color: #adb5bd;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 91, 219, .12);
            background: #fff;
            outline: none;
        }

        /* password eye toggle */
        .input-group-text {
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-left: none;
            border-radius: 0 10px 10px 0;
            cursor: pointer;
            color: var(--text-muted);
            transition: color .2s;
        }

        .input-group-text:hover {
            color: var(--primary);
        }

        .input-group .form-control {
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        /* ---- BUTTONS ---- */
        .btn-login {
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 1.05rem;
            font-weight: 700;
            width: 100%;
            transition: background .2s, transform .1s;
            letter-spacing: .02em;
        }

        .btn-login:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-outline-dark-custom {
            border: 2px solid var(--text-dark);
            background: transparent;
            color: var(--text-dark);
            border-radius: 12px;
            padding: 13px;
            font-size: 0.97rem;
            font-weight: 700;
            width: 100%;
            transition: background .2s, color .2s;
        }

        .btn-outline-dark-custom:hover {
            background: var(--text-dark);
            color: #fff;
        }

        /* ---- DIVIDER TEXT ---- */
        .divider-text {
            font-size: 0.87rem;
            font-weight: 700;
            color: var(--text-dark);
            text-align: center;
            margin: 20px 0 12px;
        }

        /* ---- BACK LINK ---- */
        .back-link {
            display: block;
            text-align: center;
            margin-top: 16px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-muted);
            text-decoration: none;
            transition: color .2s;
        }

        .back-link:hover {
            color: var(--primary);
        }

        /* ---- SECTION SWITCH ---- */
        .section {
            display: none;
        }

        .section.active {
            display: block;
        }

        /* ---- HOME BAR ---- */
        .home-bar {
            width: 40%;
            height: 5px;
            background: var(--text-dark);
            border-radius: 10px;
            margin: 24px auto 0;
        }

        /* ---- SELECT ---- */
        select.form-select {
            color: #adb5bd;
        }

        select.form-select.selected {
            color: var(--text-dark);
        }
    </style>
</head>

<body>

    <div class="auth-wrapper">
        <div class="auth-card">
            @if ($errors->any())
                <div id="errorAlert" class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <strong>Login Error:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>

                <script>
                    setTimeout(function() {
                        let alertBox = document.getElementById('errorAlert');
                        if (alertBox) {
                            alertBox.classList.remove('show');
                            alertBox.classList.add('fade');
                            setTimeout(() => alertBox.remove(), 500);
                        }
                    }, 60000); // 60 seconds
                </script>
            @endif
            <!-- ===== LOGIN SECTION ===== -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="section active" id="loginSection">

                    <div class="logo-wrap">

                        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" />

                    </div>

                    <h1 class="auth-title">Sign in</h1>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="field-label">Your Email</label>
                        <input type="email" name="email" class="form-control" placeholder="yourmail@gmail.com"
                            required />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="field-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" id="loginPass"
                                placeholder="••••••••••" required />
                            <span class="input-group-text" onclick="togglePass('loginPass', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path
                                        d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94" />
                                    <path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19" />
                                    <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <button class="btn-login mb-3">Login</button>

                    <p class="divider-text">Don't have an account?</p>
                    <button class="btn-outline-dark-custom" onclick="switchTo('registerSection')">
                        Create an Account
                    </button>
                </div>
            </form>
            <!-- END LOGIN -->


            <!-- ===== REGISTER SECTION ===== -->

            <!-- END REGISTER -->

        </div><!-- /auth-card -->

        <div class="home-bar"></div>
    </div>

    <script>
        function switchTo(id) {
            document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
            document.getElementById(id).classList.add('active');
        }

        function togglePass(inputId, btn) {
            const input = document.getElementById(inputId);
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            btn.style.color = isHidden ? 'var(--primary)' : 'var(--text-muted)';
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
