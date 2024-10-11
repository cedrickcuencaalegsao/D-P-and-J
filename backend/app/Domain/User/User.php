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
}
