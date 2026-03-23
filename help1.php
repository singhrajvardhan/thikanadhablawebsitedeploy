<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#06c1db">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 

    <title>Registration & Help Center - Thikana Dhabla Ghosi</title>
    <link rel="icon" href="1200.jpeg" />

    <style>
        /* Rajasthani Color Palette */
        :root {
            --saffron: #FF9933;
            --deep-red: #D32F2F;
            --gold: #D4AF37;
            --maroon: #800000;
            --cream: #F5F5DC;
            --dark-brown: #5D4037;
            --light-brown: #8D6E63;
            --sand: #E0C9A6;
            --royal-blue: #0D47A1;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Georgia', serif;
        }

        body {
            line-height: 1.6;
            color: #333;
            background-color: var(--cream);
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="%23F5F5DC"/><path d="M0,0 L100,100 M100,0 L0,100" stroke="%23E0C9A6" stroke-width="0.5"/></svg>');
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Header Styles */
        #topstrip {
            background: linear-gradient(to right, var(--saffron), var(--deep-red), var(--gold));
            height: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            margin-bottom: 20px;
        }

        #headstrip {
            background-color: var(--dark-brown);
            padding: 15px 0;
            text-align: center;
            border-bottom: 3px solid var(--gold);
            position: relative;
            overflow: hidden;
            margin-bottom: 20px;
            border-radius: 10px 10px 0 0;
        }

        #headstrip::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: repeating-linear-gradient(
                45deg,
                var(--gold),
                var(--gold) 10px,
                var(--saffron) 10px,
                var(--saffron) 20px
            );
        }

        /* Circular Logo Frame */
        .logo-container {
            display: inline-block;
            position: relative;
            margin: 10px auto;
        }

        .logo-frame {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--saffron));
            padding: 6px;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.5);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: glow 3s infinite alternate;
        }

        .logo-frame::before {
            content: "";
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            border-radius: 50%;
            background: conic-gradient(from 0deg, var(--gold), var(--saffron), var(--deep-red), var(--maroon), var(--gold));
            z-index: -1;
            animation: rotate 10s linear infinite;
        }

        .logo-frame::after {
            content: "";
            position: absolute;
            top: 4px;
            left: 4px;
            right: 4px;
            bottom: 4px;
            border-radius: 50%;
            background: var(--dark-brown);
            z-index: -1;
        }

        .logo-image {
            width: 108px;
            height: 108px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--gold);
            background-color: white;
            padding: 3px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        .decoration {
            position: absolute;
            width: 132px;
            height: 132px;
            border-radius: 50%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="48" fill="none" stroke="%23D4AF37" stroke-width="2" stroke-dasharray="5,5"/><path d="M50,10 A40,40 0 1,1 50,90 A40,40 0 1,1 50,10 Z" fill="none" stroke="%23FF9933" stroke-width="1"/></svg>');
            top: -6px;
            left: -6px;
            z-index: -1;
            animation: rotate 20s linear infinite;
        }

        @keyframes glow {
            0% { box-shadow: 0 0 15px rgba(212, 175, 55, 0.5); }
            100% { box-shadow: 0 0 25px rgba(212, 175, 55, 0.8), 0 0 35px rgba(255, 153, 51, 0.6); }
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        #blinking-message {
            text-align: center;
            padding: 10px;
            font-weight: bold;
            font-size: 18px;
            margin-top: 10px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
            font-family: 'Arial', sans-serif;
            transition: opacity 0.5s ease;
        }

        /* Content Styles */
        h1 {
            color: var(--maroon);
            border-bottom: 2px solid var(--gold);
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-family: 'Times New Roman', serif;
            text-align: center;
        }
        
        h2 {
            color: var(--maroon);
            margin-top: 30px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--gold);
            font-family: 'Times New Roman', serif;
        }
        
        h3 {
            color: var(--dark-brown);
            margin: 15px 0 10px 0;
        }
        
        .toc {
            background-color: rgba(212, 175, 55, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            border: 1px solid var(--sand);
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .toc ul {
            list-style-type: none;
            padding-left: 0;
        }
        
        .toc li {
            margin-bottom: 10px;
            padding-left: 20px;
            position: relative;
        }
        
        .toc li:before {
            content: "ЁЯХМ";
            position: absolute;
            left: 0;
            color: var(--gold);
        }
        
        .toc a {
            text-decoration: none;
            color: var(--dark-brown);
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .toc a:hover {
            color: var(--deep-red);
            text-decoration: underline;
        }
        
        .steps {
            background-color: rgba(212, 175, 55, 0.1);
            padding: 20px;
            border-left: 4px solid var(--gold);
            margin: 20px 0;
            border-radius: 0 10px 10px 0;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .steps ol {
            padding-left: 20px;
        }
        
        .steps li {
            margin-bottom: 10px;
        }
        
        .troubleshooting {
            background-color: rgba(241, 196, 15, 0.1);
            padding: 20px;
            border-left: 4px solid var(--saffron);
            margin: 20px 0;
            border-radius: 0 10px 10px 0;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .note {
            font-style: italic;
            color: var(--light-brown);
        }
        
        .demo-box {
            border: 2px solid var(--gold);
            padding: 25px;
            margin: 20px 0;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            position: relative;
        }
        
        .demo-box::before {
            content: "ЁЯУЭ";
            position: absolute;
            top: -15px;
            left: 20px;
            background: var(--cream);
            padding: 0 10px;
            color: var(--maroon);
            font-size: 20px;
        }
        
        .demo-box input[type="text"],
        .demo-box input[type="password"],
        .demo-box input[type="email"],
        .demo-box input[type="tel"],
        .demo-box input[type="date"],
        .demo-box textarea,
        .demo-box select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid var(--sand);
            border-radius: 5px;
            background-color: #f9f9f9;
            font-family: 'Georgia', serif;
        }
        
        .demo-box button {
            background: linear-gradient(to right, var(--saffron), var(--deep-red));
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            font-weight: bold;
            transition: all 0.3s;
            box-shadow: 0 3px 5px rgba(0,0,0,0.2);
        }
        
        .demo-box button:hover {
            background: linear-gradient(to right, var(--deep-red), var(--saffron));
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0,0,0,0.3);
        }
        
        .profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--gold);
            margin: 10px 0;
        }
        
        .profile-section {
            display: flex;
            gap: 20px;
            margin: 20px 0;
            align-items: center;
        }
        
        .profile-info {
            flex-grow: 1;
        }
        
        .nav-menu {
            background: linear-gradient(to right, var(--maroon), var(--dark-brown));
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .nav-menu a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .nav-menu a:hover {
            color: var(--gold);
            text-decoration: underline;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .info-table td {
            padding: 10px;
            border-bottom: 1px solid var(--sand);
        }
        
        .info-table td:first-child {
            font-weight: bold;
            width: 30%;
            color: var(--maroon);
        }
        
        .image-upload {
            margin: 20px 0;
        }
        
        .image-upload input {
            margin: 10px 0;
        }
        
        .live-datetime {
            color: white;
            font-family: Arial, sans-serif;
            margin-right: 15px;
        }
        
        .email-template {
            border: 2px solid var(--gold);
            padding: 25px;
            margin: 20px 0;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .email-header {
            border-bottom: 1px solid var(--sand);
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .email-footer {
            border-top: 1px solid var(--sand);
            padding-top: 15px;
            margin-top: 20px;
            font-size: 0.9em;
            color: var(--light-brown);
        }
        
        .verification-btn {
            display: inline-block;
            background: linear-gradient(to right, var(--saffron), var(--deep-red));
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin: 15px 0;
            font-weight: bold;
            transition: all 0.3s;
            box-shadow: 0 3px 5px rgba(0,0,0,0.2);
        }
        
        .verification-btn:hover {
            background: linear-gradient(to right, var(--deep-red), var(--saffron));
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0,0,0,0.3);
        }
        
        .footer-links {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background-color: rgba(212, 175, 55, 0.1);
            border-radius: 10px;
            border: 1px solid var(--sand);
        }
        
        .footer-links a {
            color: var(--maroon);
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--deep-red);
            text-decoration: underline;
        }
        
        footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid var(--gold);
            text-align: center;
            color: var(--light-brown);
        }
        
        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .profile-section {
                flex-direction: column;
                text-align: center;
            }
            
            .nav-menu {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
            
            .live-datetime {
                margin-right: 0;
                margin-bottom: 10px;
            }
            
            .footer-links a {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div id="topstrip"></div>
    
    <div id="headstrip">
        <a href="index.php">
            <div class="logo-container">
                <div class="decoration"></div>
                <div class="logo-frame">
                    <img id="logo1" src="1200.jpeg" alt="Thikana Dhabla Ghosi" class="logo-image"/>
                </div>
            </div>
        </a>
        <div id="blinking-message"></div>
    </div>

    <h1>Thikana Dhabla - Registration & Help Center</h1>
    
    <div class="toc">
        <h2>Table of Contents</h2>
        <ul>
            <li><a href="#registration">1. Registration Process</a></li>
            <li><a href="#email-verification">2. Email Verification</a></li>
            <li><a href="#login">3. Login to Your Account</a></li>
            <li><a href="#dashboard">4. Accessing Your Dashboard</a></li>
            <li><a href="#profile-update">5. Updating Your Profile</a></li>
        </ul>
    </div>
    
    <!-- Registration Section -->
    <section id="registration">
        <h2>1. Registration Process</h2>
        
        <div class="demo-box">
            <h3>Registration Form</h3>
            <form id="registrationForm">
                <label for="reg-email">Email</label>
                <input type="email" id="reg-email" placeholder="your@email.com" required>
                
                <label for="reg-password">Password (min 8 characters)</label>
                <input type="password" id="reg-password" minlength="8" required>
                
                <label for="reg-confirm">Confirm Password</label>
                <input type="password" id="reg-confirm" required>
                
                <label for="reg-name">Full Name</label>
                <input type="text" id="reg-name" placeholder="Thikana Dhabla" required>
                
                <label for="reg-phone">Phone Number</label>
                <input type="tel" id="reg-phone" placeholder="1234567890" required>
                
                <div>
                    <input type="checkbox" id="terms" required>
                    <label for="terms">I agree to the Terms of Service and Privacy Policy</label>
                </div>
                
                <button type="submit">Register</button>
                
                <p>Already have an account? <a href="#login">Login here</a></p>
            </form>
        </div>
        
        <div class="steps">
            <h3>How to Register:</h3>
            <ol>
                <li>Fill in all required fields in the registration form</li>
                <li>Ensure your password is at least 8 characters long</li>
                <li>Provide a valid email address you have access to</li>
                <li>Agree to the Terms of Service and Privacy Policy</li>
                <li>Click "Register" to submit your information</li>
                <li>Check your email for a verification link (see next section)</li>
            </ol>
        </div>
    </section>
    
    <!-- Email Verification Section -->
    <section id="email-verification">
        <h2>2. Email Verification Process</h2>
        
        <div class="email-template">
            <div class="email-header">
                <h3>Thikana Dhabla</h3>
                <p>support@thikanadhabla.in</p>
                <p>Date: <span id="email-date"></span></p>
                <p>Subject: Email Verification - Thikana Dhabla</p>
            </div>
            
            <h3>Email Verification</h3>
            <p>Welcome to Thikana Dhabla!</p>
            <p>Please verify your email by clicking this link:</p>
            
            <a href="#" class="verification-btn">Verify Email Address</a>
            
            <p>Or copy and paste this link into your browser:<br>
            <small>https://thikanadhabla.in/verify.php?token=52cf1052d290111204735080c5fc018438fa51211604b0946b0e322c06b567e8</small></p>
            
            <div class="email-footer">
                <p>If you didn't request this, please ignore this email.</p>
            </div>
        </div>
        
        <div class="steps">
            <h3>Verification Steps:</h3>
            <ol>
                <li>After registration, check your inbox (and spam folder) for our verification email</li>
                <li>Click the "Verify Email Address" button in the email</li>
                <li>You'll be redirected to our website with a confirmation message</li>
                <li>Once verified, you can login to your account</li>
                <li>If you don't receive the email within 5 minutes, check your spam folder or request a new verification link</li>
            </ol>
        </div>
        
        <div class="troubleshooting">
            <h3>Troubleshooting:</h3>
            <ul>
                <li><strong>Link expired?</strong> Verification links are valid for 24 hours. Request a new one if expired.</li>
                <li><strong>Wrong email?</strong> Log in with the email you used to register and update it in your profile.</li>
                <li><strong>Still not working?</strong> Contact support@thikanadhabla.in for assistance.</li>
            </ul>
        </div>
    </section>
    
    <!-- Login Section -->
    <section id="login">
        <h2>3. Login to Your Account</h2>
        
        <div class="demo-box">
            <h3>Login Form</h3>
            <form>
                <label for="username">Username (If you don't know the username, Contact the Admin)</label>
                <input type="text" id="username" placeholder="username or 1000">
                
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="тАвтАвтАвтАвтАвтАвтАвтАвтАв">
                
                <button type="submit">Login</button>
                
                <p>Don't have an account? <a href="#registration">Register here</a></p>
                <p><a href="#">Forgot password? Reset it here</a></p>
            </form>
        </div>
        
        <div class="steps">
            <h3>How to Login:</h3>
            <ol>
                <li>Enter your username</li>
                <li>Type your password (case sensitive)</li>
                <li>Click "Login" to access your account</li>
                <li>If you haven't verified your email, you'll be prompted to do so</li>
                <li>Upon successful login, you'll be redirected to your dashboard</li>
            </ol>
        </div>
    </section>
    
    <!-- Dashboard Section -->
    <section id="dashboard">
        <h2>4. Accessing Your Dashboard</h2>
        
        <div class="demo-box">
            <div class="nav-menu">
                <span class="live-datetime" id="currentDateTime"></span>
                <a href="#">Dashboard</a>
                <a href="#">Public Profile</a>
                <a href="#">Edit Profile</a>
                <a href="#">Website</a>
                <a href="#">Logout</a>
            </div>
            
            <h3>Dashboard Overview</h3>
            <div class="profile-section">
                <div class="profile-info">
                    <h3>Welcome back, Thikana Dhabla!</h3>
                    <p>@1000 | Member since 2025</p>
                </div>
            </div>
            
            <p>From your dashboard you can:</p>
            <ul>
                <li>View and edit your profile information</li>
                <li>Access your account settings</li>
                <li>See your recent activity</li>
                <li>Manage your preferences</li>
            </ul>
        </div>
    </section>
    
    <!-- Profile Update Section -->
    <section id="profile-update">
        <h2>5. Updating Your Profile</h2>
        
        <div class="demo-box">
            <h3>Edit Profile Information</h3>
            <form>
                <table class="info-table">
                    <tr>
                        <td>Username</td>
                        <td>1000</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>xyz@gmail.com (verified)</td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td><input type="tel" value="1234567890"></td>
                    </tr>
                    <tr>
                        <td>Birthdate</td>
                        <td><input type="date" value="2025-01-01"></td>
                    </tr>
                    <tr>
                        <td>Location</td>
                        <td><input type="text" value="Thikana Dhabla Ghosi"></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>
                            <select>
                                <option>Not specified</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Bio</td>
                        <td><textarea rows="3">how are you</textarea></td>
                    </tr>
                </table>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </section>
    
    <!-- Footer Links -->
    <div class="footer-links">
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        <p>Forgot password? <a href="forgot-password.php">Reset it here</a></p>
        <p>Already have an account? <a href="login.php">Login here</a></p>
        <p>Return To Website <a href="index.php">Return TO Website</a></p>
    </div>
    
    <footer>
  <p style="color: ; margin-top: 15px;">
    Copyright © 2025 
    <a href="http://www.rajvardhansingh.in" style="color: ; text-decoration: none;">
        <span style="text-decoration: underline;">Rajvardhan Singh </span>
    </a> & Family. All Rights Reserved.
</p>    </footer>

    <script>
        // Blinking message script
        const messages = [
            { text: "рд░рд╛рдШрд╡рд╛рдп рдирдордГ", color: "#ffd700" }, // Gold
            { text: "рдЬрдп рдорд╛рдБ рдЖрд╕рд╛рд╡рд░реА", color: "#ff0000" } // Red
        ];
        
        let currentIndex = 0;
        const messageElement = document.getElementById('blinking-message');
        
        function updateMessage() {
            // Fade out
            messageElement.style.opacity = 0;
            
            setTimeout(() => {
                // Change message and color
                currentIndex = (currentIndex + 1) % messages.length;
                messageElement.textContent = messages[currentIndex].text;
                messageElement.style.color = messages[currentIndex].color;
                
                // Fade in
                messageElement.style.opacity = 1;
            }, 500); // Half-second fade out duration
        }
        
        // Initial message
        messageElement.textContent = messages[0].text;
        messageElement.style.color = messages[0].color;
        messageElement.style.opacity = 1;
        
        // Change message every 2 seconds
        setInterval(updateMessage, 2000);

        // Live date and time
        function updateDateTime() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            };
            document.getElementById('currentDateTime').textContent = now.toLocaleDateString('en-US', options) + ' at ' + now.toLocaleTimeString('en-US', {hour: '2-digit', minute:'2-digit'});
            
            // Set email date
            const emailDate = now.toLocaleString('en-GB', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            }).replace(/,/g, '');
            document.getElementById('email-date').textContent = emailDate;
        }
        
        // Initialize and update every second
        updateDateTime();
        setInterval(updateDateTime, 1000);
        
        // Form validation
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            const password = document.getElementById('reg-password').value;
            const confirm = document.getElementById('reg-confirm').value;
            
            if (password !== confirm) {
                alert('Passwords do not match!');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>