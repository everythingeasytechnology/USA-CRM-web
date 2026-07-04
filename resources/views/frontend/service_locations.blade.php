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
        @forelse ($locations as $loc)
            @php
                $citySlug = \Illuminate\Support\Str::slug($loc->city);
            @endphp
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100 border-0 shadow-sm p-4 bg-white" style="border-radius: 16px; border-top: 4px solid var(--primary-color) !important;">
                <div class="d-flex align-items-center mb-3">
                  <div class="flex-shrink-0 text-primary me-2">
                    <i class="fas fa-map-marked-alt fa-lg text-primary"></i>
                  </div>
                  <h5 class="fw-bold text-dark mb-0">
                    {{ $loc->city }}
                    @if($loc->state)
                      <span class="text-muted font-normal small" style="font-size: 13px;">, {{ $loc->state }}</span>
                    @endif
                  </h5>
                </div>
                
                <hr class="my-2 border-slate-100 dark:border-slate-800" />

                <div class="location-links-box mt-3">
                  <ul class="list-unstyled mb-0">
                    @foreach ($services as $srv)
                        <li class="mb-2">
                          <a href="/services/{{ $srv->slug }}-in-{{ $citySlug }}" class="text-muted text-decoration-none hover-link-primary transition small d-flex align-items-center" style="font-size: 13px;">
                            <i class="fas fa-map-marker-alt text-primary me-2" style="font-size: 11px; opacity: 0.7;"></i>
                            {{ $srv->name }} in {{ $loc->city }}
                          </a>
                        </li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted bg-white rounded shadow-sm">
                No active locations targeted at the moment.
            </div>
        @endforelse
      </div>

      <!-- Pagination Links -->
      <div class="mt-5 d-flex justify-content-center">
        {{ $locations->links() }}
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
