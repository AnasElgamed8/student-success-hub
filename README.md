# 🎓 Student Success Hub

A professional, full-stack academic tracking system designed for university students to manage their semesters, courses, and calculate their cumulative GPA.

## 🚀 Features
- **Full CRUD Management**: Create, Read, Update, and Delete semesters and courses.
- **Academic Dashboard**: Real-time calculation of CGPA and total credits.
- **GPA Goal Simulator**: A professional tool using range sliders to predict required grades for future targets.
- **Official Transcript**: A printable, clean summary of all academic achievements.
- **User Authentication**: Secure login and registration system.
- **Modern UI**: Built with Bootstrap 5 and a custom Admin Dashboard layout.

## 🛠️ Technical Stack
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla), Bootstrap 5.
- **Backend**: PHP (Procedural).
- **Database**: MySQL.

## 📦 Installation & Setup

### 1. Database Setup
1. Open your database management tool (e.g., phpMyAdmin).
2. Create a new database named `student_success_db`.
3. Import the `database.sql` file provided in the root directory.

### 2. Server Configuration
1. Move the project folder to your local server directory (e.g., `C:/xampp/htdocs/student_success_hub`).
2. Open `includes/db_connect.php` and update the database credentials:
   ```php
   $user = "root"; 
   $pass = ""; 
   $dbname = "student_success_db";
   ```
3. Start Apache and MySQL from your XAMPP/WAMP control panel.

### 3. Run the Site
Open your browser and navigate to: `http://localhost/student_success_hub/index.php`

## 🎓 Academic Explanations (For the Professor)
This project demonstrates the following core Computer Science concepts:
- **Relational Database Design**: Using Foreign Keys to link Users $\rightarrow$ Semesters $\rightarrow$ Courses.
- **State Management**: Handling user sessions across multiple pages.
- **Dynamic UI**: Using JavaScript to calculate GPA simulations in real-time without page refreshes.
- **Modular Architecture**: Using PHP `include` to maintain a consistent header and footer across 12+ pages.
