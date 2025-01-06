<?php

namespace App\Http\Controllers\API;

use App\Models\TasksShare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class TaskShareController extends Controller
{
    /**
     * Menampilkan semua task share.
     */
    public function index()
    {
        $taskShares = TasksShare::with('task', 'user')->get();
        return response()->json($taskShares);
    }

    /**
     * Menampilkan task share berdasarkan ID.
     */
    public function show($id)
    {
        $taskShare = TasksShare::with('task', 'user')->find($id);

        if (!$taskShare) {
            return response()->json(['message' => 'Task share not found'], 404);
        }

        // Mengecek hak akses
        if ($taskShare->shared_with !== Auth::id() && $taskShare->permission !== 'view') {
            return response()->json(['message' => 'You do not have permission to view this task share'], 403);
        }

        return response()->json($taskShare);
    }

    /**
     * Menyimpan task share baru berdasarkan pengguna yang login.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'permission' => 'required|in:view,edit',
        ]);

        // Mengambil ID pengguna yang sedang login
        $userId = Auth::id();

        // Menyimpan task share untuk user yang login
        $taskShare = TaskShare::create([
            'task_id' => $request->task_id,
            'shared_with' => $userId,
            'permission' => $request->permission,
        ]);

        return response()->json($taskShare, 201);
    }

    /**
     * Memperbarui task share berdasarkan ID dan hak akses pengguna yang login.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'permission' => 'required|in:view,edit',
        ]);

        $taskShare = TasksShare::find($id);

        if (!$taskShare) {
            return response()->json(['message' => 'Task share not found'], 404);
        }

        // Mengecek apakah pengguna yang login memiliki hak akses untuk mengedit
        if ($taskShare->shared_with !== Auth::id() && $taskShare->permission !== 'edit') {
            return response()->json(['message' => 'You do not have permission to edit this task share'], 403);
        }

        // Memperbarui task share
        $taskShare->update([
            'task_id' => $request->task_id,
            'shared_with' => Auth::id(),
            'permission' => $request->permission,
        ]);

        return response()->json($taskShare);
    }

    /**
     * Menghapus task share berdasarkan ID.
     */
    public function destroy($id)
    {
        $taskShare = TasksShare::find($id);

        if (!$taskShare) {
            return response()->json(['message' => 'Task share not found'], 404);
        }

        // Mengecek hak akses sebelum menghapus
        if ($taskShare->shared_with !== Auth::id() && $taskShare->permission !== 'edit') {
            return response()->json(['message' => 'You do not have permission to delete this task share'], 403);
        }

        $taskShare->delete();

        return response()->json(['message' => 'Task share deleted successfully']);
    }
}
