<?php
session_start();

// Initialize session variables if not set
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = [
        'id' => 1,
        'name' => 'John Doe',
        'balance' => 10000
    ];
}

// Generate CSRF token if it doesn't exist
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Process transfer if form submitted
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF Protection: Validate token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "<div class='alert alert-danger'>CSRF token validation failed. Transaction rejected for security reasons.</div>";
    } else if (isset($_POST['amount']) && isset($_POST['recipient'])) {
        $amount = (float)$_POST['amount'];
        $recipient = htmlspecialchars($_POST['recipient']);
        
        // For demo purposes, we'll just update the balance
        if ($amount > 0 && $amount <= $_SESSION['user']['balance']) {
            $_SESSION['user']['balance'] -= $amount;
            $message = "<div class='alert alert-success'>Successfully transferred $" . number_format($amount, 2) . " to $recipient</div>";
        } else {
            $message = "<div class='alert alert-danger'>Invalid amount or insufficient funds</div>";
        }
    }
}

// Current timestamp for demonstration purposes
$timestamp = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureBank+ (CSRF Protected) - Your Trusted Banking Partner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .bank-header {
            background-color: #198754;
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .account-card {
            border-left: 5px solid #198754;
        }
        .balance {
            font-size: 24px;
            font-weight: bold;
            color: #198754;
        }
        .security-badge {
            background-color: #198754;
            color: white;
            border-radius: 50px;
            padding: 5px 15px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="bank-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1><i class="bi bi-shield-lock"></i> SecureBank+ <span class="security-badge">CSRF Protected</span></h1>
                </div>
                <div class="col-md-6 text-end">
                    <p class="mb-0">Welcome, <?php echo $_SESSION['user']['name']; ?></p>
                    <small>Last login: <?php echo $timestamp; ?></small>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php echo $message; ?>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card account-card">
                    <div class="card-body">
                        <h5 class="card-title">Checking Account</h5>
                        <p class="card-text">Account #: ****3456</p>
                        <p class="balance">$<?php echo number_format($_SESSION['user']['balance'], 2); ?></p>
                        <p class="card-text"><small class="text-muted">Available balance</small></p>
                    </div>
                </div>
                
                <div class="card mt-3">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Security Features</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                CSRF Protection
                                <span class="badge bg-success rounded-pill">Active</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                SSL Encryption
                                <span class="badge bg-success rounded-pill">Active</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Token Validation
                                <span class="badge bg-success rounded-pill">Active</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Money Transfer (CSRF Protected)</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="secure_bank.php">
                            <!-- CSRF Protection: Hidden token field -->
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            
                            <div class="mb-3">
                                <label for="recipient" class="form-label">Recipient</label>
                                <input type="text" class="form-control" id="recipient" name="recipient" required>
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" min="0.01" class="form-control" id="amount" name="amount" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description (optional)</label>
                                <input type="text" class="form-control" id="description" name="description">
                            </div>
                            <button type="submit" class="btn btn-success">Transfer Money</button>
                        </form>
                        
                        <div class="alert alert-info mt-3">
                            <h5>Why is this form secure?</h5>
                            <p>This form includes a unique CSRF token that is validated on submission. The token ensures that the request came from this page and not from a malicious site. Without a valid token, transfer requests will be rejected.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Recent Transactions</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo date('Y-m-d', strtotime('-1 day')); ?></td>
                                    <td>Grocery Store</td>
                                    <td class="text-danger">-$75.40</td>
                                    <td>$<?php echo number_format($_SESSION['user']['balance'] + 75.40, 2); ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo date('Y-m-d', strtotime('-3 day')); ?></td>
                                    <td>Salary Deposit</td>
                                    <td class="text-success">+$2,500.00</td>
                                    <td>$<?php echo number_format($_SESSION['user']['balance'] + 75.40 - 2500, 2); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light mt-5 p-3 text-center">
        <div class="container">
            <p class="text-muted mb-0">© 2023 SecureBank+. All rights reserved.</p>
            <small class="text-muted">This is a demonstration website for educational purposes only.</small>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 