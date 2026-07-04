<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FileNest - Log In</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    --bg: #f8f7f4;
    --ink: #0a0a0a;
    --line: rgba(10,10,10,0.07);
    --muted: #888888;
    --field: #ffffff;
    --field-border: rgba(10,10,10,0.12);
  }
  * { box-sizing: border-box; }
  html, body { height: 100%; }
  body{
    margin:0;
    background-color: var(--bg);
    background-image:
      linear-gradient(to right, var(--line) 1px, transparent 1px),
      linear-gradient(to bottom, var(--line) 1px, transparent 1px);
    background-size: 88px 88px;
    color: var(--ink);
    font-family: 'Inter', sans-serif;
    min-height: 100vh;
  }
  .wrap{
    min-height: 100vh;
    display:flex;
    flex-direction: column;
    align-items:center;
    padding: 48px 20px 100px;
  }
  .topbar{
    width:100%;
    max-width: 420px;
    display:flex;
    align-items:center;
    justify-content: space-between;
    margin-bottom: 56px;
  }
  .brand{
    font-family:'DM Serif Display', serif;
    font-size: 22px;
    letter-spacing: -0.02em;
  }
  .signuplink{
    font-size: 13px;
    color: var(--ink);
    text-decoration: underline;
    text-underline-offset: 3px;
    opacity: 0.75;
  }
  .signuplink:hover{ opacity: 1; }

  .heading{
    max-width: 420px;
    width: 100%;
    font-family:'DM Serif Display', serif;
    font-size: clamp(26px, 4vw, 32px);
    line-height: 1.25;
    letter-spacing: -0.01em;
    margin-bottom: 40px;
  }
  .heading em{
    font-style: normal;
    color: var(--muted);
  }

  .card{
    width: 100%;
    max-width: 420px;
  }

  .fn-status{
    background: #eef7ee;
    border: 1px solid rgba(34,139,34,0.25);
    color: #1e6b1e;
    font-size: 13px;
    padding: 12px 16px;
    border-radius: 10px;
    margin-bottom: 24px;
  }

  .oauth-btn{
    width:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    padding: 14px 16px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0.02em;
    cursor:pointer;
    border: 1px solid transparent;
    transition: all .2s ease;
  }
  .oauth-google{
    background: var(--ink);
    color: #fff;
  }
  .oauth-google:hover{ transform: translateY(-1px); box-shadow: 0 8px 24px rgba(10,10,10,0.18); }

  .oauth-x{
    background: #fff;
    color: var(--ink);
    border: 1px solid var(--field-border);
    margin-top: 12px;
  }
  .oauth-x:hover{ border-color: var(--ink); }

  .divider{
    display:flex;
    align-items:center;
    gap:16px;
    margin: 32px 0;
  }
  .divider .line{ flex:1; height:1px; background: var(--field-border); }
  .divider span{
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: var(--muted);
  }

  .field-label-row{
    display:flex;
    align-items:center;
    justify-content: space-between;
    margin-bottom: 8px;
  }
  .field-label{
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.03em;
    text-transform: uppercase;
    color: var(--ink);
  }
  .forgot-link{
    font-size: 12px;
    color: var(--muted);
    text-decoration: underline;
    text-underline-offset: 2px;
  }
  .forgot-link:hover{ color: var(--ink); }

  .field-group{ margin-bottom: 22px; }
  .field-wrap{ position: relative; }
  input[type="email"],
  input[type="password"],
  input[type="text"]{
    width:100%;
    background: var(--field);
    border: 1px solid var(--field-border);
    border-radius: 10px;
    padding: 14px 16px;
    font-size: 14px;
    color: var(--ink);
    outline: none;
    transition: border-color .2s ease;
  }
  input:focus{ border-color: var(--ink); }
  input.fn-input-error{ border-color: #d33; }

  .fn-error{
    color: #d33;
    font-size: 12px;
    margin-top: 6px;
  }

  .toggle-pass{
    position:absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    background:none;
    border:none;
    cursor:pointer;
    color: var(--muted);
    display:flex;
  }
  .toggle-pass:hover{ color: var(--ink); }

  .fn-remember-row{
    display:flex;
    align-items:center;
    margin-bottom: 22px;
  }
  .fn-remember-row input[type="checkbox"]{
    width: 16px;
    height: 16px;
    accent-color: var(--ink);
    margin-right: 8px;
  }
  .fn-remember-row label{
    font-size: 13px;
    color: #555;
  }

  .submit-btn{
    width:100%;
    background: var(--ink);
    color:#fff;
    border:none;
    border-radius: 999px;
    padding: 15px 16px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    cursor:pointer;
    transition: all .2s ease;
    margin-top: 6px;
  }
  .submit-btn:hover{ transform: translateY(-1px); box-shadow: 0 10px 28px rgba(10,10,10,0.2); }

  .fineprint{
    text-align:center;
    font-size: 12px;
    color: var(--muted);
    margin-top: 28px;
    line-height: 1.6;
  }
  .fineprint a{ color: var(--ink); text-decoration: underline; text-underline-offset: 2px; }
</style>
</head>
<body>

  <div class="wrap">
    <div class="topbar">
      <div class="brand">FileNest</div>
      @if (Route::has('register'))
        <a href="{{ route('register') }}" class="signuplink">Sign up</a>
      @endif
    </div>

    <h1 class="heading">
      Welcome back.<br />
      <em>Log in to your FileNest account.</em>
    </h1>

    <div class="card">

      <!-- Session Status -->
      @if (session('status'))
        <div class="fn-status">{{ session('status') }}</div>
      @endif

      <button type="button" class="oauth-btn oauth-google">
        <svg width="16" height="16" viewBox="0 0 24 24"><path fill="#fff" d="M21.35 11.1h-9.17v2.98h5.4c-.23 1.44-1.66 4.22-5.4 4.22-3.25 0-5.9-2.69-5.9-6s2.65-6 5.9-6c1.85 0 3.09.79 3.8 1.47l2.6-2.5C17.05 3.6 14.9 2.6 12.18 2.6 6.9 2.6 2.6 6.9 2.6 12.18s4.3 9.58 9.58 9.58c5.53 0 9.2-3.89 9.2-9.36 0-.63-.07-1.11-.03-1.3z"/></svg>
        Continue with Google
      </button>
      <button type="button" class="oauth-btn oauth-x">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.9 2H22l-7.6 8.7L23.3 22h-7l-5.5-6.6L4.3 22H1.2l8.1-9.3L1 2h7.2l5 6.1L18.9 2zm-1.2 18h1.7L7.4 4H5.6l12.1 16z"/></svg>
        Continue with X
      </button>

      <div class="divider"><span class="line"></span><span>or</span><span class="line"></span></div>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field-group">
          <label class="field-label" for="email">Email</label>
          <div class="field-wrap">
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email') }}"
                   class="@error('email') fn-input-error @enderror"
                   placeholder="you@example.com"
                   required
                   autofocus
                   autocomplete="username">
          </div>
          @error('email')
            <div class="fn-error">{{ $message }}</div>
          @enderror
        </div>

        <div class="field-group">
          <div class="field-label-row">
            <label class="field-label" for="password">Password</label>
            @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
            @endif
          </div>
          <div class="field-wrap">
            <input type="password"
                   id="password"
                   name="password"
                   class="@error('password') fn-input-error @enderror"
                   placeholder="Enter your password"
                   required
                   autocomplete="current-password">
            <button type="button" class="toggle-pass" onclick="togglePassword()">
              <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
          @error('password')
            <div class="fn-error">{{ $message }}</div>
          @enderror
        </div>

        <div class="fn-remember-row">
          <input id="remember_me" type="checkbox" name="remember">
          <label for="remember_me">Remember me</label>
        </div>

        <button type="submit" class="submit-btn">Log in</button>
      </form>

      @if (Route::has('register'))
        <p class="fineprint">
          Don't have an account?
          <a href="{{ route('register') }}">Sign up</a>
        </p>
      @endif
    </div>
  </div>

  <script>
    function togglePassword(){
      const input = document.getElementById('password');
      const icon = document.getElementById('eyeIcon');
      if(input.type === 'password'){
        input.type = 'text';
        icon.innerHTML = '<path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.5 21.5 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 7 11 7a21.5 21.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
      } else {
        input.type = 'password';
        icon.innerHTML = '<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/>';
      }
    }
  </script>

</body>
</html>