<?php

class Roles
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getRoles()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM roles");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addRole($name)
    {
        $stmt = $this->pdo->prepare("INSERT INTO roles (name) VALUES (:name)");
        $stmt->execute([':name' => $name]);
        return $this->pdo->lastInsertId();
    }

    public function addSubRole($roleId, $name, $description = null)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO sub_roles (role_id, name, description) VALUES (:role_id, :name, :description)"
        );
        $stmt->execute([
            ':role_id' => $roleId,
            ':name'    => $name,
            ':description' => $description
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getSubRoles($roleId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM sub_roles WHERE role_id = :role_id");
        $stmt->execute([':role_id' => $roleId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
