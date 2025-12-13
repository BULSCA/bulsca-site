@extends('layouts.adminlayout')

@section('title')
    Organisations |
@endsection

@section('content')
    <div class="container-responsive py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">Organisations</h1>
                <p class="text-gray-600 mt-2">Browse all clubs, leagues, and organisations</p>
            </div>
            @can('create', App\Models\Organisation::class)
                <a href="{{ route('organisations.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                    Create Organisation
                </a>
            @endcan
        </div>

        <!-- Organisations Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($organisations as $organisation)
                <a href="{{ route('organisations.show', $organisation->id) }}" 
                   class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow overflow-hidden group no-underline">
                    @if($organisation->logo)
                        <div class="h-48 bg-gray-200 overflow-hidden">
                            <img src="{{ $organisation->logo }}" alt="{{ $organisation->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    @else
                        <div class="h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <span class="text-white text-6xl font-bold">{{ substr($organisation->name, 0, 1) }}</span>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-2">
                            <h2 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                {{ $organisation->name }}
                            </h2>
                            <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded capitalize">
                                {{ str_replace('_', ' ', $organisation->type) }}
                            </span>
                        </div>
                        
                        @if($organisation->description)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{ $organisation->description }}
                            </p>
                        @endif
                        
                        <!-- Stats -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200 text-sm">
                            <div class="flex items-center text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <span>{{ $organisation->members_count ?? 0 }} members</span>
                            </div>
                            <div class="flex items-center text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span>{{ $organisation->managers_count ?? 0 }} managers</span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No organisations yet</h3>
                    <p class="text-gray-600 mb-4">Be the first to create an organisation</p>
                    @can('create', App\Models\Organisation::class)
                        <a href="{{ route('organisations.create') }}" 
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
                            Create Organisation
                        </a>
                    @endcan
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($organisations->hasPages())
            <div class="mt-8">
                {{ $organisations->links() }}
            </div>
        @endif
    </div>
@endsection