@extends('layouts.frontend')

@section('title', $blog->seo_title ?: $blog->title)
@section('meta_description', $blog->meta_description ?: strip_tags(Str::limit($blog->content, 150)))

@section('head')
    @if ($blog->schema_custom)
        {!! $blog->schema_custom !!}
    @endif
@endsection

@section('content')

  <!-- Page Header -->
  <section class="py-5 bg-gradient-primary text-white" style="padding-top: 120px !important">
    <div class="container text-center py-4">
      <span class="badge bg-warning text-dark px-3 py-2 mb-3">
        <i class="fas fa-bookmark me-1"></i>{{ $blog->category }}
      </span>
      <h1 class="display-5 fw-bold mb-3">{{ $blog->title }}</h1>
      <p class="lead mb-0 text-white-50">
        Published on {{ $blog->created_at->format('M d, Y') }} &bull; {{ $blog->read_time ?: '5 min' }} read
      </p>
    </div>
  </section>

  <!-- Article Body -->
  <section class="py-5 bg-white">
    <div class="container py-4">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          
          <!-- Cover image -->
          @if ($blog->cover_image)
              <div class="mb-5 rounded-4 shadow-sm overflow-hidden" style="max-height: 450px;">
                <img src="{{ asset($blog->cover_image) }}" alt="{{ $blog->title }}" class="w-100 object-cover" />
              </div>
          @endif

          <!-- Content body -->
          <div class="article-content text-muted leading-relaxed" style="font-size: 15px;">
            {!! $blog->content !!}
          </div>

          <hr class="my-5" />

          <div class="d-flex justify-content-between">
            <a href="/blogs" class="btn btn-outline-primary" style="border-radius: 8px;">
              <i class="fas fa-arrow-left me-2"></i>Back to Blogs
            </a>
          </div>

        </div>
      </div>
    </div>
  </section>

@endsection
