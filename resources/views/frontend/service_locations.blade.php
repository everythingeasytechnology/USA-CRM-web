@extends('layouts.frontend')

@section('title', 'Service Locations Directory | EverythingEasy')
@section('meta_description', 'Browse EverythingEasy digital services and custom software solution locations across targeted cities and states.')

@section('content')

  <!-- Page Header -->
  <section class="py-5 bg-gradient-primary text-white" style="padding-top: 120px !important; background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important;">
    <div class="container text-center py-4">
      <h1 class="display-4 fw-bold mb-3">Service Locations</h1>
      <p class="lead mb-4">
        Discover our premium IT services, custom software engineering, and digital marketing programs in your city.
      </p>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center bg-transparent">
          <li class="breadcrumb-item"><a href="/" class="text-warning text-decoration-none">Home</a></li>
          <li class="breadcrumb-item active text-white" aria-current="page">Service Locations</li>
        </ol>
      </nav>
    </div>
  </section>

  <!-- Location Directory Grid -->
  <section class="py-5 bg-light">
    <div class="container py-4">
      <div class="row g-4">
        @forelse ($services as $srv)
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100 border-0 shadow-sm p-4 bg-white" style="border-radius: 16px; border-top: 4px solid var(--primary-color) !important;">
                <div class="d-flex align-items-center mb-3">
                  <div class="flex-shrink-0 text-primary me-2">
                    <i class="fas fa-map-marked-alt fa-lg text-primary"></i>
                  </div>
                  <h5 class="fw-bold text-dark mb-0">{{ $srv->name }}</h5>
                </div>
                
                <p class="text-muted small mb-4" style="line-height: 1.6;">
                  {{ Str::limit($srv->short_description, 120) }}
                </p>

                <div class="location-links-box">
                  <h6 class="fw-bold text-dark mb-2.5 small text-uppercase tracking-wider text-muted" style="font-size: 11px;">Target Locations:</h6>
                  
                  @if ($srv->pseo_enabled && $locations->count() > 0)
                      <ul class="list-unstyled mb-0">
                        @foreach ($locations as $loc)
                            @php
                                $citySlug = \Illuminate\Support\Str::slug($loc->city);
                            @endphp
                            <li class="mb-2">
                              <a href="/services/{{ $srv->slug }}-in-{{ $citySlug }}" class="text-muted text-decoration-none hover-link-primary transition small d-flex align-items-center" style="font-size: 13px;">
                                <i class="fas fa-map-marker-alt text-primary me-2" style="font-size: 11px; opacity: 0.7;"></i>
                                {{ $srv->name }} in {{ $loc->city }}
                              </a>
                            </li>
                        @endforeach
                      </ul>
                  @else
                      <p class="text-muted small mb-0">
                        Available globally. <a href="/services/{{ $srv->slug }}" class="text-primary text-decoration-none fw-bold">Explore Service <i class="fas fa-arrow-right ms-1"></i></a>
                      </p>
                  @endif
                </div>
              </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted bg-white rounded shadow-sm">
                No active services cataloged at the moment.
            </div>
        @endforelse
      </div>
    </div>
  </section>

  <!-- Add CSS for link hover effect -->
  <style>
    .hover-link-primary:hover {
      color: var(--primary-color, #0d6efd) !important;
      text-decoration: underline !important;
      transform: translateX(3px);
    }
    .hover-link-primary {
      transition: all 0.2s ease-in-out;
    }
  </style>

@endsection
