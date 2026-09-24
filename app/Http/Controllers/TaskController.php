<?php
namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;
class TaskController {
    public function index() {
        $tasks = Task::orderByRaw("CASE WHEN status = 'Pending' THEN 0 ELSE 1 END")->orderBy('due_date')->get();
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status','Pending')->count();
        $completedTasks = Task::where('status','Completed')->count();
        return view('tasks.index', compact('tasks','totalTasks','pendingTasks','completedTasks'));
    }
    public function create() { return view('tasks.create'); }
    public function store(Request $request) {
        $data = $request->validate(['task_name'=>'required|string|max:255','description'=>'nullable|string','status'=>'required|in:Pending,Completed','due_date'=>'required|date']);
        Task::create($data); return redirect()->route('tasks.index')->with('success','Task added successfully.');
    }
    public function show(Task $task) { return view('tasks.show', compact('task')); }
    public function edit(Task $task) { return view('tasks.edit', compact('task')); }
    public function update(Request $request, Task $task) {
        $data = $request->validate(['task_name'=>'required|string|max:255','description'=>'nullable|string','status'=>'required|in:Pending,Completed','due_date'=>'required|date']);
        $task->update($data); return redirect()->route('tasks.index')->with('success','Task updated successfully.');
    }
    public function destroy(Task $task) { $task->delete(); return redirect()->route('tasks.index')->with('success','Task deleted successfully.'); }
}
