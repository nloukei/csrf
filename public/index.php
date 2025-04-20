<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
// End of PHP code - do not put HTML content directly here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSRF Attack Demonstration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            padding: 40px 0;
        }
        .header {
            background-color: #343a40;
            color: white;
            padding: 30px 0;
            margin-bottom: 40px;
            border-radius: 10px;
        }
        .card {
            box-shadow: 0 6px 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
            cursor: pointer;
            height: 100%;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .card-header {
            font-weight: bold;
        }
        .card-img-container {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 15px;
            text-align: center;
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-img-container i {
            font-size: 60px;
        }
        .bank-icon {
            color: #0d6efd;
        }
        .attack-icon {
            color: #dc3545;
        }
        .secure-icon {
            color: #198754;
        }
        .footer {
            margin-top: 40px;
            padding: 20px 0;
            color: #6c757d;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">
        <div class="header text-center">
            <h1><i class="bi bi-shield-exclamation"></i> CSRF Attack Demonstration</h1>
            <p class="lead">A practical example of Cross-Site Request Forgery vulnerabilities and protections</p>
        </div>
        
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-info">
                    <h4 class="alert-heading">How to use this demonstration:</h4>
                    <ol>
                        <li>First, visit the "Vulnerable Bank Website" to see how a typical banking application works.</li>
                        <li>Next, visit the "Attacker's Website" which contains a CSRF payload targeting the bank.</li>
                        <li>Finally, visit the "Secure Bank Website" to see how proper CSRF protection prevents such attacks.</li>
                    </ol>
                    <hr>
                    <p class="mb-0">This demonstration is for educational purposes only, to understand how CSRF vulnerabilities work.</p>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">Step 1: Vulnerable Bank Website</div>
                    <div class="card-body">
                        <div class="card-img-container">
                            <i class="bi bi-bank bank-icon"></i>
                        </div>
                        <h5 class="card-title">SecureBank (Vulnerable)</h5>
                        <p class="card-text">This is a simulated online banking website that lacks CSRF protection. Users can transfer money through a simple form.</p>
                        <a href="bank.php" class="btn btn-primary">Visit Bank Website</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-danger text-white">Step 2: Attacker's Website</div>
                    <div class="card-body">
                        <div class="card-img-container">
                            <i class="bi bi-exclamation-triangle-fill attack-icon"></i>
                        </div>
                        <h5 class="card-title">Malicious Website</h5>
                        <p class="card-text">This site contains a hidden form that will attempt to execute a CSRF attack against the vulnerable bank.</p>
                        <a href="attacker.php" class="btn btn-danger">Visit Attacker's Site</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-success text-white">Step 3: Secure Bank Website</div>
                    <div class="card-body">
                        <div class="card-img-container">
                            <i class="bi bi-shield-check secure-icon"></i>
                        </div>
                        <h5 class="card-title">SecureBank+ (Protected)</h5>
                        <p class="card-text">This improved version of the bank uses anti-CSRF tokens to prevent cross-site request forgery attacks.</p>
                        <a href="secure_bank.php" class="btn btn-success">Visit Secure Bank</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">What is CSRF?</div>
                    <div class="card-body">
                        <h5>Cross-Site Request Forgery Explained</h5>
                        <p>CSRF (Cross-Site Request Forgery) is an attack that forces authenticated users to execute unwanted actions on a web application in which they're currently authenticated. With a little help of social engineering (like sending a link via email/chat), an attacker may trick the users of a web application into executing actions of the attacker's choosing.</p>
                        
                        <h5>How does it work?</h5>
                        <p>A CSRF attack works because browser requests automatically include all cookies, including session cookies. Therefore, if the user is authenticated to the site, the site cannot distinguish between legitimate requests and forged requests.</p>
                        
                        <h5>Protection against CSRF</h5>
                        <ul>
                            <li><strong>Anti-CSRF Tokens</strong>: Include a secret, unique token in each form that is validated when the form is submitted.</li>
                            <li><strong>SameSite Cookies</strong>: Configure cookies to be sent only in same-site requests, preventing cross-origin requests.</li>
                            <li><strong>Check Referer Header</strong>: Verify the request originated from your own domain.</li>
                            <li><strong>Custom Headers</strong>: For AJAX requests, use custom headers that simple forms cannot generate.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="footer text-center">
        <div class="container">
            <p class="mb-0">CSRF Demonstration Project - For Educational Purposes Only</p>
            <small>Not for use in production environments</small>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
