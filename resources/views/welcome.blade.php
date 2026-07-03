<!-- <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">


        @if (Route::has('login'))
        <nav class="flex items-center justify-end gap-4">
            @auth
            @if(auth()->user()->isAdmin())
            <a href="{{ url('/admin/dashboard') }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                Admin Dashboard
            </a>
            @elseif(auth()->user()->isSeller())
            <a href="{{ url('/seller/dashboard') }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                Seller Panel
            </a>
            @else
            <a href="{{ url('/buyer/dashboard') }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                Buyer Portal
            </a>
            @endif
            @else
            <a href="{{ route('login') }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                Log in
            </a> -->
<!-- 
            @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                Register
            </a>
            @endif

            @if (Route::has('seller.register'))
            <a href="{{ route('seller.register') }}"
                class="inline-block px-5 py-1.5 text-indigo-600 dark:text-indigo-400 border border-indigo-500/30 hover:border-indigo-500 rounded-sm text-sm leading-normal ml-2">
                Become a Seller
            </a>
            @endif
            @endauth
        </nav>
        @endif
    </header> --> 


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>FileNest — Premium Digital Marketplace</title>

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,700;1,300&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('frontend/style.css') }}">

<!-- Tailwind (utility classes used throughout the original design) -->
<script src="https://cdn.tailwindcss.com"></script>


    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="../assets/images/brand/new style FN.png" /> 
    
