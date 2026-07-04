@extends('layouts.frontend')

@section('title', 'About Us - EverythingEasy Technology')
@section('meta_description', 'EverythingEasy is a leading IT company in India offering website, mobile app & custom software development services.')

@section('content')

  <!-- Page Header -->
  <section class="py-5 bg-gradient-primary text-white" style="padding-top: 120px !important">
    <div class="container text-center py-4">
      <h1 class="display-4 fw-bold mb-3">About Us</h1>
      <p class="lead mb-4">
        Transforming businesses through innovative technology solutions since 2021
      </p>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center bg-transparent">
          <li class="breadcrumb-item"><a href="/" class="text-warning text-decoration-none">Home</a></li>
          <li class="breadcrumb-item active text-white" aria-current="page">About Us</li>
        </ol>
      </nav>
    </div>
  </section>

  <!-- Company Overview -->
  <section class="py-5 bg-white">
    <div class="container py-4">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&w=800&q=80" alt="Our Team Working" class="img-fluid rounded shadow-sm" />
        </div>
        <div class="col-lg-6">
          <h5 class="text-primary fw-bold uppercase tracking-wider mb-2">COMPANY OVERVIEW</h5>
          <h2 class="fw-bold mb-4">Leading IT Solutions Provider Since 2021</h2>
          <p class="text-muted mb-4">
            EverythingEasy Technology was founded with a simple mission: to make technology accessible and effective for businesses of all sizes. We've grown to be a leading IT solutions provider, serving clients across various industries.
          </p>
          <p class="text-muted mb-4">
            Our team of dedicated professionals combines technical expertise with business acumen to deliver solutions that not only meet current needs but also prepare businesses for future growth and challenges.
          </p>
          <div class="row pt-2">
            <div class="col-6">
              <div class="text-center p-3 border rounded bg-light">
                <h3 class="text-primary fw-bold mb-1">300+</h3>
                <p class="text-muted small mb-0 font-semibold">Projects Completed</p>
              </div>
            </div>
            <div class="col-6">
              <div class="text-center p-3 border rounded bg-light">
                <h3 class="text-primary fw-bold mb-1">15+</h3>
                <p class="text-muted small mb-0 font-semibold">Active Developers</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Mission, Vision, Value-->
  <section class="py-5 bg-light">
    <div class="container py-4">
      <div class="row text-center mb-5">
        <div class="col-lg-8 mx-auto">
          <h5 class="text-primary fw-bold uppercase tracking-wider mb-2">OUR FOUNDATION</h5>
          <h2 class="fw-bold">Mission, Vision & Values</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4 mb-4">
          <div class="card h-100 border-0 shadow-sm p-4 text-center">
            <div class="mb-3 text-primary"><i class="fas fa-bullseye fa-3x"></i></div>
            <h4 class="fw-bold mb-3 text-dark">Our Mission</h4>
            <p class="text-muted small leading-relaxed">
              To empower organizations by providing scalable, easy-to-manage web applications, dynamic CMS dashboards, and SEO automation platforms.
            </p>
          </div>
        </div>
        <div class="col-lg-4 mb-4">
          <div class="card h-100 border-0 shadow-sm p-4 text-center">
            <div class="mb-3 text-primary"><i class="fas fa-eye fa-3x"></i></div>
            <h4 class="fw-bold mb-3 text-dark">Our Vision</h4>
            <p class="text-muted small leading-relaxed">
              To become a globally recognized software delivery team, setting high benchmarks in web speed performance, clean schemas, and dynamic business automation.
            </p>
          </div>
        </div>
        <div class="col-lg-4 mb-4">
          <div class="card h-100 border-0 shadow-sm p-4 text-center">
            <div class="mb-3 text-primary"><i class="fas fa-heart fa-3x"></i></div>
            <h4 class="fw-bold mb-3 text-dark">Our Values</h4>
            <p class="text-muted small leading-relaxed">
              Transparency, flat pricing lists, clean coding guidelines, and committed customer support channels under the EverythingEasy brand values.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
