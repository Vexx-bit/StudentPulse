<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Sanitize string output for safe HTML rendering
function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

// Redirect helper function
function go($path)
{
    header('Location: ' . $path);
    exit;
}

// Check if student user is logged in
function auth()
{
    if (empty($_SESSION['student_id'])) {
        go('login.php');
    }
}

// Check if admin user is logged in
function admin()
{
    if (empty($_SESSION['admin_id'])) {
        go('../admin/login.php');
    }
}

// Get or generate CSRF token
function token()
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

// Verify CSRF token submission
function check()
{
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(403);
        exit('Invalid CSRF token');
    }
}

// Store a flash message in session
function flash($message)
{
    $_SESSION['flash'] = $message;
}

// Complete session destruction for logout
function logout_session()
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
    session_destroy();
}
?>