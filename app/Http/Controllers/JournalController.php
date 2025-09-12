<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Journal::where('user_id', Auth::id());

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // Filter by mood
        if ($request->filled('mood')) {
            $query->where('mood', $request->mood);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by tags
        if ($request->filled('tags')) {
            $query->whereJsonContains('tags', $request->tags);
        }

        // Search in content
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        // Filter by important
        if ($request->filled('important')) {
            $query->where('important', $request->important === 'true');
        }

        $journals = $query->orderBy('date', 'desc')
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);

        // Get today's journal for reminder
        $todayJournal = Journal::where('user_id', Auth::id())
                              ->whereDate('date', today())
                              ->first();

        // Get mood statistics
        $moodStats = Journal::where('user_id', Auth::id())
                           ->selectRaw('mood, COUNT(*) as count')
                           ->groupBy('mood')
                           ->orderBy('count', 'desc')
                           ->get();

        return view('journals.index', compact('journals', 'todayJournal', 'moodStats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $moods = [
            'happy' => '😊 Happy',
            'sad' => '😢 Sad',
            'anxious' => '😰 Anxious',
            'calm' => '😌 Calm',
            'angry' => '😠 Angry',
            'confused' => '😕 Confused',
            'excited' => '💪 Excited',
            'tired' => '😴 Tired',
            'satisfied' => '😌 Satisfied',
            'frustrated' => '😤 Frustrated',
        ];

        $categories = [
            'Personal' => 'Personal',
            'Social' => 'Social',
            'Career' => 'Career',
            'Spiritual' => 'Spiritual',
            'Academic' => 'Academic',
            'Health' => 'Health',
            'Finance' => 'Finance',
            'Hobby' => 'Hobby',
        ];

        return view('journals.create', compact('moods', 'categories'));
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
            'date' => 'required|date',
            'title' => 'nullable|string|max:100',
            'content' => 'required|string|min:1',
            'mood' => 'required|in:happy,sad,anxious,calm,angry,confused,excited,tired,satisfied,frustrated',
            'tags' => 'nullable|array|max:5',
            'tags.*' => 'string|max:20',
            'category' => 'required|in:Personal,Social,Career,Spiritual,Academic,Health,Finance,Hobby',
            'important' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if journal already exists for this date
        $existingJournal = Journal::where('user_id', Auth::id())
                                 ->whereDate('date', $request->date)
                                 ->first();

        if ($existingJournal) {
            return redirect()->back()
                ->withErrors(['date' => 'A journal for this date already exists.'])
                ->withInput();
        }

        $journal = new Journal($request->all());
        $journal->user_id = Auth::id();
        $journal->save();

        return redirect()->route('journals.index')
            ->with('success', 'Journal created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        $journal = Journal::where('user_id', Auth::id())->findOrFail($id);
        
        return view('journals.show', compact('journal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $journal = Journal::where('user_id', Auth::id())->findOrFail($id);
        
        $moods = [
            'happy' => '😊 Happy',
            'sad' => '😢 Sad',
            'anxious' => '😰 Anxious',
            'calm' => '😌 Calm',
            'angry' => '😠 Angry',
            'confused' => '😕 Confused',
            'excited' => '💪 Excited',
            'tired' => '😴 Tired',
            'satisfied' => '😌 Satisfied',
            'frustrated' => '😤 Frustrated',
        ];

        $categories = [
            'Personal' => 'Personal',
            'Social' => 'Social',
            'Career' => 'Career',
            'Spiritual' => 'Spiritual',
            'Academic' => 'Academic',
            'Health' => 'Health',
            'Finance' => 'Finance',
            'Hobby' => 'Hobby',
        ];

        return view('journals.edit', compact('journal', 'moods', 'categories'));
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
        $journal = Journal::where('user_id', Auth::id())->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'title' => 'nullable|string|max:100',
            'content' => 'required|string|min:1',
            'mood' => 'required|in:happy,sad,anxious,calm,angry,confused,excited,tired,satisfied,frustrated',
            'tags' => 'nullable|array|max:5',
            'tags.*' => 'string|max:20',
            'category' => 'required|in:Personal,Social,Career,Spiritual,Academic,Health,Finance,Hobby',
            'important' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if journal already exists for this date (excluding current journal)
        $existingJournal = Journal::where('user_id', Auth::id())
                                 ->whereDate('date', $request->date)
                                 ->where('id', '!=', $id)
                                 ->first();

        if ($existingJournal) {
            return redirect()->back()
                ->withErrors(['date' => 'A journal for this date already exists.'])
                ->withInput();
        }

        $journal->update($request->all());

        return redirect()->route('journals.show', $journal->id)
            ->with('success', 'Journal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $journal = Journal::where('user_id', Auth::id())->findOrFail($id);
        $journal->delete();

        return redirect()->route('journals.index')
            ->with('success', 'Journal deleted successfully.');
    }

    /**
     * Show calendar view of journals.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function calendar(Request $request)
    {
        try {
            $year = $request->get('year', now()->year);
            $month = $request->get('month', now()->month);

            // Validate year and month
            if (!is_numeric($year) || $year < 1900 || $year > 2100) {
                $year = now()->year;
            }
            if (!is_numeric($month) || $month < 1 || $month > 12) {
                $month = now()->month;
            }

            // Handle month overflow/underflow
            if ($month > 12) {
                $month = 1;
                $year++;
            } elseif ($month < 1) {
                $month = 12;
                $year--;
            }

            // Get journals for the specified month
            $journals = Journal::where('user_id', Auth::id())
                              ->whereYear('date', $year)
                              ->whereMonth('date', $month)
                              ->get()
                              ->keyBy(function($journal) {
                                  return $journal->date->format('Y-m-d');
                              });

            return view('journals.calendar', compact('journals', 'year', 'month'));
        } catch (\Exception $e) {
            // Log the error and redirect with a message
            \Log::error('Calendar view error: ' . $e->getMessage());
            return redirect()->route('journals.index')
                ->with('error', 'Unable to load calendar view. Please try again.');
        }
    }

    /**
     * Get insights about user's journal patterns.
     *
     * @return \Illuminate\View\View
     */
    public function insights()
    {
        try {
            $userId = Auth::id();

            // Total journals
            $totalJournals = Journal::where('user_id', $userId)->count();

            // Most common mood
            $mostCommonMood = null;
            if ($totalJournals > 0) {
                $mostCommonMood = Journal::where('user_id', $userId)
                                        ->selectRaw('mood, COUNT(*) as count')
                                        ->groupBy('mood')
                                        ->orderBy('count', 'desc')
                                        ->first();
            }

            // Most common category
            $mostCommonCategory = null;
            if ($totalJournals > 0) {
                $mostCommonCategory = Journal::where('user_id', $userId)
                                           ->selectRaw('category, COUNT(*) as count')
                                           ->groupBy('category')
                                           ->orderBy('count', 'desc')
                                           ->first();
            }

            // Most active day of week
            $mostActiveDay = null;
            if ($totalJournals > 0) {
                try {
                    // Use MySQL DAYOFWEEK function where 1=Sunday, 2=Monday, etc.
                    $mostActiveDay = Journal::where('user_id', $userId)
                                          ->selectRaw('DAYOFWEEK(date) as day_of_week, COUNT(*) as count')
                                          ->groupBy('day_of_week')
                                          ->orderBy('count', 'desc')
                                          ->first();
                } catch (\Exception $e) {
                    \Log::warning('Could not get day of week statistics: ' . $e->getMessage());
                    // Continue without day of week data
                }
            }

            // Recent journaling streak
            $streak = $this->calculateStreak($userId);

            // Important journals count
            $importantCount = Journal::where('user_id', $userId)
                                   ->where('important', true)
                                   ->count();

            return view('journals.insights', compact(
                'mostCommonMood',
                'mostCommonCategory',
                'mostActiveDay',
                'streak',
                'totalJournals',
                'importantCount'
            ));
        } catch (\Exception $e) {
            // Log the error and redirect with a message
            \Log::error('Insights view error: ' . $e->getMessage());
            return redirect()->route('journals.index')
                ->with('error', 'Unable to load insights. Please try again.');
        }
    }

    /**
     * Calculate journaling streak.
     *
     * @param string $userId
     * @return int
     */
    private function calculateStreak($userId)
    {
        $streak = 0;
        $currentDate = now()->startOfDay();

        while (true) {
            $journal = Journal::where('user_id', $userId)
                            ->whereDate('date', $currentDate)
                            ->first();

            if (!$journal) {
                break;
            }

            $streak++;
            $currentDate->subDay();
        }

        return $streak;
    }

    /**
     * Get journals by date for calendar modal.
     *
     * @param string $date
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByDate($date)
    {
        try {
            $journals = Journal::where('user_id', Auth::id())
                              ->whereDate('date', $date)
                              ->orderBy('created_at', 'desc')
                              ->get()
                              ->map(function ($journal) {
                                  return [
                                      'id' => $journal->id,
                                      'title' => $journal->title ?: 'Journal ' . $journal->date->format('d M Y'),
                                      'content' => $journal->content,
                                      'mood_emoji' => $journal->mood_emoji,
                                      'important' => $journal->important,
                                      'tags' => $journal->tags ? implode(',', $journal->tags) : null,
                                      'created_at' => $journal->created_at->format('M d, Y \a\t h:i A'),
                                      'mood' => $journal->mood,
                                      'category' => $journal->category,
                                  ];
                              });

            return response()->json([
                'success' => true,
                'journals' => $journals
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching journals by date: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading journals for this date'
            ], 500);
        }
    }
}
