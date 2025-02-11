💰 BudgetBuddy – Smart Expense Tracking App
Effortlessly manage your finances and stay on top of your budget!

<!-- Replace with an actual project banner if available -->

📌 Overview
BudgetBuddy is a personal finance management web application built with PHP and MySQL. It allows users to track expenses, set budgets, and visualize financial data with an intuitive dashboard. Designed with user-friendly UI/UX principles, it simplifies money management for users.

Features
User Authentication – Secure login & signup system.
Dashboard Overview – Displays financial summaries and spending trends.
Budget Management – Set and update monthly budgets.
Expense Tracking – Log and categorize expenses easily.
Store Locator – Integrated map to find nearby stores.
Financial Tips – Personalized insights for better money management.
Responsive Design – Works smoothly across devices.

🔧 Tech Stack
Category	Technology Used
Frontend	HTML, CSS, Bootstrap
Backend	PHP
Database	MySQL (via connection.php)
Libraries	Google Maps API (for map.php)
Authentication	Custom PHP-based login system

📂 Project Structure
/BudgetBuddy  
│── /images (UI assets)  
│── /css (Stylesheets - styles.css)  
│── /js (JavaScript files - if applicable)  
│── Login.php (User login page)  
│── Signup.php (User registration page)  
│── Dash.php (Main dashboard)  
│── Budget.php (Budget management page)  
│── Expenses.php (Expense tracking page)  
│── Map.php (Store locator page)  
│── Functions.php (Reusable PHP functions)  
│── Connection.php (Database connection file)  
│── Logout.php (User logout function)  
│── Index.php (Homepage)  
│── README.md (This File) 

🛠️ Installation & Setup
1️⃣ Clone the Repository
git clone https://github.com/Agga2772/BudgetBuddy.git
cd BudgetBuddy
2️⃣ Set Up the Database
Open phpMyAdmin:
http://localhost/phpmyadmin
Create a new database: budgetbuddy_db.
Import the provided SQL file (if available) or manually create tables.
3️⃣ Configure Database Connection
Open connection.php and update with your database credentials:
$servername = "localhost";
$username = "root"; // Default XAMPP user
$password = ""; // Default is empty
$dbname = "budgetbuddy_db"; // Your database name
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
4️⃣ Start a Local PHP Server
If you have XAMPP, move the project to htdocs and start Apache/MySQL in XAMPP.
Alternatively, run:
php -S localhost:8000
Then, open http://localhost:8000/index.php in your browser.

📸 Screenshots
🏠 Overview
![image](https://github.com/user-attachments/assets/cd816455-ef34-4095-8302-7e513a879e6e)

📊 Budget Management
![image](https://github.com/user-attachments/assets/8ffd36e0-37bb-40e3-988c-51eca4ee10bf)
![image](https://github.com/user-attachments/assets/e0f7d174-f218-44cf-977b-5444e99978ae)
![image](https://github.com/user-attachments/assets/79959952-1bde-40fa-93d5-9fed3830ab8d)

📍 Store Locator
![image](https://github.com/user-attachments/assets/f2f485ad-b34f-4d5b-8487-8470a0613aa7)


📌 Future Improvements
🔹 Enhance UI/UX with Tailwind CSS.
🔹 Improve expense categorization with charts.
🔹 Implement React.js for frontend while keeping PHP backend.
🔹 Deploy on a live server (Heroku, Firebase, or shared hosting).
