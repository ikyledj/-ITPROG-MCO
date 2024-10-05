# IT-PROG (Integrative Programming)  
### Machine Project  
**1st TAY 2024-25**  

## Inventory Management System

### DoggyLovers  

### Team Members:
- **Kyle Russ De Jesus**
- **Arstin Miguel Reaño**
- **Maria Alyssa Mansueto**
- **Marcus Brent Go**
- **Julianna Charlize Lammoglia**

---

## Introduction
Many medium to large businesses face difficulties in tracking their inventory, often due to the high volume of items and inefficient systems. Our project aims to provide a solution by developing an **Inventory Management System** that streamlines inventory processes for both the client and server sides. The system will allow employees to manage inventory tasks and administrators to oversee the entire inventory efficiently.

---

## Phase 1 - Client Side
Medium to large businesses often struggle with tracking inventory due to large quantities of items and inefficient systems. The client side of this project is designed for lower-ranking workers responsible for regularly checking and updating store inventory.

### Features:

- **Login and Authentication:**
  - Only authorized users (distributors or employees) can access the system.
  - The system provides a secure login feature using usernames and passwords.
  - After authentication, users can access their respective inventory sections.

- **View Assigned Products:**
  - The system displays inventory items assigned to the user, including item names, categories, current product quantities, and unit prices.
  - Users can navigate through the assigned products to get an overview of available items.

- **Update Inventory:**
  - Users can update inventory levels by adding or deducting quantities of assigned items.
  - The system offers a simple input form where users can enter new item quantities.
  - Real-time updates ensure current inventory data is always available.

- **Inventory Transactions History:**
  - Users can view a transaction history showing all updates made to their assigned products.
  - The system logs each transaction, displaying details such as product name, quantity added or deducted, and date of the transaction.
  - This helps users track changes over time.

- **Generate Reports:**
  - Users can generate reports displaying current inventory levels and recent transactions for their assigned items.
  - These reports can be printed or exported for further use.

### Technologies Used:
- The client side will be developed using **PHP** and **MySQL** for backend management.
- The user interface will be designed for easy navigation, available either as a web-based or standalone application.

---

## Phase 2 - Server Side
The server-side application is designed for administrators to manage inventory across all distributors or employees. This section includes advanced features like creating user accounts, assigning inventory, and generating detailed reports.

### Features:

- **Admin Login and Account Management:**
  - Only authorized administrators can access the server-side features.
  - Administrators can create and manage accounts for distributors, including setting usernames and initial passwords.

- **Inventory Management:**
  - Administrators can add new inventory items, specifying item names, categories, unit prices, and initial quantities.
  - Inventory can be categorized into sections like "Raw Materials" and "Finished Goods" for easier organization.

- **Assign Products to Distributors:**
  - Admins can assign specific inventory items to distributors, setting initial inventory levels for each distributor.
  - Assigned items can be modified at any time.

- **Track and Manage Transactions:**
  - Admins can view all transactions made by distributors, including item additions and deductions.
  - The system provides detailed summaries, allowing for a full audit trail of inventory changes.

- **Generate Detailed Reports:**
  - The server side allows the generation of comprehensive reports, including item availability, transaction history, and performance metrics across all distributors.
  - Reports can be exported in multiple formats, such as **XML**, for external use or further processing.

### Technologies Used:
- The server side will also be developed using **PHP** and **MySQL**, with **XML export capabilities**.
- The interface will be tailored to administrators for ease of inventory control and management.
