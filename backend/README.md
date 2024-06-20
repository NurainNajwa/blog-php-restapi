
# Backend API

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
- [Usage](#usage)
- [API Endpoints](#api-endpoints)
  - [GET /users](#get-users)
  - [GET /users/{id}](#get-user-by-id)
  - [POST /users](#create-user)
  - [POST /login](#login)
  - [PUT /users/{id}](#update-user)
  - [DELETE /users/{id}](#delete-user)

## Overview
This project is a backend API developed with PHP to provide various functionalities for managing users. It includes endpoints for user registration, authentication, data retrieval, and updates.

## Features
- **User Registration**: Allows users to create new accounts.
- **User Authentication**: Provides login functionality with username and password.
- **User Management**: Allows fetching, updating, and deleting user profiles.
- **Error Handling**: Includes error responses for invalid requests or database errors.

## Technologies Used
- **PHP**: Backend scripting language.
- **PDO (PHP Data Objects)**: PHP extension for accessing databases.
- **MySQL**: Relational database management system for storing user data.

## Getting Started
To get a local copy up and running follow these simple steps.

### Prerequisites
- PHP (version >= 7.0)
- MySQL (or any other supported database)
- Web server (e.g., Apache, Nginx)
- Composer (for managing PHP dependencies)

### Installation
1. Clone the repository:
 ```bash
   git clone <repository-url>
   cd backend
```


2. Import the database schema (`my_database.sql`) into your MySQL database.

3. Configure the database connection in `config.php`:
   ```php
   // config.php
   class db {
       // Properties
       private $host = 'localhost';
       private $user = 'root';
       private $password = '';
       private $dbname = 'my_database';

       // Connect
       function connect() {
           $mysql_connect_str = "mysql:host=$this->host;dbname=$this->dbname";
           $dbConnection = new PDO($mysql_connect_str, $this->user, $this->password);
           $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           return $dbConnection;
       }
   }
   ```

4. Start your web server.

## Usage
1. Ensure your web server and database server are running.

2. Navigate to the root directory of your backend application.

3. Use tools like Postman or curl to send requests to the API endpoints.

## API Endpoints

### GET /users
Returns a list of all users.

#### Example
```http
GET /users
```

### GET /users/{id}
Returns details of a specific user by ID.

#### Parameters
- `id`: The ID of the user to retrieve.

#### Example
```http
GET /users/1
```

### POST /users
Creates a new user.

#### Example Request Body
```json
{
  "fullName": "John Doe",
  "username": "johndoe",
  "email": "john.doe@example.com",
  "password": "password123",
  "matricNumber": "12345",
  "yearOfStudy": "2024"
}
```

#### Example
```http
POST /users
Content-Type: application/json

{
  "fullName": "John Doe",
  "username": "johndoe",
  "email": "john.doe@example.com",
  "password": "password123",
  "matricNumber": "12345",
  "yearOfStudy": "2024"
}
```

### POST /login
Authenticates a user and returns user details.

#### Example Request Body
```json
{
  "username": "johndoe",
  "password": "password123"
}
```

#### Example
```http
POST /login
Content-Type: application/json

{
  "username": "johndoe",
  "password": "password123"
}
```

### PUT /users/{id}
Updates details of a specific user by ID.

#### Example Request Body
```json
{
  "id": 1,
  "fullName": "Updated Name",
  "username": "updatedusername",
  "email": "updated.email@example.com",
  "password": "updatedpassword",
  "matricNumber": "54321",
  "yearOfStudy": "2023"
}
```

#### Example
```http
PUT /users/1
Content-Type: application/json

{
  "id": 1,
  "fullName": "Updated Name",
  "username": "updatedusername",
  "email": "updated.email@example.com",
  "password": "updatedpassword",
  "matricNumber": "54321",
  "yearOfStudy": "2023"
}
```

### DELETE /users/{id}
Deletes a specific user by ID.

#### Example
```http
DELETE /users/1
```

Feel free to explore and modify the code and documentation as per your specific project requirements.
```

This README.md provides an overview of the backend API, features, technologies used, installation instructions, usage guidelines, and details about each API endpoint including examples of requests and responses. Adjust the endpoints, examples, and details based on your specific backend implementation and API requirements.