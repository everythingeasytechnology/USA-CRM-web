@extends('layouts.frontend')

@section('title', 'Careers | Join EverythingEasy Engineering Team')
@section('meta_description', 'Build cutting-edge tech products and programmatic SEO landing architectures. Explore open remote and hybrid software development positions.')

@section('content')

  <!-- Page Header -->
  <section class="py-5 bg-gradient-primary text-white" style="padding-top: 120px !important">
    <div class="container text-center py-4">
      <h1 class="display-4 fw-bold mb-3">Careers</h1>
      <p class="lead mb-4">
        Build your career with EverythingEasy and shape the future of technology
      </p>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center bg-transparent">
          <li class="breadcrumb-item"><a href="/" class="text-warning text-decoration-none">Home</a></li>
          <li class="breadcrumb-item active text-white" aria-current="page">Careers</li>
        </ol>
      </nav>
    </div>
  </section>

  <!-- Why Join Us -->
  <section class="py-5 bg-light">
    <div class="container py-4">
      <div class="row text-center mb-5">
        <div class="col-lg-10 mx-auto">
          <h5 class="text-primary fw-bold mb-2">💼 WHY JOIN US</h5>
          <h2 class="fw-bold mb-3">Work With Industry Experts</h2>
          <p class="text-muted leading-relaxed">
            At EverythingEasy, we believe in fostering innovation, creativity, and growth. Join a team of passionate professionals dedicated to making a difference.
          </p>
        </div>
      </div>

      <div class="row text-center">
        <div class="col-md-3 col-6 mb-4">
          <div class="card bg-white border-0 shadow-sm p-4 h-100">
            <div class="mb-3 text-primary"><i class="fas fa-users fa-2x"></i></div>
            <h6 class="fw-bold mb-1 text-dark">Great Team</h6>
            <small class="text-muted">Collaborative Culture</small>
          </div>
        </div>
        <div class="col-md-3 col-6 mb-4">
          <div class="card bg-white border-0 shadow-sm p-4 h-100">
            <div class="mb-3 text-success"><i class="fas fa-chart-line fa-2x"></i></div>
            <h6 class="fw-bold mb-1 text-dark">Growth</h6>
            <small class="text-muted">Career Development</small>
          </div>
        </div>
        <div class="col-md-3 col-6 mb-4">
          <div class="card bg-white border-0 shadow-sm p-4 h-100">
            <div class="mb-3 text-warning"><i class="fas fa-laptop-code fa-2x"></i></div>
            <h6 class="fw-bold mb-1 text-dark">Technology</h6>
            <small class="text-muted">Latest Tools</small>
          </div>
        </div>
        <div class="col-md-3 col-6 mb-4">
          <div class="card bg-white border-0 shadow-sm p-4 h-100">
            <div class="mb-3 text-info"><i class="fas fa-gift fa-2x"></i></div>
            <h6 class="fw-bold mb-1 text-dark">Benefits</h6>
            <small class="text-muted">Competitive Package</small>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Vacancies & Forms Grid -->
  <div class="container py-5" x-data="{
      selectedJobId: '',
      selectedJobTitle: 'General Position Roster',
      name: '',
      email: '',
      phone: '',
      experience: 0,
      portfolio: '',
      cover: '',
      success: false,
      msg: '',
      loading: false
  }">
    <div class="row">
      <!-- Open Vacancies List -->
      <div class="col-lg-7 mb-4">
        <h3 class="fw-bold mb-4 text-dark border-bottom pb-2">Active Job Openings</h3>

        @forelse ($jobs as $job)
            <div class="card p-4 border shadow-sm bg-white mb-4">
              <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <div>
                  <h5 class="fw-bold mb-1 text-primary">{{ $job->title }}</h5>
                  <span class="text-muted small"><i class="fas fa-map-marker-alt me-1"></i>{{ $job->location }}</span>
                </div>
                <button type="button" x-on:click="
                    selectedJobId = '{{ $job->id }}';
                    selectedJobTitle = '{{ addslashes($job->title) }}';
                    document.getElementById('application-form').scrollIntoView({ behavior: 'smooth' });
                " class="btn btn-primary text-white py-1.5 px-3 btn-sm" style="border-radius: 8px;">
                  Apply Position
                </button>
              </div>
              <p class="text-muted small leading-relaxed">{{ $job->description }}</p>
              
              @if ($job->requirements)
                <div class="border-top pt-3 mt-3">
                  <h6 class="fw-bold text-dark small">Role Requirements:</h6>
                  <ul class="list-unstyled text-muted small ps-2">
                    @php
                      $reqs = is_array($job->requirements) ? $job->requirements : explode("\n", $job->requirements);
                    @endphp
                    @foreach ($reqs as $req)
                      @if (trim($req))
                        <li class="mb-1"><i class="fas fa-arrow-right text-primary me-2" style="font-size: 8px;"></i>{{ trim($req) }}</li>
                      @endif
                    @endforeach
                  </ul>
                </div>
              @endif
            </div>
        @empty
            <div class="text-center py-5 text-muted bg-white border rounded shadow-sm">
              No active job openings posted at this moment. You can submit a general application using the form.
            </div>
        @endforelse
      </div>

      <!-- Application Form -->
      <div class="col-lg-5" id="application-form">
        <div class="card p-4 border rounded shadow-sm bg-white">
          <h4 class="fw-bold text-dark mb-4 border-bottom pb-2">Apply for Position</h4>

          <form class="space-y-4" x-on:submit.prevent="
              loading = true;
              msg = '';
              
              const formData = new FormData();
              formData.append('job_posting_id', selectedJobId);
              formData.append('name', name);
              formData.append('email', email);
              formData.append('phone', phone);
              formData.append('experience', experience);
              formData.append('portfolio_url', portfolio);
              formData.append('cover_letter', cover);
              
              const fileInput = document.getElementById('resume-file');
              if (fileInput.files[0]) {
                  formData.append('resume', fileInput.files[0]);
              }

              fetch('/submit-application', {
                  method: 'POST',
                  headers: {
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  },
                  body: formData
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
                      experience = 0;
                      portfolio = '';
                      cover = '';
                      fileInput.value = '';
                      selectedJobTitle = 'General Position Roster';
                      selectedJobId = '';
                  }
              })
              .catch(() => {
                  loading = false;
                  success = false;
                  msg = 'Inquiry transmission failure. Please check inputs.';
              });
          ">
            
            <div class="mb-3">
              <label class="form-label small fw-bold">Applying For</label>
              <select x-model="selectedJobId" x-on:change="
                  const idx = $el.selectedIndex;
                  selectedJobTitle = $el.options[idx].text;
              " class="form-select">
                <option value="">General Application / Roster</option>
                @foreach ($jobs as $job)
                  <option value="{{ $job->id }}">{{ $job->title }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-bold">Full Name</label>
              <input type="text" x-model="name" required placeholder="John Watson" class="form-control" />
            </div>

            <div class="mb-3">
              <label class="form-label small fw-bold">Email Address</label>
              <input type="email" x-model="email" required placeholder="watson@baker.org" class="form-control" />
            </div>

            <div class="mb-3">
              <label class="form-label small fw-bold">Phone Number</label>
              <input type="tel" x-model="phone" required placeholder="+1 (555) 000-0000" class="form-control" />
            </div>

            <div class="row mb-3">
              <div class="col-6">
                <label class="form-label small fw-bold">Years of Exp</label>
                <input type="number" x-model="experience" required min="0" max="40" class="form-control" />
              </div>
              <div class="col-6">
                <label class="form-label small fw-bold">Portfolio (Opt)</label>
                <input type="url" x-model="portfolio" placeholder="https://portfolio.org" class="form-control" />
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-bold">Upload Resume (PDF only)</label>
              <input type="file" id="resume-file" required accept=".pdf" class="form-control" />
            </div>

            <div class="mb-4">
              <label class="form-label small fw-bold">Cover Letter</label>
              <textarea x-model="cover" required rows="3" placeholder="Briefly introduce yourself..." class="form-control"></textarea>
            </div>

            <button type="submit" :disabled="loading" class="btn btn-primary w-100 py-2.5 text-white fw-bold" style="border-radius: 8px;">
                <span x-show="!loading">Submit Profile</span>
                <span x-show="loading" style="display:none;">Uploading...</span>
            </button>

            <div x-show="msg" class="alert mt-3 text-center py-2" :class="success ? 'alert-success' : 'alert-danger'" x-text="msg" style="display:none;"></div>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection
