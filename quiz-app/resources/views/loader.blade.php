<style>
.loader-overlay {
    position: fixed;
    inset: 0;
    background: linear-gradient(135deg, rgba(15,32,39,0.5), rgba(32,58,67,0.5), rgba(44,83,100,0.5));
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}
.loader-card {
    width: 260px;
    padding: 35px 25px;
    border-radius: 18px;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(12px);
    box-shadow: 0 25px 60px rgba(0,0,0,0.4);
    text-align: center;
}
.loader-ring {
    position: relative;
    width: 90px;
    height: 90px;
    margin: 0 auto 20px;
}
.loader-ring span {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    border: 4px solid transparent;
    border-top: 4px solid #00f2fe;
    border-right: 4px solid #4facfe;
    animation: loader-spin 1.2s linear infinite;
}
.loader-ring span:nth-child(2) {
    inset: 10px;
    border-top-color: #43e97b;
    border-right-color: #38f9d7;
    animation-duration: .9s;
}
.loader-ring span:nth-child(3) {
    inset: 20px;
    border-top-color: #fa709a;
    border-right-color: #fee140;
    animation-duration: .6s;
}
.loader-dots {
    display: flex;
    justify-content: center;
    margin-top: 15px;
}
.loader-dot {
    width: 8px;
    height: 8px;
    margin: 0 4px;
    background: #fff;
    border-radius: 50%;
    animation: loader-bounce 1.4s infinite ease-in-out both;
}

.loader-dot:nth-child(1){animation-delay:-0.32s}
.loader-dot:nth-child(2){animation-delay:-0.16s}
.loader-text {
	text-align: center;
    margin-top: 18px;
    color: #fff;
    font-size: 16px;
    letter-spacing: .5px;
}
@keyframes loader-spin {
    to { transform: rotate(360deg); }
}

@keyframes loader-bounce {
    0%,80%,100% { transform: scale(0); }
    40% { transform: scale(1); }
}
.loader-btn {
    margin: 15px;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    background: #4facfe;
    color: #fff;
    cursor: pointer;
}
</style>
</head>
<body>

<div class="loader-overlay">
    <div class="loader">
        <div class="loader-ring">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="loader-dots">
            <div class="loader-dot"></div>
            <div class="loader-dot"></div>
            <div class="loader-dot"></div>
        </div>

        <div class="loader-text">Processing your request</div>
    </div>
</div>

<script>
function showLoader(){
    $('.loader-overlay').fadeIn(300);
}

function hideLoader(){
    $('.loader-overlay').fadeOut(300);
}
</script>

</body>
</html>
