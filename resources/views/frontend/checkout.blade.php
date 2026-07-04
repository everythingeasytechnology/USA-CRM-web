@php
  $paypalGateway = \App\Models\PaymentGateway::where('gateway', 'paypal')->first();
  $clientId = 'sb';
  if ($paypalGateway && $paypalGateway->is_enabled && isset($paypalGateway->credentials['client']) && !empty($paypalGateway->credentials['client'])) {
      $clientId = $paypalGateway->credentials['client'];
  }
@endphp
@extends('layouts.frontend')

@section('title', 'Secure Checkout | EverythingEasy')

@section('content')
  <section class="py-5 bg-light" style="padding-top: 120px !important;">
    <div class="container py-4">
      <div class="row g-5">
        <!-- Left Column: Checkout Form & PayPal -->
        <div class="col-lg-7">
          <div class="card p-4 border-0 shadow-sm bg-white rounded-4">
            <h4 class="fw-bold mb-1 text-dark">Checkout Details</h4>
            <p class="text-muted small mb-4">Please fill out your contact and billing info below to activate the secure checkout.</p>
            
            <form id="checkout-form" class="row g-3 needs-validation" novalidate>
              <input type="hidden" id="package-id" value="{{ $package->id }}" />
              
              <div class="col-md-6">
                <label class="form-label small fw-bold text-dark">Full Name*</label>
                <input type="text" id="client-name" class="form-control py-2.5 px-3 rounded-3" style="border: 1px solid #e0e0e0;" placeholder="John Watson" required />
                <div class="invalid-feedback small">Please enter your full name.</div>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-bold text-dark">Email Address*</label>
                <input type="email" id="email" class="form-control py-2.5 px-3 rounded-3" style="border: 1px solid #e0e0e0;" placeholder="john@example.com" required />
                <div class="invalid-feedback small">Please enter a valid email address.</div>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-bold text-dark">Phone Number*</label>
                <input type="tel" id="phone" class="form-control py-2.5 px-3 rounded-3" style="border: 1px solid #e0e0e0;" placeholder="+91 99999-99999" required />
                <div class="invalid-feedback small">Please enter your phone number.</div>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-bold text-dark">Company Name (Optional)</label>
                <input type="text" id="company-name" class="form-control py-2.5 px-3 rounded-3" style="border: 1px solid #e0e0e0;" placeholder="Watson Agency" />
              </div>

              <div class="col-12">
                <label class="form-label small fw-bold text-dark">Billing Address*</label>
                <textarea id="billing-address" class="form-control py-2.5 px-3 rounded-3" style="border: 1px solid #e0e0e0;" rows="3" placeholder="Suite 404, Tech Park, Noida, UP, India" required></textarea>
                <div class="invalid-feedback small">Please enter your billing address.</div>
              </div>

              <div class="col-12 mt-4 pt-3 border-top">
                <h5 class="fw-bold mb-3 text-dark">Pay securely with PayPal</h5>
                <p class="text-muted small mb-4"><i class="fas fa-lock text-success me-1.5"></i>Secure SSL payment gate. Click the button below to process your transaction safely via PayPal.</p>
                
                <!-- PayPal Button Container -->
                <div id="paypal-button-container" class="position-relative" style="z-index: 10;"></div>
                
                <!-- Feedback error messaging -->
                <div id="checkout-error" class="alert alert-danger mt-3 py-2 text-center small" style="display: none;"></div>
              </div>
            </form>
          </div>
        </div>

        <!-- Right Column: Order Summary -->
        <div class="col-lg-5">
          <div class="card border-0 shadow-sm bg-white rounded-4 overflow-hidden">
            <div class="p-4 bg-primary text-white">
              <h5 class="fw-bold mb-0 text-white">Order Summary</h5>
            </div>
            <div class="p-4">
              <div class="d-flex align-items-center mb-4">
                <div class="rounded-circle bg-light p-3 d-flex align-items-center justify-content-center text-primary" style="width: 55px; height: 55px;">
                  <i class="fas fa-rocket fa-lg"></i>
                </div>
                <div class="ms-3">
                  <h6 class="fw-bold text-dark mb-0" style="font-size: 17px;">{{ $package->name }}</h6>
                  <small class="text-muted">{{ $package->service->name }}</small>
                </div>
              </div>

              <!-- Spacing / Pricing details -->
              <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted small">Package Price</span>
                  <strong class="text-dark">${{ number_format($package->price) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                  <span class="text-muted small">Setup Fee</span>
                  <strong class="text-success small">Free Setup</strong>
                </div>
                <hr class="my-3 border-slate-100" />
                <div class="d-flex justify-content-between">
                  <span class="fw-bold text-dark">Total Amount</span>
                  <strong class="text-primary fs-5">${{ number_format($package->price) }}</strong>
                </div>
              </div>

              <!-- Package features -->
              <div class="p-3 bg-light rounded-3 mb-4">
                <h6 class="fw-bold text-dark mb-2.5 small">Deliverables Included:</h6>
                <ul class="list-unstyled mb-0 text-muted small">
                  @if($package->delivery_time)
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i><strong>Delivery:</strong> {{ $package->delivery_time }}</li>
                  @endif
                  @if($package->revisions)
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i><strong>Revisions:</strong> {{ $package->revisions }}</li>
                  @endif
                  @if(is_array($package->features) && count($package->features) > 0)
                    @foreach(array_slice($package->features, 0, 5) as $feat)
                      @if(trim($feat))
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>{{ trim($feat) }}</li>
                      @endif
                    @endforeach
                  @endif
                </ul>
              </div>

              <!-- Trust badge block -->
              <div class="text-center py-2 border-top">
                <p class="text-muted mb-0" style="font-size: 12px;">
                  <i class="fas fa-shield-alt text-success me-1"></i> 100% Secure Checkout Guaranteed by PayPal.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- PayPal SDK Script -->
  <script src="https://www.paypal.com/sdk/js?client-id={{ $clientId }}&currency=USD"></script>

  <!-- Checkout payment execution logic -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('checkout-form');
        const errorAlert = document.getElementById('checkout-error');

        paypal.Buttons({
            // Validate form input fields before loading payment popup
            onClick: function(data, actions) {
                form.classList.add('was-validated');
                if (!form.checkValidity()) {
                    errorAlert.innerText = 'Please fill out all required billing and contact fields correctly.';
                    errorAlert.style.display = 'block';
                    return actions.reject();
                } else {
                    errorAlert.style.display = 'none';
                    return actions.resolve();
                }
            },

            // Create Order on local server and get total
            createOrder: function(data, actions) {
                return fetch('/checkout/process', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        package_id: document.getElementById('package-id').value,
                        client_name: document.getElementById('client-name').value,
                        email: document.getElementById('email').value,
                        phone: document.getElementById('phone').value,
                        billing_address: document.getElementById('billing-address').value,
                        company_name: document.getElementById('company-name').value
                    })
                })
                .then(function(res) {
                    return res.json();
                })
                .then(function(orderData) {
                    if (!orderData.success) {
                        throw new Error('Failed to create order on server.');
                    }
                    // Save order ID locally
                    window.currentOrderId = orderData.order_id;
                    
                    // Split client name for given_name and surname fields
                    const fullName = document.getElementById('client-name').value.trim();
                    const nameParts = fullName.split(' ');
                    const firstName = nameParts[0] || '';
                    const lastName = nameParts.slice(1).join(' ') || '';

                    // Create PayPal transaction with pre-filled payer details
                    return actions.order.create({
                        payer: {
                            name: {
                                given_name: firstName,
                                surname: lastName
                            },
                            email_address: document.getElementById('email').value,
                            phone: {
                                phone_type: "MOBILE",
                                phone_number: {
                                    national_number: document.getElementById('phone').value.replace(/[^0-9]/g, '')
                                }
                            },
                            address: {
                                address_line_1: document.getElementById('billing-address').value,
                                country_code: "US"
                            }
                        },
                        purchase_units: [{
                            invoice_id: orderData.order_number,
                            amount: {
                                value: orderData.usd_amount,
                                currency_code: 'USD'
                            }
                        }]
                    });
                })
                .catch(function(err) {
                    errorAlert.innerText = 'An error occurred during order preprocessing. Please check your inputs.';
                    errorAlert.style.display = 'block';
                });
            },

            // Payment succeeded and captured via PayPal
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    return fetch('/checkout/payment-success', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            order_id: window.currentOrderId
                        })
                    })
                    .then(function(res) {
                        return res.json();
                    })
                    .then(function(successData) {
                        if (successData.success) {
                            window.location.href = successData.redirect_url;
                        } else {
                            throw new Error('Failed to capture local payment status.');
                        }
                    });
                });
            },

            onError: function(err) {
                errorAlert.innerText = 'Checkout transaction was cancelled or encountered a payment gateway error.';
                errorAlert.style.display = 'block';
            }
        }).render('#paypal-button-container');
    });
  </script>
@endsection
