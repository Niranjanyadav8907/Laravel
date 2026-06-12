<!-- CDN Links -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.5/css/perfect-scrollbar.min.css">

<!-- JavaScript CDN Links -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.5/perfect-scrollbar.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<style>
	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	body {
		font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
		color: #333;
		overflow-x: hidden;
	}

	/* Header & Navigation */
	header {
		background: #000;
		padding: 1rem 3rem;
		display: flex;
		justify-content: space-between;
		align-items: center;
		position: sticky;
		top: 0;
		z-index: 1000;
	}

	.logo {
		font-size: 1.5rem;
		font-weight: bold;
		color: #fff;
	}

	/* Desktop Navigation */
	.desktop-nav {
		display: flex;
		gap: 2rem;
		align-items: center;
	}

	.desktop-nav a {
		color: #fff;
		text-decoration: none;
		font-size: 0.95rem;
		transition: color 0.3s;
	}

	.desktop-nav a:hover {
		color: #0066cc;
	}

	.btn-contact {
		background: #0066cc;
		padding: 0.5rem 1.5rem;
		border-radius: 4px;
		color: #fff;
	}

	/* Mobile Navigation */
	.mobile-nav-btn {
		display: none;
		background: none;
		border: none;
		color: white;
		font-size: 1.5rem;
		cursor: pointer;
		padding: 0.5rem;
	}

	.mobile-nav {
		display: none;
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100vh;
		background: rgba(0, 0, 0, 0.95);
		z-index: 2000;
		flex-direction: column;
		justify-content: center;
		align-items: center;
		opacity: 0;
		transform: translateY(-100%);
		transition: all 0.4s ease;
	}

	.mobile-nav.active {
		opacity: 1;
		transform: translateY(0);
	}

	.mobile-nav a {
		color: white;
		text-decoration: none;
		font-size: 1.5rem;
		padding: 0.5rem 2rem;
		transition: all 0.3s;
		text-align: center;
		width: 100%;
	}

	.mobile-nav a:hover {
		color: #0066cc;
		background: rgba(255, 255, 255, 0.1);
	}

	.mobile-nav-close {
		position: absolute;
		top: 2rem;
		right: 2rem;
		background: none;
		border: none;
		color: white;
		font-size: 2rem;
		cursor: pointer;
	}

	/* Hero Section */
	.hero {
		position: relative;
		height: 100vh;
		overflow: hidden;
		display: flex;
		align-items: center;
		justify-content: center;
		color: #fff;
	}

	/* Background Slider Container */
	.hero-slider {
		position: absolute;
		inset: 0;
		z-index: 1;
	}

	/* Individual Slides */
	.hero-slide {
		position: absolute;
		inset: 0;
		background-size: cover;
		background-position: center;
		opacity: 0;
		animation: slideShow 15s infinite;
	}

	.hero-slide:nth-child(1) {
		/*background-image: url("https://plus.unsplash.com/premium_photo-1661505494064-306b2a586412");*/
		background-image: url("/quiz-app/public/assets/images/home_page/quiz_photo.png");
		animation-delay: 0s;
	}

	.hero-slide:nth-child(2) {
		background-image: url("/quiz-app/public/assets/images/home_page/quiz_image.png");
		animation-delay: 5s;
	}

	.hero-slide:nth-child(3) {
		background-image: url("/quiz-app/public/assets/images/home_page/quiz_im.png");
		animation-delay: 10s;
	}

	/* Smooth Fade Animation */
	@keyframes slideShow {
		0% { 
			opacity: 0;
			transform: scale(1);
		}
		5% { 
			opacity: 1;
			transform: scale(1.05);
		}
		33% { 
			opacity: 1;
			transform: scale(1.08);
		}
		38% { 
			opacity: 0;
			transform: scale(1.08);
		}
		100% { 
			opacity: 0;
		}
	}

	/* Dark overlay */
	.hero::after {
		content: "";
		position: absolute;
		inset: 0;
		background: linear-gradient(
			135deg, 
			rgba(0, 0, 0, 0.65) 0%, 
			rgba(0, 0, 0, 0.45) 50%,
			rgba(0, 0, 0, 0.65) 100%
		);
		z-index: 2;
	}

	/* Content above images */
	.hero-content {
		position: relative;
		z-index: 3;
		text-align: center;
		max-width: 700px;
		padding: 0 20px;
		animation: fadeInUp 1s ease-out;
	}

	@keyframes fadeInUp {
		from {
			opacity: 0;
			transform: translateY(30px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}

	.hero-subtitle {
		font-size: 0.9rem;
		letter-spacing: 3px;
		font-weight: 600;
		color: #0066cc;
		margin-bottom: 1rem;
		text-transform: uppercase;
	}

	.hero-content h1 {
		font-size: 3.5rem;
		font-weight: 700;
		margin-bottom: 1.5rem;
		line-height: 1.2;
		text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
	}

	.hero-content p {
		font-size: 1.3rem;
		margin-bottom: 2.5rem;
		color: #f0f0f0;
		text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
	}

	.btn-primary {
		background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
		color: #fff;
		padding: 16px 45px;
		border: none;
		border-radius: 50px;
		font-size: 1.1rem;
		font-weight: 600;
		cursor: pointer;
		transition: all 0.3s ease;
		box-shadow: 0 5px 15px rgba(0, 102, 204, 0.3);
	}

	.btn-primary:hover {
		background: linear-gradient(135deg, #0052a3 0%, #0066cc 100%);
		transform: translateY(-3px);
		box-shadow: 0 10px 30px rgba(0, 102, 204, 0.5);
	}

	.btn-primary:active {
		transform: translateY(-1px);
	}

	/* Regions Section */
	.regions {
		padding: 5rem 3rem;
		background: #f5f5f5;
	}

	.section-title {
		font-size: 2rem;
		margin-bottom: 3rem;
		text-align: center;
	}

	.regions-grid {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
		gap: 1rem;
		max-width: 1400px;
		margin: 0 auto;
	}

	.region-card {
		background: #fff;
		border-radius: 15px;
		overflow: hidden;
		cursor: pointer;
		transition: transform 0.3s;
		box-shadow: 0 4px 15px rgba(0,0,0,0.1);
	}

	.region-card:hover {
		transform: translateY(-5px);
	}

	.region-image {
		width: 100%;
		height: 200px;
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 3rem;
	}

	.region-name {
		padding: 1.5rem;
		text-align: center;
		font-size: 1.2rem;
		font-weight: 600;
	}

	/* About Section */
	.about {
		padding: 5rem 3rem;
		background: #fff;
	}

	.about-content {
		max-width: 1200px;
		margin: 0 auto;
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 4rem;
		align-items: center;
	}

	.about-text h2 {
		font-size: 2.5rem;
		margin-bottom: 2rem;
		line-height: 1.3;
	}

	.about-text p {
		font-size: 1.1rem;
		line-height: 1.8;
		color: #666;
		margin-bottom: 1.5rem;
	}

	.about-logo {
		text-align: center;
		font-size: 4rem;
		font-weight: bold;
	}

	/* Quote Section */
	.quote-section {
		padding: 5rem 3rem;
		background: #f9f9f9;
	}

	.quote-container {
		max-width: 1200px;
		margin: 0 auto;
		display: flex;
		gap: 3rem;
		align-items: center;
	}

	.quote-author {
		text-align: center;
	}

	.quote-author img {
		width: 150px;
		height: 150px;
		border-radius: 50%;
		margin-bottom: 1rem;
	}

	.quote-author h3 {
		font-size: 1.5rem;
		color: #0066cc;
		margin-bottom: 0.5rem;
	}

	.quote-author p {
		font-size: 0.9rem;
		color: #666;
	}

	.quote-text {
		flex: 1;
		font-size: 1.2rem;
		line-height: 1.8;
		color: #333;
		position: relative;
		padding-left: 3rem;
	}

	.quote-text::before {
		content: '"';
		position: absolute;
		left: 0;
		top: -20px;
		font-size: 5rem;
		color: #0066cc;
		opacity: 0.3;
	}

	/* Sample Quiz Section */
	.sample-quiz {
		padding: 5rem 3rem;
		background: #000;
		color: #fff;
	}

	.quiz-container {
		max-width: 800px;
		margin: 0 auto;
	}

	.quiz-header {
		text-align: center;
		margin-bottom: 3rem;
	}

	.quiz-number {
		float: right;
		font-size: 1rem;
	}

	.question {
		margin-bottom: 2rem;
	}

	.question h3 {
		font-size: 1.5rem;
		margin-bottom: 2rem;
	}

	.options {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 1rem;
	}

	.option {
		background: #1a1a1a;
		padding: 1rem;
		border-radius: 8px;
		cursor: pointer;
		transition: background 0.3s;
		display: flex;
		align-items: center;
		gap: 0.5rem;
	}

	.option:hover {
		background: #2a2a2a;
	}

	.option input {
		width: 20px;
		height: 20px;
	}

	/* Quiz Masters */
	.quiz-masters {
		padding: 5rem 3rem;
		background: #fff;
	}

	.masters-grid {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
		gap: 3rem;
		max-width: 1200px;
		margin: 3rem auto 0;
	}

	.master-card {
		text-align: center;
	}

	.master-image {
		width: 200px;
		height: 200px;
		border-radius: 50%;
		margin: 0 auto 1.5rem;
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	}

	.master-name {
		font-size: 1.5rem;
		color: #0066cc;
		margin-bottom: 0.5rem;
	}

	.master-title {
		font-size: 0.9rem;
		font-weight: bold;
		margin-bottom: 1rem;
	}

	.master-bio {
		font-size: 1rem;
		color: #666;
		line-height: 1.6;
	}
	
	/* Expertise Cloud */
	.expertise-cloud {
		margin-top: 4rem;
		padding: 3rem;
		background: #fff;
		border-radius: 20px;
		box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
	}

	.tags-container {
		display: flex;
		flex-wrap: wrap;
		justify-content: center;
		gap: 1rem;
		max-width: 1000px;
		margin: 0 auto;
	}

	.expertise-tag {
		display: inline-block;
		padding: 0.8rem 1.5rem;
		background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
		border-radius: 50px;
		font-size: 0.85rem;
		font-weight: 600;
		color: #333;
		letter-spacing: 1px;
		transition: all 0.3s ease;
		cursor: default;
	}

	.expertise-tag:hover {
		background: linear-gradient(135deg, #0066cc 0%, #0052a3 100%);
		color: #fff;
		transform: translateY(-3px);
		box-shadow: 0 5px 15px rgba(0, 102, 204, 0.3);
	}

	/* Snapshots Section */
	.snapshots {
		padding: 5rem 3rem;
		background: #f5f5f5;
	}

	.snapshots-grid {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
		gap: 2rem;
		max-width: 1400px;
		margin: 3rem auto 0;
	}

	.snapshot-card {
		background: #fff;
		border-radius: 15px;
		overflow: hidden;
		box-shadow: 0 4px 15px rgba(0,0,0,0.1);
	}

	.snapshot-image {
		width: 100%;
		height: 300px;
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	}

	.snapshot-info {
		padding: 2rem;
	}

	.snapshot-info h3 {
		font-size: 1.8rem;
		margin-bottom: 1rem;
	}

	.snapshot-info p {
		color: #666;
		line-height: 1.6;
	}

	/* Social Section */
	.social {
		padding: 5rem 3rem;
		background: #000;
		color: #fff;
	}

	.social-title {
		font-size: 0.9rem;
		letter-spacing: 2px;
		margin-bottom: 1rem;
	}

	.social h2 {
		font-size: 2.5rem;
		margin-bottom: 3rem;
	}

	.social-links {
		display: flex;
		gap: 3rem;
		flex-wrap: wrap;
	}

	.social-link {
		display: flex;
		align-items: center;
		gap: 1rem;
		font-size: 1.2rem;
		color: #fff;
		text-decoration: none;
	}

	.social-icon {
		font-size: 2rem;
	}

	/* Footer */
	footer {
		background: #000;
		color: #fff;
		padding: 2rem 3rem;
		border-top: 1px solid #333;
	}

	.footer-content {
		display: flex;
		justify-content: space-between;
		align-items: center;
		flex-wrap: wrap;
		gap: 1rem;
	}

	.footer-links {
		display: flex;
		gap: 2rem;
		flex-wrap: wrap;
	}

	.footer-links a {
		color: #fff;
		text-decoration: none;
		font-size: 0.9rem;
	}

	/* Responsive Styles */
	@media (max-width: 1024px) {
		.hero-content h1 {
			font-size: 2.8rem;
		}
		
		.about-content {
			gap: 2rem;
		}
	}

	@media (max-width: 768px) {
		header {
			padding: 1rem 2rem;
		}

		.logo {
			font-size: 1.2rem;
		}

		/* Hide desktop nav on mobile */
		.desktop-nav {
			display: none;
		}

		/* Show mobile menu button */
		.mobile-nav-btn {
			display: block;
		}

		/* Mobile navigation styles */
		.mobile-nav {
			display: flex;
		}

		.hero {
			height: 80vh;
		}

		.hero-content h1 {
			font-size: 2.2rem;
		}

		.hero-content p {
			font-size: 1.1rem;
		}

		.btn-primary {
			padding: 14px 35px;
			font-size: 1rem;
		}

		.regions,
		.about,
		.quote-section,
		.sample-quiz,
		.quiz-masters,
		.snapshots,
		.social {
			padding: 3rem 1.5rem;
		}

		.about-content {
			grid-template-columns: 1fr;
			gap: 2rem;
		}

		.about-text h2 {
			font-size: 2rem;
		}

		.quote-container {
			flex-direction: column;
			text-align: center;
		}

		.quote-text {
			padding-left: 0;
			padding-top: 2rem;
		}

		.quote-text::before {
			left: 50%;
			transform: translateX(-50%);
			top: 0;
		}

		.options {
			grid-template-columns: 1fr;
		}

		.masters-grid {
			grid-template-columns: 1fr;
		}

		.snapshots-grid {
			grid-template-columns: 1fr;
		}

		.social-links {
			flex-direction: column;
			gap: 2rem;
		}

		.footer-content {
			flex-direction: column;
			text-align: center;
			gap: 1.5rem;
		}

		.footer-links {
			justify-content: center;
		}
	}

	@media (max-width: 480px) {
		header {
			padding: 0.8rem 1rem;
		}

		.logo {
			font-size: 1rem;
		}

		.hero-content h1 {
			font-size: 1.8rem;
		}

		.hero-content p {
			font-size: 1rem;
		}

		.section-title {
			font-size: 1.5rem;
		}

		.regions-grid {
			grid-template-columns: 1fr;
		}

		.social h2 {
			font-size: 2rem;
		}

		.footer-links {
			flex-direction: column;
			gap: 0.5rem;
		}
	}

	/* Prevent scrolling when mobile menu is open */
	body.no-scroll {
		overflow: hidden;
	}
	
	
	/* Gradient Text with Continuous Shine */
	.section-title {
		font-family: 'Poppins', sans-serif;
		font-size: 2rem;
		font-weight: 700;
		background: linear-gradient(270deg, #f7971e, #ffd200, #f857a6, #e91e77, #f7971e);
		background-size: 800% 800%; /* Large size for smooth movement */
		-webkit-background-clip: text;
		-webkit-text-fill-color: transparent;
		animation: shineGradient 6s ease infinite;
		position: relative;
		transition: transform 0.3s ease;
	}

	@keyframes shineGradient {
		0% { background-position: 0% 50%; }
		50% { background-position: 100% 50%; }
		100% { background-position: 0% 50%; }
	}

	.section-title:hover {
		transform: scale(1.05);
	}

	/* Refresh link styling */
	.small-box-footer {
		display: inline-flex;
		align-items: center;
		margin-left: 15px;
		font-size: 0.9rem;
		font-weight: 500;
		color: #e91e77;
		text-decoration: none;
		transition: all 0.3s ease;
	}

	.small-box-footer:hover {
		color: #f857a6;
	}

	.small-box-footer i {
		margin-left: 5px;
		animation: bounce 2s infinite;
	}

	/* Bounce animation for icon */
	@keyframes bounce {
		0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
		40% { transform: translateY(-6px); }
		60% { transform: translateY(-3px); }
	}

	.desktop-nav {
		display: flex;
	}

	.mobile-nav-btn,
	.mobile-nav {
		display: none;
	}

	/* Mobile view */
	@media (max-width: 768px) {
		.desktop-nav {
			display: none;
		}

		.mobile-nav-btn {
			display: block;
		}
	}



	.mobile-nav {
		position: fixed;
		top: 0;
		right: -100%;
		width: 85%;
		height: 100%;
		background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
		color: #fff;
		z-index: 9999;
		padding: 20px;
		transition: 0.4s ease-in-out;
		box-shadow: -10px 0 30px rgba(0,0,0,0.4);
	}

	.mobile-nav.active {
		right: 0;
	}

	/* Header */
	.mobile-nav-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 30px;
	}

	.mobile-nav-header .logo {
		font-size: 22px;
		font-weight: bold;
	}

	/* Close Button */
	.mobile-nav-close {
		background: none;
		border: none;
		font-size: 22px;
		color: #fff;
		cursor: pointer;
	}

	/* Menu */
	.mobile-nav-menu {
		display: flex;
		flex-direction: column;
		gap: 18px;
	}

	.mobile-nav-link {
		display: flex;
		align-items: center;
		gap: 12px;
		padding: 14px 18px;
		border-radius: 10px;
		color: #fff;
		text-decoration: none;
		font-size: 16px;
		background: rgba(255,255,255,0.08);
		transition: all 0.3s ease;
	}

	.mobile-nav-link:hover {
		background: rgba(255,255,255,0.18);
		transform: translateX(6px);
	}

	/* Footer Buttons */
	.mobile-nav-footer {
		position: absolute;
		bottom: 30px;
		left: 20px;
		right: 20px;
	}

	.btn-primary,
	.btn-danger {
		display: block;
		text-align: center;
		padding: 14px;
		border-radius: 12px;
		font-weight: 600;
		text-decoration: none;
		color: #fff;
	}

	.btn-primary {
		background: linear-gradient(135deg, #00c6ff, #0072ff);
	}

	.btn-danger {
		background: linear-gradient(135deg, #ff416c, #ff4b2b);
	}



	.ultra-btn {
		position: relative;
		padding: 14px 42px;
		font-size: 17px;
		font-weight: 700;
		color: #fff;
		background: linear-gradient(135deg, #e91e77, #ff5fa2, #ff8ac8);
		border: none;
		border-radius: 40px;
		cursor: pointer;
		overflow: hidden;
		letter-spacing: 0.5px;
		box-shadow: 0 10px 25px rgba(233,30,119,0.45);
		transition: all 0.4s ease;
		animation: floatBtn 3s ease-in-out infinite;
	}

	@keyframes floatBtn {
		0% { transform: translateY(0); }
		50% { transform: translateY(-6px); }
		100% { transform: translateY(0); }
	}

	.ultra-btn::before {
		content: "";
		position: absolute;
		inset: -2px;
		background: linear-gradient(
			45deg,
			#ff007a,
			#ff6ec7,
			#ffc1e3,
			#ff007a
		);
		border-radius: 42px;
		z-index: 0;
		filter: blur(8px);
		opacity: 0.8;
		animation: glowRotate 4s linear infinite;
	}

	@keyframes glowRotate {
		0% { filter: blur(8px) hue-rotate(0deg); }
		100% { filter: blur(8px) hue-rotate(360deg); }
	}

	.ultra-btn::after {
		content: "";
		position: absolute;
		top: -50%;
		left: -75%;
		width: 50%;
		height: 200%;
		background: linear-gradient(
			120deg,
			transparent,
			rgba(255,255,255,0.8),
			transparent
		);
		transform: rotate(25deg);
		animation: shine 3s infinite;
	}

	@keyframes shine {
		0% { left: -75%; }
		60% { left: 120%; }
		100% { left: 120%; }
	}

	.ultra-btn span {
		position: relative;
		z-index: 2;
		text-shadow: 0 0 5px rgba(0,0,0,0.6), 0 0 10px rgba(0,0,0,0.3);
		background: rgba(0,0,0,0.05); 
		padding: 0 6px; 
		border-radius: 6px;
	}

	.ultra-btn:hover {
		transform: scale(1.08);
		box-shadow: 0 15px 40px rgba(233,30,119,0.65),
					0 0 30px rgba(255,140,200,0.8);
	}

	.ultra-btn:active {
		transform: scale(0.95);
	}

	@media (max-width: 768px) {
		.ultra-btn {
			animation: none;
		}
	}

	.quiz-header {
		margin-top: 30px;
		margin-bottom: 30px;
	}
	.quiz-card {
		background: #ffffff;
		border-radius: 12px;
		box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
		overflow: hidden;
		padding: 20px;
	}
	.quiz-info {
		margin-top: 15px;
	}
	.quiz-info .btn {
		width: 100%;
	}
	.quiz-stats {
		display: flex;
		gap: 15px;
		margin-top: 15px;
	}
	.quiz-stat {
		background: #495057;
		color: #fff;
		padding: 15px;
		border-radius: 8px;
		text-align: center;
		flex: 1;
	}
	.about-quiz {
		margin-top: 40px;
		background: #fff;
		padding: 20px;
		border-radius: 12px;
		box-shadow: 0px 4px 12px rgba(0,0,0,0.05);
	}
	
	
	
	.quiz_question_header {
		font-size: 22px;
		font-weight: 600;
		color: #8b0033;
	}
	.question_box {
		background: #fff;
		border-radius: 6px;
		padding: 20px;
		min-height: 350px;
	}
	.question_timer {
		color: red;
		font-weight: bold;
	}
	.skip_atampt {
		color: red;
		font-weight: bold;
	}
	.question_number {
		width: 35px;
		height: 35px;
		border: 1px solid #ccc;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		margin: 4px;
		cursor: pointer;
	}
	.question_number.active {
		background: #e91e77;
		color: #fff;
	}
	.legend span {
		margin-right: 15px;
		font-size: 14px;
	}
	.answered_question {
		color: #0d6efd;
	}
	.skipped_question {
		color: orange;
	}


	.question_timer { 
		font-size: 18px;
		margin-bottom: 10px;
	}
	
	.skip_atampt { 
		font-size: 18px;
		margin-bottom: 10px;
	}

	.timer_progress_container {
		width: 100%;
		height: 5px;
		background: #e0e0e0;
		border-radius: 10px;
		overflow: hidden;
	}

	.timer_progress_bar {
		height: 100%;
		width: 0%;
		background: green;
		transition: width 1s linear, background 1s linear;
		border-radius: 10px;
	}
	
	.question_actions .btn{
		padding: 8px 18px;   
		line-height: 1.5;
	}
	
	.hero-slide {
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
		image-rendering: -webkit-optimize-contrast;
    }
	
	.hero::after {
		background: linear-gradient(
			135deg, 
			rgba(0, 0, 0, 0.4) 0%,   /* reduce */
			rgba(0, 0, 0, 0.2) 50%, 
			rgba(0, 0, 0, 0.4) 100%
    );
}

</style>