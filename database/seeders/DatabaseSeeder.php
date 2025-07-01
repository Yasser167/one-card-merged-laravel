<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            "name" => "admin",
            "email" => "admin@admin.com",
            "password" => Hash::make("111"),
            "email_verified_at" => now(),
            "usertype" => 1,
        ]);

        Setting::create([
            'title_en' => "Store",
            'title_ar' => "متجر",
            'description_en' => "Welcome to our website! We offer you the best products and various services.",
            'description_ar' => "مرحبًا بكم في موقعنا! نقدم لكم أفضل المنتجات والخدمات المتنوعة.",
            'logo_og' => "",
            'logo_site' => "",
            'keywords' => "متجر, Store,متجر, Store,متجر, Store",
            'favicon' => "",
            'head' => "",
        ]);
    }
}
