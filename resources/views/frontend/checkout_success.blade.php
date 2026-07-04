@extends('layouts.frontend')

@section('title', 'Order Success | EverythingEasy')

@section('content')
  <section class="py-5 bg-light d-flex align-items-center" style="padding-top: 150px !important; min-height: 80vh;">
    <div class="container py-4">
      <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
          <div class="card p-5 border-0 shadow-sm bg-white rounded-4">
            <div class="mb-4 text-success d-flex justify-content-center">
              <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background-color: #d1e7dd !important;">
                <i class="fas fa-check-circle text-success" style="font-size: 40px;"></i>
              </div>
            </div>

            <h3 class="fw-bold text-dark mb-2">Order Confirmed!</h3>
            <p class="text-muted small mb-4">Thank you, your payment has been processed successfully. We've emailed your order receipt details.</p>
            
            <div class="bg-light p-4 rounded-3 text-start mb-4">
              <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Invoice Details</h6>
              <div class="d-flex justify-content-between mb-2 small text-muted">
                <span>Invoice ID:</span>
                <strong class="text-dark">{{ $order->order_number }}</strong>
              </div>
              <div class="d-flex justify-content-between mb-2 small text-muted">
                <span>Selected Solution:</span>
                <strong class="text-dark">{{ $order->service_name }}</strong>
              </div>
              <div class="d-flex justify-content-between mb-2 small text-muted">
                <span>Client Name:</span>
                <strong class="text-dark">{{ $order->client_name }}</strong>
              </div>
              <div class="d-flex justify-content-between mb-2 small text-muted">
                <span>Email Address:</span>
                <strong class="text-dark">{{ $order->email }}</strong>
              </div>
              <div class="d-flex justify-content-between mb-2 small text-muted">
                <span>Payment Method:</span>
                <strong class="text-dark">PayPal secure checkout</strong>
              </div>
              <div class="d-flex justify-content-between mb-2 small text-muted">
                <span>Status:</span>
                <strong class="text-success"><i class="fas fa-check-circle me-1"></i>PAID</strong>
              </div>
              <hr class="my-3" />
              <div class="d-flex justify-content-between">
                <span class="fw-bold text-dark">Amount Charged:</span>
                <strong class="text-primary fs-5">${{ number_format($order->amount) }}</strong>
              </div>
            </div>

            <div class="d-flex gap-3 justify-content-center">
              <a href="/" class="btn btn-primary px-4 py-2" style="border-radius: 8px;">Back to Home</a>
              <a href="/contact" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 8px;">Contact Support</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
