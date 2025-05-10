# Library Management System

This is a simple Library Management System built using **PHP**, **MySQL**, **Bootstrap**, and **jQuery** for the frontend. It allows users to perform CRUD (Create, Read, Update, Delete) operations to manage books in a library system.

## Features

- **Create**: Add new books to the library with details such as book name, author, customer, return date, and price.
- **Read**: View a list of all books in the library.
- **Update**: Edit details of an existing book, including book name, author, customer, return date, and price.
- **Delete**: Delete a book record from the library.

## Technologies Used

- **Frontend**: HTML, CSS, JavaScript, Bootstrap, jQuery
- **Backend**: PHP
- **Database**: MySQL

## Requirements

To run this project, you need the following:

1. **PHP** installed on your local server.
2. **MySQL** database server.
3. **Apache** or any other PHP server.
4. **Bootstrap** and **jQuery** (included via CDN).
5. Run this query to create database and table

CREATE DATABASE IF NOT EXISTS library_db;

USE library_db;

CREATE TABLE lend (
  id INT AUTO_INCREMENT PRIMARY KEY,
  book_name VARCHAR(255) NOT NULL,
  author_name VARCHAR(255) NOT NULL,
  customer_name VARCHAR(255) NOT NULL,
  return_date DATE NOT NULL,
  price DECIMAL(10, 2) NOT NULL
);

