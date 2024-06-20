# Blog Project

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
- [Backend Setup](#backend-setup)
  - [Configuration](#configuration)
  - [Running the Backend](#running-the-backend)
- [Frontend Setup](#frontend-setup)
  - [Project Structure](#project-structure)
  - [Running the Frontend](#running-the-frontend)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Overview
The Blog project is a full-stack web application for managing and publishing blog posts. It consists of a backend API developed with PHP and a frontend SPA (Single Page Application) built with Vue.js.

## Features
- **User Authentication**: Allows users to register, login, and manage their accounts.
- **CRUD Operations**: Enables users to create, read, update, and delete blog posts.
- **Commenting System**: Supports commenting on blog posts.
- **Responsive Design**: Provides a responsive and user-friendly interface for both desktop and mobile devices.

## Technologies Used
- **Backend**:
  - PHP
  - MySQL
  - PDO (PHP Data Objects)
  
- **Frontend**:
  - Vue.js
  - Vuex (for state management)
  - Vue Router (for routing)
  - Axios (for HTTP requests)
  - Bootstrap (for styling)

## Getting Started
To get a local copy up and running, follow these simple steps.

### Prerequisites
- PHP (version >= 7.0)
- MySQL (or any other supported database)
- Node.js (for frontend development)
- Composer (for managing PHP dependencies)

### Installation
1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd blog
   ```

2. **Backend Setup**:
   - Import the database schema (`blog.sql`) into your MySQL database.
   - Configure the database connection in `config.php`.

3. **Frontend Setup**:
   ```bash
   cd frontend
   npm install
   ```

## Backend Setup
### Configuration
Update `config.php` with your database credentials:
```php
// config.php
class db {
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $dbname = 'blog_database';

    // Connect
    function connect() {
        $mysql_connect_str = "mysql:host=$this->host;dbname=$this->dbname";
        $dbConnection = new PDO($mysql_connect_str, $this->user, $this->password);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
}
```

### Running the Backend
Start your PHP development server or use a web server like Apache or Nginx to host the backend.

## Frontend Setup
### Project Structure
The frontend project structure:
```
frontend/
├── node_modules/
├── public/
├── src/
│   ├── assets/
│   ├── components/
│   ├── views/
│   ├── App.vue
│   ├── main.js
│   ├── router.js
├── .gitignore
├── babel.config.js
├── package.json
└── README.md
```

### Running the Frontend
```bash
cd frontend
npm run serve
```

## Usage
1. Ensure both backend and frontend servers are running.
2. Navigate to `http://localhost:8080` (or your specified frontend port) in your web browser.
3. Register or login to start creating and managing blog posts.
4. Explore and interact with the blog features such as creating posts, commenting, etc.

## Contributing
Contributions are welcome! Please fork the repository and create a pull request with your improvements.

## License
This project is licensed under the [MIT License](LICENSE).
```

This README.md file provides a comprehensive guide for setting up and running the entire "Blog" project, including backend and frontend components. Adjust the paths, dependencies, and instructions as per your specific project structure and requirements.