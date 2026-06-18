<?php
// =============================================
// Alnoor Store – Registration Page
// BIT3208: Week 4 – Backend Development
// =============================================

session_start();

// Redirect if already logged in
if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
    exit();
}

require_once 'includes/db.php';

$errors  = [];
$success = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // Sanitize inputs
    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $email     = htmlspecialchars(trim($_POST['email']));
    $phone     = htmlspecialchars(trim($_POST['phone']));
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm'];

    // Validate
    if(strlen($full_name) < 2){
        $errors[] = "Please enter your full name.";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Please enter a valid email address.";
    }

    if(strlen($password) < 6){
        $errors[] = "Password must be at least 6 characters.";
    }

    if($password !== $confirm){
        $errors[] = "Passwords do not match.";
    }

    // Check if email already exists
    if(empty($errors)){
        $check = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($check, "s", $email);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);

        if(mysqli_stmt_num_rows($check) > 0){
            $errors[] = "An account with this email already exists.";
        }
        mysqli_stmt_close($check);
    }

    // Insert into database
    if(empty($errors)){
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($conn,
            "INSERT INTO users (full_name, email, phone, password, role)
             VALUES (?, ?, ?, ?, 'customer')"
        );
        mysqli_stmt_bind_param($stmt, "ssss", $full_name, $email, $phone, $hashed);

        if(mysqli_stmt_execute($stmt)){
            $success = "Account created successfully! You can now sign in.";
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
        mysqli_stmt_close($stmt);
    }
}

$pageTitle  = "Register";
$activePage = "register";
$cssPath    = "css/style.css";
$homePath   = "index.php";
?>

<?php require_once 'includes/header.php'; ?>

<!-- Main -->
<div class="auth-main">

    <!-- Left panel -->
    <div class="auth-left">
        <div class="tag">Alnoor Store</div>
        <h1>Join the<br><span>community.</span></h1>
        <p>Create your free account and start shopping thousands of products delivered right to your door.</p>
        <div class="features">
            <div class="feature-item">
                <div class="feature-dot"></div>
                Free account — no hidden fees
            </div>
            <div class="feature-item">
                <div class="feature-dot"></div>
                Track all your orders in one place
            </div>
            <div class="feature-item">
                <div class="feature-dot"></div>
                Exclusive deals for members
            </div>
            <div class="feature-item">
                <div class="feature-dot"></div>
                Save your addresses & preferences
            </div>
        </div>
    </div>

    <!-- Right panel -->
    <div class="auth-right">
        <div class="form-box">
            <h2>Create account</h2>
            <p class="subtitle">Fill in your details to get started</p>

            <!-- Alerts -->
            <?php if(!empty($errors)): ?>
                <div class="alert alert-error">
                    <?php foreach($errors as $error): ?>
                        <?php echo $error; ?><br>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if(!empty($success)): ?>
                <div class="alert alert-success">
                    <?php echo $success; ?>
                    <br><a href="login.php" style="color:#1a7a3c; font-weight:600;">Sign in now →</a>
                </div>
            <?php endif; ?>

            <form method="POST" action="register.php" novalidate>

                <div class="form-row">
                    <div class="form-group">
                        <label for="full_name">Full name</label>
                        <input type="text" id="full_name" name="full_name"
                               value="<?php echo isset($full_name) ? $full_name : ''; ?>"
                               placeholder="Ali Bishar">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone number</label>
                        <input type="text" id="phone" name="phone"
                               value="<?php echo isset($phone) ? $phone : ''; ?>"
                               placeholder="07XXXXXXXX">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="text" id="email" name="email"
                           value="<?php echo isset($email) ? $email : ''; ?>"
                           placeholder="you@example.com">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password"
                               placeholder="Create a strong password">
                        <span class="toggle-pw" id="togglePw">Show</span>
                    </div>
                    <div class="strength-bar" id="strengthBar"></div>
                    <div class="strength-text" id="strengthText"></div>
                </div>

                <div class="form-group">
                    <label for="confirm">Confirm password</label>
                    <input type="password" id="confirm" name="confirm"
                           placeholder="Repeat your password">
                </div>

                <button type="submit" class="btn btn-primary btn-full">
                    Create account
                </button>

            </form>

            <div class="divider"><hr><span>or</span><hr></div>

            <p style="text-align:center; font-size:13px; color:#666;">
                Already have an account?
                <a href="login.php" style="color:#1a7a3c; font-weight:600;">Sign in</a>
            </p>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <p>© 2025 Alnoor Store. All rights reserved.</p>
    <nav>
        <a href="#">Privacy</a>
        <a href="#">Terms</a>
        <a href="#">Contact</a>
    </nav>
</footer>

<script>
    // Password strength checker
    document.getElementById('password').addEventListener('input', function(){
        const bar  = document.getElementById('strengthBar');
        const text = document.getElementById('strengthText');
        const val  = this.value;

        if(val.length === 0){
            bar.style.width = '0'; bar.style.background = '#eee';
            text.textContent = ''; return;
        }

        let score = 0;
        if(val.length >= 6)              score++;
        if(val.length >= 10)             score++;
        if(/[A-Z]/.test(val))            score++;
        if(/[0-9]/.test(val))            score++;
        if(/[^A-Za-z0-9]/.test(val))    score++;

        const levels = [
            { label:'Very weak',  color:'#e74c3c', width:'20%' },
            { label:'Weak',       color:'#e67e22', width:'40%' },
            { label:'Fair',       color:'#f1c40f', width:'60%' },
            { label:'Strong',     color:'#2ecc71', width:'80%' },
            { label:'Very strong',color:'#1a7a3c', width:'100%'},
        ];

        const level = levels[Math.min(score - 1, 4)];
        bar.style.width      = level.width;
        bar.style.background = level.color;
        text.style.color     = level.color;
        text.textContent     = level.label;
    });

    // Show / hide password
    document.getElementById('togglePw').addEventListener('click', function(){
        const pw = document.getElementById('password');
        const hidden = pw.type === 'password';
        pw.type = hidden ? 'text' : 'password';
        this.textContent = hidden ? 'Hide' : 'Show';
    });
</script>

</body>
</html>