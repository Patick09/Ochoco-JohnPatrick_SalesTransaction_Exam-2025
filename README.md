# 🛒 Sales Transaction System

---

## 📘 Description / Overview  
The *Sales Transaction System* is a *Transaction Processing System (TPS)* designed to streamline and manage sales operations for a business.  
This system enables users to record sales, manage inventory, and generate reports in an efficient and user-friendly manner.

---

## 🎯 Objectives  
To develop a web-based Sales Transaction System that simplifies the recording and tracking of sales transactions.  
- To automate the process of *recording sales, managing inventory, and processing payments*, thereby reducing manual errors and delays.  
- To provide a structured system for managing *product data, customer information, and transaction records*.  
- To allow staff to *view, approve, update, or delete* transaction records via an administrative interface.  
- To ensure *data accuracy, security, and accessibility* in the system’s database.  
- To enhance user experience through a *responsive and intuitive interface* for both front-end users and administrators.  
- To demonstrate the use of *transaction processing and database management* concepts in a real-world business setting.

---

## ⚙️ Features / Functionality  
- **Dashboard** — provides an overview of key data such as total products, customers, sales transactions, and revenue.  
- **Add Product** — allows users to register and store product information (name, SKU, stock level, price).  
- **Add Customer** — enables registering customer details for tracking sales and relationships.  
- **Add Transaction (Sale)** — users can create a transaction by selecting a customer, adding products (and quantities), applying payment details, and saving the sale.    
- **CRUD Operations** — supports Create, Edit, Update, and Delete for products, customers, transactions.   
- **Data Organization** — integrates all records in a structured database for tracking sales history, stock levels, and payment status.

---

## 🧩 Installation Instructions  
To set up and run the Sales Transaction System on your local machine, follow these steps:  

1. **Download or Clone the Project**  
   ```bash
   git clone https://github.com/Patick09/Ochoco-JohnPatrick_SalesTransaction_Exam-2025.git

2. **Move the Project Folder**

Place the project folder into your web server’s root directory (for example, if using XAMPP: C:\xampp\htdocs\sales-transaction-system).



3. **Start Web Server & Database**

Launch your web server (e.g., Apache) and database service (e.g., MySQL) using your server control panel (such as XAMPP).



4. **Set Up the Database**

Open your web browser and navigate to your database admin tool (e.g., http://localhost/phpmyadmin).

Create a new database (e.g., sales_transaction_system).

Import the supplied SQL file (e.g., sales_transaction_system.sql) into the database.



5. **Configure Database Connection**

Open the project’s configuration file (e.g., dbconnect.php or connection.php).

Ensure these settings match your local setup:

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "sales_transaction_system";



6. **Run the Project**

In your web browser, go to:

http://127.0.0.1:8000/dashboard

You should see the system dashboard and be ready to use the application.





---

##🚀 Usage

To effectively use the Sales Transaction System, follow these steps:

1. **Access the System**

Open your web browser and navigate to:

http://127.0.0.1:8000/dashboard

The dashboard will display summary information: total products, customers, transactions, and revenue.



2. **Add a Product**

Navigate to the “Add Product” section.

Fill out product details: name, SKU, initial stock, price, etc.

Click Save to store the product in the database.



3. **Add a Customer**

Go to the “Add Customer” section.

Enter customer details: name, contact information, etc.

Click Save to register the customer in the system.



4. **Record a Sale (Transaction)**

Open the “Add Transaction” page.

Select an existing customer from the dropdown list.

Add one or more products (specify quantities).

Enter payment details (amount, method, date).

Click Submit to create the transaction record and update stock levels accordingly.



5. **View or Update Records**

Each module (Products, Customers, Transactions, Payments) allows you to view, edit, or delete records using action buttons.


---



##👥 Contributors

John Patrick Ochoco
Developer of the Sales Transaction System
BS Information Technology Student

John Felix Manahan
Co-Developer / Project Partner
BS Information Technology Student



---

🧾 License

This project is licensed for educational purposes only.
You are free to modify and use the system for learning, research, and academic development.
Commercial use or distribution without permission is not allowed.

