# 🌍 ImpactLab – Research & Global Solutions Incubator

ImpactLab is a web-based innovation management system designed for researchers and students to propose, track, and manage research-driven solutions for critical global challenges. Unlike traditional CRUD applications, ImpactLab frames its data around global problems, innovation scoring, categories, and UN Sustainable Development Goals (SDGs), making it a powerful tool for academic incubators and innovation labs.

---

## 🚀 Features

* **Add New Innovations:** Easily record global problems, proposed research ideas, and their impact scores.
* **Dynamic Data Logging:** Automatically fetches and displays registered solutions from a secure database.
* **Clean & Professional UI:** Built with Bootstrap 5, featuring a structured, classic, and elegant user interface.
* **Status Tracking:** Monitor the progress and status of each recorded research entry.

---

## 🛠️ Tech Stack

* **Frontend:** HTML5, CSS3, Bootstrap 5
* **Backend:** PHP
* **Database:** MySQL (managed via local environments like XAMPP)

---

## 📁 Project Structure

```text
ImpactLab/
│
├── index.php           # Main dashboard and user interface
├── db.php              # Database connection configuration
└── add_innovation.php  # Backend script for handling form submissions

⚙️ Installation & Setup
To run this project locally on your machine:
 * Clone or Download this repository into your local server directory (e.g., htdocs in XAMPP).
 * Start Local Server: Open XAMPP and start Apache and MySQL.
 * Setup Database:
   * Open phpMyAdmin (http://localhost/phpmyadmin).
   * Create a new database named innovations (or configure it in db.php).
   * Create the required table with fields matching the application (e.g., global_problem, research_idea, impact_score, status).
 * Run the Project: Open your browser and navigate to:
   http://localhost/ImpactLab/

⚠️ Technical Challenges & Solutions
During the development and deployment process of ImpactLab, several technical hurdles were encountered and resolved:
 * Challenge 1: Free Hosting Database Constraints & Reserved Keywords
   * Issue: Standard free hosting providers (such as InfinityFree) imposed restrictive naming rules, reserved database keywords, and rigid permission structures that frequently broke MySQL connection configurations.
   * Solution: Bypassed rigid external hosting restrictions by maintaining a robust local XAMPP environment and utilizing tunneling tools for secure sharing.
 * Challenge 2: Live Remote Access Without Hosting Restrictions
   * Issue: The need to present and demonstrate the live running application externally without dealing with third-party hosting setup errors.
   * Solution: Implemented Ngrok to securely tunnel the local Apache server (http://localhost), instantly generating a reliable public HTTPS URL pointing directly to the local database and PHP backend without modifying core configuration files.
🌐 Public Sharing (Optional)
If you need to share your local server with others for a live presentation or review without deploying to a public host, you can use Ngrok:
ngrok http 80

