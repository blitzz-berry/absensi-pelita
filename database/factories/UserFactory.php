<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => '', // Biarkan kosong karena di model tidak digunakan
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'guru',
            'nama' => fake()->name(),
            'nomor_id' => 'TEST-' . fake()->unique()->numberBetween(100, 999),
            'nomor_telepon' => fake()->phoneNumber(),
            'jabatan' => 'Guru',
            'gelar' => 'S.Pd',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Define state for admin user
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'email' => $attributes['email'] ?? fake()->unique()->safeEmail(),
            'nama' => 'Admin Test',
            'nomor_id' => 'ADM-' . fake()->unique()->numberBetween(100, 999),
        ]);
    }
}
