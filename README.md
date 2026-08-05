# Event Booking System

A full-stack, role-based event management and ticket reservation web application. This system allows administrators to seamlessly create and manage events, while providing customers with an intuitive platform to browse, search, book, and cancel event tickets.

## Developer Information
* **Name:** Tosibul Hossain
* **Student ID:** E223025
* **GitHub Profile:** [Tosibulhossain](https://github.com/Tosibulhossain)

## Tech Stack
* **Backend:** PHP (Core/Vanilla)
* **Database:** MySQL (PDO extension for secure queries)
* **Frontend:** HTML5, CSS3 (Custom Dark Theme), Vanilla JavaScript
* **Authentication:** Secure PHP Sessions & bcrypt Password Hashing

## Key Features
* **Role-Based Access Control (RBAC):** Distinct dashboards and capabilities for standard Customers and Administrators.
* **Secure User Authentication:** Registration and login system utilizing strong cryptographic hashing (`PASSWORD_BCRYPT`).
* **Event Management (Admin):** Admins can create, view, and delete scheduled events.
* **Event Discovery & Filtering:** A public-facing catalogue with dynamic search (by keyword) and filtering (by location).
* **Ticket Booking Engine:** Logic preventing overbooking beyond event capacity and stopping duplicate bookings by the same user.
* **Booking History & Cancellation:** Users can view their complete booking history and cancel upcoming reservations with a single click.
* **Admin Overview Panel:** Administrators have global visibility over all bookings across the platform.

## Repository Structure
```text
event-booking-system/
│
├── config/
│   └── db.php                 # Database connection (PDO)
│
├── includes/
│   ├── header.php             # Global HTML header, navigation, and CSS
│   └── footer.php             # Global HTML footer
│
├── index.php                  # Public landing page
├── register.php               # User registration functionality
├── login.php                  # User authentication functionality
├── logout.php                 # Session termination
├── dashboard.php              # Role-based routing dashboard
├── events.php                 # Event listing with search & filter logic
├── book.php                   # Booking processing script
├── my_bookings.php            # User-specific ticket history & cancellation
├── manage_events.php          # Admin tool: Event listing and deletion
├── create_event.php           # Admin tool: Event creation form
├── admin_bookings.php         # Admin tool: Global booking overview
└── README.md                  # Project documentation

## 🚀 Installation & Running Guide

Follow these step-by-step instructions to run the Event Booking System on your local machine.

### Step 1: Prerequisites
Ensure you have a local server environment installed, such as [XAMPP](https://www.apachefriends.org/), WAMP, or MAMP. You must have both **Apache** and **MySQL** services running.

### Step 2: Clone the Repository
Open your terminal or command prompt, navigate to your local server's root directory (e.g., `C:\xampp\htdocs\` for XAMPP), and clone this repository:
```bash
git clone [https://github.com/Tosibulhossain/event-booking-system.git](https://github.com/Tosibulhossain/event-booking-system.git)