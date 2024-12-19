<?php 
// app/Http/Controllers/TaskController.php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'priority' => ['required', Rule::in(['low', 'medium', 'high'])],
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        $task = Task::create($request->all());

        return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
    }

    public function upcoming()
    {
        $tasks = Task::whereBetween('due_date', [now(), now()->addDays(7)])->get();

        return response()->json($tasks, 200);
    }
}
