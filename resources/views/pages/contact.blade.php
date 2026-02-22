@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="bg-primary text-white py-5">
    <div class="container text-center">
        <h1 class="fw-bold display-4 mb-2">Get In Touch</h1>
        <p class="lead opacity-75">Have questions or need help? We're here for you.</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Contact Information</h5>
                    <div class="d-flex mb-4">
                        <div class="bg-warning text-dark rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Address</h6>
                            <p class="text-muted small mb-0">123 ShopX Lane, Colombo 03, Sri Lanka</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="bg-warning text-dark rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Phone</h6>
                            <p class="text-muted small mb-0">+94 11 234 5678</p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="bg-warning text-dark rounded-circle p-2 me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Email</h6>
                            <p class="text-muted small mb-0">support@shopx.lk</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h5 class="fw-bold mb-4">Send us a Message</h5>
                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label small fw-bold text-muted text-uppercase">Your Name</label>
                                <input type="text" name="name" id="name" class="form-control bg-light border-0 py-2" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label small fw-bold text-muted text-uppercase">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control bg-light border-0 py-2" required>
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label small fw-bold text-muted text-uppercase">Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control bg-light border-0 py-2" required>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label small fw-bold text-muted text-uppercase">Message</label>
                                <textarea name="message" id="message" rows="5" class="form-control bg-light border-0 py-2" required></textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-warning px-5 py-3 fw-bold rounded-pill shadow-sm w-100">Send Message <i class="bi bi-send ms-2"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
