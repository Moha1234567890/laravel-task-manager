<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
class TaskController extends Controller
{
    

     // Fetch all tasks for the authenticated user
     public function index()
     {
        $tasks = Task::all();

        if($tasks) {

            return response()->json([

                "status" => true,
                "data" => $tasks,
                "message" => "all tasks",
            ]);

        } else {

            return response()->json([

                "status" => false,
                "data" => null,
                "message" => "not found",
            ]);
        }
        
     }
 
     // Store a new task
     public function store(Request $request)
     {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'status' => 'in:pending,in-progress,completed',
            ]);
    
            $task = Task::create([
                'title' => $validatedData['title'],
                'status' => $validatedData['status'] ?? 'pending',
                'user_id' => auth()->id(),  ///insert auth()->id here
            ]);
    
            return response()->json([
                "data" => $task,
                "status" => 200,
                "message" => "task created"
            ]);
    
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
     }
 
     // Update a task
     public function update(Request $request, Task $task)
     {
         // Check if the authenticated user owns the task
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        try {
            $validatedData = $request->validate([
                'title' => 'sometimes|string|max:255',
                'status' => 'sometimes|in:pending,in-progress,completed',
            ]);

            $task->update($validatedData);

            return response()->json([
                'message' => 'Task updated successfully',
                'task' => $task
            ], Response::HTTP_OK);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
     }
 
     // Delete a task
     public function destroy($id)
     {

        $task = Task::find($id);
        // Check if the task exists (Model Binding already handles 404)
        if (!$task) {
            return response()->json([
                'message' => 'Task not found'
            ], Response::HTTP_NOT_FOUND);
        }

        // Ensure the authenticated user owns the task
        if ($task->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Unauthorized. You do not have permission to delete this task.'
            ], Response::HTTP_FORBIDDEN);
        }

        // Try deleting the task and handle potential errors
        try {
            $task->delete();
            return response()->json([
                'message' => 'Task deleted successfully'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete the task. Please try again later.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
     }
}
