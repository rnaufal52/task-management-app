<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tasks;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Tasks= Tasks::latest()->get();

        return response()->json(['data'=>$Tasks],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari request
        $data = $request->validate([
            'title' => 'required|string|max:255', // title harus ada, berupa string, dengan panjang maksimum 255 karakter
            'description' => 'required|string', // description harus ada dan berupa string
            'deadline' => 'required|date|after:today', // deadline harus ada, berupa tanggal, dan setelah hari ini
            'status' => 'required|in:pending,inProgress,completed', // status harus salah satu dari tiga pilihan
            'labels' => 'nullable|array', // labels boleh kosong, tapi jika ada, harus berupa array
            'labels.*' => 'string|distinct|max:50', // setiap elemen dalam labels harus berupa string, tidak boleh duplikat, dan panjang maksimum 50 karakter
        ]);

        // Simpan data task ke dalam database
        $task = Tasks::create($data);

       // Mengembalikan response berhasil
        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task,
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       // Cari task berdasarkan ID
        $task = Tasks::find($id);

        // Jika task tidak ditemukan, kembalikan response error
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Kembalikan task sebagai response JSON
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'status' => 'required|in:pending,inProgress,completed',
            'labels' => 'nullable|array',
            'labels.*' => 'string',
        ]);

        // Cari task berdasarkan ID
        $task = Tasks::find($id);

        // Jika task tidak ditemukan, kembalikan response error
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Update task dengan data yang sudah divalidasi
        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'deadline' => $validated['deadline'],
            'status' => $validated['status'],
            'labels' => $validated['labels'] ?? [],
        ]);

        // Kembalikan response sukses dengan task yang sudah diperbarui
        return response()->json($task);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari task berdasarkan ID
        $task = Tasks::find($id);

        // Jika task tidak ditemukan, kembalikan response error
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Hapus task
        $task->delete();

        // Kembalikan response sukses
        return response()->json(['message' => 'Task deleted successfully']);
    }

}
