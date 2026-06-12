<style>
    #toaster-container {
		visibility: hidden;
		min-width: 250px;
		color: #fff;
		text-align: left;
		border-radius: 5px;
		padding: 16px 20px;
		position: fixed;
		z-index: 9999;
		top: 20px;         
		right: 20px;       
		font-size: 17px;
		opacity: 0;
		transition: opacity 0.5s, visibility 0.5s;
		display: flex;
		align-items: center;
		gap: 10px;
	}

    #toaster-container.toaster-show {
        visibility: visible;
        opacity: 1;
    }

    #toaster-container.success { background-color: #4CAF50; }
    #toaster-container.error { background-color: #f44336; }
    #toaster-container.warning { background-color: #ff9800; }

    .toaster-icon {
        font-weight: bold;
        font-size: 20px;
    }

    .toaster-button {
        padding: 10px 20px;
        margin: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .toaster-open-btn {
        background-color: #4CAF50;
        color: white;
        border: none;
    }

    .toaster-close-btn {
        background-color: #f44336;
        color: white;
        border: none;
    }
</style>
</head>
<body>

<div id="toaster-container">
    <span class="toaster-icon"></span>
    <span class="toaster-message"></span>
</div>

<script>
$(document).ready(function() {
    let toasterTimeout;

    window.showToaster = function(type = 'success', message = '', duration = 3000) {
        const $toaster = $("#toaster-container");
        const $icon = $toaster.find(".toaster-icon");
        const $msg = $toaster.find(".toaster-message");

        $toaster.removeClass("success error warning").addClass(type);

        let icon = '';
        if(type === 'success') icon = '✔️';
        else if(type === 'error') icon = '❌';
        else if(type === 'warning') icon = '⚠️';

        $icon.text(icon);
        $msg.text(message);
        $toaster.addClass("toaster-show");
        clearTimeout(toasterTimeout);
        toasterTimeout = setTimeout(hideToaster, duration);
    };

    window.hideToaster = function() {
        const $toaster = $("#toaster-container");
        $toaster.removeClass("toaster-show success error warning");
        clearTimeout(toasterTimeout); 
    };

    $(".toaster-open-btn").click(function() {
        showToaster('success', 'Ye message success type ka hai!');
    });

    $(".toaster-close-btn").click(function() {
        hideToaster();
    });
});

</script>
