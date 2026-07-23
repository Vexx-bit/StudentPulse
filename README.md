# 🎓 StudentPulse - Campus Events Management Portal
> **Course Project**: Internet Programming II  
> **Tech Stack**: PHP (Procedural MySQLi), MySQL, HTML5, CSS3, JavaScript

StudentPulse is a campus event management system designed for students to explore, RSVP, and track university events while providing administrators with a separate control panel to manage events and student inquiries.

---

## 🛠️ Requirements & Setup Guide

### 1. Prerequisites
- **XAMPP Control Panel** (Includes Apache Web Server & MySQL Database).
- Any standard browser (Chrome, Firefox, Edge, etc.).

---

### 2. Step-by-Step Installation

#### **Step 1: Extract Project Files**
- Copy or unzip the `StudentPulse` folder into your XAMPP `htdocs` directory:
  ```text
  C:\xampp\htdocs\StudentPulse
  ```

#### **Step 2: Start XAMPP Server**
1. Open **XAMPP Control Panel**.
2. Click **Start** next to **Apache**.
3. Click **Start** next to **MySQL**.

#### **Step 3: Import Database (`database.sql`)**
1. Open your browser and go to:  
   👉 [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)
2. Click on the **Import** tab at the top.
3. Click **Choose File** and select the [`database.sql`](database.sql) file inside `C:\xampp\htdocs\StudentPulse\`.
4. Click **Import** (or **Go**) at the bottom.
   > *Note: The script automatically creates the database `studentpulse` with all necessary tables and sample seed data.*

#### **Step 4: Launch the Application**
Open your browser and visit:  
👉 **[http://localhost/StudentPulse/](http://localhost/StudentPulse/)**

---

## 🔐 Login Portals & Tested Credentials

### 1. 🛡️ Admin Portal
- **URL**: [http://localhost/StudentPulse/admin/login.php](http://localhost/StudentPulse/admin/login.php) (or `/admin/`)
- **Admin Credentials**:
  - **Email**: `admin@studentpulse.test`
  - **Password**: `password`
- **Admin Features**: Create events, edit events, publish/draft events, delete events, and review student contact message submissions.

---

### 2. 🎓 Student Portal
- **URL**: [http://localhost/StudentPulse/login.php](http://localhost/StudentPulse/login.php)
- **Student Credentials**:
  - **Email**: `student@studentpulse.test`
  - **Password**: `password`
- **Self-Registration**: Teammates or students can also create new accounts at [http://localhost/StudentPulse/register.php](http://localhost/StudentPulse/register.php).
- **Student Features**: Browse upcoming campus events, RSVP or cancel RSVPs, view dashboard countdown timers, submit contact inquiries, and manage profile.

---

## 📁 Project Architecture & Code Design

- **Procedural MySQLi Syntax**: Easy-to-read, standard PHP `mysqli_*` procedural functions (`mysqli_connect`, `mysqli_query`, `mysqli_fetch_assoc`, `mysqli_real_escape_string`) designed for quick code presentation and defense.
- **Separated Module Structure**:
  - `/` (Root): Student-facing pages (`login.php`, `register.php`, `dashboard.php`, `events.php`, `rsvp.php`, `contact.php`, `profile.php`).
  - `/admin/`: Dedicated Admin Control Panel (`admin/login.php`, `admin/events.php`, `admin/event_form.php`, `admin/delete.php`, `admin/messages.php`).
  - `/config/`: Central database connection (`config/database.php`).
  - `/includes/`: Shared header, footer, CSRF security, and session management (`includes/core.php`, `includes/header.php`, `includes/footer.php`).

---
