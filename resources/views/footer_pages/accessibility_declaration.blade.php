@extends('layouts.user')

@section('title', 'Accessibility Declaration')
@section('page-title', 'Accessibility Declaration')
@section('breadcrumb', 'Accessibility Declaration')

@section('content')

<style>
/* Same CSS as Privacy Page */
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
        <h1>♿ Accessibility Declaration</h1>
        <p class="mt-3">We are committed to making our Quiz App accessible to everyone.</p>
        <p class="small mt-2">Last Updated: {{ date('F d, Y') }}</p>
    </div>
</section>

<section class="privacy-timeline">
    <div class="container">

        <div class="timeline-item left">
            <div class="timeline-card">
                <h5>🌍 Our Commitment</h5>
                <p>
                    Quiz App is dedicated to ensuring digital accessibility for all users,
                    including people with disabilities. We continuously improve the user
                    experience and apply relevant accessibility standards.
                </p>
            </div>
        </div>

        <div class="timeline-item right">
            <div class="timeline-card">
                <h5>📋 Accessibility Standards</h5>
                <p>
                    We strive to follow the Web Content Accessibility Guidelines (WCAG)
                    to ensure our platform is perceivable, operable, understandable,
                    and robust for all users.
                </p>
            </div>
        </div>

        <div class="timeline-item left">
            <div class="timeline-card">
                <h5>⌨️ Keyboard Navigation</h5>
                <ul>
                    <li>Full keyboard navigation support</li>
                    <li>Visible focus indicators</li>
                    <li>Accessible quiz interaction without mouse</li>
                </ul>
            </div>
        </div>

        <div class="timeline-item right">
            <div class="timeline-card">
                <h5>🎨 Visual Accessibility</h5>
                <ul>
                    <li>High contrast design elements</li>
                    <li>Readable font sizes</li>
                    <li>Responsive layout for all devices</li>
                </ul>
            </div>
        </div>

        <div class="timeline-item left">
            <div class="timeline-card">
                <h5>🔊 Screen Reader Support</h5>
                <p>
                    Our platform is structured using semantic HTML and proper labels
                    to ensure compatibility with screen readers and assistive technologies.
                </p>
            </div>
        </div>

        <div class="timeline-item right">
            <div class="timeline-card">
                <h5>⚙️ Ongoing Improvements</h5>
                <p>
                    Accessibility is an ongoing effort. We regularly test and update
                    our platform to enhance accessibility features and remove barriers.
                </p>
            </div>
        </div>

        <div class="timeline-item left">
            <div class="timeline-card text-center">
                <h5>📩 Feedback & Contact</h5>
                <p>
                    If you encounter any accessibility barriers while using Quiz App,
                    please contact us at 
                    <a href="mailto:anilkumar856111@gmail.com">support@quizapp.com</a>.
                    We value your feedback and will work to improve accessibility.
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
