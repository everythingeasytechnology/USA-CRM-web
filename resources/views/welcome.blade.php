@extends('layouts.frontend')

@section('title', 'EverythingEasy Technology – Website Development, SEO, Web Designing Company in India')

@section('content')

  <!-- Hero Section -->
  <section id="home" class="hero-section py-5">
    <div class="hero-container">
      <div class="hero-wrapper row align-items-center">
        <!-- Hero Text -->
        <div class="hero-left col-lg-7 text-white">
          <div class="hero-content">
            <h5 class="hero-subtitle text-warning fw-bold uppercase tracking-wider mb-3">CREATIVE & INNOVATIVE</h5>
            <h1 class="hero-title fw-bold text-white mb-4 display-4 leading-tight">
              Creative & Innovative <br />
              <span class="text-warning">Digital Solutions</span>
            </h1>
            <p class="hero-text text-white-50 mb-5 leading-relaxed">
              We provide cutting-edge IT solutions to help your business grow and succeed in the digital world. Our expert team delivers innovative technology solutions tailored to your needs.
            </p>
            <div class="hero-buttons d-flex gap-3">
              <a href="#quote" class="btn btn-warning btn-lg text-dark fw-bold">Get Free Quote</a>
              <a href="#contact" class="btn btn-outline-light btn-lg">Contact Us</a>
            </div>
          </div>
        </div>

        <!-- Hero Form -->
        <div class="hero-right col-lg-5">
          <div class="hero-form-card bg-white rounded-4 shadow-lg" id="hero-contact-form" x-data="{
              name: '',
              email: '',
              phone: '',
              service: '',
              message: '',
              success: false,
              msg: '',
              loading: false
          }">
            <div class="hero-form-wrapper">
              <h4 class="hero-form-title text-primary fw-bold mb-4 text-center">Get a Free Quote</h4>
              <form class="hero-quote-form space-y-3" x-on:submit.prevent="
                  loading = true;
                  msg = '';
                  fetch('/submit-lead', {
                      method: 'POST',
                      headers: {
                          'Content-Type': 'application/json',
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                      },
                      body: JSON.stringify({
                          name: name,
                          email: email,
                          phone: phone,
                          company_name: 'Website Lead',
                          budget_tier: 'growth',
                          service_requested: service,
                          project_details: message || 'Free quote request from homepage.'
                      })
                  })
                  .then(res => res.json())
                  .then(data => {
                      loading = false;
                      success = data.success;
                      msg = data.message;
                      if (data.success) {
                          name = '';
                          email = '';
                          phone = '';
                          service = '';
                          message = '';
                      }
                  })
                  .catch(() => {
                      loading = false;
                      success = false;
                      msg = 'Inquiry transmission failure. Please check inputs.';
                  });
              ">
                <div class="hero-form-group">
                  <input type="text" x-model="name" class="hero-input" placeholder="Your Name*" required />
                </div>
                <div class="hero-form-group">
                  <input type="email" x-model="email" class="hero-input" placeholder="Your Email*" required />
                </div>
                <div class="hero-form-group">
                  <input type="tel" x-model="phone" class="hero-input" placeholder="Phone Number*" required />
                </div>
                <div class="hero-form-group">
                  <select x-model="service" class="hero-select" required>
                    <option value="">Select Service*</option>
                    <option value="SEO">SEO</option>
                    <option value="Website">Website</option>
                    <option value="Application">Application</option>
                    <option value="Custom Software">Custom Software</option>
                    <option value="E-Commerce">E-Commerce</option>
                    <option value="Digital Marketing">Digital Marketing</option>
                    <option value="Google Ads">Google Ads</option>
                    <option value="Meta Marketing">Meta Marketing</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
                <div class="hero-form-group">
                  <textarea x-model="message" class="hero-textarea" rows="2" placeholder="Brief about your project (optional)"></textarea>
                </div>
                <button type="submit" :disabled="loading" class="hero-submit-btn">
                    <span x-show="!loading">Submit Request</span>
                    <span x-show="loading" style="display:none;">Sending...</span>
                </button>

                <div x-show="msg" class="alert mt-3 text-center py-2" :class="success ? 'alert-success' : 'alert-danger'" x-text="msg" style="display:none;"></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Stats Counter Section -->
  <section class="stats-section bg-white py-5 border-bottom border-light">
    <div class="container">
      <div class="row text-center">
        <div class="col-6 col-md-3 mb-4 mb-md-0">
          <div class="stat-item">
            <h2 class="counter text-primary fw-bold mb-2">100+</h2>
            <p class="stat-label text-muted">Happy Clients</p>
          </div>
        </div>
        <div class="col-6 col-md-3 mb-4 mb-md-0">
          <div class="stat-item">
            <h2 class="counter text-primary fw-bold mb-2">300+</h2>
            <p class="stat-label text-muted">Projects Done</p>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-item">
            <h2 class="counter text-primary fw-bold mb-2">50+</h2>
            <p class="stat-label text-muted">Active Systems</p>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-item">
            <h2 class="counter text-primary fw-bold mb-2">5+</h2>
            <p class="stat-label text-muted">Years Experience</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="py-5 bg-light">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <img src="{{ asset('images/about.jpg') }}" alt="About EverythingEasy" class="img-fluid rounded shadow-sm" onerror="this.src='https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80'" />
        </div>
        <div class="col-lg-6">
          <div class="about-content ps-lg-4">
            <h5 class="text-primary fw-bold uppercase tracking-wider mb-2">ABOUT US</h5>
            <h2 class="fw-bold mb-4">We are leading technology solution provider company</h2>
            <p class="text-muted leading-relaxed mb-4">
              EverythingEasy Technology delivers custom software, optimized design blueprints, and high-engagement web applications to automate client scaling tunnels.
            </p>
            <ul class="list-unstyled space-y-3 mb-4 text-muted">
              <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Dedicated technical delivery teams</li>
              <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Custom-tailored system structures</li>
              <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Priority SLA customer response guarantees</li>
            </ul>
            <a href="/contact" class="btn btn-primary text-white py-2.5 px-4" style="border-radius: 8px;">Learn More</a>
          </div>
        </div>
      </div>
    </div>
  <!-- Comprehensive IT Solutions Section -->
  <section class="py-5 bg-light border-bottom border-top" style="background-color: #f8f9fa !important;">
    <div class="container py-4">
      <div class="row text-center mb-5">
        <div class="col-lg-8 mx-auto">
          <h5 class="text-primary fw-bold uppercase tracking-wider mb-2" style="font-size: 13px; letter-spacing: 1px;">OUR SERVICES</h5>
          <h2 class="fw-bold text-dark" style="font-size: 36px;">Comprehensive IT Solutions</h2>
        </div>
      </div>

      <div class="row g-4 justify-content-center">
        <!-- Card 1: Website Development -->
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 border-0 shadow-sm p-4 text-center bg-white" style="border-radius: 16px;">
            <div class="text-primary mb-3 mt-2">
              <i class="fas fa-globe" style="font-size: 40px; color: var(--primary-color) !important;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-2" style="font-size: 18px;">Website Development</h5>
            <p class="text-muted small mb-3" style="line-height: 1.6;">
              Custom, responsive websites that convert visitors into customers and boost your online presence.
            </p>
          </div>
        </div>

        <!-- Card 2: Mobile App Development -->
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 border-0 shadow-sm p-4 text-center bg-white" style="border-radius: 16px;">
            <div class="text-primary mb-3 mt-2">
              <i class="fas fa-mobile-alt" style="font-size: 40px; color: var(--primary-color) !important;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-2" style="font-size: 18px;">Mobile App Development</h5>
            <p class="text-muted small mb-3" style="line-height: 1.6;">
              Native and cross-platform apps for iOS and Android that engage users and drive growth.
            </p>
          </div>
        </div>

        <!-- Card 3: E-Commerce Solutions -->
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 border-0 shadow-sm p-4 text-center bg-white" style="border-radius: 16px;">
            <div class="text-primary mb-3 mt-2">
              <i class="fas fa-shopping-cart" style="font-size: 40px; color: var(--primary-color) !important;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-2" style="font-size: 18px;">E-Commerce Solutions</h5>
            <p class="text-muted small mb-3" style="line-height: 1.6;">
              Powerful online stores with secure payments, inventory management, and conversion optimization.
            </p>
          </div>
        </div>

        <!-- Card 4: SEO & Digital Marketing -->
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 border-0 shadow-sm p-4 text-center bg-white" style="border-radius: 16px;">
            <div class="text-primary mb-3 mt-2">
              <i class="fas fa-search" style="font-size: 40px; color: var(--primary-color) !important;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-2" style="font-size: 18px;">SEO & Digital Marketing</h5>
            <p class="text-muted small mb-3" style="line-height: 1.6;">
              Strategic SEO, PPC, social media, and content marketing to boost your visibility online.
            </p>
          </div>
        </div>

        <!-- Card 5: Cloud Solutions -->
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 border-0 shadow-sm p-4 text-center bg-white" style="border-radius: 16px;">
            <div class="text-primary mb-3 mt-2">
              <i class="fas fa-cloud" style="font-size: 40px; color: var(--primary-color) !important;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-2" style="font-size: 18px;">Cloud Solutions</h5>
            <p class="text-muted small mb-3" style="line-height: 1.6;">
              Scalable cloud infrastructure and DevOps services for reliable, secure operations.
            </p>
          </div>
        </div>

        <!-- Card 6: API Integration -->
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 border-0 shadow-sm p-4 text-center bg-white" style="border-radius: 16px;">
            <div class="text-primary mb-3 mt-2">
              <i class="fas fa-cogs" style="font-size: 40px; color: var(--primary-color) !important;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-2" style="font-size: 18px;">API Integration</h5>
            <p class="text-muted small mb-3" style="line-height: 1.6;">
              Seamless integration with third-party services and custom API development.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Why Partner Section -->
  <section class="py-5 bg-white">
    <div class="container py-4">
      <div class="row text-center mb-5">
        <div class="col-lg-8 mx-auto">
          <h5 class="text-primary fw-bold uppercase tracking-wider mb-2" style="font-size: 13px; letter-spacing: 1px;">WHY CHOOSE US</h5>
          <h2 class="fw-bold text-dark">Why Partner With EverythingEasy</h2>
        </div>
      </div>

      <div class="row g-4 justify-content-center">
        <!-- Card 1: Quick Turnaround -->
        <div class="col-lg-6 col-md-6">
          <div class="p-4 bg-light rounded shadow-none h-100" style="border-left: 4px solid var(--primary-color) !important; background-color: #f8f9fa !important;">
            <div class="d-flex align-items-start">
              <div class="flex-shrink-0 text-primary me-3">
                <i class="fas fa-rocket fa-lg"></i>
              </div>
              <div>
                <h5 class="fw-bold text-dark mb-2" style="font-size: 18px;">Quick Turnaround</h5>
                <p class="text-muted mb-0 small" style="line-height: 1.6;">
                  We deliver high-quality projects on time without compromising on excellence. Fast execution is our commitment.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Card 2: Results-Driven -->
        <div class="col-lg-6 col-md-6">
          <div class="p-4 bg-light rounded shadow-none h-100" style="border-left: 4px solid var(--primary-color) !important; background-color: #f8f9fa !important;">
            <div class="d-flex align-items-start">
              <div class="flex-shrink-0 text-primary me-3">
                <i class="fas fa-chart-line fa-lg"></i>
              </div>
              <div>
                <h5 class="fw-bold text-dark mb-2" style="font-size: 18px;">Results-Driven</h5>
                <p class="text-muted mb-0 small" style="line-height: 1.6;">
                  Every project is focused on achieving your business goals and delivering measurable ROI improvements.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Card 3: Expert Team -->
        <div class="col-lg-6 col-md-6">
          <div class="p-4 bg-light rounded shadow-none h-100" style="border-left: 4px solid var(--primary-color) !important; background-color: #f8f9fa !important;">
            <div class="d-flex align-items-start">
              <div class="flex-shrink-0 text-primary me-3">
                <i class="fas fa-users fa-lg"></i>
              </div>
              <div>
                <h5 class="fw-bold text-dark mb-2" style="font-size: 18px;">Expert Team</h5>
                <p class="text-muted mb-0 small" style="line-height: 1.6;">
                  Our certified professionals bring years of experience and stay updated with the latest technologies.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Card 4: 24/7 Support -->
        <div class="col-lg-6 col-md-6">
          <div class="p-4 bg-light rounded shadow-none h-100" style="border-left: 4px solid var(--primary-color) !important; background-color: #f8f9fa !important;">
            <div class="d-flex align-items-start">
              <div class="flex-shrink-0 text-primary me-3">
                <i class="fas fa-headset fa-lg"></i>
              </div>
              <div>
                <h5 class="fw-bold text-dark mb-2" style="font-size: 18px;">24/7 Support</h5>
                <p class="text-muted mb-0 small" style="line-height: 1.6;">
                  Round-the-clock customer support ensures your business never stops. We're always here to help.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Work Process Section -->
  <section class="py-5 bg-white border-bottom border-light">
    <div class="container">
      <div class="row text-center mb-5">
        <div class="col-lg-8 mx-auto">
          <h5 class="text-primary fw-bold uppercase tracking-wider mb-2" style="font-size: 14px; letter-spacing: 1px;">WORK PROCESS</h5>
          <h2 class="fw-bold text-dark" style="font-size: 32px;">Simple & Clean Working Process</h2>
        </div>
      </div>

      <div class="row">
        <!-- Step 1 -->
        <div class="col-6 col-lg-3 mb-4 mb-lg-0 text-center process-item">
          <div class="process-number mx-auto mb-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold">
            01
          </div>
          <h5 class="fw-bold text-dark mb-2">Research</h5>
          <p class="text-muted small px-3">We analyze your requirements and conduct thorough research.</p>
        </div>

        <!-- Step 2 -->
        <div class="col-6 col-lg-3 mb-4 mb-lg-0 text-center process-item">
          <div class="process-number mx-auto mb-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold">
            02
          </div>
          <h5 class="fw-bold text-dark mb-2">Concept</h5>
          <p class="text-muted small px-3">We develop strategies tailored to your business objectives.</p>
        </div>

        <!-- Step 3 -->
        <div class="col-6 col-lg-3 mb-4 mb-lg-0 text-center process-item">
          <div class="process-number mx-auto mb-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold">
            03
          </div>
          <h5 class="fw-bold text-dark mb-2">Development</h5>
          <p class="text-muted small px-3">Our team implements solutions using latest technologies.</p>
        </div>

        <!-- Step 4 -->
        <div class="col-6 col-lg-3 mb-4 mb-lg-0 text-center process-item">
          <div class="process-number mx-auto mb-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold">
            04
          </div>
          <h5 class="fw-bold text-dark mb-2">Finalization</h5>
          <p class="text-muted small px-3">We test, deploy, and deliver with ongoing support.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Pricing plans grid -->
  @php
    $packages = \App\Models\Package::with('service')->orderBy('id', 'asc')->take(4)->get();
  @endphp
  <section id="pricing" class="py-5 bg-light">
    <div class="container">
      <div class="row text-center mb-5">
        <div class="col-lg-8 mx-auto">
          <h5 class="text-primary fw-bold uppercase tracking-wider mb-2">PRICING</h5>
          <h2 class="fw-bold">Simple, Flat Pricing Plans</h2>
          <p class="text-muted">Transparent tiers, no hidden setup parameters.</p>
        </div>
      </div>      <div class="row justify-content-center">
        @forelse ($packages as $pkg)
            <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
              <div class="pricing-card-new h-100 position-relative rounded shadow-sm {{ $pkg->is_featured ? 'pricing-popular text-white' : 'bg-white border border-light' }}">
                @if ($pkg->is_featured)
                    <div class="popular-badge">
                      <span class="badge bg-warning text-dark px-3 py-2">
                        <i class="fas fa-star me-1"></i>{{ $pkg->badge ?: 'Most Popular' }}
                      </span>
                    </div>
                @elseif ($pkg->discount_price > 0)
                    <div class="popular-badge">
                      <span class="badge bg-warning text-dark px-3 py-2">
                        <i class="fas fa-star me-1"></i>On Sale
                      </span>
                    </div>
                @endif

                <div class="pricing-header text-center p-3">
                  <div class="pricing-icon mb-2">
                    <i class="fas fa-rocket fa-2x {{ $pkg->is_featured ? 'text-white' : 'text-primary' }}"></i>
                  </div>
                  <h4 class="plan-name fw-bold mb-1 {{ $pkg->is_featured ? 'text-white' : 'text-dark' }}" style="font-size: 18px;">{{ $pkg->name }}</h4>
                  <p class="plan-description mb-0 small {{ $pkg->is_featured ? 'text-white-50' : 'text-muted' }}">
                    {{ $pkg->description ?: ($pkg->service->name ?? 'Solution') }}
                  </p>
                </div>

                <div class="pricing-price text-center py-3 {{ $pkg->is_featured ? '' : 'bg-light' }}">
                  <div class="price-wrapper">
                    <span class="currency {{ $pkg->is_featured ? 'text-white' : 'text-primary' }}">$</span>
                    <span class="amount fw-bold fs-3 {{ $pkg->is_featured ? 'text-white' : 'text-primary' }}">{{ number_format($pkg->price) }}</span>
                    <span class="period {{ $pkg->is_featured ? 'text-white-50' : 'text-muted' }}">/flat</span>
                  </div>
                  @if ($pkg->original_price > $pkg->price)
                      <p class="small text-decoration-line-through mb-0 {{ $pkg->is_featured ? 'text-white-50' : 'text-muted' }}">Original: ${{ number_format($pkg->original_price) }}</p>
                  @endif
                </div>

                <div class="pricing-features p-3">
                  <ul class="list-unstyled feature-list small mb-2 {{ $pkg->is_featured ? 'text-white-50' : 'text-muted' }}">
                    @if($pkg->delivery_time)
                      <li class="mb-1"><i class="fas fa-clock text-{{ $pkg->is_featured ? 'warning' : 'primary' }} me-2"></i> <strong class="{{ $pkg->is_featured ? 'text-white' : 'text-dark' }}">Delivery:</strong> {{ $pkg->delivery_time }}</li>
                    @endif
                    @if($pkg->revisions)
                      <li class="mb-1"><i class="fas fa-sync text-{{ $pkg->is_featured ? 'warning' : 'primary' }} me-2"></i> <strong class="{{ $pkg->is_featured ? 'text-white' : 'text-dark' }}">Revisions:</strong> {{ $pkg->revisions }}</li>
                    @endif
                    @if($pkg->support_duration)
                      <li class="mb-1"><i class="fas fa-headset text-{{ $pkg->is_featured ? 'warning' : 'primary' }} me-2"></i> <strong class="{{ $pkg->is_featured ? 'text-white' : 'text-dark' }}">Support:</strong> {{ $pkg->support_duration }}</li>
                    @endif
                    @if($pkg->tech_stack)
                      <li class="mb-1"><i class="fas fa-code text-{{ $pkg->is_featured ? 'warning' : 'primary' }} me-2"></i> <strong class="{{ $pkg->is_featured ? 'text-white' : 'text-dark' }}">Tech Stack:</strong> {{ $pkg->tech_stack }}</li>
                    @endif
                    @if($pkg->suitable_for)
                      <li class="mb-1"><i class="fas fa-bullseye text-{{ $pkg->is_featured ? 'warning' : 'primary' }} me-2"></i> <strong class="{{ $pkg->is_featured ? 'text-white' : 'text-dark' }}">Best For:</strong> {{ $pkg->suitable_for }}</li>
                    @endif
                  </ul>

                  @if(is_array($pkg->features) && count($pkg->features) > 0)
                      <hr class="my-2 {{ $pkg->is_featured ? 'border-white border-opacity-10' : 'border-slate-100' }}" />
                      <ul class="list-unstyled feature-list small {{ $pkg->is_featured ? 'text-white-50' : 'text-muted' }}">
                        @foreach($pkg->features as $feat)
                          @if(trim($feat))
                            <li class="mb-1"><i class="fas fa-check text-{{ $pkg->is_featured ? 'warning' : 'success' }} me-2"></i> {{ trim($feat) }}</li>
                          @endif
                        @endforeach
                      </ul>
                  @endif
                </div>

                <div class="pricing-footer p-3">
                  @if($pkg->is_featured)
                    <a href="/checkout/{{ $pkg->id }}" class="btn btn-warning text-dark w-100 fw-bold shadow-sm" style="border-radius: 8px;">Order Now</a>
                  @else
                    <a href="/checkout/{{ $pkg->id }}" class="btn btn-outline-primary w-100" style="border-radius: 8px;">Order Now</a>
                  @endif
                </div>
              </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">
                No pricing packages configured yet.
            </div>
        @endforelse
      </div>

      <!-- Optional Upgrades & Add-ons -->
      @php
        $addons = \App\Models\Addon::where('is_active', true)->get();
      @endphp
      @if($addons->count() > 0)
          <div class="row mt-5">
            <div class="col-12 text-center mb-4">
              <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">Optional Upgrades & Add-ons</h4>
              <p class="text-muted small">Supercharge your main deliverables package with these custom extensions</p>
            </div>
            @foreach($addons as $addon)
              <div class="col-md-6 col-lg-4 mb-3">
                <div class="p-3 bg-white border border-light rounded shadow-sm h-100 d-flex justify-content-between align-items-center">
                  <div>
                    <h6 class="fw-bold text-dark mb-1" style="font-size: 13px;">{{ $addon->name }}</h6>
                    <p class="text-muted small mb-0" style="font-size: 11px;">Optional upgrade package</p>
                  </div>
                  <div class="text-end ps-3">
                    <span class="text-primary fw-bold font-mono" style="font-size: 14px;">+${{ number_format($addon->price) }}</span>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
      @endif
    </div>
  </section>

  <!-- General FAQs Section -->
  @php
    $faqsByCategory = \App\Models\Faq::where('is_active', true)
        ->orderBy('category')
        ->orderBy('sort_order', 'asc')
        ->get()
        ->groupBy('category');
  @endphp
  @if($faqsByCategory->count() > 0)
      <section class="py-5 bg-white border-top border-bottom faq-section" x-data="{ activeCategory: '{{ $faqsByCategory->keys()->first() }}' }">
        <div class="container py-4">
          <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
              <h5 class="text-primary fw-bold uppercase tracking-wider mb-2" style="font-size: 14px; letter-spacing: 1px;">GENERAL FAQS</h5>
              <h2 class="fw-bold text-dark mb-3">Questions? Check FAQs or Contact Us</h2>
              <p class="text-muted small">Find answers to commonly asked questions.</p>
            </div>
          </div>

          <!-- Category Tabs Navigation -->
          <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
              <div class="d-inline-flex flex-wrap justify-content-center gap-2 p-1.5 bg-light rounded-pill border border-slate-100">
                @foreach($faqsByCategory as $categoryName => $faqs)
                  <button type="button" 
                          class="btn rounded-pill px-4 py-2 fw-semibold text-capitalize transition-all duration-300"
                          style="font-size: 14px; border: none !important;"
                          :class="activeCategory === '{{ $categoryName }}' ? 'btn-primary text-white shadow' : 'btn-light text-secondary bg-transparent'"
                          @click="activeCategory = '{{ $categoryName }}'">
                    {{ $categoryName }} FAQs
                  </button>
                @endforeach
              </div>
            </div>
          </div>

          <!-- Category Questions panels -->
          <div class="row justify-content-center">
            <div class="col-lg-8">
              @foreach($faqsByCategory as $categoryName => $faqs)
                <div x-show="activeCategory === '{{ $categoryName }}'" 
                     x-transition:enter="transition ease-out duration-300" 
                     x-transition:enter-start="opacity-0 transform translate-y-3" 
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     style="display: none;">
                  @foreach($faqs as $faq)
                    <div class="faq-item" x-data="{ open: false }" :class="open ? 'active' : ''" @click="open = !open">
                      <h6 class="d-flex justify-content-between align-items-center">
                        <span>{{ $faq->question }}</span>
                        <i class="fas fa-chevron-down ms-3"></i>
                      </h6>
                      <div class="faq-answer">
                        <p class="mb-0 text-muted">{{ $faq->answer }}</p>
                      </div>
                    </div>
                  @endforeach
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </section>
  @endif

  <!-- Leadership Team Section -->
  @php
    $teamMembers = \App\Models\TeamMember::where('is_active', true)->orderBy('sort_order', 'asc')->get();
  @endphp
  @if($teamMembers->count() > 0)
      <section class="py-5 bg-light border-top border-bottom">
        <div class="container py-4">
          <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
              <h5 class="text-primary fw-bold uppercase tracking-wider mb-2" style="font-size: 14px; letter-spacing: 1px;">LEADERSHIP</h5>
              <h2 class="fw-bold text-dark">Meet Our Executive Team</h2>
            </div>
          </div>

          <div class="row justify-content-center">
            @foreach($teamMembers as $member)
              <div class="col-md-6 col-lg-3 mb-4">
                <div class="card p-4 text-center border-0 shadow-sm bg-white rounded-4 h-100 team-card">
                  <div class="mb-4 d-inline-block position-relative">
                    <img src="{{ asset($member->avatar) }}" 
                         alt="{{ $member->name }}" 
                         class="rounded-circle mx-auto img-fluid" 
                         style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.08);" />
                  </div>
                  <h5 class="fw-bold text-dark mb-1" style="font-size: 18px;">{{ $member->name }}</h5>
                  <p class="text-primary fw-bold small mb-3" style="font-size: 13px;">{{ $member->role }}</p>
                  <p class="text-muted small mb-0 px-1" style="font-size: 13px; line-height: 1.6;">{{ $member->bio }}</p>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </section>
  @endif

  <!-- Client Testimonials Section -->
  @php
    $testimonials = \App\Models\Testimonial::where('is_active', true)->orderBy('sort_order', 'asc')->get();
  @endphp
  @if($testimonials->count() > 0)
      <section class="py-5 bg-white border-top border-bottom">
        <div class="container py-4">
          <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
              <h5 class="text-primary fw-bold uppercase tracking-wider mb-2" style="font-size: 14px; letter-spacing: 1px;">TESTIMONIAL</h5>
              <h2 class="fw-bold text-dark">What Our Clients Say</h2>
            </div>
          </div>

          <div class="row justify-content-center">
            @foreach($testimonials as $testi)
              <div class="col-md-6 col-lg-4 mb-4">
                <div class="card p-4 border-0 shadow-sm bg-white rounded-4 h-100 testimonial-card d-flex flex-column">
                  <div class="stars mb-3 text-warning">
                    @for($i = 1; $i <= 5; $i++)
                      <i class="{{ $i <= $testi->rating ? 'fas' : 'far' }} fa-star" style="font-size: 14px;"></i>
                    @endfor
                  </div>
                  <p class="text-muted mb-4 flex-grow-1" style="font-size: 14px; line-height: 1.6; font-style: italic;">
                    "{{ $testi->review }}"
                  </p>
                  <h6 class="fw-bold text-dark mb-0" style="font-size: 16px;">{{ $testi->name }}</h6>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </section>
  @endif

  <!-- Quick Quote request form -->
  <section id="quote" class="py-5 bg-primary text-white" x-data="{
      name: '',
      email: '',
      phone: '',
      service: 'General Inquiry',
      details: '',
      success: false,
      msg: '',
      loading: false
  }">
    <div class="container py-4">
      <div class="row align-items-center">
        <!-- Left Side: Call info & headings -->
        <div class="col-lg-6 mb-5 mb-lg-0">
          <h6 class="text-warning fw-bold text-uppercase mb-2" style="font-size: 13px; letter-spacing: 2px;">REQUEST A QUOTE</h6>
          <h2 class="fw-bold mb-4" style="font-size: 40px; line-height: 1.2;">Need A Free Quote? Contact Us</h2>
          
          <ul class="list-unstyled mb-4">
            <li class="mb-3 d-flex align-items-center">
              <i class="fas fa-reply text-warning me-3" style="font-size: 18px;"></i>
              <span class="fw-semibold">Reply within 24 hours</span>
            </li>
            <li class="mb-3 d-flex align-items-center">
              <i class="fas fa-phone-alt text-warning me-3" style="font-size: 18px;"></i>
              <span class="fw-semibold">24 hrs telephone support</span>
            </li>
          </ul>

          <p class="mb-4 text-white-50" style="font-size: 15px; max-width: 480px;">
            Get in touch to discuss your project and receive a detailed quote.
          </p>

          <div class="mt-4 pt-2">
            <p class="text-white-50 small mb-1">Call to ask any question</p>
            <h3 class="fw-bold text-warning mb-0" style="font-size: 28px;">
              <a href="tel:{{ \App\Models\Setting::get('phone', '+1 (888) 621-0452') }}" class="text-warning text-decoration-none">{{ \App\Models\Setting::get('phone', '+1 (888) 621-0452') }}</a>
            </h3>
          </div>
        </div>

        <!-- Right Side: White Card Grid Form -->
        <div class="col-lg-6">
          <div class="card p-4 border-0 shadow-lg bg-white rounded-4">
            <form class="row g-3" x-on:submit.prevent="
                loading = true;
                msg = '';
                fetch('/submit-lead', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: name,
                        email: email,
                        phone: phone,
                        company_name: '',
                        budget_tier: 'startup',
                        service_requested: service,
                        project_details: details
                    })
                })
                .then(res => res.json())
                .then(data => {
                    loading = false;
                    success = data.success;
                    msg = data.message;
                    if (data.success) {
                        name = '';
                        email = '';
                        phone = '';
                        details = '';
                        service = 'General Inquiry';
                    }
                })
                .catch(() => {
                    loading = false;
                    success = false;
                    msg = 'Inquiry transmission failure. Please check inputs.';
                });
            ">
              <!-- Name & Email row -->
              <div class="col-md-6">
                <input type="text" x-model="name" class="form-control" style="background-color: #f8f9fa; border: 1px solid #e0e0e0; border-radius: 8px; padding: 12px 16px; font-size: 14px;" placeholder="Your Name" required />
              </div>
              <div class="col-md-6">
                <input type="email" x-model="email" class="form-control" style="background-color: #f8f9fa; border: 1px solid #e0e0e0; border-radius: 8px; padding: 12px 16px; font-size: 14px;" placeholder="Your Email" required />
              </div>

              <!-- Phone & Service row -->
              <div class="col-md-6">
                <input type="tel" x-model="phone" class="form-control" style="background-color: #f8f9fa; border: 1px solid #e0e0e0; border-radius: 8px; padding: 12px 16px; font-size: 14px;" placeholder="Your Phone" required />
              </div>
              <div class="col-md-6">
                <select x-model="service" class="form-select" style="background-color: #f8f9fa; border: 1px solid #e0e0e0; border-radius: 8px; padding: 12px 16px; font-size: 14px; color: #6c757d;" required>
                  <option value="General Inquiry">Select Service</option>
                  <option value="SEO">SEO</option>
                  <option value="Website">Website</option>
                  <option value="Application">Application</option>
                  <option value="Custom Software">Custom Software</option>
                  <option value="E-Commerce">E-Commerce</option>
                  <option value="Digital Marketing">Digital Marketing</option>
                  <option value="Google Ads">Google Ads</option>
                  <option value="Meta Marketing">Meta Marketing</option>
                  <option value="Other">Other</option>
                </select>
              </div>

              <!-- Project details textarea -->
              <div class="col-12">
                <textarea x-model="details" class="form-control" style="background-color: #f8f9fa; border: 1px solid #e0e0e0; border-radius: 8px; padding: 12px 16px; font-size: 14px;" rows="4" placeholder="Project Details" required></textarea>
              </div>

              <!-- Submit button -->
              <div class="col-12">
                <button type="submit" :disabled="loading" class="btn btn-primary w-100 py-3 text-white fw-bold shadow" style="border-radius: 8px; font-size: 16px; background-color: var(--primary-color); border-color: var(--primary-color);">
                    <span x-show="!loading">Request Quote</span>
                    <span x-show="loading" style="display:none;">Transmitting...</span>
                </button>
              </div>
              
              <div x-show="msg" class="col-12 mt-3" style="display: none;">
                <div class="alert text-center py-2" :class="success ? 'alert-success' : 'alert-danger'" x-text="msg"></div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Info Section -->
  <section class="py-5 bg-white border-top border-bottom">
    <div class="container py-4">
      <div class="row text-center mb-5">
        <div class="col-lg-8 mx-auto">
          <h5 class="text-primary fw-bold uppercase tracking-wider mb-2" style="font-size: 14px; letter-spacing: 1px;">CONTACT US</h5>
          <h2 class="fw-bold text-dark">Get In Touch With Us</h2>
        </div>
      </div>

      <div class="row text-center g-4 justify-content-center">
        <!-- Address -->
        <div class="col-md-4 mb-4 mb-md-0">
          <div class="d-flex flex-column align-items-center">
            <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle bg-light" style="width: 60px; height: 60px;">
              <i class="fas fa-map-marker-alt text-primary" style="font-size: 24px;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-2" style="font-size: 18px;">Our Address</h5>
            <p class="text-muted small mb-0 px-3" style="line-height: 1.6; font-size: 13px;">
              {!! nl2br(e(\App\Models\Setting::get('address', "Everything Easy\nBalawala, Dehradun 248001\nUttarakhand, India"))) !!}
            </p>
          </div>
        </div>

        <!-- Email -->
        <div class="col-md-4 mb-4 mb-md-0">
          <div class="d-flex flex-column align-items-center">
            <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle bg-light" style="width: 60px; height: 60px;">
              <i class="fas fa-envelope text-primary" style="font-size: 24px;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-2" style="font-size: 18px;">Email Us</h5>
            <p class="text-muted small mb-0" style="font-size: 13px;">
              <a href="mailto:{{ \App\Models\Setting::get('support_email', 'info@everythingeasy.in') }}" class="text-muted text-decoration-none hover-primary">{{ \App\Models\Setting::get('support_email', 'info@everythingeasy.in') }}</a>
            </p>
          </div>
        </div>

        <!-- Call -->
        <div class="col-md-4">
          <div class="d-flex flex-column align-items-center">
            <div class="mb-3 d-flex align-items-center justify-content-center rounded-circle bg-light" style="width: 60px; height: 60px;">
              <i class="fas fa-phone-alt text-primary" style="font-size: 24px;"></i>
            </div>
            <h5 class="fw-bold text-dark mb-2" style="font-size: 18px;">Call Us</h5>
            <p class="text-muted small mb-0" style="font-size: 13px; line-height: 1.6;">
              <a href="tel:{{ \App\Models\Setting::get('phone', '+1 (888) 621-0452') }}" class="text-muted text-decoration-none hover-primary">{{ \App\Models\Setting::get('phone', '+1 (888) 621-0452') }}</a><br />
              <a href="tel:{{ \App\Models\Setting::get('whatsapp', '+1 (888) 621-0452') }}" class="text-muted text-decoration-none hover-primary">{{ \App\Models\Setting::get('whatsapp', '+1 (888) 621-0452') }}</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
