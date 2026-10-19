@extends('layouts.app')

@section('title', 'Notifications - SUCCEZZ Drivers Agency')

@section('content')
<div class="page-header">
    <div>
        <h1>Notifications</h1>
        <p>All account notifications sent to you, including admin messages, booking updates, and application status changes.</p>
    </div>
    <div>
        <a href="{{ route('dashboard') }}" class="btn btn-soft">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</div>

<div class="notification-list">
    @if($notifications->isEmpty())
        <div class="alert alert-info rounded-18" style="border-radius: 18px;">
            <i class="fas fa-info-circle me-2"></i> No notifications yet. Messages from the admin and status updates will appear here.
        </div>
    @else
        @foreach($notifications as $notification)
            <div class="notification-item">
                <div class="notification-header">
                    <div>
                        <h4>{{ $notification->title }}</h4>
                        <small class="text-muted">{{ $notification->created_at?->format('M d, Y \a\t H:i') ?? 'Recently' }}</small>
                    </div>
                    <span class="badge bg-{{ $notification->status === 'unread' ? 'warning text-dark' : 'secondary' }}">
                        {{ ucfirst($notification->status) }}
                    </span>
                </div>
                <p class="mb-3">{{ $notification->message }}</p>
                @if($notification->status === 'unread')
                    <form method="POST" action="{{ route('notifications.read', $notification) }}">
                        @csrf
                        <button type="submit" class="btn btn-soft btn-sm">Mark as read</button>
                    </form>
                @endif
            </div>
        @endforeach

        <div class="pagination-wrapper mt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
