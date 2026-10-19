@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<div class="container-max content-section py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="policy-header text-center mb-5">
                <h1 class="display-4 mb-3">Privacy Policy</h1>
                <p class="lead text-muted">Last updated: May 3, 2026</p>
                <p class="text-muted">Your privacy is important to us. This policy explains how we collect, use, and protect your information.</p>
            </div>

            <div class="policy-content">
                <div class="policy-section mb-5">
                    <h2 class="section-title mb-4">1. Information We Collect</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="policy-card p-4 mb-4">
                                <h5 class="card-title mb-3">
                                    <i class="fas fa-user-circle text-primary me-2"></i>
                                    Personal Information
                                </h5>
                                <p class="mb-0">Name, email address, phone number, and other contact details you provide when registering or contacting us.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="policy-card p-4 mb-4">
                                <h5 class="card-title mb-3">
                                    <i class="fas fa-car text-primary me-2"></i>
                                    Vehicle & Driver Data
                                </h5>
                                <p class="mb-0">Vehicle specifications, driver credentials, license information, and related documentation for service provision.</p>
                            </div>
                        </div>
                    </div>
                    <div class="policy-card p-4">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-chart-line text-primary me-2"></i>
                            Usage Information
                        </h5>
                        <p class="mb-0">How you interact with our platform, including pages visited, features used, and booking history to improve our services.</p>
                    </div>
                </div>

                <div class="policy-section mb-5">
                    <h2 class="section-title mb-4">2. How We Use Your Information</h2>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="policy-card p-4 h-100">
                                <div class="feature-icon mb-3">
                                    <i class="fas fa-handshake text-success"></i>
                                </div>
                                <h5 class="card-title mb-3">Service Provision</h5>
                                <p class="mb-0">To connect drivers with vehicle owners and facilitate transportation services.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="policy-card p-4 h-100">
                                <div class="feature-icon mb-3">
                                    <i class="fas fa-shield-alt text-info"></i>
                                </div>
                                <h5 class="card-title mb-3">Security & Verification</h5>
                                <p class="mb-0">To verify identities, prevent fraud, and ensure platform safety.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="policy-card p-4 h-100">
                                <div class="feature-icon mb-3">
                                    <i class="fas fa-envelope text-warning"></i>
                                </div>
                                <h5 class="card-title mb-3">Communication</h5>
                                <p class="mb-0">To send important updates, booking confirmations, and service notifications.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="policy-section mb-5">
                    <h2 class="section-title mb-4">3. Information Sharing</h2>
                    <div class="alert alert-info p-4 mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Important:</strong> We do not sell, trade, or rent your personal information to third parties for marketing purposes.
                    </div>
                    <p class="mb-4">We may share your information only in the following circumstances:</p>
                    <ul class="policy-list">
                        <li><strong>Service Partners:</strong> With verified drivers or vehicle owners to facilitate bookings</li>
                        <li><strong>Legal Requirements:</strong> When required by law or to protect our rights</li>
                        <li><strong>Platform Security:</strong> To prevent fraud and ensure platform integrity</li>
                        <li><strong>Business Transfers:</strong> In case of company merger, acquisition, or sale</li>
                    </ul>
                </div>

                <div class="policy-section mb-5">
                    <h2 class="section-title mb-4">4. Data Security</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="security-feature p-4 mb-4">
                                <i class="fas fa-lock text-primary mb-3" style="font-size: 2rem;"></i>
                                <h5>Encryption</h5>
                                <p>All data transmission is encrypted using industry-standard SSL/TLS protocols.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="security-feature p-4 mb-4">
                                <i class="fas fa-server text-primary mb-3" style="font-size: 2rem;"></i>
                                <h5>Secure Storage</h5>
                                <p>Your information is stored on secure servers with access controls and monitoring.</p>
                            </div>
                        </div>
                    </div>
                    <div class="security-feature p-4">
                        <i class="fas fa-user-shield text-primary mb-3" style="font-size: 2rem;"></i>
                        <h5>Access Controls</h5>
                        <p>Only authorized personnel have access to your data, and all access is logged and monitored.</p>
                    </div>
                </div>

                <div class="policy-section mb-5">
                    <h2 class="section-title mb-4">5. Your Rights</h2>
                    <p class="mb-4">You have the following rights regarding your personal information:</p>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="rights-card p-4">
                                <h6 class="text-primary mb-2">Access</h6>
                                <p class="mb-0 small">Request a copy of the personal information we hold about you.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="rights-card p-4">
                                <h6 class="text-primary mb-2">Correction</h6>
                                <p class="mb-0 small">Request correction of inaccurate or incomplete information.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="rights-card p-4">
                                <h6 class="text-primary mb-2">Deletion</h6>
                                <p class="mb-0 small">Request deletion of your personal information under certain conditions.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="rights-card p-4">
                                <h6 class="text-primary mb-2">Portability</h6>
                                <p class="mb-0 small">Request transfer of your data to another service provider.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="policy-section mb-5">
                    <h2 class="section-title mb-4">6. Cookies & Tracking</h2>
                    <p class="mb-4">We use cookies and similar technologies to enhance your experience:</p>
                    <div class="cookie-info p-4 bg-light rounded">
                        <h6 class="mb-3">Types of Cookies We Use:</h6>
                        <ul class="mb-0">
                            <li><strong>Essential Cookies:</strong> Required for platform functionality</li>
                            <li><strong>Analytics Cookies:</strong> Help us understand how you use our service</li>
                            <li><strong>Preference Cookies:</strong> Remember your settings and preferences</li>
                        </ul>
                    </div>
                </div>

                <div class="policy-section mb-5">
                    <h2 class="section-title mb-4">7. Contact Us</h2>
                    <div class="contact-info p-4 bg-light rounded">
                        <p class="mb-3">If you have any questions about this Privacy Policy, please contact us:</p>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Email:</strong> privacy@succezzdriversagency.com</p>
                                <p class="mb-1"><strong>Phone:</strong> +233 50 073 0901</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Address:</strong> 123 Transport Avenue</p>
                                <p class="mb-0"><strong>City:</strong> Accra, Ghana</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="policy-section">
                    <h2 class="section-title mb-4">8. Changes to This Policy</h2>
                    <p class="mb-0">We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page and updating the "Last updated" date.</p>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('home') }}" class="btn btn-outline-primary me-3">Back to Home</a>
                <a href="{{ route('terms.conditions') }}" class="btn btn-primary">View Terms & Conditions</a>
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

    .policy-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .policy-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .card-title {
        color: #1f2937;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .feature-icon {
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

    .policy-list {
        list-style: none;
        padding: 0;
    }

    .policy-list li {
        padding: 0.75rem 0;
        padding-left: 1.5rem;
        position: relative;
        border-bottom: 1px solid #f3f4f6;
    }

    .policy-list li::before {
        content: '→';
        position: absolute;
        left: 0;
        color: #3b82f6;
        font-weight: bold;
    }

    .policy-list li:last-child {
        border-bottom: none;
    }

    .security-feature {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 1px solid #bae6fd;
        border-radius: 12px;
        text-align: center;
    }

    .rights-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        height: 100%;
    }

    .cookie-info {
        border-left: 4px solid #3b82f6;
    }

    .contact-info {
        border-left: 4px solid #10b981;
    }

    @media (max-width: 768px) {
        .policy-header {
            padding: 2rem 0;
        }

        .section-title {
            font-size: 1.5rem;
        }

        .policy-card {
            margin-bottom: 1rem;
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }
    }
</style>
@endsection