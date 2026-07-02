<?php

class Task
{
    private $conn;

    public $id;
    public $user_id;
    public $title;
    public $description;
    public $status;
    public $created_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function save()
    {
        $query = "INSERT INTO tasks
                (user_id, title, description, status)
                VALUES
                (:user_id, :title, :description, :status)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":status", $this->status);

        return $stmt->execute();
    }

    public function getTasksByUser($user_id)
    {
        $query = "SELECT * FROM tasks
                  WHERE user_id = :user_id
                  ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $user_id);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTaskById($id)
    {
        $query = "SELECT * FROM tasks
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update()
    {
        $query = "UPDATE tasks
                  SET
                    title = :title,
                    description = :description,
                    status = :status
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    public function delete()
    {
        $query = "DELETE FROM tasks
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    public function getAllTasks(){
    $query = "SELECT tasks.*, users.first_name, users.last_name
              FROM tasks
              INNER JOIN users
              ON tasks.user_id = users.id
              ORDER BY tasks.created_at DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}