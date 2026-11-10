<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'student_roll',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Find or create a student portal login account for the given roll number.
     */
    public static function provisionStudentAccount(string $rollNo, string $name, ?string $email = null, ?string $phone = null): ?self
    {
        $rollNo = trim($rollNo);
        if ($rollNo === '') {
            return null;
        }

        $existing = static::where('student_roll', $rollNo)->first();
        if ($existing) {
            return $existing;
        }

        $safeRollSlug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '', $rollNo)) ?: ('student' . time());
        $candidateEmail = !empty($email) && !static::where('email', $email)->exists()
            ? $email
            : ($safeRollSlug . '@student.jubounnayon.com');

        if (static::where('email', $candidateEmail)->exists()) {
            $candidateEmail = $safeRollSlug . '_' . Str::lower(Str::random(4)) . '@student.jubounnayon.com';
        }

        return static::create([
            'name' => trim($name) ?: 'Student Trainee',
            'email' => $candidateEmail,
            'phone' => $phone,
            'role' => 'student',
            'student_roll' => $rollNo,
            'password' => Hash::make('student123'),
        ]);
    }
}
