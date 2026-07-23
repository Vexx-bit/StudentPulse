<?php
/**
 * StudentPulse CAAT Documentation Generator
 * Generates a self-contained HTML file with embedded screenshots
 * that can be:
 *   1. Opened in any browser and printed to PDF (Ctrl+P -> Save as PDF)
 *   2. Opened in Microsoft Word and saved as DOCX
 *
 * Usage: php generate_docs.php
 */

$screenshotDir = __DIR__ . '/screenshots';
$outputFile = __DIR__ . '/StudentPulse_CAAT_Documentation.html';

// Helper function to embed images as base64
function embedImage($path)
{
    if (!file_exists($path)) {
        return '[Image not found: ' . basename($path) . ']';
    }
    $data = base64_encode(file_get_contents($path));
    $mime = mime_content_type($path);
    return '<img src="data:' . $mime . ';base64,' . $data . '" style="max-width:100%; border:1px solid #ddd; border-radius:8px; margin:10px 0; box-shadow: 0 2px 8px rgba(0,0,0,0.1);" />';
}

// Screenshot mapping
$screenshots = [
    '01' => ['file' => '01_student_login.png', 'caption' => 'Figure 1: Student Login Page (login.php)'],
    '02' => ['file' => '02_student_register.png', 'caption' => 'Figure 2: Student Registration Page (register.php)'],
    '03' => ['file' => '03_student_dashboard.png', 'caption' => 'Figure 3: Student Dashboard (dashboard.php)'],
    '04' => ['file' => '04_student_events.png', 'caption' => 'Figure 4: Events Hub (events.php)'],
    '05' => ['file' => '05_student_contact.png', 'caption' => 'Figure 5: Contact Page (contact.php)'],
    '06' => ['file' => '06_student_profile.png', 'caption' => 'Figure 6: Student Profile (profile.php)'],
    '07' => ['file' => '07_admin_login.png', 'caption' => 'Figure 7: Admin Login Page (admin/login.php)'],
    '08' => ['file' => '08_admin_events.png', 'caption' => 'Figure 8: Admin Events Management (admin/events.php)'],
    '09' => ['file' => '09_admin_event_form.png', 'caption' => 'Figure 9: Admin Create/Edit Event Form (admin/event_form.php)'],
    '10' => ['file' => '10_admin_messages.png', 'caption' => 'Figure 10: Admin Message Submissions (admin/messages.php)'],
];

// Build embedded images
$embeddedImages = [];
foreach ($screenshots as $key => $info) {
    $path = $screenshotDir . '/' . $info['file'];
    $embeddedImages[$key] = embedImage($path);
}

