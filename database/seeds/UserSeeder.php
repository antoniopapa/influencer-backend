<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 20)->create();

        factory(User::class)->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'is_influencer' => 0
        ])->each(function (User $user) {
            \App\UserRole::create([
                'user_id' => $user->id,
                'role_id' => 1,
            ]);
        });

        factory(User::class)->create([
            'first_name' => 'Editor',
            'last_name' => 'Editor',
            'email' => 'editor@editor.com',
            'is_influencer' => 0
        ]);

        factory(User::class)->create([
            'first_name' => 'Viewer',
            'last_name' => 'Viewer',
            'email' => 'viewer@viewer.com',
            'is_influencer' => 0
        ]);
    }
}
