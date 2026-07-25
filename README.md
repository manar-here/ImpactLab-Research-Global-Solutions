# 🌍 ImpactLab – Research & Global Solutions Incubator

ImpactLab is a web-based innovation management system designed for researchers and students to propose, track, and manage research-driven solutions for critical global challenges. Unlike traditional CRUD applications, ImpactLab frames its data around global problems, innovation scoring, categories, and UN Sustainable Development Goals (SDGs), making it a powerful tool for academic incubators and innovation labs.

---

## 🚀 Features

- Global Innovation Submission: Link a specific global problem to a proposed research idea.
- Categorization: Classify innovations into domains such as Environment, Healthcare, Space, Energy, etc.
- Impact Scoring: Assign and track an impact score ranging from 1 to 100.
- SDG Alignment: Connect research ideas directly to UN Sustainable Development Goals (SDGs).
- Live Dashboard: Real-time statistics tracking total ideas, accepted innovations, and items under review.
- Status Management: Toggle innovation statuses directly between Under Review and Accepted.

---

## 🛠️ Tech Stack

- Frontend: HTML5, CSS3 (Modern Flexbox/Grid UI)
- Backend: PHP
- Database: MySQL
- Environment: XAMPP (Apache & MySQL)

---

## ⚙️ Installation & Setup

Follow these steps to run the project locally on your machine:

1. Prerequisites:
   - Download and install XAMPP.

2. Clone or Download the Project:
   - Place the project folder (named impact-lab`) inside the `htdocs directory of your XAMPP installation (`C:\xampp\htdocs\impact-lab`).

3. Start the Services:
   - Open the XAMPP Control Panel and start both Apache and MySQL.

4. Setup the Database:
   - Open your browser and go to http://localhost/phpmyadmin/.
   - Create a new database named impact_lab_db.
   - Go to the SQL tab and run the following query to create the required table:

   ```sql
   CREATE TABLE IF NOT EXISTS innovations (
       id INT AUTO_INCREMENT PRIMARY KEY,
       global_problem VARCHAR(255) NOT NULL,
       research_idea VARCHAR(255) NOT NULL,
       category VARCHAR(100) NOT NULL,
       impact_score INT NOT NULL,
       sdg VARCHAR(150) NOT NULL,
       status VARCHAR(50) DEFAULT 'Under Review',
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );