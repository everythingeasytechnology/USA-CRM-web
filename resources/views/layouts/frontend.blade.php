<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="theme-color" content="#0066cc" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'EverythingEasy Technology – Website Development, SEO, Web Designing Company in India')</title>
    <meta name="description" content="@yield('meta_description', 'EverythingEasy Technology is a professional website development & SEO company in India. We build modern websites, eCommerce stores, apps, and offer premium digital marketing services.')">
    <meta name="keywords" content="EverythingEasy Technology, website development company, web design, SEO company, digital marketing, ecommerce website, India web agency">

    <!-- Bootstrap & FontAwesome & Poppins font -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />

    <!-- Local Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />

    <!-- Alpine.js library -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @yield('head')
</head>
<body>

    <!-- Header Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
      <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="/">
          <img src="{{ asset('images/logo.webp') }}" alt="Everything Easy Logo" class="navbar-logo" style="height: 40px!important; margin-right: -8px;" />
          EverythingEasy
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="/about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('services*') ? 'active' : '' }}" href="/services">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('portfolio') ? 'active' : '' }}" href="/portfolio">Portfolio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('blogs*') ? 'active' : '' }}" href="/blogs">Blog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="/contact">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('careers*') ? 'active' : '' }}" href="/careers">Career</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-primary ms-2 text-white" href="/#quote" style="border-radius: 8px;">Get Quote</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Main Content Area -->
    <main id="main-content" style="margin-top: 70px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 mb-4">
            <div class="footer-about">
              <h5 class="fw-bold text-white mb-3">EverythingEasy Technology</h5>
              <p class="text-muted mb-4">
                Leading IT solutions company providing innovative technology services to help businesses grow digitally.
              </p>
              <div class="social-links mb-4">
                <a href="https://www.facebook.com/profile.php?id=61575148140871" target="_blank" class="facebook me-2"><i class="fab fa-facebook fa-lg"></i></a>
                <a href="https://x.com/Everythingeasy0" target="_blank" class="twitter me-2"><i class="fab fa-twitter fa-lg"></i></a>
                <a href="https://www.linkedin.com/company/everythingeasy/" target="_blank" class="linkedin me-2"><i class="fab fa-linkedin fa-lg"></i></a>
                <a href="https://www.instagram.com/everythingeasy_technology/" target="_blank" class="instagram me-2"><i class="fab fa-instagram fa-lg"></i></a>
              </div>
              
              <!-- Trustpilot Widget -->
              <div class="trustpilot-widget mt-3" data-locale="en-US" data-template-id="56278e9abfbbba0bdcd568bc" data-businessunit-id="693706f7f444175f88990f6c" data-style-height="52px" data-style-width="100%" data-token="448d2ef3-edd9-486d-8d48-04a5d3ac55b6">
                <a href="https://www.trustpilot.com/review/everythingeasy.in" target="_blank" rel="noopener">Trustpilot</a>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 mb-4">
            <div class="footer-links">
              <h6 class="fw-bold mb-3">Quick Links</h6>
              <ul class="list-unstyled">
                <li><a href="/" class="text-muted text-decoration-none">Home</a></li>
                <li><a href="/about" class="text-muted text-decoration-none">About Us</a></li>
                <li><a href="/services" class="text-muted text-decoration-none">Our Services</a></li>
                <li><a href="/portfolio" class="text-muted text-decoration-none">Portfolio</a></li>
                <li><a href="/blogs" class="text-muted text-decoration-none">Blog</a></li>
                <li><a href="/contact" class="text-muted text-decoration-none">Contact Us</a></li>
                <li><a href="/careers" class="text-muted text-decoration-none">Careers</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-2 col-md-6 mb-4">
            <div class="footer-links">
              <h6 class="fw-bold mb-3">Services</h6>
              <ul class="list-unstyled">
                <li><a href="/services" class="text-muted text-decoration-none">Digital Marketing</a></li>
                <li><a href="/services" class="text-muted text-decoration-none">E-commerce</a></li>
                <li><a href="/services" class="text-muted text-decoration-none">Web Development</a></li>
                <li><a href="/services" class="text-muted text-decoration-none">App Development</a></li>
                <li><a href="/services" class="text-muted text-decoration-none">SEO Optimization</a></li>
                <li><a href="/services" class="text-muted text-decoration-none">Custom Software</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-4 mb-4">
            <div class="footer-contact">
              <h6 class="fw-bold mb-3">Get In Touch</h6>
               <div class="contact-item d-flex mb-2">
                <span class="text-muted">
                  <i class="fas fa-map-marker-alt me-2 mt-1 text-primary"></i>{!! nl2br(e(\App\Models\Setting::get('address', 'EverythingEasy Technology Balawala, Dehradun 248001 Uttarakhand, India'))) !!}
                </span>
              </div>
              <div class="contact-item d-flex mb-2">
                <i class="fas fa-envelope me-2 mt-1 text-primary"></i>
                <a href="mailto:{{ \App\Models\Setting::get('support_email', 'info@everythingeasy.in') }}" class="text-muted text-decoration-none">{{ \App\Models\Setting::get('support_email', 'info@everythingeasy.in') }}</a>
              </div>
              <div class="contact-item d-flex mb-3">
                <i class="fas fa-phone me-2 mt-1 text-primary"></i>
                <a href="tel:{{ \App\Models\Setting::get('phone', '+91 86308 40577') }}" class="text-muted text-decoration-none">{{ \App\Models\Setting::get('phone', '+91 86308 40577') }}</a>
              </div>
            </div>
          </div>
        </div>
        <hr class="my-4" />
        <div class="row align-items-center">
          <div class="col-md-6">
            <p class="text-muted mb-0">
              &copy; {{ date('Y') }} EverythingEasy Technology. All Rights Reserved.
            </p>
          </div>
          <div class="col-md-6 text-md-end">
            <p class="text-muted mb-0">
              Designed with <i class="fas fa-heart text-danger"></i> by Everything Easy Team
            </p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap JS bundles -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

    <!-- Start of Tawk.to Script --> 
    <script type="text/javascript">
      var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
      (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/69d20bf25b6b4c1c37f3d691/1jle7tbuh';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
      })();
    </script>
    <script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>

    <!-- Announcement Popups Engine -->
    @php
      $activePopups = \App\Models\Popup::where('is_active', true)
          ->where(function ($query) {
              $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now()->toDateString());
          })
          ->where(function ($query) {
              $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', now()->toDateString());
          })
          ->get();
    @endphp
    @foreach ($activePopups as $popup)
      <div x-data="{ show: false }" 
           x-show="show" 
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 scale-95"
           x-transition:enter-end="opacity-100 scale-100"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="opacity-100 scale-100"
           x-transition:leave-end="opacity-0 scale-95"
           class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
           style="z-index: 9999; background-color: rgba(0,0,0,0.55); backdrop-filter: blur(5px); display: none;"
           x-init="
              @if ($popup->trigger_type === 'delay')
                  setTimeout(() => { 
                      show = true; 
                      fetch('/popups/{{ $popup->id }}/impression', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                  }, 5000);
              @elseif ($popup->trigger_type === 'exit')
                  document.addEventListener('mouseleave', (e) => {
                      if (e.clientY < 50 && !show) {
                          show = true;
                          fetch('/popups/{{ $popup->id }}/impression', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                      }
                  });
              @elseif ($popup->trigger_type === 'scroll')
                  window.addEventListener('scroll', () => {
                      let scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
                      if (scrolled > 45 && !show) {
                          show = true;
                          fetch('/popups/{{ $popup->id }}/impression', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                      }
                  });
              @endif
           ">
        <div class="card p-4 border-0 shadow-lg rounded-4 position-relative" 
             style="max-width: 480px; width: 90%; background-color: #fff;"
             @click.outside="show = false">
          
          <button type="button" 
                  class="btn-close position-absolute top-0 end-0 m-3 shadow-none border-0" 
                  style="font-size: 14px; cursor: pointer; outline: none;" 
                  @click="show = false"></button>
          
          <h4 class="fw-bold text-dark mb-3 pe-4" style="font-size: 20px;">{{ $popup->title }}</h4>
          
          <div class="popup-html-content text-muted mb-4" 
               style="font-size: 14px; line-height: 1.6;"
               @click="
                  fetch('/popups/{{ $popup->id }}/conversion', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
               ">
            {!! $popup->content !!}
          </div>

          <div class="text-end">
            <button type="button" class="btn btn-primary px-4" style="border-radius: 8px;" @click="show = false">Okay</button>
          </div>
        </div>
      </div>
    @endforeach

</body>
</html>
