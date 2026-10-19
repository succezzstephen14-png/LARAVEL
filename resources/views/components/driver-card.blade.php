@props(['driver'])

<style>
    .driver-card {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        background: white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .driver-card:hover {
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        transform: translateY(-8px);
    }

    .driver-card-image-container {
        position: relative;
        width: 100%;
        padding-bottom: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        overflow: hidden;
    }

    .driver-card-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .driver-card:hover .driver-card-image {
        transform: scale(1.1);
    }

    .driver-card-avatar-fallback {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
        font-weight: 700;
        color: white;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .driver-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.6) 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 1.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .driver-card:hover .driver-card-overlay {
        opacity: 1;
    }

    .driver-card-overlay-content {
        color: white;
    }

    .driver-card-overlay-name {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1.2;
    }

    .driver-card-overlay-meta {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-bottom: 0.8rem;
    }

    .driver-card-overlay-meta-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.4rem;
    }

    .driver-card-overlay-meta-icon {
        margin-right: 0.6rem;
        opacity: 0.8;
    }

    .driver-card-content {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .driver-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.3rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .driver-card-subtitle {
        font-size: 0.85rem;
        color: #9ca3af;
        margin-bottom: 0.8rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .driver-card-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        font-size: 0.85rem;
        color: #6b7280;
    }

    .driver-card-rating {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .driver-card-rating-star {
        color: #fbbf24;
        font-size: 0.8rem;
    }

    .driver-card-rating-value {
        font-weight: 600;
        margin-left: 0.3rem;
        color: #374151;
    }

    .driver-card-bio {
        font-size: 0.85rem;
        color: #6b7280;
        line-height: 1.4;
        margin-bottom: 1rem;
        flex: 1;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .driver-card-footer {
        margin-top: auto;
        display: flex;
        gap: 0.8rem;
    }

    .driver-card-btn {
        flex: 1;
        padding: 0.7rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .driver-card-btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
    }

    .driver-card-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .driver-card-btn-secondary {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #e5e7eb;
    }

    .driver-card-btn-secondary:hover {
        background: #e5e7eb;
        color: #1f2937;
    }

    .driver-status-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: rgba(34, 197, 94, 0.9);
        color: white;
        z-index: 10;
        backdrop-filter: blur(4px);
    }

    .driver-approval-badge {
        position: absolute;
        top: 3rem;
        right: 1rem;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: white;
        z-index: 10;
        backdrop-filter: blur(4px);
    }

    .driver-approval-badge.approved {
        background: rgba(34, 197, 94, 0.9);
    }

    .driver-approval-badge.pending {
        background: rgba(245, 158, 11, 0.9);
    }

    .driver-approval-badge.rejected {
        background: rgba(239, 68, 68, 0.9);
    }

    @media (max-width: 768px) {
        .driver-card-title {
            font-size: 1rem;
        }

        .driver-card-overlay-name {
            font-size: 1.1rem;
        }

        .driver-card-content {
            padding: 1.2rem;
        }
    }
</style>

<div class="driver-card">
    <!-- Status Badges -->
    <div class="driver-status-badge">{{ ucfirst($driver->status) }}</div>
    <div class="driver-approval-badge {{ $driver->approval_status }}">{{ ucfirst($driver->approval_status) }}</div>

    <!-- Image Container with Overlay -->
    <div class="driver-card-image-container">
        @if($driver->hasProfilePicture())
            <img src="{{ $driver->getProfilePictureUrl() }}" 
                 alt="{{ $driver->user->name }}" 
                 class="driver-card-image"
                 loading="lazy">
        @else
            <div class="driver-card-avatar-fallback">
                {{ strtoupper(substr($driver->user->name, 0, 1)) }}
            </div>
        @endif

        <!-- Hover Overlay with Details -->
        <div class="driver-card-overlay">
            <div class="driver-card-overlay-content">
                <div class="driver-card-overlay-name">{{ $driver->user->name }}</div>
                <div class="driver-card-overlay-meta">
                    <div class="driver-card-overlay-meta-item">
                        <span class="driver-card-overlay-meta-icon">📍</span>
                        <span>{{ $driver->user->address ?? 'No location' }}</span>
                    </div>
                    <div class="driver-card-overlay-meta-item">
                        <span class="driver-card-overlay-meta-icon">🎖️</span>
                        <span>{{ $driver->experience_years }} years experience</span>
                    </div>
                    <div class="driver-card-overlay-meta-item">
                        <span class="driver-card-overlay-meta-icon">📜</span>
                        <span>License Class {{ $driver->license_class }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="driver-content">
        <h3 class="driver-card-title">{{ $driver->user->name }}</h3>
        <p class="driver-card-subtitle">{{ $driver->user->email }}</p>

        <!-- Meta Information -->
        <div class="driver-card-meta">
            <div>
                <strong style="color: #374151; font-size: 0.9rem;">{{ $driver->experience_years }} yrs</strong>
                <span style="color: #9ca3af; font-size: 0.8rem;">Experience</span>
            </div>
            <div class="driver-card-rating">
                @for($i = 1; $i <= 5; $i++)
                    <span class="driver-card-rating-star">
                        <i class="fas fa-star{{ $i <= ($driver->rating ?? 0) ? '' : '-o' }}"></i>
                    </span>
                @endfor
            </div>
        </div>

        <!-- Bio -->
        @if($driver->bio)
            <p class="driver-card-bio">{{ $driver->bio }}</p>
        @else
            <p class="driver-card-bio" style="color: #d1d5db; font-style: italic;">No bio added yet</p>
        @endif
    </div>

    <!-- Action Buttons -->
    <div class="driver-card-footer">
        <a href="{{ route('drivers.show', $driver) }}" class="driver-card-btn driver-card-btn-secondary">
            <i class="fas fa-eye"></i> View
        </a>
        @if(Auth::check() && Auth::id() !== $driver->user_id)
            <a href="{{ route('booking.page', ['type' => 'driver', 'id' => $driver->id]) }}" class="driver-card-btn driver-card-btn-primary">
                <i class="fas fa-calendar-check"></i> Book Now
            </a>
        @elseif(!Auth::check())
            <a href="{{ route('guest.booking.page', ['type' => 'driver', 'id' => $driver->id]) }}" class="driver-card-btn driver-card-btn-primary">
                <i class="fas fa-calendar-check"></i> Book as Guest
            </a>
        @endif
    </div>
</div>
