document.addEventListener("DOMContentLoaded", () => {

  /* ─────────────────────────────────────────
     LOADER
  ───────────────────────────────────────── */
  const loader = document.getElementById("loader");
  setTimeout(() => {
    loader.classList.add("loader-hidden");
  }, 2000);
  // Safety fallback: guarantees the loader can never get stuck on screen.
  window.addEventListener("load", () => {
    setTimeout(() => loader.classList.add("loader-hidden"), 2500);
  });

  /* ─────────────────────────────────────────
     CUSTOM CURSOR
  ───────────────────────────────────────── */
  const cursorDot = document.getElementById("cursor-dot");
  const cursorRing = document.getElementById("cursor-ring");
  const mouse = { x: 0, y: 0 };
  const ring = { x: 0, y: 0 };

  document.addEventListener("mousemove", (e) => {
    mouse.x = e.clientX;
    mouse.y = e.clientY;
  });

  function animateCursor() {
    ring.x += (mouse.x - ring.x) * 0.18;
    ring.y += (mouse.y - ring.y) * 0.18;
    if (cursorDot) {
      cursorDot.style.transform = `translate(${mouse.x}px, ${mouse.y}px) translate(-50%, -50%)`;
    }
    if (cursorRing) {
      cursorRing.style.transform = `translate(${ring.x}px, ${ring.y}px) translate(-50%, -50%)`;
    }
    requestAnimationFrame(animateCursor);
  }
  requestAnimationFrame(animateCursor);

  /* ─────────────────────────────────────────
     NAVBAR SCROLL STATE
  ───────────────────────────────────────── */
  const navbar = document.getElementById("navbar");
  window.addEventListener("scroll", () => {
    if (window.scrollY > 40) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    }
  });

  /* ─────────────────────────────────────────
     MOBILE MENU
  ───────────────────────────────────────── */
  const hamburger = document.getElementById("hamburger");
  const mobileMenu = document.getElementById("mobile-menu");

  function closeMobileMenu() {
    hamburger.classList.remove("open");
    mobileMenu.classList.remove("open");
  }

  hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("open");
    mobileMenu.classList.toggle("open");
  });

  /* ─────────────────────────────────────────
     SMOOTH SCROLL (data-scroll links)
  ───────────────────────────────────────── */
  document.querySelectorAll("[data-scroll]").forEach((el) => {
    el.addEventListener("click", () => {
      closeMobileMenu();
      const target = document.querySelector(el.getAttribute("data-scroll"));
      if (target) target.scrollIntoView({ behavior: "smooth" });
    });
  });

  /* ─────────────────────────────────────────
     REVEAL ON SCROLL
  ───────────────────────────────────────── */
  const revealEls = document.querySelectorAll(".reveal");
  const revealObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const delay = entry.target.getAttribute("data-delay") || 0;
          entry.target.style.transitionDelay = `${delay}ms`;
          entry.target.classList.add("visible");
          revealObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.12 }
  );
  revealEls.forEach((el) => revealObserver.observe(el));

  /* ─────────────────────────────────────────
     COUNTER ANIMATION
  ───────────────────────────────────────── */
  const counters = document.querySelectorAll(".counter");
  const counterObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          startCounter(entry.target);
          counterObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.5 }
  );
  counters.forEach((el) => counterObserver.observe(el));

  function startCounter(el) {
    const target = parseInt(el.getAttribute("data-target"), 10);
    const duration = 1800;
    let startTime = null;

    function step(timestamp) {
      if (!startTime) startTime = timestamp;
      const progress = Math.min((timestamp - startTime) / duration, 1);
      const ease = 1 - Math.pow(1 - progress, 4);
      const value = Math.floor(ease * target);
      el.textContent = value.toLocaleString();
      if (progress < 1) {
        requestAnimationFrame(step);
      } else {
        el.textContent = target.toLocaleString();
      }
    }
    requestAnimationFrame(step);
  }

  /* ─────────────────────────────────────────
     MARQUEE
  ───────────────────────────────────────── */
  const marqueeItems = [
    "UI Kits", "Design Templates", "Notion Dashboards", "Figma Assets",
    "Digital Planners", "Stock Photos", "Fonts & Icons", "Code Templates",
    "Presets & Actions",
  ];
  const marqueeTrack = document.getElementById("marquee-track");
  const doubledItems = [...marqueeItems, ...marqueeItems];
  marqueeTrack.innerHTML = doubledItems
    .map((item, i) => {
      const dot = i < doubledItems.length - 1 ? `<span class="text-white/30 ml-16">·</span>` : "";
      return `<span class="font-['Bebas_Neue'] text-lg tracking-[0.12em] text-[#f8f7f4] whitespace-nowrap">${item}${dot}</span>`;
    })
    .join("");

  /* ─────────────────────────────────────────
     FEATURES
  ───────────────────────────────────────── */
  const FEATURES = [
    { num: "01", icon: "🏪", title: "Instant Storefront", desc: "Launch your digital product store in minutes. No coding required — just upload, price, and sell." },
    { num: "02", icon: "🔒", title: "Secure Delivery", desc: "Files are delivered via encrypted links with download limits. Buyers get what they paid for, nothing more." },
    { num: "03", icon: "💳", title: "Instant Payouts", desc: "Get paid directly to your bank or wallet. Zero holds, zero waiting. Your money, your timeline." },
    { num: "04", icon: "📊", title: "Deep Analytics", desc: "Track views, conversions, revenue trends, and buyer behaviour with a clean, real-time dashboard." },
    { num: "05", icon: "🤝", title: "Affiliate System", desc: "Reward your fans. Built-in affiliate tracking so others can sell your products and earn commissions." },
    { num: "06", icon: "🌍", title: "Global Reach", desc: "Sell in 130+ currencies with automatic tax handling. Your products, everywhere in the world." },
  ];
