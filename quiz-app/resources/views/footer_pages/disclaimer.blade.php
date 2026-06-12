@extends('layouts.user')

@section('title', 'Disclaimer')
@section('page-title', 'Disclaimer')
@section('breadcrumb', 'Disclaimer')

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
        <h1>⚠️ Disclaimer</h1>
        <p class="mt-3">Please read this disclaimer carefully before using our Quiz App.</p>
        <p class="small mt-2">Last Updated: {{ date('F d, Y') }}</p>
    </div>
</section>
<section class="privacy-timeline">
    <div class="container">
        <div class="timeline-item left">
            <div class="timeline-card">
                <h5>📘 General Information</h5>
                <p>
                    The information provided by Quiz App is for general educational and entertainment
                    purposes only. While we strive to ensure accuracy, we make no guarantees regarding
                    the completeness or reliability of any content.
                </p>
            </div>
        </div>
        <div class="timeline-item right">
            <div class="timeline-card">
                <h5>🎯 No Professional Advice</h5>
                <p>
                    The content available on this platform does not constitute professional,
                    legal, financial, or educational advice. Users should seek appropriate
                    professional guidance where necessary.
                </p>
            </div>
        </div>
        <div class="timeline-item left">
            <div class="timeline-card">
                <h5>⚙️ Platform Availability</h5>
                <p>
                    We do not guarantee uninterrupted access to the Quiz App. Technical
                    issues, maintenance, or unforeseen circumstances may temporarily
                    affect availability.
                </p>
            </div>
        </div>
        <div class="timeline-item right">
            <div class="timeline-card">
                <h5>🔗 External Links</h5>
                <p>
                    Our platform may contain links to third-party websites. We are not
                    responsible for the content, privacy practices, or accuracy of
                    information on external sites.
                </p>
            </div>
        </div>
        <div class="timeline-item left">
            <div class="timeline-card">
                <h5>🏆 Quiz Results & Scores</h5>
                <p>
                    Quiz scores and rankings are calculated automatically based on user
                    responses. We are not liable for any misunderstandings or decisions
                    made based on quiz results.
                </p>
            </div>
        </div>
        <div class="timeline-item right">
            <div class="timeline-card">
                <h5>⚖️ Limitation of Liability</h5>
                <p>
                    Quiz App shall not be held liable for any direct, indirect,
                    incidental, or consequential damages resulting from the use
                    of our platform.
                </p>
            </div>
        </div>
        <div class="timeline-item left">
            <div class="timeline-card text-center">
                <h5>📩 Contact Us</h5>
                <p>
                    If you have any questions regarding this Disclaimer,
                    please contact us at 
                    <a href="mailto:anilkumar856111@gmail.com">support@quizapp.com</a>.
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
