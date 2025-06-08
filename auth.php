<?php
// filepath: c:\Users\Prashant\OneDrive\Desktop\mainflow\signup page\auth.php

session_start();

// Database config
$host = 'localhost';
$db   = 'user_auth';
$user = 'root';
$pass = 'annabelle comes home'; // your DB password
$charset = 'utf8mb4';

// DSN
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    exit('Database connection failed: ' . $e->getMessage());
}

// Handle signup form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input
    $name     = trim($_POST['name'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // Validation
    $errors = [];
    if (empty($name) || empty($phone) || empty($email) || empty($password) || empty($confirm)) {
        $errors[] = "All fields are required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (!preg_match('/^[0-9]{10,}$/', $phone)) {
        $errors[] = "Phone number must be at least 10 digits.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }
    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    // Check if email already exists
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Email already registered.";
        }
    }

    // Insert user if no errors
    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, phone, email, password) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$name, $phone, $email, $hashed])) {
            // Success message and redirect or display
            echo "<script>alert('You are successfully registered!');window.location.href='signin.html';</script>";
            exit;
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
    }

    // Show errors
    if (!empty($errors)) {
        foreach ($errors as $err) {
            echo "<script>alert('".htmlspecialchars($err, ENT_QUOTES)."');window.history.back();</script>";
            break;
        }
        exit;
    }
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $login_errors = [];

    if (empty($email) || empty($password)) {
        $login_errors[] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $login_errors[] = "Invalid email format.";
    }

    if (empty($login_errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            echo "<script>alert('Login successful!');window.location.href='dashboard.php';</script>";
            exit;
        } else {
            $login_errors[] = "Incorrect email or password.";
        }
    }

    // Show login errors
    if (!empty($login_errors)) {
        foreach ($login_errors as $err) {
            echo "<script>alert('".htmlspecialchars($err, ENT_QUOTES)."');window.history.back();</script>";
            break;
        }
        exit;
    }
}


// ...existing signup code above...

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $login_errors = [];

    if (empty($email) || empty($password)) {
        $login_errors[] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $login_errors[] = "Invalid email format.";
    }

    if (empty($login_errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            echo "<script>alert('Login successful!');window.location.href='dashboard.php';</script>";
            exit;
        } else {
            $login_errors[] = "Incorrect email or password.";
        }
    }

    // Show login errors
    if (!empty($login_errors)) {
        foreach ($login_errors as $err) {
            echo "<script>alert('".htmlspecialchars($err, ENT_QUOTES)."');window.history.back();</script>";
            break;
        }
        exit;
    }
}

?>