const featuresGrid = document.getElementById("features-grid");
  featuresGrid.innerHTML = FEATURES.map(({ num, icon, title, desc }, i) => `
    <div class="reveal h-full" data-delay="${(i % 3) * 100}">
      <div class="h-full p-12 border-r border-b border-white/8 hover:bg-white/4 transition-colors duration-300 relative overflow-hidden group">
        <div class="font-['Bebas_Neue'] text-[11px] tracking-[0.2em] text-white/20 mb-8">${num}</div>
        <span class="text-[32px] mb-5 block">${icon}</span>
        <div class="font-['DM_Serif_Display'] text-[22px] tracking-tight mb-3">${title}</div>
        <div class="text-sm text-white/50 leading-[1.7] font-light">${desc}</div>
      </div>
    </div>
  `).join("");

  // re-observe dynamically injected reveal elements
  featuresGrid.querySelectorAll(".reveal").forEach((el) => revealObserver.observe(el));

  /* ─────────────────────────────────────────
     NEWSLETTER SIGNUP
  ───────────────────────────────────────── */
  const newsletterForm = document.getElementById("newsletter-form");
  const newsletterMessage = document.getElementById("newsletter-message");

  if (newsletterForm) {
    newsletterForm.addEventListener("submit", (e) => {
      e.preventDefault();
      newsletterForm.reset();
      newsletterMessage.classList.remove("hidden");
    });
  }
//   /* ─────────────────────────────────────────
//      REVIEWS CAROUSEL
//   ───────────────────────────────────────── */
//   const REVIEWS = [
//     { initials: "AK", name: "Ayesha Khan", role: "UI Designer, Dubai", text: "FileNest completely changed how I sell my design assets. The storefront is gorgeous and setup took under an hour. Revenue doubled in my first month." },
//     { initials: "MR", name: "Marco Rossi", role: "Illustrator, Milan", text: "I've tried every marketplace out there. FileNest is the only one that actually feels premium. My buyers love how smooth the checkout experience is." },
//     { initials: "SL", name: "Sarah Lin", role: "Notion Creator, NYC", text: "The affiliate system alone is worth it. I've had people promoting my templates and earning commissions. Truly passive income built into the platform." },
//     { initials: "JP", name: "James Park", role: "Developer, Seoul", text: "Analytics are insane — I can see exactly what's working and what isn't. Customer support is fast too. The best investment for any digital creator." },
//     { initials: "PN", name: "Priya Nair", role: "Photographer, Bangalore", text: "Clean, fast, and reliable. Got my first sale within 3 days of uploading. The discovery algorithm actually works — buyers found me without any paid ads." },
//   ];

//   const reviewsTrack = document.getElementById("reviews-track");
//   const reviewDotsEl = document.getElementById("review-dots");

