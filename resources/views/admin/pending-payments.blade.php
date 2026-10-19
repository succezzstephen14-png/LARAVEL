@extends('layouts.admin')

@section('title', 'Pending Payments')

@section('content')
<style>
    .admin-wrapper {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        min-height: calc(100vh - 80px);
        padding: 2rem 0;
    }
    .admin-header {
        background: white;
        padding: 1.5rem 2rem;
        border-radius: 24px;
        margin-bottom: 2rem;
        box-shadow: 0 12px 40px rgba(15, 23, 42, 0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .admin-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 800;
    }
    .payments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .payment-card {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 12px 40px rgba(15, 23, 42, 0.08);
        border: 1px solid rgba(15, 23, 42, 0.06);
    }
    .payment-card-header {
        background: linear-gradient(135deg, #ec4899 0%, #d946ef 100%);
        color: white;
        padding: 1.5rem;
    }
    .payment-card-header h5 {
        margin: 0;
        font-size: 1.1rem;
    }
    .pending-badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.25);
        color: white;
        margin-top: 0.5rem;
    }
    .payment-card-body {
        padding: 1.5rem;
    }
    .payment-info {
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
    }
    .payment-info strong {
        color: #6b7280;
        display: inline-block;
        width: 120px;
    }
    .payment-amount {
        margin: 1rem 0;
        padding: 1rem;
        background: #f0fdf4;
        border-radius: 12px;
        text-align: center;
        border-left: 3px solid #10b981;
    }
    .payment-amount .amount {
        font-size: 1.5rem;
        font-weight: 800;
        color: #10b981;
    }
    .payment-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }
    .approve-btn {
        padding: 0.75rem 1rem;
        background: #10b981;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .approve-btn:hover {
        background: #059669;
    }
    .reject-btn {
        padding: 0.75rem 1rem;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .reject-btn:hover {
        background: #dc2626;
    }
</style>

<div class="admin-wrapper">
    <div class="container-max">
        <div class="admin-header">
            <h2><i class="fas fa-credit-card"></i> Pending Payments</h2>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>

        @if($payments->count() === 0)
            <div style="background: white; padding: 3rem 2rem; border-radius: 18px; text-align: center; box-shadow: 0 12px 40px rgba(15, 23, 42, 0.08);">
                <i class="fas fa-check-circle" style="font-size: 3rem; color: #10b981; margin-bottom: 1rem; display: block;"></i>
                <p style="color: #10b981; font-weight: 600; margin: 0; font-size: 1.1rem;">All pending payments have been processed</p>
            </div>
        @else
            <div class="payments-grid">
                @foreach($payments as $payment)
                    <div class="payment-card">
                        <div class="payment-card-header">
                            <h5>💳 Payment #{{ $payment->id }}</h5>
                            <span class="pending-badge">⏳ {{ ucfirst($payment->status) }}</span>
                        </div>
                        <div class="payment-card-body">
                            <div class="payment-info">
                                <strong>From:</strong> {{ $payment->user->name }}
                            </div>
                            <div class="payment-info">
                                <strong>Type:</strong> {{ ucfirst($payment->payment_type) }}
                            </div>
                            <div class="payment-info">
                                <strong>Date:</strong> {{ $payment->created_at->format('M d, Y') }}
                            </div>

                            <div class="payment-amount">
                                <div style="font-size: 0.85rem; color: #6b7280; margin-bottom: 0.5rem;">Amount</div>
                                <div class="amount">{{ config('app.currency_label', 'GHC') }} {{ number_format($payment->amount / 100, 2) }}</div>
                            </div>

                            <div class="payment-info">
                                <strong>Reference:</strong> {{ $payment->reference_number }}
                            </div>

                            <div class="payment-actions">
                                <form action="{{ route('admin.payments.approve', $payment) }}" method="POST" style="width: 100%;">
                                    @csrf
                                    <button type="submit" class="approve-btn w-100">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                                <button type="button" class="reject-btn" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $payment->id }}">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Reject Modal -->
                    <div class="modal fade" id="rejectModal{{ $payment->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Reject Payment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.payments.reject', $payment) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <label for="rejection_reason" class="form-label">Reason for Rejection</label>
                                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Reject Payment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
