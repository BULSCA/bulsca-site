@php
    use App\Models\Competition;
    
    // Get competitions that finished in the last 7 days and have results
    $recentComp = Competition::where('when', '>=', now()->subDays(7))
        ->where('when', '<=', now())
        ->where(function($query) {
            $query->whereNotNull('results_resource')
                  ->orWhere('results_type', '!=', 'NONE');
        })
        ->orderBy('when', 'desc')
        ->first();
@endphp

@if($recentComp && $recentComp->hasResults())
    <a href="{{ route('lc-view', Str::lower($recentComp->hostUni->name) . '-' . $recentComp->when->format('Y') . '.' . $recentComp->id) }}" 
       class="notification-stripe ns-red">
        {{ $recentComp->hostUni->name }} results are now available!
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
        </svg>
    </a>
@endif