<?php
// =============================================
// Alnoor Store – Login Page
// BIT3208: Week 4 – Backend Development
// =============================================

session_start();

// Redirect if already logged in
if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
    exit();
}

require_once __DIR__ . '/includes/db.php';

$error   = "";
$success = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $email    = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];

    // Validate inputs
    if(empty($email) || empty($password)){
        $error = "Please enter both email and password.";
    } else {

        // Fetch user by email using prepared statement
        $stmt = mysqli_prepare($conn, "SELECT id, full_name, password, role FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($result)){

            // Verify password
            if(password_verify($password, $row['password'])){

                // Set session variables
                $_SESSION['user_id']   = $row['id'];
                $_SESSION['user_name'] = $row['full_name'];
                $_SESSION['user_role'] = $row['role'];

                // Redirect to dashboard
                header("Location: dashboard.php");
                exit();

            } else {
                $error = "Incorrect password. Please try again.";
            }
        } else {
            $error = "No account found with that email address.";
        }
        mysqli_stmt_close($stmt);
    }
}

$pageTitle  = "Sign In";
$activePage = "login";
$cssPath    = "css/style.css";
$homePath   = "index.php";
?>

<?php require_once __DIR__ . '/includes/header.php'; ?>

<!-- Main -->
<div class="auth-main">

    <!-- Left panel -->
    <div class="auth-left">
        <div class="tag">Alnoor Store</div>
        <h1>Shop smarter,<br>live <span>better.</span></h1>
        <p>Your one-stop destination for quality products across fashion, electronics, home essentials and more.</p>
        <div class="features">
            <div class="feature-item">
                <div class="feature-dot"></div>
                Fast & reliable delivery across Kenya
            </div>
            <div class="feature-item">
                <div class="feature-dot"></div>
                Secure checkout with M-Pesa & card
            </div>
            <div class="feature-item">
                <div class="feature-dot"></div>
                Thousands of verified products
            </div>
            <div class="feature-item">
                <div class="feature-dot"></div>
                24/7 customer support
            </div>
        </div>
    </div>

    <!-- Right panel -->
    <div class="auth-right">
        <div class="form-box">
            <h2>Sign in</h2>
            <p class="subtitle">Welcome back — enter your details below</p>

            <!-- Alerts -->
            <?php if(!empty($error)): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if(isset($_GET['registered'])): ?>
                <div class="alert alert-success">
                    Account created successfully! Please sign in.
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php" novalidate>

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
                               placeholder="Enter your password">
                        <span class="toggle-pw" id="togglePw">Show</span>
                    </div>
                    <div class="strength-bar" id="strengthBar"></div>
                    <div class="strength-text" id="strengthText"></div>
                </div>

                <div style="text-align:right; margin-top:-10px; margin-bottom:20px;">
                    <a href="#" style="font-size:12px; color:#1a7a3c;">Forgot password?</a>
                </div>

                <button type="submit" class="btn btn-primary btn-full">
                    Sign in
                </button>

            </form>

            <div class="divider"><hr><span>or</span><hr></div>

            <p style="text-align:center; font-size:13px; color:#666;">
                Don't have an account?
                <a href="register.php" style="color:#1a7a3c; font-weight:600;">Create one</a>
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
    // Show / hide password
    document.getElementById('togglePw').addEventListener('click', function(){
        const pw = document.getElementById('password');
        const hidden = pw.type === 'password';
        pw.type = hidden ? 'text' : 'password';
        this.textContent = hidden ? 'Hide' : 'Show';
    });

    // Password strength
    document.getElementById('password').addEventListener('input', function(){
        const bar  = document.getElementById('strengthBar');
        const text = document.getElementById('strengthText');
        const val  = this.value;

        if(val.length === 0){
            bar.style.width = '0'; bar.style.background = '#eee';
            text.textContent = ''; return;
        }

        let score = 0;
        if(val.length >= 6)           score++;
        if(val.length >= 10)          score++;
        if(/[A-Z]/.test(val))         score++;
        if(/[0-9]/.test(val))         score++;
        if(/[^A-Za-z0-9]/.test(val)) score++;

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
</script>

</body>
</html>