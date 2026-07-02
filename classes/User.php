<?php
class User
{
    // Database Connection
    private $conn;
    // User Properties
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $is_admin;
    public $created_at;

    // Constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

// Save New User
public function save(){
    $query = "INSERT INTO users
            (first_name, last_name, email, password, is_admin)
            VALUES
            (:first_name, :last_name, :email, :password, :is_admin)";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":first_name", $this->first_name);
    $stmt->bindParam(":last_name", $this->last_name);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":is_admin", $this->is_admin);

    return $stmt->execute();
}

// Find User By Email
public function findByEmail($email){
    $query = "SELECT * FROM users WHERE email = :email";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":email", $email);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Get User By ID
public function update(){
    $query = "UPDATE users
              SET first_name = :first_name,
                  last_name = :last_name,
                  email = :email
              WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":first_name", $this->first_name);
    $stmt->bindParam(":last_name", $this->last_name);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":id", $this->id);

    return $stmt->execute();
}

public function delete(){
    $query = "DELETE FROM users WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":id", $this->id);

    return $stmt->execute();
}

// Get All Users
public function getAllUsers(){
    $query = "SELECT * FROM users ORDER BY id ASC";

    $stmt = $this->conn->prepare($query);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Update User Profile
public function updateProfile()
{
    $query = "UPDATE users
              SET first_name = :first_name,
                  last_name = :last_name,
                  email = :email
              WHERE id = :id";

$stmt = $this->conn->prepare($query);

$stmt->bindParam(":first_name", $this->first_name);
$stmt->bindParam(":last_name", $this->last_name);
$stmt->bindParam(":email", $this->email);
$stmt->bindParam(":id", $this->id);

return $stmt->execute();
}

public function getById($id)
{
    $query = "SELECT * FROM users WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":id", $id);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}