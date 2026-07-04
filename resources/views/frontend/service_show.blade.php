@extends('layouts.frontend')

@php
    $cityText = $city ?: '';
    $stateText = $state ?: '';
    $serviceName = $service->name;

    $brandName = \App\Models\Setting::get('brand_name', 'EverythingEasy');

    // Bracket parsing closure
    $replaceBrackets = function($text) use ($serviceName, $cityText, $stateText, $brandName) {
        $out = str_ireplace('{service}', $serviceName, $text);
        $out = str_ireplace('{city}', $cityText, $out);
        $out = str_ireplace('{state}', $stateText, $out);
        $out = str_ireplace('{brand_name}', $brandName, $out);
        $out = preg_replace('/\s+/', ' ', $out);
        return trim($out);
    };

    // Resolve title and description
    $rawTitle = ($city && $service->pseo_title_template) ? $service->pseo_title_template : ($service->seo_title ?: $service->name);
    $resolvedTitle = $replaceBrackets($rawTitle);

    $rawDesc = ($city && $service->pseo_desc_template) ? $service->pseo_desc_template : ($service->meta_description ?: $service->short_description);
    $resolvedDesc = $replaceBrackets($rawDesc);

    // Resolve custom schema block
    $resolvedSchema = '';
    if ($service->schema_custom) {
        $resolvedSchema = $replaceBrackets($service->schema_custom);
    }
@endphp

@section('title', $resolvedTitle)
@section('meta_description', $resolvedDesc)

@section('head')
    @if ($resolvedSchema)
        {!! $resolvedSchema !!}
    @else
        <script type="application/ld+json">
        {
            "{{ '@' }}context": "https://schema.org",
            "{{ '@' }}type": "Service",
            "name": "{{ $serviceName }}",
            "description": "{{ $resolvedDesc }}",
            "provider": {
                "{{ '@' }}type": "LocalBusiness",
                "name": "EverythingEasy",
                "address": {
                    "{{ '@' }}type": "PostalAddress",
                    "addressLocality": "{{ $city ?: 'Dehradun' }}",
                    "addressRegion": "{{ $state ?: 'Uttarakhand' }}",
                    "addressCountry": "IN"
                }
            }
        }
        </script>
    @endif
@endsection

@section('content')

  <!-- Page Header / Hero -->
  <section class="py-5 bg-gradient-primary text-white" style="padding-top: 120px !important">
    <div class="container py-4">
      <div class="row">
        <div class="col-12">
          <span class="badge bg-warning text-dark px-3 py-2 mb-3">
            <i class="fas fa-tags me-1"></i>Category: {{ $service->category }}
          </span>
          <h1 class="fw-bold mb-3" style="font-size: 34px; line-height: 1.3;">{{ $resolvedTitle }}</h1>
          <p class="lead mb-0 text-white-50" style="font-size: 16px; max-width: 850px;">{{ $resolvedDesc }}</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Detailed Scope and Sidebar -->
  <section class="py-5 bg-white">
    <div class="container py-4">
      <div class="row">
        <!-- Main details -->
        <div class="col-lg-8 mb-4">
          @if ($service->long_description)
              <div class="p-4 border rounded shadow-sm bg-light mb-4">
                <h4 class="fw-bold mb-3 text-dark border-bottom pb-2">Scope of Work</h4>
                <div class="text-muted leading-relaxed" style="font-size: 14px;">
                  {!! $replaceBrackets($service->long_description) !!}
                </div>
              </div>
          @endif
        </div>

        <!-- Sidebar metrics -->
        <div class="col-lg-4">
          <div class="card p-4 border shadow-sm bg-white mb-4">
            <h5 class="fw-bold mb-3 text-primary">Service Specifications</h5>
            <hr />
            <div class="d-flex justify-content-between mb-2 small text-muted">
              <span>Category</span>
              <strong class="text-dark">{{ $service->category }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-2 small text-muted">
              <span>Target Area</span>
              <strong class="text-dark">{{ $city ?: 'National' }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-2 small text-muted">
              <span>Availability</span>
              <strong class="text-success"><i class="fas fa-check-circle me-1"></i>Active Delivery</strong>
            </div>
          </div>

          <!-- Homepage Quote Form in Sidebar -->
          <div class="hero-form-card bg-white rounded-4 shadow-lg mb-4" id="hero-contact-form" x-data="{
              name: '',
              email: '',
              phone: '',
              service: '{{ in_array($service->name ?? '', ['SEO', 'Website', 'Application', 'Custom Software', 'E-Commerce', 'Digital Marketing', 'Google Ads', 'Meta Marketing', 'Other']) ? ($service->name ?? '') : '' }}',
              message: '',
              success: false,
              msg: '',
              loading: false
          }">
            <div class="hero-form-wrapper">
              <h4 class="hero-form-title text-primary fw-bold mb-4 text-center" style="font-size: 20px;">Get a Free Quote</h4>
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
                          company_name: '',
                          budget_tier: 'startup',
                          service_requested: service,
                          project_details: message
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
                          service = '{{ in_array($service->name ?? '', ['SEO', 'Website', 'Application', 'Custom Software', 'E-Commerce', 'Digital Marketing', 'Google Ads', 'Meta Marketing', 'Other']) ? ($service->name ?? '') : '' }}';
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

  <!-- Packages pricing section -->
  <section class="py-5 bg-light border-top border-bottom">
    <div class="container py-4">
      <div class="row text-center mb-5">
        <div class="col-lg-8 mx-auto">
          <h3 class="fw-bold">Pricing Packages for {{ $serviceName }} @if($city) in {{ $city }} @endif</h3>
          <p class="text-muted small">Select a pricing level to initiate project onboarding deliverables.</p>
        </div>
      </div>

      <div class="row justify-content-center">
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
                    {{ $pkg->description ?: ($serviceName . ' Level') }}
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
                    <a href="/checkout/{{ $pkg->id }}" class="btn btn-warning text-dark w-100 fw-bold shadow-sm" style="border-radius: 8px;">Select Package</a>
                  @else
                    <a href="/checkout/{{ $pkg->id }}" class="btn btn-outline-primary w-100" style="border-radius: 8px;">Select Package</a>
                  @endif
                </div>
              </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted bg-white rounded shadow-sm">
                No flat-pricing packages registered for this service capability.
            </div>
        @endforelse
      </div>
    </div>
  </section>

@endsection
