<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FileNest - Seller Sign Up</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    --bg: #f8f7f4;
    --ink: #0a0a0a;
    --line: rgba(10,10,10,0.07);
    --line-light: rgba(255,255,255,0.09);
    --muted: #888888;
    --field: #ffffff;
    --field-border: rgba(10,10,10,0.12);
  }
  * { box-sizing: border-box; }
  html, body { height: 100%; }
  body{
    margin:0;
    color: var(--ink);
    font-family: 'Inter', sans-serif;
    overflow: hidden;
  }

  .screen{
    height: 100vh;
    width: 100%;
    display:flex;
  }

  /* ---------- LEFT: brand / pitch panel ---------- */
  .panel-left{
    flex: 1 1 46%;
    max-width: 46%;
    background-color: var(--ink);
    background-image:
      linear-gradient(to right, var(--line-light) 1px, transparent 1px),
      linear-gradient(to bottom, var(--line-light) 1px, transparent 1px);
    background-size: 64px 64px;
    color: #f8f7f4;
    display:flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 44px 52px;
  }
  .brand{
    font-family:'DM Serif Display', serif;
    font-size: 22px;
    letter-spacing: -0.02em;
  }
  .pitch{
    max-width: 420px;
  }
  .pitch h1{
    font-family:'DM Serif Display', serif;
    font-weight: 400;
    font-size: clamp(30px, 3vw, 42px);
    line-height: 1.25;
    letter-spacing: -0.01em;
    margin: 0 0 22px;
  }
  .pitch h1 em{
    font-style: normal;
    color: #9a9a9a;
  }
  .pitch p{
    font-size: 14px;
    line-height: 1.7;
    color: #b9b9b9;
    margin: 0 0 28px;
  }
  .perks{
    list-style:none;
    padding:0;
    margin:0;
    display:flex;
    flex-direction: column;
    gap: 16px;
  }
  .perks li{
    display:flex;
    align-items:flex-start;
    gap: 12px;
    font-size: 13px;
    color: #e6e6e6;
  }
  .perks li svg{ flex-shrink:0; margin-top: 2px; }
  .perks li b{ display:block; color:#fff; font-size:13px; margin-bottom:2px; }
  .perks li span.desc{ color:#9a9a9a; }

  .foot-note{
    font-size: 12px;
    color: #777;
  }

  /* ---------- RIGHT: form panel ---------- */
  .panel-right{
    flex: 1 1 54%;
    max-width: 54%;
    background-color: var(--bg);
    background-image:
      linear-gradient(to right, var(--line) 1px, transparent 1px),
      linear-gradient(to bottom, var(--line) 1px, transparent 1px);
    background-size: 64px 64px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding: 32px;
    overflow-y: auto;
  }
  .card{
    width: 100%;
    max-width: 380px;
  }
  .card-top{
    display:flex;
    align-items:flex-start;
    justify-content: space-between;
    margin-bottom: 22px;
  }
  .card-top-mobile{ display: none; }
  .card-heading{
    font-family:'DM Serif Display', serif;
    font-size: 24px;
    letter-spacing: -0.01em;
  }
  .card-subtext{
    font-size: 12.5px;
    color: var(--muted);
    margin-top: 4px;
  }
  .signuplink{
    font-size: 13px;
    color: var(--ink);
    text-decoration: underline;
    text-underline-offset: 3px;
    opacity: 0.75;
  }
  .signuplink:hover{ opacity: 1; }

  .fn-status{
    background: #eef7ee;
    border: 1px solid rgba(34,139,34,0.25);
    color: #1e6b1e;
    font-size: 13px;
    padding: 10px 14px;
    border-radius: 10px;
    margin-bottom: 16px;
  }

  .field-label{
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.03em;
    text-transform: uppercase;
    color: var(--ink);
    display:block;
    margin-bottom: 6px;
  }

  .field-group{ margin-bottom: 14px; }
  .field-wrap{ position: relative; }
  input[type="email"],
  input[type="password"],
  input[type="text"]{
    width:100%;
    background: var(--field);
    border: 1px solid var(--field-border);
    border-radius: 10px;
    padding: 12px 14px;
    font-size: 13.5px;
    color: var(--ink);
    outline: none;
    transition: border-color .2s ease;
  }
  input:focus{ border-color: var(--ink); }
  input.fn-input-error{ border-color: #d33; }

  .fn-error{
    color: #d33;
    font-size: 11.5px;
    margin-top: 5px;
  }

  .toggle-pass{
    position:absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background:none;
    border:none;
    cursor:pointer;
    color: var(--muted);
    display:flex;
  }
  .toggle-pass:hover{ color: var(--ink); }

  .submit-btn{
    width:100%;
    background: var(--ink);
    color:#fff;
    border:none;
    border-radius: 999px;
    padding: 13px 16px;
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    cursor:pointer;
    transition: all .2s ease;
    margin-top: 4px;
  }
  .submit-btn:hover{ transform: translateY(-1px); box-shadow: 0 10px 28px rgba(10,10,10,0.2); }

  .fineprint{
    text-align:center;
    font-size: 12px;
    color: var(--muted);
    margin-top: 18px;
    line-height: 1.6;
  }
  .fineprint a{ color: var(--ink); text-decoration: underline; text-underline-offset: 2px; }

  /* ---------- responsive: stack on small screens, allow scroll there ---------- */
  @media (max-width: 860px){
    body{ overflow: auto; }
    .screen{ height: auto; flex-direction: column; }
    .panel-left{ display: none; }
    .panel-right{ max-width: 100%; flex: none; padding: 32px 24px 48px; }
    .card-top-desktop{ display: none; }
    .card-top-mobile{ display: flex; }
  }
</style>
</head>
<body>

  <div class="screen">

    <!-- LEFT: pitch panel -->
    <div class="panel-left">
      <div class="brand">FileNest</div>

      <div class="pitch">
        <h1>Sell your files.<br /><em>Reach buyers worldwide.</em></h1>
        <p>Join FileNest as a seller and turn your digital products, templates, and assets into a steady stream of income — with zero setup hassle.</p>

        <ul class="perks">
          <li>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8"><path d="M20 6L9 17l-5-5"/></svg>
            <span><b>Instant storefront</b><span class="desc">Start listing your files the moment you sign up.</span></span>
          </li>
          <li>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8"><path d="M20 6L9 17l-5-5"/></svg>
            <span><b>Secure payouts</b><span class="desc">Get paid safely and on time, every time.</span></span>
          </li>
          <li>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8"><path d="M20 6L9 17l-5-5"/></svg>
            <span><b>Global reach</b><span class="desc">Your files, in front of buyers around the world.</span></span>
          </li>
        </ul>
      </div>

      <div class="foot-note">© {{ date('Y') }} FileNest. All rights reserved.</div>
    </div>

    <!-- RIGHT: form panel -->
    <div class="panel-right">
      <div class="card">

        <div class="card-top card-top-desktop">
          <div class="card-heading">Become a seller</div>
          <a href="{{ route('login') }}" class="signuplink">Log in</a>
        </div>

        <div class="card-top card-top-mobile">
          <div>
            <div class="card-heading">FileNest</div>
            <div class="card-subtext">Create your seller account and start selling.</div>
          </div>
          <a href="{{ route('login') }}" class="signuplink">Log in</a>
        </div>

        @if (session('status'))
          <div class="fn-status">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('seller.register') }}">
          @csrf

          <!-- Name -->
          <div class="field-group">
            <label class="field-label" for="name">Name</label>
            <div class="field-wrap">
              <input type="text"
                     id="name"
                     name="name"
                     value="{{ old('name') }}"
                     class="@error('name') fn-input-error @enderror"
                     placeholder="Your full name"
                     required
                     autofocus
                     autocomplete="name">
            </div>
            @error('name')
              <div class="fn-error">{{ $message }}</div>
            @enderror
          </div>

          <!-- Email -->
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
                     autocomplete="username">
            </div>
            @error('email')
              <div class="fn-error">{{ $message }}</div>
            @enderror
          </div>

          <!-- Password -->
          <div class="field-group">
            <label class="field-label" for="password">Password</label>
            <div class="field-wrap">
              <input type="password"
                     id="password"
                     name="password"
                     class="@error('password') fn-input-error @enderror"
                     placeholder="Create a password"
                     required
                     autocomplete="new-password">
              <button type="button" class="toggle-pass" onclick="togglePassword('password','eyeIcon1')">
                <svg id="eyeIcon1" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            @error('password')
              <div class="fn-error">{{ $message }}</div>
            @enderror
          </div>

          <!-- Confirm Password -->
          <div class="field-group">
            <label class="field-label" for="password_confirmation">Confirm Password</label>
            <div class="field-wrap">
              <input type="password"
                     id="password_confirmation"
                     name="password_confirmation"
                     class="@error('password_confirmation') fn-input-error @enderror"
                     placeholder="Re-enter your password"
                     required
                     autocomplete="new-password">
              <button type="button" class="toggle-pass" onclick="togglePassword('password_confirmation','eyeIcon2')">
                <svg id="eyeIcon2" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            @error('password_confirmation')
              <div class="fn-error">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="submit-btn">Register as Seller</button>
        </form>

        <p class="fineprint">
          Already registered?
          <a href="{{ route('login') }}">Log in</a>
        </p>
      </div>
    </div>

  </div>

  <script>
    function togglePassword(inputId, iconId){
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
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