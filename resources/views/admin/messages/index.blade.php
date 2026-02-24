@extends('layouts.app')

@section('title', 'Admin: Messages')

@section('content')
<div class="bg-dark text-white py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold mb-0"><i class="bi bi-chat-left-text me-2 text-warning"></i>Messages</h1>
            <small class="opacity-75">{{ $messages->total() }} message(s) received</small>
        </div>
    </div>
</div>

<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success rounded-4 border-0 shadow-sm mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="border-0 px-3 py-3">Status</th>
                        <th class="border-0 py-3">Sender</th>
                        <th class="border-0 py-3 d-none d-md-table-cell">Subject</th>
                        <th class="border-0 py-3 text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr class="{{ $message->status === 'unread' ? 'bg-light-subtle fw-bold' : '' }}">
                            <td class="px-3 py-3">
                                @if($message->status === 'unread')
                                    <span class="badge bg-primary rounded-pill px-2" style="font-size: 0.6rem;">New</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2" style="font-size: 0.6rem;">Read</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-dark small fw-bold">{{ Str::limit($message->name, 15) }}</div>
                                <small class="text-muted d-none d-lg-block">{{ $message->email }}</small>
                                <div class="d-md-none small text-muted text-truncate" style="max-width: 100px;">{{ $message->subject }}</div>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <div class="text-dark small text-truncate" style="max-width: 200px;">{{ $message->subject }}</div>
                                <small class="text-muted d-none d-lg-block">{{ Str::limit($message->message, 40) }}</small>
                            </td>
                            <td class="text-end px-3 py-3">
                                <div class="btn-group">
                                    <a href="{{ route('admin.messages.show', $message) }}" 
                                       class="btn btn-outline-dark btn-sm rounded-pill p-1 px-2" style="font-size: 0.7rem;">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-chat-left-dots fs-1 text-muted d-block mb-3"></i>
                                <h6 class="text-muted">No messages yet.</h6>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($messages->hasPages())
            <div class="card-footer bg-white border-top-0 p-4">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
