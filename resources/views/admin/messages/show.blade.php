@extends('layouts.app')

@section('title', 'View Message: ' . $message->subject)

@section('content')
<div class="bg-dark text-white py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold mb-0"><i class="bi bi-chat-left-text me-2 text-warning"></i>View Message</h1>
            <small class="opacity-75">From: {{ $message->name }}</small>
        </div>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-light rounded-pill btn-sm px-4">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Message Content</h5>
                    <span class="badge bg-{{ $message->status === 'unread' ? 'primary' : 'secondary' }} rounded-pill px-3">
                        {{ ucfirst($message->status) }}
                    </span>
                </div>
                <div class="card-body p-4 p-md-5">
                    <div class="mb-4 bg-light p-4 rounded-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small fw-bold text-muted text-uppercase d-block mb-1">From</label>
                                <div class="fw-bold text-dark">{{ $message->name }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-muted text-uppercase d-block mb-1">Email</label>
                                <a href="mailto:{{ $message->email }}" class="text-decoration-none text-primary">{{ $message->email }}</a>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-muted text-uppercase d-block mb-1">Date Received</label>
                                <div class="text-dark">{{ $message->created_at->format('d M Y, h:i A') }}</div>
                            </div>
                            <div class="col-6 text-md-end">
                                <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="btn btn-warning rounded-pill px-4 btn-sm">
                                    <i class="bi bi-reply-fill me-1"></i>Reply via Email
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="small fw-bold text-muted text-uppercase d-block mb-2">Subject</label>
                        <h5 class="fw-bold text-dark">{{ $message->subject }}</h5>
                    </div>

                    <div class="mb-0">
                        <label class="small fw-bold text-muted text-uppercase d-block mb-2">Message Content</label>
                        <div class="p-4 bg-light border rounded-4 text-dark shadow-inner" style="white-space: pre-wrap; line-height: 1.6; min-height: 200px;">{{ $message->message }}</div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 border border-danger-subtle">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold text-danger mb-1">Delete this message?</h6>
                        <small class="text-muted">This will permanently remove the message from your database.</small>
                    </div>
                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST"
                          onsubmit="return confirm('Permanently delete this message?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-pill px-4">
                            <i class="bi bi-trash me-1"></i>Delete Permanent
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
