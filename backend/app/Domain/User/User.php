<?php

namespace App\Domain\User;

class User
{
    private int $id;
    private int $roleID;
    private string $name;
    private String $email;
    private String $password;

    public function __construct(int $id = null, int $roleID = null, string $name = null, string $email = null, string $password = null)
    {
        $this->id = $id;
        $this->roleID = $roleID;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
    public function toArray()
    {
        return [
            'id' => $this->id,
            'roleID' => $this->roleID,
            'name' => $this->name,
            'email' => $this->email
        ];
    }
    public function getId()
    {
        return $this->id;
    }
    public function getRoleID()
    {
        return $this->roleID;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPassword()
    {
        return $this->password;
    }
}
