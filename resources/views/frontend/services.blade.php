@extends('layouts.frontend')

@section('title', 'Our Services | EverythingEasy Technology')
@section('meta_description', 'Explore EverythingEasy services directory including custom web developments, mobile app structures, SEO strategies and systems integrations.')

@section('content')

  <!-- Page Header -->
  <section class="py-5 bg-gradient-primary text-white" style="padding-top: 120px !important">
    <div class="container text-center py-4">
      <h1 class="display-4 fw-bold mb-3">Our Services</h1>
      <p class="lead mb-4">
        Explore our full suite of enterprise software engineering, programmatic SEO layouts, and conversion rate optimizations
      </p>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center bg-transparent">
          <li class="breadcrumb-item"><a href="/" class="text-warning text-decoration-none">Home</a></li>
          <li class="breadcrumb-item active text-white" aria-current="page">Services</li>
        </ol>
      </nav>
    </div>
  </section>

  <!-- Services Grid -->
  <section class="py-5 bg-light">
    <div class="container py-4">
      <div class="row g-4 justify-content-center">
        <!-- Service 1: Web Development -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="service-card h-100 p-4 bg-white rounded border border-light shadow-sm text-center">
            <div class="service-icon mb-3">
              <i class="fas fa-code fa-3x text-primary"></i>
            </div>
            <h5 class="fw-bold mb-3 text-dark">Website Development</h5>
            <p class="text-muted small leading-relaxed">
              EverythingEasy is a trusted website development company, delivering fast, secure, and conversion-focused websites for growing businesses. From custom design to scalable back-end architecture, we help brands build a strong digital presence that drives real results.
            </p>
            <a href="/services/website-development" class="text-primary text-decoration-none fw-bold small">Explore Service <i class="fas fa-arrow-right ms-1"></i></a>
          </div>
        </div>

        <!-- Service 2: SEO Packages -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="service-card h-100 p-4 bg-white rounded border border-light shadow-sm text-center">
            <div class="service-icon mb-3">
              <i class="fas fa-search-plus fa-3x text-primary"></i>
            </div>
            <h5 class="fw-bold mb-3 text-dark">Search Engine Optimization</h5>
            <p class="text-muted small leading-relaxed">
              Scale your organic search rankings and dominate search engine results. We deliver performance-driven SEO strategies, technical performance audits, search ranking optimizations, and custom campaigns to generate warm leads.
            </p>
            <a href="/services/seo-packages" class="text-primary text-decoration-none fw-bold small">Explore Service <i class="fas fa-arrow-right ms-1"></i></a>
          </div>
        </div>

        <!-- Service 3: Custom Software & ERP -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="service-card h-100 p-4 bg-white rounded border border-light shadow-sm text-center">
            <div class="service-icon mb-3">
              <i class="fas fa-cogs fa-3x text-primary"></i>
            </div>
            <h5 class="fw-bold mb-3 text-dark">Enterprise Software & CRM</h5>
            <p class="text-muted small leading-relaxed">
              Custom software development tailored to automate your business processes. From custom dashboard tracking portals to ERP and CRM integrations, we engineer secure database systems to streamline your operations.
            </p>
            <a href="/services/website-development-company" class="text-primary text-decoration-none fw-bold small">Explore Service <i class="fas fa-arrow-right ms-1"></i></a>
          </div>
        </div>

        <!-- Service 4: Digital Marketing -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="service-card h-100 p-4 bg-white rounded border border-light shadow-sm text-center">
            <div class="service-icon mb-3">
              <i class="fas fa-bullhorn fa-3x text-primary"></i>
            </div>
            <h5 class="fw-bold mb-3 text-dark">Digital Marketing</h5>
            <p class="text-muted small leading-relaxed">
              Maximize your digital footprint and conversions. From strategic brand campaigns and social media growth to lead nurturing, we connect your business with high-intent buyers worldwide.
            </p>
            <a href="/services/digital-marketing" class="text-primary text-decoration-none fw-bold small">Explore Service <i class="fas fa-arrow-right ms-1"></i></a>
          </div>
        </div>

        <!-- Service 5: App Development -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="service-card h-100 p-4 bg-white rounded border border-light shadow-sm text-center">
            <div class="service-icon mb-3">
              <i class="fas fa-mobile-alt fa-3x text-primary"></i>
            </div>
            <h5 class="fw-bold mb-3 text-dark">App Development</h5>
            <p class="text-muted small leading-relaxed">
              Build premium native and cross-platform mobile apps for iOS and Android. Custom engineered with secure database synchronization, offline support, and smooth user animations.
            </p>
            <a href="/services/app-development" class="text-primary text-decoration-none fw-bold small">Explore Service <i class="fas fa-arrow-right ms-1"></i></a>
          </div>
        </div>

        <!-- Service 6: Meta Ads -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="service-card h-100 p-4 bg-white rounded border border-light shadow-sm text-center">
            <div class="service-icon mb-3">
              <i class="fab fa-facebook fa-3x text-primary"></i>
            </div>
            <h5 class="fw-bold mb-3 text-dark">Meta Ads</h5>
            <p class="text-muted small leading-relaxed">
              Target and convert active buyers on Facebook & Instagram. High-conversion ad creative design, pixel tracking sync, precision copywriting, and custom lookalike audience scaling.
            </p>
            <a href="/services/meta-ads" class="text-primary text-decoration-none fw-bold small">Explore Service <i class="fas fa-arrow-right ms-1"></i></a>
          </div>
        </div>

        <!-- Service 7: Google Ads -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="service-card h-100 p-4 bg-white rounded border border-light shadow-sm text-center">
            <div class="service-icon mb-3">
              <i class="fab fa-google fa-3x text-primary"></i>
            </div>
            <h5 class="fw-bold mb-3 text-dark">Google Ads</h5>
            <p class="text-muted small leading-relaxed">
              Rank at the top of Google searches instantly. Strategic high-intent keyword bidding, quality score optimization, negative keyword filtering, and conversion rate landing pages.
            </p>
            <a href="/services/google-ads" class="text-primary text-decoration-none fw-bold small">Explore Service <i class="fas fa-arrow-right ms-1"></i></a>
          </div>
        </div>

        <!-- Service 8: Custom Website -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="service-card h-100 p-4 bg-white rounded border border-light shadow-sm text-center">
            <div class="service-icon mb-3">
              <i class="fas fa-laptop-code fa-3x text-primary"></i>
            </div>
            <h5 class="fw-bold mb-3 text-dark">Custom Website</h5>
            <p class="text-muted small leading-relaxed">
              Bespoke, custom-coded web architectures optimized for speed and conversion. Coded using Jamstack, React, Next.js or Laravel frameworks tailored to fit unique client workflows.
            </p>
            <a href="/services/custom-website" class="text-primary text-decoration-none fw-bold small">Explore Service <i class="fas fa-arrow-right ms-1"></i></a>
          </div>
        </div>

        <!-- Service 9: WordPress Development -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="service-card h-100 p-4 bg-white rounded border border-light shadow-sm text-center">
            <div class="service-icon mb-3">
              <i class="fab fa-wordpress fa-3x text-primary"></i>
            </div>
            <h5 class="fw-bold mb-3 text-dark">WordPress Development</h5>
            <p class="text-muted small leading-relaxed">
              Fast, secure, and SEO-friendly WordPress blogs, corporate sites, and WooCommerce stores. Custom themed and structured for easy client-side updates.
            </p>
            <a href="/services/wordpress-website-development" class="text-primary text-decoration-none fw-bold small">Explore Service <i class="fas fa-arrow-right ms-1"></i></a>
          </div>
        </div>

        <!-- Service 10: Shopify Development -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="service-card h-100 p-4 bg-white rounded border border-light shadow-sm text-center">
            <div class="service-icon mb-3">
              <i class="fab fa-shopify fa-3x text-primary"></i>
            </div>
            <h5 class="fw-bold mb-3 text-dark">Shopify Development</h5>
            <p class="text-muted small leading-relaxed">
              Launch your online retail storefront on Shopify. Bespoke theme design, checkout performance audit, custom app sync, and dynamic inventory synchronization.
            </p>
            <a href="/services/shopify-development" class="text-primary text-decoration-none fw-bold small">Explore Service <i class="fas fa-arrow-right ms-1"></i></a>
          </div>
        </div>
      </div>
    </div>
  <!-- Why Choose Section -->
  <section class="py-5 bg-white">
    <div class="container py-4">
      <div class="row text-center mb-5">
        <div class="col-lg-8 mx-auto">
          <h2 class="fw-bold text-dark mb-3">Why Choose EverythingEasy?</h2>
        </div>
      </div>

      <div class="row g-4 justify-content-center">
        <!-- Expert Team -->
        <div class="col-lg-6 col-md-6">
          <div class="d-flex align-items-start p-3">
            <div class="flex-shrink-0 rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; background-color: var(--primary-color) !important;">
              <i class="fas fa-star" style="font-size: 20px;"></i>
            </div>
            <div class="ms-3 text-start">
              <h5 class="fw-bold text-dark mb-1" style="font-size: 17px;">Expert Team</h5>
              <p class="text-muted small mb-0">Experienced developers, designers, and project managers dedicated to your success.</p>
            </div>
          </div>
        </div>

        <!-- On-Time Delivery -->
        <div class="col-lg-6 col-md-6">
          <div class="d-flex align-items-start p-3">
            <div class="flex-shrink-0 rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; background-color: var(--primary-color) !important;">
              <i class="fas fa-clock" style="font-size: 20px;"></i>
            </div>
            <div class="ms-3 text-start">
              <h5 class="fw-bold text-dark mb-1" style="font-size: 17px;">On-Time Delivery</h5>
              <p class="text-muted small mb-0">We respect your timeline and deliver quality solutions on schedule.</p>
            </div>
          </div>
        </div>

        <!-- Transparent Communication -->
        <div class="col-lg-6 col-md-6">
          <div class="d-flex align-items-start p-3">
            <div class="flex-shrink-0 rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; background-color: var(--primary-color) !important;">
              <i class="fas fa-handshake" style="font-size: 18px;"></i>
            </div>
            <div class="ms-3 text-start">
              <h5 class="fw-bold text-dark mb-1" style="font-size: 17px;">Transparent Communication</h5>
              <p class="text-muted small mb-0">Stay informed with regular updates and clear communication throughout the project.</p>
            </div>
          </div>
        </div>

        <!-- Ongoing Support -->
        <div class="col-lg-6 col-md-6">
          <div class="d-flex align-items-start p-3">
            <div class="flex-shrink-0 rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; background-color: var(--primary-color) !important;">
              <i class="fas fa-headset" style="font-size: 20px;"></i>
            </div>
            <div class="ms-3 text-start">
              <h5 class="fw-bold text-dark mb-1" style="font-size: 17px;">Ongoing Support</h5>
              <p class="text-muted small mb-0">Comprehensive post-launch support and maintenance to keep your solution running smoothly.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Ready to Get Started Section -->
  <section class="py-5 text-white text-center position-relative overflow-hidden" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important;">
    <div class="position-absolute end-0 bottom-0 rounded-circle opacity-10 bg-white" style="width: 300px; height: 300px; margin-right: -100px; margin-bottom: -100px;"></div>
    
    <div class="container py-4 position-relative" style="z-index: 2;">
      <h2 class="fw-bold text-white mb-2" style="font-size: 32px;">Ready to Get Started?</h2>
      <p class="text-white-50 mb-4" style="font-size: 16px;">Let's discuss how we can help your business through technology</p>
      
      <div class="d-flex flex-wrap gap-3 justify-content-center">
        <a href="/#quote" class="btn bg-white text-primary fw-bold px-4 py-2.5 d-flex align-items-center shadow-sm" style="border-radius: 8px; font-size: 15px;">
          <i class="fas fa-envelope me-2"></i> Get Free Quote
        </a>
        <a href="tel:{{ \App\Models\Setting::get('phone', '+1 (888) 621-0452') }}" class="btn btn-outline-light text-white fw-bold px-4 py-2.5 d-flex align-items-center" style="border-radius: 8px; font-size: 15px; border-width: 2px;">
          <i class="fas fa-phone-alt me-2"></i> Call Now
        </a>
      </div>
    </div>
  </section>

@endsection
