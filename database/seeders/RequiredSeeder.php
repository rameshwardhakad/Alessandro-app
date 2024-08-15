<?php

namespace Database\Seeders;

use AhsanDev\Support\NestedCategory;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RequiredSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Cache::flush();

        $this->users();
        $this->categories();
        $this->options();
        $this->roles();
        $this->permissions();
        $this->pivots();
    }

    /**
     * Seed the application's database.
     */
    protected function users(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    /**
     * Seed the application's database.
     */
    protected function categories(): void
    {
        $categories = [
            'Front Site Feature' => [],
            'Front Site Faq' => [],
        ];

        DB::table('categories')->insert(
            NestedCategory::make($categories)->get()
        );
    }

    /**
     * Seed the application's database.
     */
    protected function options(): void
    {
        option([
            'app_direction' => 'ltr',
            'app_locale' => 'en',
            'app_name' => 'Spack SaaS',
            'app_timezone' => 'UTC',
            'app_url' => 'https://spack-saas.codedot.dev',
            'date_format' => 'M d, Y',
            'default_color' => 'slate-500',
            'email_config' => false,
            'header_logo' => null,
            'mail_driver' => 'smtp',
            'mail_encryption' => 'null',
            'per_page' => 15,
            'trial_days' => 5,
            'app_updates' => [
                'update_available' => false,
                'version' => '1.0.1',
                'new_version' => null,
                'checked_at' => null,
            ],
        ]);
    }

    /**
     * Seed the application's database.
     */
    protected function roles(): void
    {
        $data = [
            'Admin',
            'User',
        ];

        $data = collect($data)->map(function ($value) {
            return ['name' => $value];
        })->all();

        DB::table('roles')->insert($data);
    }

    /**
     * Seed the application's database.
     */
    protected function permissions(): void
    {
        $data = [
            'project-list:create',
            'project-list:delete',
            'project-list:update',
            'project:add/remove-user',
            'project:archive',
            'project:create',
            'project:unarchive',
            'project:update',
            'project:view-archived',
            'setting',
            'task:create',
            'task:delete',
            'task:move',
            'task:update',
            'user:create',
            'user:delete',
            'user:update',
            'user:view',
        ];

        $data = collect($data)->map(function ($value) {
            return ['name' => $value];
        })->all();

        DB::table('permissions')->insert($data);
    }

    /**
     * Seed the application's database.
     */
    protected function pivots(): void
    {
        // Assign permissions to the role.
        $role = Role::first();
        $permissions = Permission::get();
        $role->permissions()->sync($permissions);
        $user = User::first();
        $user->assignRole($role->name);
    }
}
