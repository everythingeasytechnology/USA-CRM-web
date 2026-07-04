@extends('layouts.frontend')

@section('title', 'Portfolio - Everything Easy')
@section('meta_description', 'Discover our latest projects and innovative solutions that help businesses grow and succeed in the digital world.')

@section('content')

  <!-- Page Header -->
  <section class="hero-portfolio" style="padding-top: 120px !important">
    <div class="container py-4">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="hero-content">
            <span class="badge bg-warning text-dark px-3 py-2 mb-3">
              <i class="fas fa-rocket me-1"></i>Our Work
            </span>
            <h1 class="display-4 fw-bold text-dark mb-4">
              Creative
              <span class="text-primary">Portfolio</span>
            </h1>
            <p class="lead text-muted mb-4">
              Discover our latest projects and innovative solutions that help businesses grow and succeed in the digital world.
            </p>
            <div class="stats-row d-flex flex-wrap gap-4 mb-4">
              <div class="stat-item border-start border-primary border-4 ps-3">
                <h3 class="fw-bold text-primary mb-0">50+</h3>
                <small class="text-muted font-semibold">Projects Deliveries</small>
              </div>
              <div class="stat-item border-start border-success border-4 ps-3">
                <h3 class="fw-bold text-success mb-0">99%</h3>
                <small class="text-muted font-semibold">Success Rate</small>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="hero-image text-center">
            <img src="https://images.unsplash.com/photo-1559028006-448665bd7c7f?auto=format&fit=crop&w=600&h=400&q=80" alt="Portfolio Stack" class="img-fluid rounded shadow-lg portfolio-img-1" />
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Portfolio Masonry Grid -->
  @php
    $projects = [
        [
            'img' => asset('images/ceu.webp'),
            'alt' => 'CEUTrainers Logo',
            'category' => 'Online Learning',
            'title' => 'CEUTrainers Online Courses',
            'desc' => 'Access 5,800+ online courses, certificates, and degrees from top universities and companies.',
            'tech' => ['Webinars', 'Remote Learning', 'Professional Certificates'],
            'link' => 'https://ceuservices.com/'
        ],
        [
            'img' => asset('images/5.webp'),
            'alt' => 'PowerStroke Drive Platform',
            'category' => 'Auto Parts Marketplace',
            'title' => 'PowerStroke Drive - Used Engines & Transmissions',
            'desc' => 'Buy quality tested, low-mileage used engines and transmissions with nationwide shipping.',
            'tech' => ['Used Engines', 'Transmissions', 'Shipping'],
            'link' => 'https://powerstrokedrive.com/'
        ],
        [
            'img' => asset('images/6.webp'),
            'alt' => 'Rivaaz Films',
            'category' => 'Music & Video Distribution',
            'title' => 'Rivaaz Films - Maximize Music Reach',
            'desc' => 'Distribute your music and videos globally with Rivaaz Films. We offer music publishing and media growth.',
            'tech' => ['Music Distribution', 'Video Distribution', 'Media Growth'],
            'link' => 'https://rivaazfilms.com/'
        ],
        [
            'img' => asset('images/1.webp'),
            'alt' => 'Clothing E-commerce Platform',
            'category' => 'E-commerce Platform',
            'title' => 'Ethnic Fashion Store',
            'desc' => 'Clothing E-commerce Platform is an online ethnic fashion store offering sarees, kurtis, and suits.',
            'tech' => ['E-commerce', 'Fast Delivery', 'Secure Checkout'],
            'link' => '#'
        ],
        [
            'img' => asset('images/4.webp'),
            'alt' => 'Truetop Roofing Ltd',
            'category' => 'Roofing & Maintenance',
            'title' => 'Truetop Roofing Ltd',
            'desc' => 'Reliable roofing and property maintenance services in Hounslow. Tailored solutions and techniques.',
            'tech' => ['Roofing', 'Guttering', 'Maintenance'],
            'link' => 'https://truetoproofingltd.com/'
        ],
        [
            'img' => asset('images/3.webp'),
            'alt' => 'RealTimeVoice News Portal',
            'category' => 'News Portal',
            'title' => 'RealTimeVoice News',
            'desc' => 'RealTimeVoice delivers real-time news, updates, and in-depth coverage across politics and business.',
            'tech' => ['Live Updates', 'Multi-Category', 'Responsive Design'],
            'link' => 'https://realtimevoice.in/'
        ]
    ];
  @endphp
  <section class="py-5 bg-light">
    <div class="container py-4">
      <div class="row g-4 justify-content-center">
        @foreach ($projects as $proj)
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
                <div class="position-relative overflow-hidden" style="aspect-ratio: 16/10;">
                  <img src="{{ $proj['img'] }}" alt="{{ $proj['alt'] }}" class="w-100 h-100 object-cover" onerror="this.src='https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=600&q=80'" />
                  <span class="position-absolute top-3 start-3 badge bg-primary text-white uppercase tracking-wider px-2.5 py-1.5" style="font-size: 9px;">{{ $proj['category'] }}</span>
                </div>
                <div class="card-body p-4 d-flex flex-col justify-content-between">
                  <div>
                    <h5 class="fw-bold mb-2 text-dark">{{ $proj['title'] }}</h5>
                    <p class="text-muted small leading-relaxed">{{ $proj['desc'] }}</p>
                    <div class="d-flex flex-wrap gap-1 mb-3">
                      @foreach ($proj['tech'] as $t)
                        <span class="badge bg-light text-muted border text-2xs" style="font-size: 8px;">{{ $t }}</span>
                      @endforeach
                    </div>
                  </div>
                  @if ($proj['link'] !== '#')
                    <a href="{{ $proj['link'] }}" target="_blank" class="btn btn-outline-primary w-100 mt-2 small py-2" style="border-radius: 8px;">Visit Project Site</a>
                  @endif
                </div>
              </div>
            </div>
        @endforeach
      </div>
    </div>
  </section>

@endsection
