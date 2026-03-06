
CI4 CRUD Exam — README
----------------------------------------
Student Name  : Clarence Izaac E. Combes
Section       : BSIT 3.7
Subject       : Advanced Web Development
Date          : March 6, 2026

---------------------------------------
DATABASE SETUP
---------------------------------------
Database name : ci4_exam
MySQL username: root
MySQL password: 

Import the included ci4_exam.sql file:
1. Open phpMyAdmin at http://localhost/phpmyadmin
2. Create a database named: ci4_exam
3. Click Import and select the ci4_exam.sql file
4. Click Go

---------------------------------------
TEST LOGIN CREDENTIALS
---------------------------------------
Email   : combes.izaac@gmail.com
Password: 123456

---------------------------------------
SETUP STEPS
---------------------------------------
1. Extract the zip file into xampp/htdocs/
2. Open terminal inside the project folder
3. Run: composer install
4. Copy env to .env and set your database credentials
5. Run: php spark migrate
6. Run: php spark serve
7. Visit: http://localhost:8080

---------------------------------------
NOTES
---------------------------------------
- Bootstrap 5 used for all UI styling
