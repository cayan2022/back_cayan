<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * @var Repository|Application|mixed
     */
    private $count;

    public function __construct()
    {
        $this->count=config('database.seeder_count');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count($this->count)
            ->create()
            ->each(fn($user) => $user->assignRole(Role::inRandomOrder()->first()));
        //create super admin roles and give him all permissions
        $superRole = Role::firstOrCreate(['name' => 'Super', 'guard_name' => 'api']);
        $superRole->givePermissionTo(Permission::all());
        $superAdmin = User::factory()->create(['email' => 'super-admin@gmail.com']);
        $superAdmin->assignRole($superRole);
    }
}
