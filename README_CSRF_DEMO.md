# CSRF Attack Demonstration

This project provides a practical demonstration of Cross-Site Request Forgery (CSRF) attacks and how to protect against them. It includes three main components:

1. A vulnerable banking website
2. An attacker's malicious website
3. A secure banking website with CSRF protection

## How to Use This Demonstration

Follow these steps to understand how CSRF attacks work:

1. Navigate to `http://localhost/csrf/public/csrf_demo.php` in your browser
2. First, visit the "Vulnerable Bank Website" to see how a typical banking application works
3. Next, visit the "Attacker's Website" which contains a CSRF payload targeting the bank
4. Finally, visit the "Secure Bank Website" to see how proper CSRF protection prevents such attacks

## Understanding the CSRF Vulnerability

### What is CSRF?

CSRF (Cross-Site Request Forgery) is an attack that forces authenticated users to execute unwanted actions on a web application in which they're currently authenticated. With a little help of social engineering (like sending a link via email/chat), an attacker may trick the users of a web application into executing actions of the attacker's choosing.

### How it Works in This Demo

1. The vulnerable bank site (`bank.php`) allows money transfers but doesn't validate the origin of the request
2. When a user is logged into the bank site, their session cookie is stored in the browser
3. The attacker's site (`attacker.php`) contains a hidden form that submits to the bank's transfer endpoint
4. When the user visits the attacker's site, clicking the "Claim iPhone" button actually submits the hidden form
5. Since the browser automatically includes the session cookie, the bank processes the request as legitimate

### CSRF Protection Demonstration

The secure bank site (`secure_bank.php`) implements CSRF protection by:

1. Generating a unique token for each session
2. Including this token as a hidden field in legitimate forms
3. Validating the token when processing form submissions
4. Rejecting requests that don't contain a valid token

## Technical Implementation

This demonstration implements:

- PHP session management to simulate user authentication
- Bootstrap 5 for a modern UI
- JavaScript for the attack page functionality
- Anti-CSRF token validation in the secure version

## Educational Purpose

This demonstration is for educational purposes only to help understand how CSRF vulnerabilities work and how to properly protect against them. It should not be used in a production environment.

## Security Best Practices

Always protect your web applications from CSRF attacks by:

1. Implementing anti-CSRF tokens in all forms
2. Using the SameSite cookie attribute
3. Checking the Referer header for sensitive operations
4. Requiring re-authentication for sensitive actions
5. Using proper session management 