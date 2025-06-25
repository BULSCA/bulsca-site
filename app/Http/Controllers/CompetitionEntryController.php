<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\CompetitionInfo;
use App\Models\CompetitionEntry;
use App\Models\Season;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\University;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CompetitionEntryController extends Controller
{
    public function create($competitionId)
    {
        $competition = Competition::findOrFail($competitionId);
        $user = auth()->user();
    
        if ($user->university) {
            // Check if the university has already submitted an entry for this competition
            $existingEntry = $user->university->competitionEntries()
                ->where('competition_id', $competitionId)
                ->first();
    
            if ($existingEntry) {
                return redirect()->route('lc-manage', $competitionId)
                    ->with('info', 'You have already submitted an entry for this competition.');
            }
    
            return view('competition-entry.create', compact('competition', 'user.university'));
        } else {
            return redirect()->route('dashboard')
                ->with('error', 'You must be associated with a university to submit a competition entry.');
        }
    }

    public function store(Request $request, $competitionId)
    {
        $validatedData = $request->validate([
            'team_name' => 'required|string',
            'team_members' => 'required|array',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
        ]);

        $university = auth()->user()->university;
        $competition = Competition::findOrFail($competitionId);

        $entry = $university->competitionEntries()->create([
            'competition_id' => $competition->id,
            'team_name' => $validatedData['team_name'],
            'team_members' => json_encode($validatedData['team_members']),
            'contact_email' => $validatedData['contact_email'],
            'contact_phone' => $validatedData['contact_phone'],
        ]);

        return redirect()->route('lc-manage', $competitionId)
            ->with('success', 'Competition entry submitted successfully!');
    }

    public function edit($competitionId)
    {
        $competition = Competition::findOrFail($competitionId);
        $university = auth()->user()->university;
        $entry = $university->competitionEntries()
            ->where('competition_id', $competitionId)
            ->first();

        if (!$entry) {
            return redirect()->route('lc-manage', $competitionId)
                ->with('error', 'You have not submitted an entry for this competition yet.');
        }

        return view('competition-entry.edit', compact('competition', 'university', 'entry'));
    }

    public function update(Request $request, $competitionId)
    {
        $validatedData = $request->validate([
            'team_name' => 'required|string',
            'team_members' => 'required|array',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
        ]);

        $university = auth()->user()->university;
        $entry = $university->competitionEntries()
            ->where('competition_id', $competitionId)
            ->first();

        $entry->update([
            'team_name' => $validatedData['team_name'],
            'team_members' => json_encode($validatedData['team_members']),
            'contact_email' => $validatedData['contact_email'],
            'contact_phone' => $validatedData['contact_phone'],
        ]);

        return redirect()->route('lc-manage', $competitionId)
            ->with('success', 'Competition entry updated successfully!');
    }
}
