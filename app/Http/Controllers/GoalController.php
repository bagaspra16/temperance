<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $goals = Goal::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('goals.index', compact('goals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::where('user_id', Auth::id())->get();
        return view('goals.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'priority' => 'required|in:low,medium,high',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $goal = new Goal($request->all());
        $goal->user_id = Auth::id();
        $goal->progress_percent = 0; // Menggunakan progress_percent
        $goal->save();

        return redirect()->route('goals.show', $goal->id)
            ->with('success', 'Goal created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        $goal = Goal::where('user_id', Auth::id())->findOrFail($id);
        $tasks = $goal->tasks()->orderBy('created_at', 'desc')->get();
        $progress = $goal->progressRecords()->orderBy('created_at', 'desc')->get();
        
        return view('goals.show', compact('goal', 'tasks', 'progress'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $goal = Goal::where('user_id', Auth::id())->findOrFail($id);
        $categories = Category::where('user_id', Auth::id())->get();
        
        return view('goals.edit', compact('goal', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:not_started,in_progress,complete,abandoned',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $goal = Goal::where('user_id', Auth::id())->findOrFail($id);
        $goal->update($request->all());

        // If status is complete, set progress to 100%
        if ($request->status === 'complete' && $goal->progress_percent < 100) {
            $goal->progress_percent = 100;
            $goal->save();
        }

        return redirect()->route('goals.show', $goal->id)
            ->with('success', 'Goal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $goal = Goal::where('user_id', Auth::id())->findOrFail($id);
        $goal->delete();

        return redirect()->route('goals.index')
            ->with('success', 'Goal deleted successfully.');
    }
    
    /**
     * Update the progress of a goal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProgress(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'progress_percent' => 'required|integer|min:0|max:100',
            'status' => 'required|string|in:not_started,in_progress,complete,completed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $goal = Goal::where('user_id', Auth::id())->findOrFail($id);
        
        // Update goal progress
        $goal->progress_percent = $request->progress_percent;
        $goal->status = $request->status;
        
        // Create progress record
        $goal->progressRecords()->create([
            'note' => 'Goal progress updated to ' . $request->progress_percent . '%',
            'progress_value' => $request->progress_percent,
            'user_id' => Auth::id(),
            'goal_id' => $goal->id
        ]);
        
        // Ensure status is consistent with progress
        if ($request->progress_percent == 0 && $request->status != 'not_started') {
            $goal->status = 'not_started';
        } elseif ($request->progress_percent == 100 && $request->status != 'complete' && $request->status != 'completed') {
            $goal->status = 'complete';
        } elseif ($request->progress_percent > 0 && $request->progress_percent < 100 && $request->status != 'in_progress') {
            $goal->status = 'in_progress';
        }
        
        $goal->save();

        return redirect()->route('goals.show', $goal->id)
            ->with('success', 'Goal progress updated successfully.');
    }
}