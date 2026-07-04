@extends('layouts.frontend')

@section('title', 'Insights & Blog | EverythingEasy Technology')
@section('meta_description', 'Latest technical blogs, engineering write-ups, programmatic SEO guidelines, and conversion rate optimizations from EverythingEasy.')

@section('content')

  <!-- Page Header -->
  <section class="py-5 bg-gradient-primary text-white" style="padding-top: 120px !important">
    <div class="container text-center py-4">
      <h1 class="display-4 fw-bold mb-3">Our Blogs & Insights</h1>
      <p class="lead mb-4">
        Read our latest writeups on software developments, SEO optimizations, and scaling systems
      </p>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center bg-transparent">
          <li class="breadcrumb-item"><a href="/" class="text-warning text-decoration-none">Home</a></li>
          <li class="breadcrumb-item active text-white" aria-current="page">Blog</li>
        </ol>
      </nav>
    </div>
  </section>

  <!-- Blogs catalog -->
  <section class="py-5 bg-light">
    <div class="container py-4">
      <div class="row">
        @forelse ($blogs as $post)
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 16px;">
                <div class="position-relative overflow-hidden bg-dark" style="aspect-ratio: 16/10;">
                  @if ($post->cover_image)
                    <img src="{{ asset($post->cover_image) }}" alt="{{ $post->title }}" class="w-100 h-100 object-cover" />
                  @else
                    <div class="w-100 h-100 d-flex items-center justify-center text-white-50 bg-secondary fw-bold text-center pt-5">EverythingEasy</div>
                  @endif
                  <span class="position-absolute top-3 start-3 badge bg-primary text-white uppercase tracking-wider px-2.5 py-1.5" style="font-size: 9px;">{{ $post->category }}</span>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                  <div>
                    <span class="text-muted small block mb-2">{{ $post->created_at->format('M d, Y') }} &bull; {{ $post->read_time ?: '5 min' }} read</span>
                    <h5 class="fw-bold mb-3 text-dark leading-tight">{{ $post->title }}</h5>
                    <p class="text-muted small leading-relaxed">{{ Str::limit(strip_tags($post->content), 120) }}</p>
                  </div>
                  <a href="/blogs/{{ $post->slug }}" class="text-primary text-decoration-none fw-bold small mt-3 block">Read Article <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
              </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted bg-white rounded shadow-sm">
                No blog articles published yet. Please check back later.
            </div>
        @endforelse
      </div>
    </div>
  </section>

@endsection
