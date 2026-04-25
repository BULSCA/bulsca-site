<div class="location-display">
    @if($location)
        @if(is_object($location))
            <!-- Location Model Object -->
            <div class="space-y-2">
                <h3 class="font-bold text-lg">{{ $location->name }}</h3>
                @if($location->address)
                    <p class="text-gray-600">{{ $location->address }}</p>
                @endif
                @if($location->postcode)
                    <p class="text-gray-600">{{ $location->postcode }}</p>
                @endif
                @if($location->country)
                    <p class="text-gray-600">{{ $location->country }}</p>
                @endif
                @if($location->lat && $location->long)
                    <p class="text-sm text-gray-500">
                        <a href="https://maps.google.com/?q={{ $location->lat }},{{ $location->long }}" target="_blank" class="text-blue-600 hover:underline">
                            View on Map ({{ $location->lat }}, {{ $location->long }})
                        </a>
                    </p>
                @endif
            </div>
        @else
            <!-- Simple String Location -->
            <div class="space-y-2">
                <p class="text-gray-700">{{ $location }}</p>
            </div>
        @endif
    @else
        <p class="text-gray-500">No location specified</p>
    @endif
</div>