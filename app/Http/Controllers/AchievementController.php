<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $achievements = Achievement::where('user_id', Auth::id())
            ->with(['goal.category'])
            ->orderBy('achievement_date', 'desc')
            ->paginate(12);

        $stats = [
            'total' => Achievement::where('user_id', Auth::id())->count(),
            'this_month' => Achievement::where('user_id', Auth::id())
                ->whereMonth('achievement_date', now()->month)
                ->whereYear('achievement_date', now()->year)
                ->count(),
            'this_year' => Achievement::where('user_id', Auth::id())
                ->whereYear('achievement_date', now()->year)
                ->count(),
        ];

        return view('achievements.index', compact('achievements', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\View\View
     */
    public function show(string $id)
    {
        $achievement = Achievement::where('user_id', Auth::id())
            ->with(['goal.category', 'user'])
            ->findOrFail($id);

        return view('achievements.show', compact('achievement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Show certificate download page.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadCertificate(string $id)
    {
        $achievement = Achievement::where('user_id', Auth::id())
            ->with(['goal.category', 'user'])
            ->findOrFail($id);

        return view('achievements.download', compact('achievement'));
    }

    /**
     * Generate certificate PNG based on selected template.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function generateCertificate(Request $request, string $id)
    {
        $achievement = Achievement::where('user_id', Auth::id())
            ->with(['goal.category', 'user'])
            ->findOrFail($id);

        $template = $request->input('template', 'traditional');
        
        // Generate certificate based on template
        $certificateData = $this->generateCertificateData($achievement, $template);
        
        return response()->json([
            'success' => true,
            'certificate_data' => $certificateData,
            'template' => $template
        ]);
    }

    /**
     * Generate certificate data for different templates.
     *
     * @param  \App\Models\Achievement  $achievement
     * @param  string  $template
     * @return array
     */
    private function generateCertificateData($achievement, $template)
    {
        $data = [
            'title' => $achievement->title,
            'certificate_message' => $achievement->certificate_message,
            'affirmation_message' => $achievement->affirmation_message,
            'certificate_number' => $achievement->certificate_number,
            'achievement_date' => $achievement->formatted_date,
            'user_name' => $achievement->user->name,
            'goal_title' => $achievement->goal->title,
            'category_name' => $achievement->goal->category->name,
            'category_color' => $achievement->goal->category->color,
        ];

        switch ($template) {
            case 'traditional':
                $data['template'] = 'traditional';
                $data['dimensions'] = ['width' => 1200, 'height' => 800];
                $data['preview_dimensions'] = ['width' => 480, 'height' => 320];
                break;
            case 'rectangle':
                $data['template'] = 'rectangle';
                $data['dimensions'] = ['width' => 1000, 'height' => 1000];
                $data['preview_dimensions'] = ['width' => 400, 'height' => 400];
                break;
            case 'instagram':
                $data['template'] = 'instagram';
                $data['dimensions'] = ['width' => 1080, 'height' => 1920];
                $data['preview_dimensions'] = ['width' => 432, 'height' => 768];
                break;
            default:
                $data['template'] = 'traditional';
                $data['dimensions'] = ['width' => 1200, 'height' => 800];
                $data['preview_dimensions'] = ['width' => 480, 'height' => 320];
        }

        return $data;
    }
}