//   reviewsTrack.innerHTML = REVIEWS.map(({ initials, name, role, text }) => `
//     <div class="review-card bg-white/4 border border-white/7 rounded-[20px] p-9">
//       <div class="text-base mb-5 text-[#f5c842]">★★★★★</div>
//       <div class="font-['DM_Serif_Display'] text-5xl leading-none text-white/10 mb-2">"</div>
//       <p class="text-[15px] leading-[1.75] text-white/70 font-light italic mb-7">${text}</p>
//       <div class="flex items-center gap-3.5">
//         <div class="w-11 h-11 rounded-full bg-white/10 border border-white/10 flex items-center justify-center font-['Bebas_Neue'] text-lg">${initials}</div>
//         <div>
//           <div class="text-sm font-semibold">${name}</div>
//           <div class="text-xs text-white/35 mt-0.5">${role}</div>
//         </div>
//       </div>
//     </div>
//   `).join("");

//   reviewDotsEl.innerHTML = [0, 1, 2].map((i) => `<button class="review-dot${i === 0 ? " active" : ""}" data-index="${i}"></button>`).join("");

//   let current = 0;

//   function goTo(i) {
//     current = i;
//     const card = reviewsTrack.children[0];
//     const cardWidth = card ? card.offsetWidth + 24 : 0;
//     reviewsTrack.style.transform = `translateX(-${i * cardWidth}px)`;
//     reviewDotsEl.querySelectorAll(".review-dot").forEach((dot, idx) => {
//       dot.classList.toggle("active", idx === i);
//     });
//   }

//   reviewDotsEl.querySelectorAll(".review-dot").forEach((dot) => {
//     dot.addEventListener("click", () => goTo(parseInt(dot.getAttribute("data-index"), 10)));
//   });

//   setInterval(() => {
//     const next = (current + 1) % 3;
//     goTo(next);
//   }, 4000);

  /* ─────────────────────────────────────────
     FAQ ACCORDION
  ───────────────────────────────────────── */
  const FAQS = [
    { q: "How do I start selling on FileNest?", a: "Create a free account, upload your digital product, set a price, and your store is live. Setup takes under 10 minutes." },
    { q: "What types of products can I sell?", a: "Any digital file — templates, UI kits, fonts, presets, PDFs, ebooks, audio files, software, courses, and more." },
    { q: "What are the platform fees?", a: "FileNest charges a flat 3% transaction fee. No monthly fees, no hidden charges. Free plan available." },
    { q: "How are files delivered to buyers?", a: "Buyers receive a time-limited, encrypted download link immediately after purchase. Fully automated, zero manual work." },
    { q: "When do I receive my payouts?", a: "Payouts are processed weekly to your bank or PayPal. No minimum threshold required." },
    { q: "Can I offer discount codes?", a: "Yes! Create custom discount codes, limit uses, set expiry dates, and track performance from your dashboard." },
  ];

  const faqGrid = document.getElementById("faq-grid");
  faqGrid.innerHTML = FAQS.map(({ q, a }, i) => `
    <div class="border border-black/10 rounded-2xl overflow-hidden">
      <button class="faq-question w-full flex justify-between items-center px-7 py-6 text-[15px] font-medium text-left hover:bg-black/2 transition-colors duration-200 cursor-pointer bg-transparent border-none" data-index="${i}">
        ${q}
        <span class="faq-icon w-7 h-7 rounded-full border border-black/10 flex items-center justify-center text-base flex-shrink-0 ml-4">+</span>
      </button>
      <div class="faq-answer">
        <div class="px-7 pb-6 text-sm text-[#666] leading-[1.8] font-light">${a}</div>
      </div>
    </div>
  `).join("");

  let openFaqIndex = null;
  const faqQuestions = faqGrid.querySelectorAll(".faq-question");

  faqQuestions.forEach((btn) => {
    btn.addEventListener("click", () => {
      const idx = parseInt(btn.getAttribute("data-index"), 10);
      const answer = btn.parentElement.querySelector(".faq-answer");
      const icon = btn.querySelector(".faq-icon");

      if (openFaqIndex === idx) {
        // close it
        answer.classList.remove("open");
        icon.classList.remove("open");
        openFaqIndex = null;
      } else {
        // close previously open one
        if (openFaqIndex !== null) {
          const prevBtn = faqGrid.querySelector(`.faq-question[data-index="${openFaqIndex}"]`);
          if (prevBtn) {
            prevBtn.parentElement.querySelector(".faq-answer").classList.remove("open");
            prevBtn.querySelector(".faq-icon").classList.remove("open");
          }
        }
        answer.classList.add("open");
        icon.classList.add("open");
        openFaqIndex = idx;
      }
    });
  });

});