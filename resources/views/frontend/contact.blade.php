@extends('layouts.frontend')

@section('title', 'Contact Us - EverythingEasy Technology')
@section('meta_description', 'Get in touch with EverythingEasy Technology for web development, app development, cyber security, and more.')

@section('content')

  <!-- Hero Section -->
  <section class="py-5 bg-gradient-primary text-white" style="padding-top: 120px !important">
    <div class="container text-center py-4">
      <h1 class="display-4 fw-bold mb-3 text-white">Get In Touch</h1>
      <p class="lead mb-4 text-white-50">
        Ready to start your next project? We'd love to hear from you.
      </p>
      <div class="row justify-content-center text-center">
        <div class="col-md-3 col-6 mb-3">
          <div class="p-3 bg-white bg-opacity-10 rounded">
            <i class="fas fa-phone mb-2 text-warning"></i>
            <h6 class="mb-0 text-white font-semibold">24/7 Support</h6>
          </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
          <div class="p-3 bg-white bg-opacity-10 rounded">
            <i class="fas fa-clock mb-2 text-warning"></i>
            <h6 class="mb-0 text-white font-semibold">Quick Response</h6>
          </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
          <div class="p-3 bg-white bg-opacity-10 rounded">
            <i class="fas fa-handshake mb-2 text-warning"></i>
            <h6 class="mb-0 text-white font-semibold">Personal Touch</h6>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Information Section -->
  <section class="py-5 bg-light">
    <div class="container py-4">
      <div class="row text-center mb-5">
        <div class="col-lg-8 mx-auto">
          <h5 class="text-primary fw-bold mb-2">CONTACT INFORMATION</h5>
          <h2 class="fw-bold mb-3">How Can We Help You?</h2>
          <p class="text-muted">Choose your preferred way to get in touch with our team.</p>
        </div>
      </div>

      <div class="row">
        <!-- Address card -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card h-100 p-4 bg-white rounded border border-light shadow-sm text-center">
            <div class="mb-3 text-primary"><i class="fas fa-map-marker-alt fa-3x"></i></div>
            <h5 class="fw-bold mb-2 text-dark">Office Address</h5>
            <p class="text-muted small mb-0">
              {!! nl2br(e(\App\Models\Setting::get('address', 'EverythingEasy Technology Balawala, Dehradun 248001 Uttarakhand, India'))) !!}
            </p>
            <a href="https://maps.google.com" target="_blank" class="btn btn-outline-primary btn-sm mt-3 w-100 py-2">Get Directions</a>
          </div>
        </div>

        <!-- Phone numbers card -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card h-100 p-4 bg-white rounded border border-light shadow-sm text-center">
            <div class="mb-3 text-primary"><i class="fas fa-phone fa-3x"></i></div>
            <h5 class="fw-bold mb-2 text-dark">Phone Numbers</h5>
            <p class="text-muted small mb-1">{{ \App\Models\Setting::get('phone', '+91 86308 40577') }}</p>
            <p class="text-muted small mb-0">{{ \App\Models\Setting::get('whatsapp', '+91 70883 60325') }}</p>
            <a href="tel:{{ \App\Models\Setting::get('phone', '+91 86308 40577') }}" class="btn btn-outline-primary btn-sm mt-3 w-100 py-2">Call Support</a>
          </div>
        </div>

        <!-- Email card -->
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card h-100 p-4 bg-white rounded border border-light shadow-sm text-center">
            <div class="mb-3 text-primary"><i class="fas fa-envelope fa-3x"></i></div>
            <h5 class="fw-bold mb-2 text-dark">Email Channels</h5>
            <p class="text-muted small mb-1">{{ \App\Models\Setting::get('support_email', 'info@everythingeasy.in') }}</p>
            <p class="text-muted small mb-0">{{ \App\Models\Setting::get('sales_email', 'support@everythingeasy.in') }}</p>
            <a href="mailto:{{ \App\Models\Setting::get('support_email', 'info@everythingeasy.in') }}" class="btn btn-outline-primary btn-sm mt-3 w-100 py-2">Send Mail</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Form -->
  <section class="py-5 bg-white" x-data="{
      name: '',
      email: '',
      phone: '',
      subject: '',
      message: '',
      success: false,
      msg: '',
      loading: false
  }">
    <div class="container py-4">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card p-5 border rounded-4 shadow-sm bg-light">
            <h3 class="fw-bold mb-3 text-center text-dark font-display">Send Enquiry Message</h3>
            <p class="text-muted text-center small mb-5">Have any questions? Drop us a line and we will reply within 12 hours.</p>

            <form class="row g-3" x-on:submit.prevent="
                loading = true;
                msg = '';
                fetch('/submit-contact', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: name,
                        email: email,
                        phone: phone,
                        subject: subject,
                        message: message
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
                        subject = '';
                        message = '';
                    }
                })
                .catch(() => {
                    loading = false;
                    success = false;
                    msg = 'Inquiry transmission failure. Please check inputs.';
                });
            ">
              <div class="col-md-6">
                <label class="form-label small fw-bold">Full Name</label>
                <input type="text" x-model="name" required placeholder="John Watson" class="form-control py-2.5" />
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold">Email Address</label>
                <input type="email" x-model="email" required placeholder="watson@baker.org" class="form-control py-2.5" />
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold">Phone Number</label>
                <input type="tel" x-model="phone" placeholder="+91 99999-99999" class="form-control py-2.5" />
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold">Subject</label>
                <input type="text" x-model="subject" required placeholder="General cooperation enquiry" class="form-control py-2.5" />
              </div>
              <div class="col-12">
                <label class="form-label small fw-bold">Message Details</label>
                <textarea x-model="message" required rows="4" placeholder="Enter message text body details..." class="form-control"></textarea>
              </div>
              <div class="col-12">
                <button type="submit" :disabled="loading" class="btn btn-primary w-100 py-2.5 text-white fw-bold" style="border-radius: 8px;">
                    <span x-show="!loading">Send Message</span>
                    <span x-show="loading" style="display:none;">Transmitting...</span>
                </button>
              </div>

              <div x-show="msg" class="col-12 mt-3">
                <div class="alert text-center py-2" :class="success ? 'alert-success' : 'alert-danger'" x-text="msg"></div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
