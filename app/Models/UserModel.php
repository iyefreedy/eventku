<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $allowedFields = ['name', 'email', 'image', 'password', 'token', 'role_id', 'is_active'];
    protected $useTimestamps = true;
    protected $returnType = 'App\Entities\User';
}
