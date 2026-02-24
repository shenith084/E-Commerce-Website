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
                        <th class="border-0 px-4 py-3">Status</th>
                        <th class="border-0 py-3">From</th>
                        <th class="border-0 py-3">Subject</th>
                        <th class="border-0 py-3 text-center">Date</th>
                        <th class="border-0 py-3 text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr class="{{ $message->status === 'unread' ? 'bg-light-subtle fw-bold' : '' }}">
                            <td class="px-4 py-3">
                                @if($message->status === 'unread')
                                    <span class="badge bg-primary rounded-pill px-2">Unread</span>
                                @elseif($message->status === 'read')
                                    <span class="badge bg-secondary rounded-pill px-2">Read</span>
                                @else
                                    <span class="badge bg-success rounded-pill px-2">Replied</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-dark">{{ $message->name }}</div>
                                <small class="text-muted">{{ $message->email }}</small>
                            </td>
                            <td>
                                <div class="text-dark">{{ $message->subject }}</div>
                                <small class="text-muted">{{ Str::limit($message->message, 50) }}</small>
                            </td>
                            <td class="text-center text-muted small">
                                {{ $message->created_at->format('d M, h:i A') }}
                            </td>
                            <td class="text-end px-4 py-3">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.messages.show', $message) }}" 
                                       class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST"
                                          onsubmit="return confirm('Delete this message?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
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
