<div class="flex items-start gap-6 rounded-md border p-6 bg-white">
    {{-- Profile Picture --}}
    <div class="flex-shrink-0">
        <div class="rounded-full w-32 h-32 overflow-hidden flex items-center justify-center">
            <img src="{{ $member->image_path ? route('image', $member->image_path) : '/storage/logo/blogo.png' }}" 
                 class="w-full h-full object-cover" 
                 alt="{{ $member->display_name }}">
        </div>
    </div>

    {{-- Information Section --}}
    <div class="flex-1">
        {{-- Name --}}
        <h2 class="header text-2xl font-bold mb-2">
            {{ $member->display_name }}
        </h2>

        {{-- Parent Organisation --}}
        @if($member->parentMembership)
        <div class="text-gray-600 mb-2">
            <span class="font-semibold">Part of:</span> 
            {{ $member->parentMembership->parent->display_name }}
            <span class="text-sm text-gray-500">({{ $member->parentMembership->role }})</span>
        </div>
        @endif

        {{-- Membership Counter --}}
        @php
            $memberCount = $member->childMemberships->count();
        @endphp
        <div class="inline-flex items-center gap-2 bg-bulsca text-white px-4 py-2 rounded-md font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span>{{ $memberCount }} {{ Str::plural('Member', $memberCount) }}</span>
        </div>
    </div>
</div>