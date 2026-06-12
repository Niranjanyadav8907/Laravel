@extends('layouts.user')

@section('title', 'Security Policy')
@section('page-title', 'Security Policy')
@section('breadcrumb', 'Security Policy')

@section('content')

<style>
/* Same Design CSS */
.privacy-hero {
    background: linear-gradient(135deg, #4e73df, #1cc88a);
    color: #fff;
    padding: 80px 20px;
    text-align: center;
    border-radius: 0 0 60px 60px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.privacy-hero h1 {
    font-size: 2.5rem;
    font-weight: 700;
}
.privacy-hero p {
    font-size: 1.1rem;
}
.privacy-timeline {
    position: relative;
    margin: 60px 0;
    padding: 0 15px;
}
.privacy-timeline::after {
    content: '';
    position: absolute;
    width: 4px;
    background-color: #ddd;
    top: 0;
    bottom: 0;
    left: 50%;
    margin-left: -2px;
}
.timeline-item {
    padding: 20px 40px;
    position: relative;
    width: 50%;
    opacity: 0;
    transform: translateY(40px);
    transition: all 0.6s ease-out;
}
.timeline-item.show {
    opacity: 1;
    transform: translateY(0);
}
.timeline-item.left { left: 0; }
.timeline-item.right { left: 50%; }
.timeline-item::before {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    right: -10px;
    background: #fff;
    border: 4px solid #667eea;
    top: 25px;
    border-radius: 50%;
    z-index: 1;
}
.timeline-item.right::before {
    left: -10px;
    right: auto;
    border-color: #764ba2;
}
.timeline-card {
    background: #fff;
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    transition: 0.3s;
}
.timeline-card:hover {
    transform: translateY(-5px);
}
.timeline-card h5 {
    font-weight: 600;
    margin-bottom: 10px;
    color: #667eea;
}
.timeline-card p,
.timeline-card li {
    color: #6c757d;
}

@media (max-width: 992px) {
    .privacy-timeline::after { left: 20px; }
    .timeline-item {
        width: 100%;
        padding-left: 60px;
        padding-right: 20px;
        margin-bottom: 40px;
    }
    .timeline-item.left,
    .timeline-item.right { left: 0; }
    .timeline-item::before {
        left: 8px;
        right: auto;
    }
}
</style>

<section class="privacy-hero">
    <div class="container">
        <h1>🔐 Security Policy</h1>
        <p class="mt-3">We are committed to protecting your data and maintaining platform security.</p>
        <p class="small mt-2">Last Updated: {{ date('F d, Y') }}</p>
    </div>
</section>

<section class="privacy-timeline">
    <div class="container">

        <div class="timeline-item left">
            <div class="timeline-card">
                <h5>🛡️ Our Security Commitment</h5>
                <p>
                    Quiz App takes the security of user data seriously. We implement
                    industry-standard measures to safeguard personal information
                    and prevent unauthorized access.
                </p>
            </div>
        </div>

        <div class="timeline-item right">
            <div class="timeline-card">
                <h5>🔒 Data Encryption</h5>
                <p>
                    All sensitive data is encrypted during transmission using secure
                    protocols (HTTPS/SSL). We also apply encryption and hashing
                    techniques for stored credentials.
                </p>
            </div>
        </div>

        <div class="timeline-item left">
            <div class="timeline-card">
                <h5>👤 Account Protection</h5>
                <ul>
                    <li>Secure authentication systems</li>
                    <li>Password hashing mechanisms</li>
                    <li>Protection against unauthorized login attempts</li>
                </ul>
            </div>
        </div>

        <div class="timeline-item right">
            <div class="timeline-card">
                <h5>🖥️ System Monitoring</h5>
                <p>
                    We monitor our systems regularly to detect vulnerabilities,
                    unusual activities, and potential security threats.
                </p>
            </div>
        </div>

        <div class="timeline-item left">
            <div class="timeline-card">
                <h5>📂 Data Access Control</h5>
                <p>
                    Access to personal data is restricted to authorized personnel
                    only, based on their role and necessity.
                </p>
            </div>
        </div>

        <div class="timeline-item right">
            <div class="timeline-card">
                <h5>⚠️ Reporting Vulnerabilities</h5>
                <p>
                    If you discover a security vulnerability, please report it
                    immediately to our support team. We appreciate responsible
                    disclosure and will address issues promptly.
                </p>
            </div>
        </div>

        <div class="timeline-item left">
            <div class="timeline-card text-center">
                <h5>📩 Security Contact</h5>
                <p>
                    For security-related concerns, contact us at 
                    <a href="mailto:support@quizapp.com">support@quizapp.com</a>.
                </p>
            </div>
        </div>

    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const items = document.querySelectorAll('.timeline-item');
    function checkScroll() {
        const triggerBottom = window.innerHeight * 0.85;
        items.forEach(item => {
            const itemTop = item.getBoundingClientRect().top;
            if (itemTop < triggerBottom) {
                item.classList.add('show');
            }
        });
    }
    window.addEventListener('scroll', checkScroll);
    checkScroll();
});
</script>

@endsection