<!-- Custom styles / keyframes -->
<link rel="stylesheet" href="style.css" />
</head>
<body class="font-['DM_Sans'] bg-[#f8f7f4] text-[#0a0a0a] overflow-x-hidden" style="cursor:none;">

  <!-- ─── LOADER ─── -->
  <div id="loader" class="fixed inset-0 bg-[#0a0a0a] z-[10000] flex flex-col items-center justify-center gap-6 transition-opacity duration-700 opacity-100">
    <div class="font-['Bebas_Neue'] text-[clamp(48px,8vw,96px)] text-[#f8f7f4] tracking-widest" style="animation:loaderPulse 1.2s ease-in-out infinite alternate;">
      FileNest
    </div>
    <div class="w-48 h-px bg-white/10 relative overflow-hidden">
      <div class="absolute inset-0 bg-[#f8f7f4]" style="animation:loaderFill 1.8s ease forwards; transform-origin:left; transform:scaleX(0);"></div>
    </div>
  </div>

  <!-- ─── CUSTOM CURSOR ─── -->
  <div id="cursor-dot" class="w-2.5 h-2.5 bg-[#0a0a0a] rounded-full fixed top-0 left-0 pointer-events-none z-[9999] hidden md:block"></div>
  <div id="cursor-ring" class="w-9 h-9 border border-[#0a0a0a] rounded-full fixed top-0 left-0 pointer-events-none z-[9998] opacity-50 hidden md:block"></div>

  <!-- ─── NAVBAR ─── -->
  <nav id="navbar" class="fixed top-0 left-0 right-0 z-[1000] px-[5vw] h-[72px] flex items-center justify-between transition-all duration-400">
    <a data-scroll="#home" class="font-['Bebas_Neue'] text-[28px] tracking-[0.08em] text-[#0a0a0a] no-underline cursor-pointer relative group">
      FileNest
      <span class="absolute bottom-[-2px] left-0 right-0 h-0.5 bg-[#0a0a0a] scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
    </a>

    <!-- Desktop Links -->
    <div class="hidden md:flex items-center gap-2">
      <!-- <a data-scroll="#home" class="text-xs font-semibold tracking-widest text-[#0a0a0a] uppercase px-4 py-2 rounded-full hover:bg-[#0a0a0a] hover:text-[#f8f7f4] transition-colors duration-200 cursor-pointer">Home</a>
      <a data-scroll="#about" class="text-xs font-semibold tracking-widest text-[#0a0a0a] uppercase px-4 py-2 rounded-full hover:bg-[#0a0a0a] hover:text-[#f8f7f4] transition-colors duration-200 cursor-pointer">About</a>
      <a data-scroll="catalog" class="text-xs font-semibold tracking-widest text-[#0a0a0a] uppercase px-4 py-2 rounded-full hover:bg-[#0a0a0a] hover:text-[#f8f7f4] transition-colors duration-200 cursor-pointer">Catalog</a>
      <a data-scroll="#contact" class="text-xs font-semibold tracking-widest text-[#0a0a0a] uppercase px-4 py-2 rounded-full hover:bg-[#0a0a0a] hover:text-[#f8f7f4] transition-colors duration-200 cursor-pointer">Contact</a> -->
      <a href="{{ route('login') }}" class="text-xs font-semibold tracking-widest text-[#0a0a0a] uppercase px-4 py-2 rounded-full border border-[#0a0a0a] hover:bg-[#0a0a0a] hover:text-[#f8f7f4] transition-colors duration-200 cursor-pointer">Login</a>
      <a href="{{ route('register') }}" class="text-xs font-semibold tracking-widest text-[#0a0a0a] uppercase px-4 py-2 rounded-full border border-[#0a0a0a] hover:bg-[#0a0a0a] hover:text-[#f8f7f4] transition-colors duration-200 cursor-pointer">Register</a>
    </div>

    <!-- Hamburger -->
    <button id="hamburger" class="md:hidden flex flex-col gap-[5px] cursor-pointer bg-transparent border-none p-1">
      <span class="ham-line block w-6 h-px bg-[#0a0a0a] transition-all duration-300"></span>
      <span class="ham-line block w-6 h-px bg-[#0a0a0a] transition-all duration-300"></span>
      <span class="ham-line block w-6 h-px bg-[#0a0a0a] transition-all duration-300"></span>
    </button>
  </nav>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="fixed inset-0 bg-[#f8f7f4] z-[999] flex-col items-center justify-center gap-8 hidden">
   
    <a href="{{ route('login') }}" class="mobile-link font-['Bebas_Neue'] text-5xl tracking-widest text-[#0a0a0a] cursor-pointer">Login</a>
    <a href="{{ route('register') }}" class="mobile-link font-['Bebas_Neue'] text-5xl tracking-widest text-[#0a0a0a] cursor-pointer">Register</a>
  </div>

  <main>
    <!-- ─── HERO ─── -->
    <section id="home" class="min-h-screen flex flex-col justify-center px-[5vw] pt-[120px] pb-20 relative overflow-hidden">
      <div class="absolute inset-0 opacity-40 pointer-events-none" style="background-image:linear-gradient(rgba(0,0,0,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,0.1) 1px, transparent 1px); background-size:80px 80px; animation:gridDrift 20s linear infinite;"></div>
      <div class="absolute top-[-200px] right-[-100px] w-[600px] h-[600px] rounded-full bg-[#0a0a0a] opacity-[0.06] blur-[80px]" style="animation:orbFloat 8s ease-in-out infinite alternate;"></div>
      <div class="absolute bottom-[-100px] left-[-100px] w-[400px] h-[400px] rounded-full bg-[#0a0a0a] opacity-[0.06] blur-[80px]" style="animation:orbFloat 8s 2s ease-in-out infinite alternate;"></div>

      <div class="inline-flex items-center gap-2 text-[11px] font-semibold tracking-[0.15em] uppercase text-[#888] border border-black/10 px-4 py-1.5 rounded-full w-fit mb-8" style="animation:fadeUp 0.8s ease forwards;">
        <span class="w-1.5 h-1.5 rounded-full bg-[#0a0a0a]" style="animation:blink 1.5s ease-in-out infinite;"></span>
        Premium Digital Marketplace
      </div>

      <h1 class="font-['DM_Serif_Display'] leading-[0.94] tracking-tight max-w-[900px]" style="font-size:clamp(52px, 9vw, 130px); letter-spacing:-0.03em; animation:fadeUp 0.9s 0.1s ease forwards; opacity:0;">
        Your Ideas,<br />
        <em class="not-italic text-[#888]">Beautifully</em><br />
        Packaged.
      </h1>

      <p class="text-[#555] max-w-[440px] leading-[1.7] mt-7 font-light" style="font-size:clamp(15px, 1.4vw, 18px); animation:fadeUp 0.9s 0.2s ease forwards; opacity:0;">
        Discover, buy, and sell premium digital products — templates, tools, UI kits, and more. Crafted by creators, for creators.
      </p>

      <div class="flex gap-4 mt-12 flex-wrap" style="animation:fadeUp 0.9s 0.3s ease forwards; opacity:0;">
        <a data-scroll="#catalog" class="inline-flex items-center gap-2.5 bg-[#0a0a0a] text-[#f8f7f4] text-xs font-semibold tracking-widest uppercase px-9 py-4 rounded-full cursor-pointer hover:-translate-y-0.5 hover:shadow-xl transition-all duration-200 relative overflow-hidden group">
          <span class="absolute inset-0 bg-white/10 -translate-x-full group-hover:translate-x-0 transition-transform duration-400 rounded-full"></span>
          Explore Catalog →
        </a>
        <a data-scroll="#about" class="inline-flex items-center gap-2.5 bg-transparent text-[#0a0a0a] text-xs font-semibold tracking-widest uppercase px-9 py-4 rounded-full border border-black/10 cursor-pointer hover:border-[#0a0a0a] hover:-translate-y-0.5 transition-all duration-200">
          How it works
        </a>
      </div>

      <div class="absolute bottom-10 left-[5vw] flex items-center gap-3 text-[11px] tracking-widest uppercase text-[#888]" style="animation:fadeUp 1s 0.6s ease forwards; opacity:0;">
        <div class="w-10 h-px bg-[#888] relative overflow-hidden">
          <span class="absolute inset-0 bg-[#0a0a0a]" style="animation:scanLine 2s ease-in-out infinite;"></span>
        </div>
        Scroll to explore
      </div>

      <!-- Floating Cards -->
      <div class="absolute right-[5vw] top-1/2 -translate-y-1/2 flex-col gap-4 hidden xl:flex">
        <div class="bg-white/80 backdrop-blur-xl border border-black/10 rounded-2xl px-5 py-4 shadow-lg hover:-translate-x-2 transition-transform duration-300" style="animation:floatCard1 6s ease-in-out infinite;">
          <div class="text-[10px] tracking-widest uppercase text-[#888]">Total Revenue</div>
          <div class="font-['Bebas_Neue'] text-[32px] tracking-wide">$84K</div>
          <div class="text-[11px] font-semibold text-[#2a7a2a]">↑ 24% this month</div>
        </div>
        <div class="bg-white/80 backdrop-blur-xl border border-black/10 rounded-2xl px-5 py-4 shadow-lg hover:-translate-x-2 transition-transform duration-300" style="animation:floatCard2 7s ease-in-out infinite;">
          <div class="text-[10px] tracking-widest uppercase text-[#888]">Active Sellers</div>
          <div class="font-['Bebas_Neue'] text-[32px] tracking-wide">1,200+</div>
          <div class="text-[11px] font-semibold text-[#2a7a2a]">↑ Growing fast</div>
        </div>
        <div class="bg-white/80 backdrop-blur-xl border border-black/10 rounded-2xl px-5 py-4 shadow-lg hover:-translate-x-2 transition-transform duration-300" style="animation:floatCard3 8s ease-in-out infinite;">
          <div class="text-[10px] tracking-widest uppercase text-[#888]">Happy Buyers</div>
          <div class="font-['Bebas_Neue'] text-[32px] tracking-wide">18K</div>
          <div class="text-[11px] font-semibold text-[#2a7a2a]">★ 4.9 avg rating</div>
        </div>
      </div>
    </section>

    <!-- ─── MARQUEE ─── -->
    <div class="overflow-hidden border-t border-b border-black/10 py-[18px] bg-[#0a0a0a]">
      <div class="flex gap-16 w-max" style="animation:marquee 20s linear infinite;" id="marquee-track"></div>
    </div>

    <!-- ─── STATS ─── -->
    <section id="about" class="py-[120px] px-[5vw]">
      <div class="reveal"><div class="flex items-center gap-3 text-[11px] tracking-[0.15em] uppercase font-medium text-[#888]"><span class="block w-6 h-px bg-[#888]"></span>Platform Statistics</div></div>
      <div class="reveal" data-delay="100">
        <h2 class="font-['DM_Serif_Display'] text-[clamp(36px,5vw,72px)] tracking-tight leading-[1.05] max-w-[700px] mt-4">
          Numbers that<br /><em class="not-italic text-[#888]">speak loudly.</em>
        </h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-[72px]">
        <div class="reveal">
          <div class="stat-card border border-black/10 rounded-3xl p-12 relative overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:border-[#0a0a0a] group bg-[#f8f7f4]">
            <div class="absolute inset-0 bg-[#0a0a0a] opacity-0 group-hover:opacity-100 transition-opacity duration-400 z-0"></div>
            <div class="relative z-10">
              <span class="text-[28px] mb-6 block">📦</span>
              <div class="counter font-['Bebas_Neue'] text-[clamp(52px,5vw,80px)] leading-none tracking-wide text-[#0a0a0a] group-hover:text-[#f8f7f4] transition-colors duration-300" data-target="4820">0</div>
              <div class="text-sm font-medium text-[#888] mt-2 uppercase tracking-widest group-hover:text-[#f8f7f4] transition-colors duration-300">Products Uploaded</div>
              <div class="text-[13px] text-[#999] mt-2 group-hover:text-white/60 transition-colors duration-300">Across 24 categories</div>
            </div>
            <div class="absolute bottom-[-40px] right-[-40px] w-[150px] h-[150px] rounded-full bg-[#f8f7f4] opacity-5 blur-[40px]"></div>
          </div>
        </div>
        <div class="reveal" data-delay="100">
          <div class="stat-card border border-black/10 rounded-3xl p-12 relative overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:border-[#0a0a0a] group bg-[#f8f7f4]">
            <div class="absolute inset-0 bg-[#0a0a0a] opacity-0 group-hover:opacity-100 transition-opacity duration-400 z-0"></div>
            <div class="relative z-10">
              <span class="text-[28px] mb-6 block">🛒</span>
              <div class="counter font-['Bebas_Neue'] text-[clamp(52px,5vw,80px)] leading-none tracking-wide text-[#0a0a0a] group-hover:text-[#f8f7f4] transition-colors duration-300" data-target="38400">0</div>
              <div class="text-sm font-medium text-[#888] mt-2 uppercase tracking-widest group-hover:text-[#f8f7f4] transition-colors duration-300">Total Products Sold</div>
              <div class="text-[13px] text-[#999] mt-2 group-hover:text-white/60 transition-colors duration-300">Since launch in 2022</div>
            </div>
            <div class="absolute bottom-[-40px] right-[-40px] w-[150px] h-[150px] rounded-full bg-[#f8f7f4] opacity-5 blur-[40px]"></div>
          </div>
        </div>
        <div class="reveal" data-delay="200">
          <div class="stat-card border border-black/10 rounded-3xl p-12 relative overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl hover:border-[#0a0a0a] group bg-[#f8f7f4]">
            <div class="absolute inset-0 bg-[#0a0a0a] opacity-0 group-hover:opacity-100 transition-opacity duration-400 z-0"></div>
            <div class="relative z-10">
              <span class="text-[28px] mb-6 block">⚡</span>
              <div class="counter font-['Bebas_Neue'] text-[clamp(52px,5vw,80px)] leading-none tracking-wide text-[#0a0a0a] group-hover:text-[#f8f7f4] transition-colors duration-300" data-target="312">0</div>
              <div class="text-sm font-medium text-[#888] mt-2 uppercase tracking-widest group-hover:text-[#f8f7f4] transition-colors duration-300">Today's Sales</div>
              <div class="text-[13px] text-[#999] mt-2 group-hover:text-white/60 transition-colors duration-300">And counting…</div>
            </div>
            <div class="absolute bottom-[-40px] right-[-40px] w-[150px] h-[150px] rounded-full bg-[#f8f7f4] opacity-5 blur-[40px]"></div>
          </div>
        </div>
      </div>
    </section>

    <!-- ─── FEATURES ─── -->
    <section id="features" class="py-[120px] px-[5vw] bg-[#0a0a0a] text-[#f8f7f4] relative overflow-hidden">
      <div class="reveal"><div class="flex items-center gap-3 text-[11px] tracking-[0.15em] uppercase font-medium text-white/30"><span class="block w-6 h-px bg-white/30"></span>Why FileNest</div></div>
      <div class="reveal" data-delay="100">
        <h2 class="font-['DM_Serif_Display'] text-[clamp(36px,5vw,72px)] tracking-tight leading-[1.05] max-w-[700px] mt-4">
          Built for the<br /><em class="not-italic text-white/30">modern creator.</em>
        </h2>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 border border-white/8 rounded-3xl overflow-hidden mt-20" id="features-grid"></div>
    </section>

    <!-- ─── PRICING ─── -->
    <section id="catalog" class="py-[120px] px-[5vw]">
      <div class="reveal"><div class="flex items-center gap-3 text-[11px] tracking-[0.15em] uppercase font-medium text-[#888]"><span class="block w-6 h-px bg-[#888]"></span>Pricing</div></div>
      <div class="reveal" data-delay="100">
        <h2 class="font-['DM_Serif_Display'] text-[clamp(36px,5vw,72px)] tracking-tight leading-[1.05] max-w-[700px] mt-4">
          Simple, transparent<br /><em class="not-italic text-[#888]">pricing.</em>
        </h2>
      </div>
      <div class="reveal" data-delay="150">
        <p class="text-[#555] max-w-[440px] leading-[1.7] mt-7 font-light text-[15px]">
          Start for free. Upgrade only when you're ready to scale your store.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-[72px] items-stretch">

        <!-- FREE PLAN -->
        <div class="reveal h-full" data-delay="0">
          <div class="h-full flex flex-col border border-black/10 rounded-3xl p-10 bg-[#f8f7f4] hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
            <div class="text-[11px] font-semibold tracking-widest uppercase text-[#888]">Free</div>
            <div class="flex items-end gap-1 mt-5">
              <span class="font-['Bebas_Neue'] text-[56px] leading-none tracking-wide">$0</span>
              <span class="text-sm text-[#888] mb-1">/month</span>
            </div>
            <p class="text-[13px] text-[#999] mt-3">For creators just getting started.</p>
            <ul class="flex flex-col gap-3 mt-8 flex-1">
              <li class="flex items-start gap-3 text-sm text-[#444]"><span class="font-['DM_Serif_Display'] text-[#0a0a0a] flex-shrink-0">✓</span>Up to 5 product listings</li>
              <li class="flex items-start gap-3 text-sm text-[#444]"><span class="font-['DM_Serif_Display'] text-[#0a0a0a] flex-shrink-0">✓</span>7% transaction fee</li>
              <li class="flex items-start gap-3 text-sm text-[#444]"><span class="font-['DM_Serif_Display'] text-[#0a0a0a] flex-shrink-0">✓</span>Basic analytics</li>
              <li class="flex items-start gap-3 text-sm text-[#444]"><span class="font-['DM_Serif_Display'] text-[#0a0a0a] flex-shrink-0">✓</span>Weekly payouts</li>
            </ul>
            <a class="inline-flex items-center justify-center gap-2.5 bg-transparent text-[#0a0a0a] text-xs font-semibold tracking-widest uppercase px-9 py-4 rounded-full border border-black/10 cursor-pointer hover:border-[#0a0a0a] transition-all duration-200 mt-10">
              Get Started
            </a>
          </div>
        </div>

        <!-- PRO PLAN (highlighted) -->
        <div class="reveal h-full" data-delay="100">
          <div class="h-full flex flex-col border border-[#0a0a0a] rounded-3xl p-10 bg-[#0a0a0a] text-[#f8f7f4] relative overflow-hidden hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
            <span class="absolute top-6 right-6 bg-[#f8f7f4] text-[#0a0a0a] text-[10px] font-bold tracking-widest uppercase px-3 py-1 rounded-full">Most Popular</span>
            <div class="text-[11px] font-semibold tracking-widest uppercase text-white/50">Pro</div>
            <div class="flex items-end gap-1 mt-5">
              <span class="font-['Bebas_Neue'] text-[56px] leading-none tracking-wide">$19</span>
              <span class="text-sm text-white/50 mb-1">/month</span>
            </div>
            <p class="text-[13px] text-white/40 mt-3">For sellers ready to grow serious revenue.</p>
            <ul class="flex flex-col gap-3 mt-8 flex-1">
              <li class="flex items-start gap-3 text-sm text-white/80"><span class="font-['DM_Serif_Display'] text-[#f8f7f4] flex-shrink-0">✓</span>Unlimited product listings</li>
              <li class="flex items-start gap-3 text-sm text-white/80"><span class="font-['DM_Serif_Display'] text-[#f8f7f4] flex-shrink-0">✓</span>Only 3% transaction fee</li>
              <li class="flex items-start gap-3 text-sm text-white/80"><span class="font-['DM_Serif_Display'] text-[#f8f7f4] flex-shrink-0">✓</span>Deep analytics dashboard</li>
              <li class="flex items-start gap-3 text-sm text-white/80"><span class="font-['DM_Serif_Display'] text-[#f8f7f4] flex-shrink-0">✓</span>Instant payouts</li>
              <li class="flex items-start gap-3 text-sm text-white/80"><span class="font-['DM_Serif_Display'] text-[#f8f7f4] flex-shrink-0">✓</span>Built-in affiliate system</li>
            </ul>
            <a class="inline-flex items-center justify-center gap-2.5 bg-[#f8f7f4] text-[#0a0a0a] text-xs font-semibold tracking-widest uppercase px-9 py-4 rounded-full cursor-pointer hover:-translate-y-0.5 hover:shadow-xl transition-all duration-200 mt-10">
              Upgrade to Pro
            </a>
          </div>
        </div>

        <!-- BUSINESS PLAN -->
        <div class="reveal h-full" data-delay="200">
          <div class="h-full flex flex-col border border-black/10 rounded-3xl p-10 bg-[#f8f7f4] hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
            <div class="text-[11px] font-semibold tracking-widest uppercase text-[#888]">Business</div>
            <div class="flex items-end gap-1 mt-5">
              <span class="font-['Bebas_Neue'] text-[56px] leading-none tracking-wide">$49</span>
              <span class="text-sm text-[#888] mb-1">/month</span>
            </div>
            <p class="text-[13px] text-[#999] mt-3">For teams and high-volume stores.</p>
            <ul class="flex flex-col gap-3 mt-8 flex-1">
              <li class="flex items-start gap-3 text-sm text-[#444]"><span class="font-['DM_Serif_Display'] text-[#0a0a0a] flex-shrink-0">✓</span>Everything in Pro</li>
              <li class="flex items-start gap-3 text-sm text-[#444]"><span class="font-['DM_Serif_Display'] text-[#0a0a0a] flex-shrink-0">✓</span>Just 1.5% transaction fee</li>
              <li class="flex items-start gap-3 text-sm text-[#444]"><span class="font-['DM_Serif_Display'] text-[#0a0a0a] flex-shrink-0">✓</span>Multi-seat team access</li>
              <li class="flex items-start gap-3 text-sm text-[#444]"><span class="font-['DM_Serif_Display'] text-[#0a0a0a] flex-shrink-0">✓</span>Priority support</li>
            </ul>
            <a class="inline-flex items-center justify-center gap-2.5 bg-transparent text-[#0a0a0a] text-xs font-semibold tracking-widest uppercase px-9 py-4 rounded-full border border-black/10 cursor-pointer hover:border-[#0a0a0a] transition-all duration-200 mt-10">
              Contact Sales
            </a>
          </div>
        </div>

      </div>
    </section>

    <!-- ─── REVIEWS ─── -->
    <!-- ─── REVIEWS ─── -->
    <section id="reviews" class="py-[120px] px-[5vw] bg-[#0f0f0f] text-[#f8f7f4] overflow-hidden">
      <div class="reveal"><div class="flex items-center gap-3 text-[11px] tracking-[0.15em] uppercase font-medium text-white/30"><span class="block w-6 h-px bg-white/30"></span>Testimonials</div></div>
      <div class="reveal" data-delay="100">
        <h2 class="font-['DM_Serif_Display'] text-[clamp(36px,5vw,72px)] tracking-tight leading-[1.05] max-w-[700px] mt-4">
          Loved by<br /><em class="not-italic text-white/25">10,000+ creators.</em>
        </h2>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-[72px]">
        <div class="reveal review-box bg-white/4 border border-white/7 rounded-[20px] p-9">
          <div class="text-base mb-5 text-[#f5c842]">★★★★★</div>
          <p class="text-[15px] leading-[1.75] text-white/70 font-light italic mb-7">FileNest completely changed how I sell my design assets. The storefront is gorgeous and setup took under an hour.</p>
          <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-full bg-white/10 border border-white/10 flex items-center justify-center font-['Bebas_Neue'] text-lg">AK</div>
            <div>
              <div class="text-sm font-semibold">Ayesha Khan</div>
              <div class="text-xs text-white/35 mt-0.5">UI Designer, Dubai</div>
            </div>
          </div>
        </div>

        <div class="reveal review-box bg-white/4 border border-white/7 rounded-[20px] p-9" data-delay="100">
          <div class="text-base mb-5 text-[#f5c842]">★★★★★</div>
          <p class="text-[15px] leading-[1.75] text-white/70 font-light italic mb-7">I've tried every marketplace out there. FileNest is the only one that actually feels premium and smooth.</p>
          <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-full bg-white/10 border border-white/10 flex items-center justify-center font-['Bebas_Neue'] text-lg">MR</div>
            <div>
              <div class="text-sm font-semibold">Marco Rossi</div>
              <div class="text-xs text-white/35 mt-0.5">Illustrator, Milan</div>
            </div>
          </div>
        </div>

        <div class="reveal review-box bg-white/4 border border-white/7 rounded-[20px] p-9" data-delay="200">
          <div class="text-base mb-5 text-[#f5c842]">★★★★★</div>
          <p class="text-[15px] leading-[1.75] text-white/70 font-light italic mb-7">The affiliate system alone is worth it. Truly passive income built into the platform.</p>
          <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-full bg-white/10 border border-white/10 flex items-center justify-center font-['Bebas_Neue'] text-lg">SL</div>
            <div>
              <div class="text-sm font-semibold">Sarah Lin</div>
              <div class="text-xs text-white/35 mt-0.5">Notion Creator, NYC</div>
            </div>
          </div>
        </div>

        <div class="reveal review-box bg-white/4 border border-white/7 rounded-[20px] p-9" data-delay="300">
          <div class="text-base mb-5 text-[#f5c842]">★★★★★</div>
          <p class="text-[15px] leading-[1.75] text-white/70 font-light italic mb-7">Analytics are insane — I can see exactly what's working. The best investment for any digital creator.</p>
          <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-full bg-white/10 border border-white/10 flex items-center justify-center font-['Bebas_Neue'] text-lg">JP</div>
            <div>
              <div class="text-sm font-semibold">James Park</div>
              <div class="text-xs text-white/35 mt-0.5">Developer, Seoul</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ─── ABOUT SPLIT ─── -->
    <section id="about-split" class="py-[120px] px-[5vw] grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
      <div class="reveal hidden md:block">
        <div class="aspect-square bg-[#000000] rounded-3xl relative overflow-hidden flex items-center justify-center">
          <div class="font-['Bebas_Neue'] text-[10vw] text-white/4 text-center leading-[0.9] tracking-tight select-none">
            File<br />Nest 
          </div>
          <div class="absolute bottom-8 right-8 bg-[#f8f7f4] rounded-2xl px-6 py-5 shadow-2xl">
            <span class="font-['Bebas_Neue'] text-[40px] block leading-none">2022</span>
            <span class="text-[11px] tracking-widest uppercase text-[#888]">Founded</span>
          </div>
        </div>
      </div>
      <div>
        <div class="reveal"><div class="flex items-center gap-3 text-[11px] tracking-[0.15em] uppercase font-medium text-[#888]"><span class="block w-6 h-px bg-[#888]"></span>Our Story</div></div>
        <div class="reveal" data-delay="100">
          <h2 class="font-['DM_Serif_Display'] text-[clamp(36px,5vw,72px)] tracking-tight leading-[1.05] mt-4">
            We built the store<br />we <em class="not-italic text-[#888]">always wanted.</em>
          </h2>
        </div>
        <div class="reveal" data-delay="200">
          <p class="text-sm text-[#555] leading-[1.8] mt-7 font-light">
            FileNest was born from frustration — existing platforms were clunky, took huge cuts, and treated sellers like an afterthought. We set out to build something different.
          </p>
          <ul class="list-none mt-9 flex flex-col gap-4">
            <li class="flex items-start gap-4 text-sm text-[#444]"><span class="font-['DM_Serif_Display'] text-[#0a0a0a] flex-shrink-0">→</span>Lowest fees in the industry — keep up to 97% of every sale</li>
            <li class="flex items-start gap-4 text-sm text-[#444]"><span class="font-['DM_Serif_Display'] text-[#0a0a0a] flex-shrink-0">→</span>Obsessively designed for a premium buyer experience</li>
            <li class="flex items-start gap-4 text-sm text-[#444]"><span class="font-['DM_Serif_Display'] text-[#0a0a0a] flex-shrink-0">→</span>Creator-first policies, real human support, no bots</li>
            <li class="flex items-start gap-4 text-sm text-[#444]"><span class="font-['DM_Serif_Display'] text-[#0a0a0a] flex-shrink-0">→</span>Built on speed, security, and simplicity</li>
          </ul>
        </div>
        <div class="reveal" data-delay="300">
          <a data-scroll="#catalog" class="inline-flex items-center gap-2.5 bg-[#0a0a0a] text-[#f8f7f4] text-xs font-semibold tracking-widest uppercase px-9 py-4 rounded-full cursor-pointer hover:-translate-y-0.5 hover:shadow-xl transition-all duration-200 mt-10">
            Start Selling Today →
          </a>
        </div>
      </div>
    </section>

    <!-- ─── FAQ ─── -->
    <section id="contact" class="py-[120px] px-[5vw] border-t border-black/10">
      <div class="reveal"><div class="flex items-center gap-3 text-[11px] tracking-[0.15em] uppercase font-medium text-[#888]"><span class="block w-6 h-px bg-[#888]"></span>FAQ</div></div>
      <div class="reveal" data-delay="100">
        <h2 class="font-['DM_Serif_Display'] text-[clamp(36px,5vw,72px)] tracking-tight leading-[1.05] max-w-[700px] mt-4">
          Got <em class="not-italic text-[#888]">questions?</em><br />We have answers.
        </h2>
      </div>
      <div class="reveal" data-delay="100">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-[72px]" id="faq-grid"></div>
      </div>
    </section>
  </main>

  <!-- ─── FOOTER ─── -->
  <footer class="bg-[#0a0a0a] text-[#f8f7f4] px-[5vw] pt-20 pb-10">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-16 mb-20">
      <div class="lg:col-span-1">
        <a class="font-['Bebas_Neue'] text-4xl tracking-widest mb-5 block text-[#f8f7f4] no-underline cursor-pointer">FileNest</a>
        <p class="text-sm text-white/40 font-light leading-[1.7] max-w-[240px]">The premium marketplace for digital creators. Sell more, keep more, grow faster.</p>
      </div>
      <div>
        <h4 class="text-[11px] tracking-[0.15em] uppercase text-white/30 mb-5">Quick Links</h4>
        <a class="block text-sm text-white/60 hover:text-white transition-colors duration-200 mb-2.5 cursor-pointer">Home</a>
        <a class="block text-sm text-white/60 hover:text-white transition-colors duration-200 mb-2.5 cursor-pointer">About</a>
        <a class="block text-sm text-white/60 hover:text-white transition-colors duration-200 mb-2.5 cursor-pointer">Catalog</a>
        <a class="block text-sm text-white/60 hover:text-white transition-colors duration-200 mb-2.5 cursor-pointer">FAQ</a>
      </div>
      <div>
        <h4 class="text-[11px] tracking-[0.15em] uppercase text-white/30 mb-5">Platform</h4>
        <a href="{{ route('seller.register') }}" class="block text-sm text-white/60 hover:text-white transition-colors duration-200 mb-2.5 cursor-pointer">Start Selling</a>
        <a class="block text-sm text-white/60 hover:text-white transition-colors duration-200 mb-2.5 cursor-pointer">Pricing</a>
        <a class="block text-sm text-white/60 hover:text-white transition-colors duration-200 mb-2.5 cursor-pointer">Affiliates</a>
        <a class="block text-sm text-white/60 hover:text-white transition-colors duration-200 mb-2.5 cursor-pointer">Analytics</a>
      </div>
      <div>
        <h4 class="text-[11px] tracking-[0.15em] uppercase text-white/30 mb-5">Contact</h4>
        <p class="text-sm text-white/50 leading-[1.7]">hello@filenest.co<br />Mon–Fri, 9am–6pm<br />Response within 4hrs</p>
      </div>
    </div>
    <div class="border-t border-white/7 pt-8 flex items-center justify-between flex-wrap gap-4">
      <div class="text-xs text-white/25">© 2025 FileNest. All rights reserved.</div>
      <div class="flex gap-3">
        <a class="w-9 h-9 rounded-full border border-white/12 flex items-center justify-center text-sm text-white/50 hover:border-white hover:text-white transition-all duration-200 cursor-pointer">𝕏</a>
        <a class="w-9 h-9 rounded-full border border-white/12 flex items-center justify-center text-sm text-white/50 hover:border-white hover:text-white transition-all duration-200 cursor-pointer">◎</a>
        <a class="w-9 h-9 rounded-full border border-white/12 flex items-center justify-center text-sm text-white/50 hover:border-white hover:text-white transition-all duration-200 cursor-pointer">in</a>
        <a class="w-9 h-9 rounded-full border border-white/12 flex items-center justify-center text-sm text-white/50 hover:border-white hover:text-white transition-all duration-200 cursor-pointer">▷</a>
      </div>
    </div>
  </footer>
<script src="{{ asset('frontend/script.js') }}"></script>
</body>
</html>