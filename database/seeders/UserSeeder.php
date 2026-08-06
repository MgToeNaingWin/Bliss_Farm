<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->delete();

        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'superadmin',
            'phone' => '09987654321',
            'region' => 'ရန်ကုန်',
            'township' => 'မဟာအောင်မြေ',
            'village' => 'ရပ်ကွက်(၁)',
        ]);

        // Admins
        $admins = [
            ['name' => 'Admin One', 'email' => 'admin1@gmail.com', 'region' => 'ရန်ကုန်', 'township' => 'လှိုင်'],
            ['name' => 'Admin Two', 'email' => 'admin2@gmail.com', 'region' => 'မန္တလေး', 'township' => 'အောင်မြေ'],
            ['name' => 'Admin Three', 'email' => 'admin3@gmail.com', 'region' => 'စစ်ကိုင်း', 'township' => 'မင်းဘူး'],
        ];

        foreach ($admins as $admin) {
            User::create([
                'name' => $admin['name'],
                'email' => $admin['email'],
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '09' . \Illuminate\Support\Str::random(9),
                'region' => $admin['region'],
                'township' => $admin['township'],
                'village' => 'ကျေးရွာ(၁)',
            ]);
        }

        // Regular Users
        $users = [
            ['name' => 'ဦးကျော်မင်း', 'region' => 'ပဲခူး', 'township' => 'ပန်းတောင်း'],
            ['name' => 'ဒေါ်ခင်ခင်ဝင်း', 'region' => 'ဧရာဝတီ', 'township' => 'ဖျာပုံ'],
            ['name' => 'ဦးအောင်ကိုကို', 'region' => 'ရှမ်း', 'township' => 'လှိုင်လှ'],
            ['name' => 'ဒေါ်မြတ်မြတ်အေး', 'region' => 'ကချင်', 'township' => 'မြစ်ကြီးနား'],
            ['name' => 'ဦးသန်းဇော်', 'region' => 'ရန်ကုန်', 'township' => 'ဒဂုံ'],
            ['name' => 'ဒေါ်အေးအေးသန်း', 'region' => 'မန္တလေး', 'township' => 'ချမ်းမြသာစည်'],
            ['name' => 'ဦးမျိုးကို', 'region' => 'ပဲခူး', 'township' => 'ပေါင်းတည်'],
            ['name' => 'ဦးဝင်းမောင်', 'region' => 'ဧရာဝတီ', 'township' => 'မအူပင်'],
            ['name' => 'ဒေါ်စန်းစန်းမြင့်', 'region' => 'စစ်ကိုင်း', 'township' => 'ကနီ'],
            ['name' => 'ဦးဇော်ဇော်ဝင်း', 'region' => 'ရှမ်း', 'township' => 'တောင်ကြီး'],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => strtolower(str_replace(' ', '', $user['name'])) . '@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '09' . \Illuminate\Support\Str::random(9),
                'region' => $user['region'],
                'township' => $user['township'],
                'village' => 'ကျေးရွာ(' . rand(1, 10) . ')',
            ]);
        }

        $this->command->info('✅ Users seeded: 1 superadmin, 3 admins, 10 users');
    }
}
