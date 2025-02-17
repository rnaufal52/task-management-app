<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Tasks;
use App\Models\TasksShare;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat user untuk pengujian
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Menambahkan data contoh ke tabel tasks
        // Tasks::insert([
        //     [
        //         'title' => 'Task 1',
        //         'description' => 'This is the description for task 1.',
        //         'deadline' => now()->addDays(5),
        //         'status' => 'pending',
        //         'labels' => json_encode(['work', 'urgent']),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'title' => 'Task 2',
        //         'description' => 'This is the description for task 2.',
        //         'deadline' => now()->addDays(3),
        //         'status' => 'inProgress',
        //         'labels' => json_encode(['personal']),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'title' => 'Task 3',
        //         'description' => 'This is the description for task 3.',
        //         'deadline' => now()->addDays(7),
        //         'status' => 'completed',
        //         'labels' => json_encode(['work']),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // ]);

        // menambahkan taskh share
        TasksShare::create([
            'task_id' => 1,
            'shared_with' => 1,
            'permission' => 'edit', // hanya bisa mengedit task_id 2
        ]);

        TasksShare::create([
            'task_id' => 2,
            'shared_with' => 1,
            'permission' => 'view', // user bisa melihat task_id 2
        ]);

        TasksShare::create([
            'task_id' => 3,
            'shared_with' => 1,
            'permission' => 'view', // user bisa melihat task_id 3
        ]);
    }
}
