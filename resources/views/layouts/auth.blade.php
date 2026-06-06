<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GymControl - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --dark: #0d0f12;
            --surface: #161a1f;
            --surface2: #1e242b;
            --border: #2a323c;
            --accent: #c8f135;
            --accent2: #a8d020;
            --text: #e8ecf0;
            --muted: #7a8794;
            --danger: #f87171;
            --success: #36d399;
        }

        * { box-sizing: border-box; }
        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 32px 16px;
            background:
                linear-gradient(135deg, rgba(200,241,53,.08), transparent 36%),
                linear-gradient(225deg, rgba(96,165,250,.08), transparent 34%),
                var(--dark);
            color: var(--text);
            font-family: 'Barlow', sans-serif;
        }

        .auth-card {
            width: min(100%, 430px);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 28px;
            box-shadow: 0 20px 60px rgba(0,0,0,.28);
        }

        .auth-card-wide { width: min(100%, 720px); }
        .auth-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--text);
            text-decoration: none;
            font: 800 26px 'Barlow Condensed', sans-serif;
            margin-bottom: 28px;
        }

        .auth-logo span:not(.auth-logo-icon) { color: var(--accent); }
        .auth-logo-icon {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--accent);
            color: var(--dark);
            font-size: 18px;
        }

        .auth-heading h1 {
            margin: 0 0 6px;
            font: 800 34px/1 'Barlow Condensed', sans-serif;
            letter-spacing: 0;
        }

        .auth-heading p {
            margin: 0 0 24px;
            color: var(--muted);
            font-size: 15px;
        }

        .auth-form { display: grid; gap: 16px; }
        .auth-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .auth-label {
            display: block;
            margin-bottom: 6px;
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
        }

        .auth-input {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--surface2);
            color: var(--text);
            padding: 12px 13px;
            font: 500 15px 'Barlow', sans-serif;
            outline: none;
        }

        .auth-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(200,241,53,.12);
        }

        .auth-input.is-invalid { border-color: rgba(248,113,113,.75); }
        .auth-error { margin-top: 6px; color: var(--danger); font-size: 13px; }
        .auth-check {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            font-size: 14px;
        }

        .auth-check input { accent-color: var(--accent); }
        .auth-button {
            border: 0;
            border-radius: 8px;
            padding: 13px 16px;
            background: var(--accent);
            color: var(--dark);
            font: 800 15px 'Barlow', sans-serif;
            cursor: pointer;
        }

        .auth-button:hover { background: var(--accent2); }
        .auth-switch {
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid var(--border);
            color: var(--muted);
            font-size: 14px;
            text-align: center;
        }

        .auth-switch a { color: var(--accent); font-weight: 700; text-decoration: none; }
        .alert {
            margin: 0 0 18px;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 14px;
        }

        .alert-success {
            background: rgba(54,211,153,.1);
            border: 1px solid rgba(54,211,153,.3);
            color: var(--success);
        }

        @media (max-width: 680px) {
            .auth-card { padding: 22px; }
            .auth-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <main>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
