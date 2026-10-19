@extends('layouts.app')

@section('title', 'Terms and Conditions')

@section('content')
<div class="container-max content-section py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="policy-header text-center mb-5">
                <h1 class="display-4 mb-3">Terms and Conditions</h1>
                <p class="lead text-muted">Last updated: May 3, 2026</p>
                <p class="text-muted">Please read these terms carefully before using our platform.</p>
            </div>

            <div class="policy-content">
                <div class="policy-section mb-5">
                    <h2 class="section-title mb-4">1. Acceptance of Terms</h2>
                    <div class="terms-intro p-4 bg-light rounded mb-4">
                        <p class="mb-0">By accessing and using the SUCCEZZ Drivers Agency platform, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.</p>
                    </div>
                    <p>These terms apply to all users of our platform, including drivers, vehicle owners, and general visitors.</p>
                </div>

                <div class="policy-section mb-5">
                    <h2 class="section-title mb-4">2. Service Description</h2>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="service-card p-4 h-100">
                                <div class="service-icon mb-3">
                                    <i class="fas fa-car text-primary"></i>
                                </div>
                                <h5 class="card-title mb-3">Vehicle Management</h5>
                                <p class="mb-0">Platform for vehicle owners to list their vehicles and connect with qualified drivers for transportation services.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="service-card p-4 h-100">
                                <div class="service-icon mb-3">
                                    <i class="fas fa-id-card text-success"></i>
                                </div>
                                <h5 class="card-title mb-3">Driver Recruitment</h5>
                                <p class="mb-0">Comprehensive recruitment platform for drivers seeking employment opportunities in the transportation sector.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="policy-section mb-5">
                    <h2 class="section-title mb-4">3. User Responsibilities</h2>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="responsibility-card p-4 h-100">
                                <h6 class="text-primary mb-3">Account Security</h6>
                                <ul class="mb-0 small">
                                    <li>Maintain account confidentiality</li>
                                    <li>Use strong, unique passwords</li>
                                    <li>Report suspicious activity</li>
                                    <li>Accept responsibility for all activities under your account</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="responsibility-card p-4 h-100">
                                <h6 class="text-primary mb-3">Accurate Information</h6>
                                <ul class="mb-0 small">
                                    <li>Provide truthful information</li>
                                    <li>Keep information current</li>
                                    <li>Verify all submitted documents</li>
                                    <li>Report changes promptly</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="responsibility-card p-4 h-100">
                                <h6 class="text-primary mb-3">Platform Usage</h6>
                                <ul class="mb-0 small">
                                    <li>Use services lawfully</li>
                                    <li>Respect other users</li>
                                    <li>Follow booking procedures</li>
                                    <li>Report violations</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="policy-section mb-5">
                    <h2 class="section-title mb-4">4. Driver Requirements</h2>
                    <div class="requirements-section p-4 bg-light rounded">
                        <h5 class="mb-3">To register as a driver, you must:</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="requirements-list">
                                    <li>Be at least 21 years old</li>
                                    <li>Hold a valid driver's license</li>
                                    <li>Have clean driving record</li>
                                    <li>Pass background verification</li>
                                    <li>Provide required documentation</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="requirements-list">
                                    <li>Complete training programs</li>
                                    <li>Maintain professional conduct</li>
                                    <li>Follow safety protocols</li>
                                    <li>Keep license current</li>
                                    <li>Report incidents immediately</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="policy-section mb-5">
                    <h2 class="section-title mb-4">5. Vehicle Owner Requirements</h2>
                    <div class="requirements-section p-4 bg-light rounded">
                        <h5 class="mb-3">Vehicle owners must ensure:</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="requirements-list">
                                    <li>Vehicles are roadworthy</li>
                                    <li>Valid registration and insurance</li>
                                    <li>Regular maintenance records</li>
                                    <li>Clean title ownership</li>
                                    <li>Accurate vehicle specifications</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="requirements-list">
                                    <li>Compliance with local regulations</li>
                                    <li>Safe operating condition</li>
                                    <li>Proper documentation</li>
                                    <li>Timely disclosure of issues</li>
                                    <li>Professional representation</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="policy-section mb-5">
                    <h2 class="section-title mb-4">6. Booking and Payment Terms</h2>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="terms-card p-4">
                                <h6 class="text-primary mb-3">Booking Process</h6>
                                <ul class="mb-0 small">
                                    <li>Bookings made through platform only</li>
                                    <li>Confirmation required from both parties</li>
                                    <li>Cancellation policies apply</li>
                                    <li>Changes subject to mutual agreement</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="terms-card p-4">
                                <h6 class="text-primary mb-3">Payment Terms</h6>
                                <ul class="mb-0 small">
                                    <li>Payments processed securely</li>
                                    <li>Fees clearly disclosed</li>
                                    <li>Refunds per cancellation policy</li>
                                    <li>Disputes handled fairly</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="policy-section mb-5">
                    <h2 class="section-title mb-4">7. Prohibited Activities</h2>
                    <div class="alert alert-warning p-4 mb-4">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Violation Warning:</strong> Engaging in prohibited activities may result in account suspension or termination.
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-danger mb-3">Not Allowed:</h6>
                            <ul class="prohibited-list">
                                <li>Fraudulent activities</li>
                                <li>Misrepresentation of information</li>
                                <li>Harassment or abusive behavior</li>
                                <li>Violation of local laws</li>
                                <li>Unauthorized data collection</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-danger mb-3">Also Prohibited:</h6>
                            <ul class="prohibited-list">
                                <li>Spam or unsolicited communications</li>
                                <li>Impersonation of others</li>
                                <li>Platform manipulation</li>
                                <li>Intellectual property infringement</li>
                                <li>Security violations</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="policy-section mb-5">
                    <h2 class="section-title mb-4">8. Liability & Disclaimers</h2>
                    <div class="liability-notice p-4 bg-light rounded">
                        <h6 class="text-primary mb-3">Important Disclaimers:</h6>
                        <ul class="mb-0">
                            <li><strong>Service Availability:</strong> We strive for 99.9% uptime but cannot guarantee uninterrupted service</li>
                            <li><strong>User-Generated Content:</strong> We are not responsible for accuracy of user-provided information</li>
                            <li><strong>Third-Party Services:</strong> External links and integrations are provided as convenience only</li>
                            <li><strong>Force Majeure:</strong> We are not liable for events beyond our reasonable control</li>
                        </ul>
                    </div>
                </div>

                <div class="policy-section mb-5">
                    <h2 class="section-title mb-4">9. Termination</h2>
                    <p class="mb-4">Either party may terminate this agreement at any time. Upon termination:</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="termination-card p-4">
                                <h6 class="text-primary mb-2">Your Rights</h6>
                                <ul class="mb-0 small">
                                    <li>Access to your data</li>
                                    <li>Export your information</li>
                                    <li>Cancel pending bookings</li>
                                    <li>Receive final settlements</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="termination-card p-4">
                                <h6 class="text-primary mb-2">Our Rights</h6>
                                <ul class="mb-0 small">
                                    <li>Retain necessary records</li>
                                    <li>Complete pending transactions</li>
                                    <li>Enforce outstanding obligations</li>
                                    <li>Protect platform integrity</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="policy-section mb-5">
                    <h2 class="section-title mb-4">10. Governing Law</h2>
                    <div class="legal-notice p-4 bg-light rounded">
                        <p class="mb-2">These terms are governed by the laws of Ghana. Any disputes shall be resolved through:</p>
                        <ol class="mb-0">
                            <li>Negotiation between parties</li>
                            <li>Mediation by neutral third party</li>
                            <li>Arbitration in Accra, Ghana</li>
                            <li>Courts of competent jurisdiction</li>
                        </ol>
                    </div>
                </div>

                <div class="policy-section">
                    <h2 class="section-title mb-4">11. Contact Information</h2>
                    <div class="contact-section p-4 bg-primary text-white rounded">
                        <h5 class="mb-3">Questions About These Terms?</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Email:</strong> legal@succezzdriversagency.com</p>
                                <p class="mb-1"><strong>Phone:</strong> +233 50 073 0901</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Address:</strong> 123 Transport Avenue</p>
                                <p class="mb-0"><strong>City:</strong> Accra, Ghana</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('home') }}" class="btn btn-outline-primary me-3">Back to Home</a>
                <a href="{{ route('privacy.policy') }}" class="btn btn-primary">View Privacy Policy</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .policy-header {
        padding: 3rem 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .policy-content {
        font-size: 1rem;
        line-height: 1.7;
    }

    .section-title {
        color: #1f2937;
        font-weight: 700;
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #3b82f6, #1d4ed8);
        border-radius: 2px;
    }

    .terms-intro {
        border-left: 4px solid #3b82f6;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    }

    .service-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .service-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .service-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #3b82f6;
    }

    .card-title {
        color: #1f2937;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .responsibility-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        height: 100%;
    }

    .requirements-section {
        border-left: 4px solid #10b981;
    }

    .requirements-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .requirements-list li {
        padding: 0.5rem 0;
        padding-left: 1.5rem;
        position: relative;
        border-bottom: 1px solid #f3f4f6;
    }

    .requirements-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #10b981;
        font-weight: bold;
    }

    .requirements-list li:last-child {
        border-bottom: none;
    }

    .terms-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        height: 100%;
    }

    .prohibited-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .prohibited-list li {
        padding: 0.5rem 0;
        padding-left: 1.5rem;
        position: relative;
        color: #dc2626;
    }

    .prohibited-list li::before {
        content: '✗';
        position: absolute;
        left: 0;
        color: #dc2626;
        font-weight: bold;
    }

    .liability-notice {
        border-left: 4px solid #f59e0b;
    }

    .termination-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        height: 100%;
    }

    .legal-notice {
        border-left: 4px solid #8b5cf6;
    }

    .contact-section {
        background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
    }

    @media (max-width: 768px) {
        .policy-header {
            padding: 2rem 0;
        }

        .section-title {
            font-size: 1.5rem;
        }

        .service-card {
            margin-bottom: 1rem;
        }

        .service-icon {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }
    }
</style>
@endsection