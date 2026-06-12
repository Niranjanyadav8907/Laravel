@extends('layouts.user')

@section('title', 'Privacy Notice')
@section('page-title', 'Privacy Notice')
@section('breadcrumb', 'Privacy Notice')

@section('content')

<style>
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
    .privacy-timeline::after {
        left: 20px;
    }
    .timeline-item {
        width: 100%;
        padding-left: 60px;
        padding-right: 20px;
        margin-bottom: 40px;
    }
    .timeline-item.left,
    .timeline-item.right {
        left: 0;
    }
    .timeline-item::before {
        left: 8px;
        right: auto;
    }
}

@media (max-width: 576px) {
    .privacy-hero {
        padding: 60px 15px;
        border-radius: 0 0 30px 30px;
    }
    .privacy-hero h1 {
        font-size: 1.8rem;
    }
    .privacy-hero p {
        font-size: 0.95rem;
    }
    .timeline-card {
        padding: 15px;
    }
    .timeline-card h5 {
        font-size: 1rem;
    }
    .timeline-card p,
    .timeline-card li {
        font-size: 0.9rem;
    }
}

</style>

<section class="privacy-hero">
    <div class="container">
        <h1>🔒 Privacy Notice</h1>
        <p class="mt-3">We respect your privacy and are committed to protecting your personal data.</p>
        <p class="small mt-2">Last Updated: {{ date('F d, Y') }}</p>
    </div>
</section>
<section class="privacy-timeline">
    <div class="container">
        <div class="timeline-item left">
            <div class="timeline-card">
                <h5>📘 Introduction</h5>
                <p>Welcome to [Quiz App], an interactive online quiz platform designed to provide engaging and educational experiences. Your privacy is very important to us. This Privacy Notice explains how we collect, use, store, and protect your personal information when you use our quiz application, website, or related services..</p>
            </div>
        </div>
        <div class="timeline-item right">
            <div class="timeline-card">
                <h5>📊 Information We Collect</h5>
                <ul>
                    <li><strong>Name & Email:</strong> For account creation and communication.</li>
                    <li><strong>Phone Number:</strong> For verification and important updates.</li>
                    <li><strong>Quiz Scores:</strong> To track performance and display leaderboards.</li>
                    <li><strong>Usage Data:</strong> To improve platform performance and user experience.</li>
                </ul>
            </div>
        </div>
        <div class="timeline-item left">
            <div class="timeline-card">
                <h5>⚙️ How We Use Your Data</h5>
                <ul>
                    <li>To manage and maintain your account</li>
                    <li>To calculate quiz scores and leaderboard rankings</li>
                    <li>To improve platform performance and user experience</li>
                    <li>To send important updates and notifications</li>
                </ul>
            </div>
        </div>
        <div class="timeline-item right">
            <div class="timeline-card">
                <h5>🛡️ Data Security</h5>
                <p>We use appropriate technical and organizational security measures to protect your personal information from unauthorized access, misuse, alteration, or disclosure.</p>
            </div>
        </div>
        <div class="timeline-item left">
            <div class="timeline-card">
                <h5>🌐 Third-Party Services</h5>
                <p>We may use trusted third-party service providers for analytics, payment processing, and platform improvement. These providers only access data necessary to perform their services and are required to maintain data confidentiality. </p>
            </div>
        </div>
        <div class="timeline-item right">
            <div class="timeline-card">
                <h5>✅ Your Rights</h5>
                <ul>
                    <li>Access and review your personal data</li>
                    <li>Request corrections to inaccurate information</li>
                    <li>Request deletion of your data, subject to applicable laws</li>
                </ul>
            </div>
        </div>
        <div class="timeline-item left">
            <div class="timeline-card text-center">
                <h5>📩 Contact Us</h5>
                <p>If you have any questions about this Privacy Notice or how your data is handled, please contact us at <a href="mailto:anilkumar856111@gmail.com">support@quizapp.com</a>. </p>
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
