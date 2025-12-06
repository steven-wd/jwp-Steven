<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Tampilkan semua tugas
    public function index()
    {
        $tasks = Task::latest()->get();

        return view('tasks.index', compact('tasks'));
    }

    // Simpan tugas baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Task::create([
            'title' => $request->title,
            'is_done' => false,
        ]);

        return redirect()->back();
    }

    // Hapus tugas
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->back();
    }

    // Toggle selesai / belum
    public function toggle(Task $task)
    {
        $task->update([
            'is_done' => ! $task->is_done,
        ]);

        return redirect()->back();
    }
}
