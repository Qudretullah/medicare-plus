
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | Medicare+</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f3f7fc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: #172b4d;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
        }

        .login-brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-logo {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -1px;
            color: #1767d2;
        }

        .login-logo span {
            color: #18a6a0;
        }

        .login-brand p {
            font-size: 14px;
            color: #75839b;
            margin-top: 8px;
        }

        .login-card {
            background: #ffffff;
            border: 1px solid #e5eaf2;
            border-radius: 18px;
            padding: 38px 34px;
            box-shadow: 0 18px 55px rgba(25, 59, 105, .08);
        }

        .login-card h1 {
            font-size: 25px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .login-subtitle {
            font-size: 14px;
            color: #718198;
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 9px;
        }

        .form-group input {
            width: 100%;
            height: 49px;
            border: 1px solid #dce4ef;
            border-radius: 10px;
            padding: 0 15px;
            font-size: 14px;
            outline: none;
            transition: .2s ease;
            background: #fbfcff;
        }

        .form-group input:focus {
            border-color: #1767d2;
            box-shadow: 0 0 0 3px rgba(23, 103, 210, .1);
        }

        .error-box {
            padding: 12px 14px;
            border-radius: 10px;
            background: #fff1f1;
            border: 1px solid #ffd2d2;
            color: #b42332;
            font-size: 13px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .field-error {
            font-size: 12px;
            color: #c62838;
            margin-top: 7px;
        }

        .login-button {
            width: 100%;
            height: 49px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #1767d2, #0752b0);
            color: white;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: .2s ease;
        }

        .login-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(23, 103, 210, .2);
        }

        .login-footer {
            text-align: center;
            font-size: 12px;
            color: #8491a5;
            margin-top: 25px;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 28px 22px;
            }

            .login-card h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">

    <div class="login-brand">
        <div class="login-logo">
            Medicare<span>+</span>
        </div>
        <p>Healthcare Administration Portal</p>
    </div>

    <div class="login-card">

        <h1>Welcome Back</h1>

        <p class="login-subtitle">
            Sign in to manage your Medicare+ hospital dashboard.
        </p>

        @if ($errors->any())
            <div class="error-box" role="alert">
                Invalid login details. Please check your credentials.
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">

            @csrf

            <div class="form-group">
                <label for="email">Admin Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter your admin email"
                    value="{{ old('email') }}"
                    autocomplete="username"
                    required
                >

                @error('email')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required
                >

                @error('password')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="login-button">
                Sign In to Dashboard
            </button>

        </form>

    </div>

    <div class="login-footer">
        &copy; {{ date('Y') }} Medicare+ — Authorized Access Only
    </div>

</div>

</body>
</html>
