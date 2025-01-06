<?php

namespace App\Http\Controllers;

use App\Models\TaskShare;
use Illuminate\Http\Request;

class TasksShareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data task share
        $taskShares = TaskShare::all();

        // Menampilkan data dalam format JSON
        return response()->json($taskShares);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id', // Validasi task_id ada di tabel tasks
            'shared_with' => 'required|exists:users,id', // Validasi shared_with ada di tabel users
            'permission' => 'required|in:view,edit', // Validasi permission hanya boleh 'view' atau 'edit'
        ]);

        // Membuat task share baru
        $taskShare = TaskShare::create([
            'task_id' => $validated['task_id'],
            'shared_with' => $validated['shared_with'],
            'permission' => $validated['permission'],
        ]);

        // Mengembalikan response JSON
        return response()->json($taskShare, 201); // 201 untuk menunjukkan resource berhasil dibuat
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mencari task share berdasarkan ID
        $taskShare = TaskShare::find($id);

        // Jika task share tidak ditemukan, kembalikan 404
        if (!$taskShare) {
            return response()->json(['message' => 'Task Share not found'], 404);
        }

        // Mengembalikan task share yang ditemukan
        return response()->json($taskShare);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validated = $request->validate([
            'task_id' => 'sometimes|required|exists:tasks,id', // Validasi task_id ada di tabel tasks
            'shared_with' => 'sometimes|required|exists:users,id', // Validasi shared_with ada di tabel users
            'permission' => 'sometimes|required|in:view,edit', // Validasi permission hanya boleh 'view' atau 'edit'
        ]);

        // Mencari task share berdasarkan ID
        $taskShare = TaskShare::find($id);

        // Jika task share tidak ditemukan, kembalikan 404
        if (!$taskShare) {
            return response()->json(['message' => 'Task Share not found'], 404);
        }

        // Update kolom yang ada di request
        $taskShare->update($validated);

        // Mengembalikan data task share yang telah diperbarui
        return response()->json($taskShare);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Mencari task share berdasarkan ID
        $taskShare = TaskShare::find($id);

        // Jika task share tidak ditemukan, kembalikan 404
        if (!$taskShare) {
            return response()->json(['message' => 'Task Share not found'], 404);
        }

        // Menghapus task share
        $taskShare->delete();

        // Mengembalikan response sukses
        return response()->json(['message' => 'Task Share deleted successfully']);
    }
}
