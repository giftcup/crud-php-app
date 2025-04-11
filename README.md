# Simple PHP REST-style API for User Management

This project is a basic implementation of a REST-style API in pure PHP to perform CRUD operations on a `users` table using PDO for database interactions.

# Project Setup

### Build Container Images

- Move to the docker folder of this repository
  
    `cd docker`
- Run the command:
    
    `docker compose up --build -d`

### Create Database

- Enter the database container: 
    
    `docker exec -it crud-db bash`

- Start the database server: 

    `mysql -u root -p root`

- Create a database called `my_db` with a `users` table. The table should at least have an `id`, `email`, and `full_name`. You can run the following commands in the database container:

      CREATE DATABASE my_db;

      USE my_db;

      CREATE TABLE users (
	    id int UNSIGNED PRIMARY KEY AUTO_INCREMENT,
        email varchar(255) UNIQUE NOT NULL,
        full_name varchar(255)  NOT NULL
      );

### Use Application
- You can access the application on  `localhost:8000/users/{endpoint}`. The available endpoints and their required parameters are listed below.


## Features

- ✅ Read user by email
- ✅ Create user with email and full name
- ✅ Update user (email and name)
- ✅ Delete user by email
- 📦 Returns proper JSON responses with relevant HTTP status codes

## API Endpoints

Requests are handled via `GET`, `POST`, `PUT`, `DELETE` query parameters.

---

### 🔍 Create User

**Endpoint:** `/users/create`  
**Method:** POST  
**Form Body:**
- `email` – (string) user email
- `name` - (string) user name

**Response:**
```json
{
  "message": "User created successfully"
}
```
---

### 🔍 Read User

**Endpoint:** `/users/read`  
**Method:** GET  
**Query Parameters:**
- `email` – (string) user email

**Response:**
```json
{
  "user": {
    "id": 1,
    "email": "example@mail.com",
    "full_name": "Jane Doe"
  }
}
```

---

### 🔍 Update User

**Endpoint:** `/users/update`  
**Method:** POST  
**Query Parameters:**
- `email` – (string) user email

**Form Body:**
- `email` – (string) user email
- `name` - (string) user name

**Response:**
```json
{
  "message": "User updated successfully"
}
```

### 🔍 Delete User

**Endpoint:** `/users/delete`  
**Method:** POST  
**Query Parameters:**
- `email` – (string) user email

**Response:**
```json
{
  "message": "User deleted successfully"
}
```