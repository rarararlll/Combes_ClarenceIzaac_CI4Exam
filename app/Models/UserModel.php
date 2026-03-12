<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    // Added all new profile fields
    protected $allowedFields = [
        'name', 'email', 'password', 'created_at',
        'student_id', 'course', 'year_level',
        'section', 'phone', 'address', 'profile_image',
        'profile_image',
    ];

    // Find user by email for login
    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    // Update profile — thin wrapper for readability
    public function updateProfile(int $userId, array $data): bool
    {
        return $this->update($userId, $data);
    }
}