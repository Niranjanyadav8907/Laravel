@extends('layouts.user')

@section('title', 'Terms and Conditions')
@section('page-title', 'Terms and Conditions')
@section('breadcrumb', 'Terms and Conditions')

@section('content')

<style>
.hero-terms {
    background: linear-gradient(135deg, #4e73df, #1cc88a);
    color: #fff;
    padding: 80px 20px;
    text-align: center;
    border-radius: 0 0 60px 60px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.hero-terms h1 {
    font-size: 2.5rem;
    font-weight: 700;
}
.hero-terms p.lead {
    font-size: 1.1rem;
}
.timeline {
    position: relative;
    margin: 60px 0;
    padding: 0 15px;
}
.timeline::after {
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
.timeline-item.left {
    left: 0;
}
.timeline-item.right {
    left: 50%;
}
.timeline-item::before {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    right: -10px;
    background-color: #fff;
    border: 4px solid #ff512f;
    top: 25px;
    border-radius: 50%;
    z-index: 1;
}
.timeline-item.right::before {
    left: -10px;
    right: auto;
    border-color: #1cc88a;
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
    color: #ff512f;
}
.timeline-card p {
    color: #6c757d;
    margin: 0;
}
@media (max-width: 992px) {
    .timeline::after {
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
    .hero-terms {
        padding: 60px 15px;
        border-radius: 0 0 30px 30px;
    }
    .hero-terms h1 {
        font-size: 1.8rem;
    }
    .hero-terms p.lead {
        font-size: 0.95rem;
    }
    .timeline::after {
        left: 15px;
    }
    .timeline-item {
        padding-left: 50px;
        padding-right: 10px;
    }
    .timeline-card {
        padding: 15px;
    }
    .timeline-card h5 {
        font-size: 1rem;
    }
    .timeline-card p {
        font-size: 0.9rem;
    }
}
</style>

<section class="hero-terms">
    <div class="container">
        <h1>📜 Terms & Conditions</h1>
        <p class="lead mt-3">Please read these rules carefully before participating in quizzes.</p>
        <p class="small mt-2">Last Updated: {{ date('F d, Y') }}</p>
    </div>
</section>
<section class="timeline">
    <div class="container">
        <div class="timeline-item left">
            <div class="timeline-card">
                <h5>📘 Introduction</h5>
                <p>Welcome to [Quiz App], an online quiz platform designed to provide interactive learning and competitive quiz experiences. These Terms & Conditions govern your access to and use of our quiz application, website, and related services.</p>
            </div>
        </div>
        <div class="timeline-item right">
            <div class="timeline-card">
                <h5>👤 User Eligibility</h5>
                <p> To use our quiz application, you must be at least 13 years old. Users under the age of 18 may use the platform only with parental or legal guardian consent. </p>
            </div>
        </div>
        <div class="timeline-item left">
            <div class="timeline-card">
                <h5>🔑 Account Responsibility</h5>
                <p> You are responsible for maintaining the confidentiality of your login credentials. All activities conducted through your account are your responsibility. </p>
            </div>
        </div>
        <div class="timeline-item right">
            <div class="timeline-card">
                <h5>📝 Use of Content</h5>
                <p> All quizzes, questions, content, and materials available on this platform are protected by copyright and intellectual property laws. Unauthorized copying, distribution, modification, or commercial use of any content is strictly prohibited. </p>
            </div>
        </div>
        <div class="timeline-item left">
            <div class="timeline-card">
                <h5>⚠️ User Conduct</h5>
                <p> Users must not engage in cheating, hacking, spamming, or abusive behavior while using the quiz platform. Any violation of these rules may result in account suspension or permanent termination. </p>
            </div>
        </div>
        <div class="timeline-item right">
            <div class="timeline-card">
                <h5>🔒 Privacy & Data</h5>
                <p> We collect only the minimum personal information necessary to operate our quiz platform. For detailed information about how we collect, use, and protect your data, please review our Privacy Policy. </p>
            </div>
        </div>
        <div class="timeline-item left">
            <div class="timeline-card">
                <h5>⚖️ Limitation of Liability</h5>
                <p> We are not liable for any direct, indirect, incidental, or consequential damages arising from the use of our quiz application. Your participation and use of the platform are at your own risk. </p>
            </div>
        </div>
    </div>
</section>

<script>
const items = document.querySelectorAll('.timeline-item');

function checkScroll() {
    const triggerBottom = window.innerHeight / 1.2;

    items.forEach(item => {
        const itemTop = item.getBoundingClientRect().top;

        if(itemTop < triggerBottom) {
            item.classList.add('show');
        }
    });
}

window.addEventListener('scroll', checkScroll);
window.addEventListener('load', checkScroll);
</script>

@endsection
