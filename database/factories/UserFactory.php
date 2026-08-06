<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'user',
            'phone' => '09' . fake()->numerify('#########'),
            'region' => fake()->randomElement(['ရန်ကုန်', 'မန္တလေး', 'စစ်ကိုင်း', 'ပဲခူး', 'ဧရာဝတီ', 'ကချင်', 'ရှမ်း']),
            'township' => fake()->randomElement(['မဟာအောင်မြေ', 'အောင်လံ', 'လှိုင်', 'မင်းဘူး', 'ဖျာပုံ', 'ပန်းတောင်း']),
            'village' => fake()->randomElement(['ကျေးရွာ(၁)', 'ကျေးရွာ(၂)', 'ကျေးရွာ(၃)', 'ရပ်ကွက်(၁)', 'ရပ်ကွက်(၂)']),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    public function superAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'superadmin',
        ]);
    }
}
