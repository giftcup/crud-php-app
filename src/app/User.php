<?php

declare(strict_types=1);

namespace App;

use PDO;
use App\Database;

class User
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create_user(): void
    {
        header('Content-Type: application/json');

        $email = $_POST['email'] ?? null;
        $full_name = $_POST['name'] ?? null;

        if (!$email || !$full_name) {
            http_response_code(400);
            echo json_encode(['error' => 'Email and name are required']);
            return;
        }

        $query = 'INSERT INTO users(email, full_name) values (:email, :full_name)';

        $stmt = $this->db->prepare($query);

        $stmt->execute([
            'email' => $email,
            'full_name' => $full_name
        ]);

        http_response_code(201); // Created
        echo json_encode(['message' => 'User created successfully']);
    }

    public function read_user()
    {
        header('Content-Type: application/json');

        $email = $_GET['email'];

        if (!$email) {
            http_response_code(400);
            echo json_encode(['error' => 'No email provided']);
            return;
        }

        $query = 'SELECT * FROM users WHERE email = :email';

        $stmt = $this->db->prepare($query);

        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            http_response_code(200);
            echo json_encode(['user' => $user]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }

    public function update_user()
    {
        header('Content-Type: application/json');

        $original_email = $_GET['email'] ?? null;
        $email = $_POST['email'] ?? null;
        $full_name = $_POST['name'] ?? null;

        if (!$original_email || !$email || !$full_name) {
            http_response_code(400);
            echo json_encode(['error' => 'Email and name are required']);
            return;
        }

        $selectQuery = 'SELECT id FROM users WHERE email = :email';
        $selectStmt = $this->db->prepare($selectQuery);
        $selectStmt->execute(['email' => $original_email]);
        $user = $selectStmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
            return;
        }

        $userId = $user['id'];

        $query = 'UPDATE users SET email = :email, full_name = :full_name WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'email' => $email,
            'full_name' => $full_name,
            'id' => $userId
        ]);

        http_response_code(200);
        echo json_encode(['message' => 'User updated successfully']);
    }

    public function delete_user()
    {
        header('Content-Type: application/json');

        $email = $_GET['email'] ?? null;

        if (!$email) {
            http_response_code(400);
            echo json_encode(['error' => 'Email is required']);
            return;
        }

        $query = 'DELETE FROM users WHERE email = :email';
        $stmt = $this->db->prepare($query);
        $stmt->execute(['email' => $email]);

        if ($stmt->rowCount() > 0) {
            http_response_code(200);
            echo json_encode(['message' => 'User deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }
}