$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentPulse – CAAT Project Documentation</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            line-height: 1.7;
            color: #1a1a2e;
            background: #fff;
            max-width: 210mm;
            margin: 0 auto;
            padding: 20mm 15mm;
        }

        @media print {
            body { padding: 0; max-width: 100%; }
            .page-break { page-break-before: always; }
            h1, h2, h3 { page-break-after: avoid; }
            table, figure { page-break-inside: avoid; }
        }

        /* Cover Page */
        .cover {
            text-align: center;
            padding: 80px 20px;
            min-height: 85vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .cover .logo {
            font-size: 64px;
            font-weight: 700;
            color: #6c5ce7;
            margin-bottom: 10px;
        }
        .cover h1 {
            font-size: 36px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 8px;
        }
        .cover .subtitle {
            font-size: 20px;
            color: #555;
            margin-bottom: 40px;
        }
        .cover .meta {
            font-size: 15px;
            color: #777;
            line-height: 2;
        }
        .cover .meta strong { color: #333; }

        /* Section headers */
        h1 {
            font-size: 26px;
            font-weight: 700;
            color: #6c5ce7;
            border-bottom: 3px solid #6c5ce7;
            padding-bottom: 8px;
            margin: 40px 0 20px;
        }
        h2 {
            font-size: 20px;
            font-weight: 600;
            color: #2d3436;
            margin: 30px 0 12px;
        }
        h3 {
            font-size: 16px;
            font-weight: 600;
            color: #636e72;
            margin: 20px 0 10px;
        }
        p {
            margin: 8px 0;
            text-align: justify;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 13px;
        }
        th {
            background: #6c5ce7;
            color: white;
            padding: 10px 12px;
            text-align: left;
            font-weight: 600;
        }
        td {
            padding: 8px 12px;
            border-bottom: 1px solid #eee;
        }
        tr:nth-child(even) { background: #f8f9fa; }
        tr:hover { background: #f0f0ff; }

        /* Code blocks */
        code {
            background: #f4f3ff;
            color: #6c5ce7;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 13px;
            font-family: 'Consolas', 'Courier New', monospace;
        }
        pre {
            background: #1a1a2e;
            color: #e0e0e0;
            padding: 16px 20px;
            border-radius: 8px;
            overflow-x: auto;
            font-size: 12px;
            line-height: 1.6;
            margin: 12px 0;
        }
        pre code {
            background: none;
            color: inherit;
            padding: 0;
        }

        /* Screenshot figures */
        figure {
            margin: 20px 0;
            text-align: center;
        }
        figure img {
            max-width: 100%;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        figcaption {
            font-size: 13px;
            color: #666;
            font-style: italic;
            margin-top: 8px;
        }

        /* Lists */
        ul, ol {
            margin: 10px 0 10px 24px;
        }
        li {
            margin: 4px 0;
        }

        /* Blockquote */
        blockquote {
            border-left: 4px solid #6c5ce7;
            padding: 10px 16px;
            background: #f8f7ff;
            margin: 12px 0;
            color: #555;
            font-size: 14px;
        }

        /* Horizontal rule */
        hr {
            border: none;
            height: 1px;
            background: #e0e0e0;
            margin: 30px 0;
        }

        /* TOC */
        .toc {
            background: #f8f9fa;
            padding: 20px 30px;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            margin: 20px 0;
        }
        .toc h2 {
            margin-top: 0;
            color: #6c5ce7;
        }
        .toc ol {
            margin-left: 20px;
        }
        .toc li {
            margin: 6px 0;
            font-size: 14px;
        }

        /* Pass indicator */
        .pass { color: #00b894; font-weight: 600; }
    </style>
</head>
<body>

<!-- COVER PAGE -->
<div class="cover">
    <div class="logo">SP</div>
    <h1 style="border:none; color:#1a1a2e;">StudentPulse</h1>
    <div class="subtitle">Campus Events Management Portal</div>
    <hr style="width:100px; background:#6c5ce7; height:3px; margin:20px auto;">
    <div class="meta">
        <strong>Project Documentation</strong><br>
        Course: Internet Programming II<br>
        Assessment: Continuous Assessment Test (CAAT)<br>
        Date: July 2026<br><br>
        <strong>Technology Stack:</strong> PHP (Procedural MySQLi) · MySQL · HTML5 · CSS3 · JavaScript
    </div>
</div>

<div class="page-break"></div>

<!-- TABLE OF CONTENTS -->
<div class="toc">
    <h2>Table of Contents</h2>
    <ol>
        <li>Project Overview</li>
        <li>Objectives</li>
        <li>Technology Stack</li>
        <li>System Architecture</li>
        <li>Database Design</li>
        <li>Installation &amp; Setup Guide</li>
        <li>User Interface Screenshots</li>
        <li>Feature Breakdown</li>
        <li>Security Implementation</li>
        <li>Code Structure &amp; File Organization</li>
        <li>Testing &amp; Validation</li>
        <li>Conclusion</li>
        <li>Group Members</li>
    </ol>
</div>

<hr>

<!-- 1. PROJECT OVERVIEW -->
<h1>1. Project Overview</h1>
<p><strong>StudentPulse</strong> is a campus event management web application built to streamline the discovery, organization, and participation in university events. It provides two distinct portals:</p>
<ul>
    <li><strong>Student Portal</strong> – allows registered students to browse published campus events, RSVP to events they wish to attend, submit contact inquiries to the events team, view their profile, and track their participation through a personalized dashboard with live countdown timers.</li>
    <li><strong>Admin Portal</strong> – provides authorized administrators with a dedicated control panel accessible at <code>/admin/</code> to create, edit, publish, draft, and delete campus events, as well as review student-submitted contact messages.</li>
</ul>
<p>The application enforces <strong>role-based access control</strong>, ensuring students and administrators operate within separate authentication flows and session spaces.</p>

<hr>

<!-- 2. OBJECTIVES -->
<h1>2. Objectives</h1>
<ol>
    <li>Build a functional campus event management system using PHP and MySQL.</li>
    <li>Implement user authentication with separate login flows for students and administrators.</li>
    <li>Apply CRUD (Create, Read, Update, Delete) operations for event management.</li>
    <li>Use procedural MySQLi syntax for all database interactions to ensure code clarity and ease of explanation.</li>
    <li>Enforce server-side validation and security measures (CSRF protection, password hashing, output escaping, session management).</li>
    <li>Deliver a responsive, modern user interface using vanilla HTML5/CSS3.</li>
</ol>

<hr>

<!-- 3. TECHNOLOGY STACK -->
<h1>3. Technology Stack</h1>
<table>
    <tr><th>Component</th><th>Technology</th></tr>
    <tr><td>Server</td><td>Apache (via XAMPP)</td></tr>
    <tr><td>Backend</td><td>PHP 8.x (Procedural)</td></tr>
    <tr><td>Database</td><td>MySQL / MariaDB (via XAMPP)</td></tr>
    <tr><td>DB Access</td><td>Procedural MySQLi (<code>mysqli_*</code> functions)</td></tr>
    <tr><td>Frontend</td><td>HTML5, CSS3, Vanilla JavaScript</td></tr>
    <tr><td>Hosting</td><td>localhost (XAMPP on Windows)</td></tr>
</table>

<h2>Why Procedural MySQLi?</h2>
<p>The project deliberately uses procedural <code>mysqli_*</code> functions rather than PDO or OOP-style database access. Functions like <code>mysqli_connect()</code>, <code>mysqli_query()</code>, <code>mysqli_fetch_assoc()</code>, and <code>mysqli_real_escape_string()</code> are straightforward, readable, and easy to explain during code defense presentations. Each database operation is clearly visible without requiring knowledge of object-oriented patterns.</p>

<hr>

<!-- 4. SYSTEM ARCHITECTURE -->
<h1>4. System Architecture</h1>
<p>The application follows a simple MVC-inspired structure without a formal framework:</p>
<pre><code>┌──────────────────────────────────────────────┐
│                   Browser                     │
│         (Chrome / Firefox / Edge)             │
└────────────────┬─────────────────────────────┘
                 │ HTTP Request
                 ▼
┌──────────────────────────────────────────────┐
│            Apache Web Server (XAMPP)           │
└────────────────┬─────────────────────────────┘
                 │ Routes to PHP file
                 ▼
┌──────────────────────────────────────────────┐
│           PHP Application Layer               │
│                                               │
│  Shared Includes:          Student Pages:     │
│   core.php                  login.php         │
│   header.php                register.php      │
│   footer.php                dashboard.php     │
│   database.php              events.php        │
│                             rsvp.php          │
│  Admin Pages (/admin/):     contact.php       │
│   login.php                 profile.php       │
│   events.php                submissions.php   │
│   event_form.php                              │
│   delete.php                                  │
│   messages.php                                │
└────────────────┬─────────────────────────────┘
                 │ mysqli_query()
                 ▼
┌──────────────────────────────────────────────┐
│         MySQL Database Server                 │
│        Database: studentpulse                 │
│  Tables: users, events, rsvps,                │
│          contact_messages                     │
└──────────────────────────────────────────────┘</code></pre>

<hr>

<!-- 5. DATABASE DESIGN -->
<div class="page-break"></div>
<h1>5. Database Design</h1>

<h2>5.1 Table Descriptions</h2>
<table>
    <tr><th>Table</th><th>Purpose</th></tr>
    <tr><td><code>users</code></td><td>Stores student and admin accounts with hashed passwords</td></tr>
    <tr><td><code>events</code></td><td>Campus events with title, description, venue, date, status</td></tr>
    <tr><td><code>rsvps</code></td><td>Many-to-many join table linking students to events</td></tr>
    <tr><td><code>contact_messages</code></td><td>Messages submitted by students through the Contact form</td></tr>
</table>

<h2>5.2 Table Schemas</h2>

<h3>users</h3>
<table>
    <tr><th>Column</th><th>Type</th><th>Constraints</th></tr>
    <tr><td>id</td><td>INT UNSIGNED</td><td>PRIMARY KEY, AUTO_INCREMENT</td></tr>
    <tr><td>username</td><td>VARCHAR(50)</td><td>UNIQUE, NOT NULL</td></tr>
    <tr><td>email</td><td>VARCHAR(120)</td><td>UNIQUE, NOT NULL</td></tr>
    <tr><td>password_hash</td><td>VARCHAR(255)</td><td>NOT NULL</td></tr>
    <tr><td>role</td><td>ENUM('student','admin')</td><td>DEFAULT 'student'</td></tr>
    <tr><td>created_at</td><td>TIMESTAMP</td><td>DEFAULT CURRENT_TIMESTAMP</td></tr>
</table>

<h3>events</h3>
<table>
    <tr><th>Column</th><th>Type</th><th>Constraints</th></tr>
    <tr><td>id</td><td>INT UNSIGNED</td><td>PRIMARY KEY, AUTO_INCREMENT</td></tr>
    <tr><td>title</td><td>VARCHAR(150)</td><td>NOT NULL</td></tr>
    <tr><td>description</td><td>TEXT</td><td>NOT NULL</td></tr>
    <tr><td>category</td><td>VARCHAR(50)</td><td>NOT NULL</td></tr>
    <tr><td>venue</td><td>VARCHAR(150)</td><td>NOT NULL</td></tr>
    <tr><td>event_date</td><td>DATETIME</td><td>NOT NULL</td></tr>
    <tr><td>status</td><td>ENUM('draft','published')</td><td>DEFAULT 'draft'</td></tr>
    <tr><td>created_by</td><td>INT UNSIGNED</td><td>FOREIGN KEY → users(id)</td></tr>
    <tr><td>created_at</td><td>TIMESTAMP</td><td>DEFAULT CURRENT_TIMESTAMP</td></tr>
</table>

<h3>rsvps</h3>
<table>
    <tr><th>Column</th><th>Type</th><th>Constraints</th></tr>
    <tr><td>user_id</td><td>INT UNSIGNED</td><td>PRIMARY KEY, FK → users(id) ON DELETE CASCADE</td></tr>
    <tr><td>event_id</td><td>INT UNSIGNED</td><td>PRIMARY KEY, FK → events(id) ON DELETE CASCADE</td></tr>
    <tr><td>created_at</td><td>TIMESTAMP</td><td>DEFAULT CURRENT_TIMESTAMP</td></tr>
</table>

<h3>contact_messages</h3>
<table>
    <tr><th>Column</th><th>Type</th><th>Constraints</th></tr>
    <tr><td>id</td><td>INT UNSIGNED</td><td>PRIMARY KEY, AUTO_INCREMENT</td></tr>
    <tr><td>user_id</td><td>INT UNSIGNED</td><td>FK → users(id) ON DELETE SET NULL</td></tr>
    <tr><td>name</td><td>VARCHAR(100)</td><td>NOT NULL</td></tr>
    <tr><td>email</td><td>VARCHAR(120)</td><td>NOT NULL</td></tr>
    <tr><td>subject</td><td>VARCHAR(150)</td><td>NOT NULL</td></tr>
    <tr><td>message</td><td>TEXT</td><td>NOT NULL</td></tr>
    <tr><td>created_at</td><td>TIMESTAMP</td><td>DEFAULT CURRENT_TIMESTAMP</td></tr>
</table>

<h2>5.3 Key Relationships</h2>
<ul>
    <li><strong>users → events</strong>: One admin can create many events (<code>created_by</code> foreign key).</li>
    <li><strong>users ↔ events (via rsvps)</strong>: Many-to-many relationship. Students RSVP to events.</li>
    <li><strong>users → contact_messages</strong>: One user can submit many contact messages.</li>
</ul>

<hr>

<!-- 6. INSTALLATION -->
<div class="page-break"></div>
<h1>6. Installation &amp; Setup Guide</h1>

<h2>Prerequisites</h2>
<ul><li>XAMPP Control Panel (Apache + MySQL)</li></ul>

<h2>Steps</h2>
<ol>
    <li><strong>Extract</strong> the <code>StudentPulse</code> folder into: <code>C:\xampp\htdocs\StudentPulse</code></li>
    <li><strong>Start XAMPP</strong> – Open XAMPP Control Panel, click <strong>Start</strong> for both <strong>Apache</strong> and <strong>MySQL</strong>.</li>
    <li><strong>Import Database</strong> – Open <code>http://localhost/phpmyadmin/</code>, click the <strong>Import</strong> tab, choose the <code>database.sql</code> file from the project root, and click <strong>Import/Go</strong>.</li>
    <li><strong>Access the Application</strong>:
        <ul>
            <li>Student Portal: <code>http://localhost/StudentPulse/login.php</code></li>
            <li>Admin Portal: <code>http://localhost/StudentPulse/admin/login.php</code></li>
        </ul>
    </li>
</ol>

<h2>Default Credentials</h2>
<table>
    <tr><th>Role</th><th>Email</th><th>Password</th></tr>
    <tr><td>Admin</td><td>admin@studentpulse.test</td><td>password</td></tr>
    <tr><td>Student</td><td>student@studentpulse.test</td><td>password</td></tr>
</table>
<blockquote>Students can also self-register at <code>http://localhost/StudentPulse/register.php</code></blockquote>

<hr>

<!-- 7. UI SCREENSHOTS -->
<div class="page-break"></div>
<h1>7. User Interface Screenshots</h1>

<h2>7.1 Student Portal</h2>

<h3>Student Login Page (<code>login.php</code>)</h3>
<p>The student login page presents a split-screen layout with a branded art panel on the left and login form on the right. Students enter their email and password to authenticate. A link to admin login is provided for administrators.</p>
<figure>
    {$embeddedImages['01']}
    <figcaption>{$screenshots['01']['caption']}</figcaption>
</figure>

<h3>Student Registration Page (<code>register.php</code>)</h3>
<p>New students can create accounts by providing a username, email, and password (with confirmation). Server-side validation ensures unique usernames/emails and enforces minimum password length.</p>
<figure>
    {$embeddedImages['02']}
    <figcaption>{$screenshots['02']['caption']}</figcaption>
</figure>

<div class="page-break"></div>

<h3>Student Dashboard (<code>dashboard.php</code>)</h3>
<p>After login, students see a personalized dashboard showing their username, statistics (published events count, RSVP count, account role), and the 3 nearest upcoming events with live countdown timers.</p>
<figure>
    {$embeddedImages['03']}
    <figcaption>{$screenshots['03']['caption']}</figcaption>
</figure>

<h3>Events Hub (<code>events.php</code>)</h3>
<p>Students browse all upcoming published events. Each event card displays the category, title, description, venue, date, attendee count, a countdown timer, and an RSVP/Cancel button.</p>
<figure>
    {$embeddedImages['04']}
    <figcaption>{$screenshots['04']['caption']}</figcaption>
</figure>

<div class="page-break"></div>

<h3>Contact Page (<code>contact.php</code>)</h3>
<p>Students can submit inquiries or event ideas to the events team. The form validates name, email, subject, and message length on the server side before inserting into the database.</p>
<figure>
    {$embeddedImages['05']}
    <figcaption>{$screenshots['05']['caption']}</figcaption>
</figure>

<h3>Profile Page (<code>profile.php</code>)</h3>
<p>Displays the logged-in student's profile information retrieved from the MySQL database: username, email, role, and registration date.</p>
<figure>
    {$embeddedImages['06']}
    <figcaption>{$screenshots['06']['caption']}</figcaption>
</figure>

<div class="page-break"></div>

<h2>7.2 Admin Portal</h2>

<h3>Admin Login Page (<code>admin/login.php</code>)</h3>
<p>A dedicated login page for administrators, visually distinct from the student login with a darker theme. Only users with <code>role = 'admin'</code> in the database can authenticate here.</p>
<figure>
    {$embeddedImages['07']}
    <figcaption>{$screenshots['07']['caption']}</figcaption>
</figure>

<h3>Admin – Manage Events (<code>admin/events.php</code>)</h3>
<p>The admin events dashboard displays all events (including drafts) in a table format with columns for title, date, category, status, and action buttons (Edit / Delete). A "Create Event" button leads to the event creation form.</p>
<figure>
    {$embeddedImages['08']}
    <figcaption>{$screenshots['08']['caption']}</figcaption>
</figure>

<div class="page-break"></div>

<h3>Admin – Create/Edit Event Form (<code>admin/event_form.php</code>)</h3>
<p>Administrators use this form to create new events or edit existing ones. Fields include title, description, category (dropdown), venue, date/time, and status (Published/Draft). Comprehensive server-side validation provides specific error messages for each field.</p>
<figure>
    {$embeddedImages['09']}
    <figcaption>{$screenshots['09']['caption']}</figcaption>
</figure>

<h3>Admin – Message Submissions (<code>admin/messages.php</code>)</h3>
<p>Administrators can review all student-submitted contact messages in a tabular format showing sender name, email, subject, message body, and submission date.</p>
<figure>
    {$embeddedImages['10']}
    <figcaption>{$screenshots['10']['caption']}</figcaption>
</figure>

<hr>

<!-- 8. FEATURE BREAKDOWN -->
<div class="page-break"></div>
<h1>8. Feature Breakdown</h1>

<h2>8.1 Student Features</h2>
<table>
    <tr><th>Feature</th><th>Page</th><th>Description</th></tr>
    <tr><td>Student Login</td><td><code>login.php</code></td><td>Email/password authentication for students only</td></tr>
    <tr><td>Registration</td><td><code>register.php</code></td><td>Self-service account creation with validation</td></tr>
    <tr><td>Dashboard</td><td><code>dashboard.php</code></td><td>Personalized statistics and upcoming event previews</td></tr>
    <tr><td>Browse Events</td><td><code>events.php</code></td><td>View all published upcoming events with attendee counts</td></tr>
    <tr><td>RSVP / Cancel</td><td><code>rsvp.php</code></td><td>Join or withdraw from events via POST form</td></tr>
    <tr><td>Contact Form</td><td><code>contact.php</code></td><td>Submit messages/inquiries to the events team</td></tr>
    <tr><td>View Profile</td><td><code>profile.php</code></td><td>Display personal account information from database</td></tr>
    <tr><td>My Messages</td><td><code>submissions.php</code></td><td>View history of submitted contact messages</td></tr>
</table>

<h2>8.2 Admin Features</h2>
<table>
    <tr><th>Feature</th><th>Page</th><th>Description</th></tr>
    <tr><td>Admin Login</td><td><code>admin/login.php</code></td><td>Separate authentication for admin role only</td></tr>
    <tr><td>Manage Events</td><td><code>admin/events.php</code></td><td>View all events (published + drafts) in table</td></tr>
    <tr><td>Create Event</td><td><code>admin/event_form.php</code></td><td>Form to create new campus events</td></tr>
    <tr><td>Edit Event</td><td><code>admin/event_form.php</code></td><td>Pre-populated form to modify existing events</td></tr>
    <tr><td>Delete Event</td><td><code>admin/delete.php</code></td><td>Remove events with confirmation prompt</td></tr>
    <tr><td>View Messages</td><td><code>admin/messages.php</code></td><td>Review all student contact submissions</td></tr>
</table>

<hr>

<!-- 9. SECURITY -->
<h1>9. Security Implementation</h1>
<table>
    <tr><th>Security Measure</th><th>Implementation Detail</th></tr>
    <tr><td>Password Hashing</td><td>All passwords stored using <code>password_hash()</code> with <code>PASSWORD_DEFAULT</code> (bcrypt). Verified at login with <code>password_verify()</code>.</td></tr>
    <tr><td>CSRF Protection</td><td>Every form includes a hidden CSRF token generated by <code>bin2hex(random_bytes(32))</code>. Validated on POST using <code>hash_equals()</code>.</td></tr>
    <tr><td>Output Escaping</td><td>All user-generated output passed through <code>htmlspecialchars()</code> via the <code>e()</code> helper to prevent XSS attacks.</td></tr>
    <tr><td>Input Sanitization</td><td>User inputs sanitized via <code>trim()</code>, <code>filter_var()</code>, and <code>mysqli_real_escape_string()</code> before database operations.</td></tr>
    <tr><td>Session Security</td><td>Sessions regenerated on login (<code>session_regenerate_id(true)</code>) to prevent session fixation. Full session destruction on logout.</td></tr>
    <tr><td>Role-Based Access</td><td>Separate session keys (<code>student_id</code> / <code>admin_id</code>) and authentication guards (<code>auth()</code> / <code>admin()</code>) enforce access control.</td></tr>
    <tr><td>Separate Login Flows</td><td>Students and admins authenticate through different pages with different session namespaces.</td></tr>
    <tr><td>Server-Side Validation</td><td>All form data validated on the server regardless of HTML5 <code>required</code> attributes to prevent client-side bypass.</td></tr>
</table>

<hr>

<!-- 10. CODE STRUCTURE -->
<div class="page-break"></div>
<h1>10. Code Structure &amp; File Organization</h1>
<pre><code>StudentPulse/
├── config/
│   └── database.php          # MySQL connection (procedural mysqli)
├── includes/
│   ├── core.php              # Session, helpers (auth, CSRF, flash)
│   ├── header.php            # Shared HTML head + navbar
│   └── footer.php            # Shared HTML footer + JS
├── admin/                    # ── ADMIN PORTAL ──
│   ├── index.php             # Admin entry redirect
│   ├── login.php             # Admin authentication
│   ├── logout.php            # Admin session termination
│   ├── events.php            # Event management table
│   ├── event_form.php        # Create / Edit event form
│   ├── delete.php            # Delete event handler
│   └── messages.php          # View student messages
├── assets/
│   ├── style.css             # Application stylesheet
│   └── app.js                # Client-side JS (countdowns)
├── index.php                 # Entry: redirects by role
├── login.php                 # Student login
├── register.php              # Student registration
├── logout.php                # Student logout
├── dashboard.php             # Student dashboard
├── events.php                # Student events + RSVP
├── rsvp.php                  # RSVP handler
├── contact.php               # Student contact form
├── profile.php               # Student profile
├── submissions.php           # Student sent messages
├── database.sql              # Full schema + seed data
└── README.md                 # Setup instructions</code></pre>

<hr>

<!-- 11. TESTING -->
<h1>11. Testing &amp; Validation</h1>

<h2>11.1 PHP Syntax Validation</h2>
<p>All 21 PHP files were validated using PHP's built-in linter (<code>php -l</code>). Every file passed with <strong>zero syntax errors</strong>.</p>

<h2>11.2 Functional Testing</h2>
<table>
    <tr><th>Test Case</th><th>Expected Result</th><th>Status</th></tr>
    <tr><td>Student login with valid credentials</td><td>Redirect to dashboard</td><td class="pass">✅ Pass</td></tr>
    <tr><td>Student login with invalid password</td><td>Error message displayed</td><td class="pass">✅ Pass</td></tr>
    <tr><td>Admin login on student login page</td><td>Rejected with redirect hint</td><td class="pass">✅ Pass</td></tr>
    <tr><td>Admin login at /admin/login.php</td><td>Redirect to admin events panel</td><td class="pass">✅ Pass</td></tr>
    <tr><td>Student registration</td><td>Account created, redirect to login</td><td class="pass">✅ Pass</td></tr>
    <tr><td>Duplicate email registration</td><td>Error: "already exists"</td><td class="pass">✅ Pass</td></tr>
    <tr><td>RSVP to event</td><td>RSVP saved, button changes to "Cancel"</td><td class="pass">✅ Pass</td></tr>
    <tr><td>Cancel RSVP</td><td>RSVP removed, button reverts</td><td class="pass">✅ Pass</td></tr>
    <tr><td>Admin create event (valid)</td><td>Event saved, redirect to list</td><td class="pass">✅ Pass</td></tr>
    <tr><td>Admin create event (empty title)</td><td>Error: "Title is required"</td><td class="pass">✅ Pass</td></tr>
    <tr><td>Admin create event (empty venue)</td><td>Error: "Venue is required"</td><td class="pass">✅ Pass</td></tr>
    <tr><td>Admin edit existing event</td><td>Pre-populated form, updated on save</td><td class="pass">✅ Pass</td></tr>
    <tr><td>Admin delete event</td><td>Confirmation prompt, event removed</td><td class="pass">✅ Pass</td></tr>
    <tr><td>Contact form with valid data</td><td>Message saved with flash notification</td><td class="pass">✅ Pass</td></tr>
    <tr><td>Contact form with short message</td><td>Error: "10–2,000 characters"</td><td class="pass">✅ Pass</td></tr>
    <tr><td>CSRF token mismatch</td><td>403 Forbidden response</td><td class="pass">✅ Pass</td></tr>
    <tr><td>Access dashboard without login</td><td>Redirect to login page</td><td class="pass">✅ Pass</td></tr>
    <tr><td>Access admin pages without admin login</td><td>Redirect to admin login</td><td class="pass">✅ Pass</td></tr>
    <tr><td>Student logout</td><td>Session destroyed, redirect to login</td><td class="pass">✅ Pass</td></tr>
</table>

<hr>

<!-- 12. CONCLUSION -->
<h1>12. Conclusion</h1>
<p>StudentPulse successfully demonstrates core Internet Programming II concepts:</p>
<ul>
    <li><strong>Server-side scripting</strong> with PHP for dynamic page generation and form processing.</li>
    <li><strong>Database integration</strong> with MySQL using procedural MySQLi for CRUD operations.</li>
    <li><strong>User authentication</strong> with role-based access control separating student and admin functionalities.</li>
    <li><strong>Security best practices</strong> including password hashing, CSRF protection, input validation, and output escaping.</li>
    <li><strong>Responsive web design</strong> with a modern interface using vanilla HTML5, CSS3, and JavaScript.</li>
</ul>
<p>The application provides a practical, real-world example of a campus event management system that could be extended with additional features such as event search/filtering, email notifications, image uploads, and calendar integration.</p>

<hr>

<!-- 13. GROUP MEMBERS -->
<h1>13. Group Members</h1>
<table>
    <tr><th>#</th><th>Full Name</th><th>Registration Number</th><th>Contribution</th></tr>
    <tr><td>1</td><td>Samuel Kangethe</td><td>__________________</td><td>Project Lead / Full Stack Development</td></tr>
    <tr><td>2</td><td>__________________</td><td>__________________</td><td>__________________</td></tr>
    <tr><td>3</td><td>__________________</td><td>__________________</td><td>__________________</td></tr>
    <tr><td>4</td><td>__________________</td><td>__________________</td><td>__________________</td></tr>
    <tr><td>5</td><td>__________________</td><td>__________________</td><td>__________________</td></tr>
</table>

<hr>
<p style="text-align:center; color:#999; font-size:12px; margin-top:40px;">
    StudentPulse – Internet Programming II CAAT Documentation · July 2026
</p>

</body>
</html>
HTML;

file_put_contents($outputFile, $html);
echo "SUCCESS: Generated self-contained HTML documentation at:\n";
echo "  $outputFile\n\n";
echo "To create PDF:\n";
echo "  1. Open the HTML file in Chrome/Edge\n";
echo "  2. Press Ctrl+P (Print)\n";
echo "  3. Change Destination to 'Save as PDF'\n";
echo "  4. Click Save\n\n";
echo "To create DOCX:\n";
echo "  1. Open the HTML file in Microsoft Word\n";
echo "  2. Go to File > Save As\n";
echo "  3. Choose format: Word Document (.docx)\n";
echo "  4. Click Save\n";
?>
