@extends('layouts.organisationlayout')

@section('title')
    Committee
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Committee Management</h1>
                    <p class="text-gray-600 mt-2">Manage positions and assignments for {{ $organisation->name }}</p>
                </div>
                <button onclick="document.getElementById('createPositionModal').classList.remove('hidden')" 
                        class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Create Position
                </button>
            </div>
        </div>

        <!-- Committee Positions -->
        @forelse($organisation->committeePositions as $position)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $position->title }}</h2>
                        @if($position->description)
                            <p class="text-gray-600 mt-1">{{ $position->description }}</p>
                        @endif
                        
                        <!-- Permissions -->
                        @if($position->permissions && count($position->permissions) > 0)
                            <div class="mt-3">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Permissions:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($position->permissions as $permission)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">
                                            {{ $availablePermissions[$permission] ?? $permission }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex space-x-2 ml-4">
                        <button onclick="openEditPositionModal({{ $position->id }}, '{{ $position->title }}', '{{ $position->description }}', {{ json_encode($position->permissions ?? []) }})" 
                                class="text-gray-600 hover:text-gray-800 p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <form method="POST" action="{{ route('organisations.committee.positions.destroy', [$organisation->id, $position->id]) }}" 
                              onsubmit="return confirm('Are you sure? This will remove all members from this position.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Members in this position -->
                <div class="border-t pt-4">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-semibold text-gray-900">Members ({{ $position->members->count() }})</h3>
                        <button onclick="openAssignMemberModal({{ $position->id }})" 
                                class="text-sm bg-green-100 hover:bg-green-200 text-green-700 font-medium py-1 px-3 rounded">
                            + Assign Member
                        </button>
                    </div>
                    
                    <div class="space-y-2">
                        @forelse($position->members as $member)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="bg-green-100 rounded-full w-10 h-10 flex items-center justify-center mr-3">
                                        <span class="text-green-600 font-bold">{{ substr($member->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $member->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $member->email }}</p>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('organisations.committee.positions.members.remove', [$organisation->id, $position->id, $member->id]) }}" 
                                      onsubmit="return confirm('Remove this member from the position?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Remove</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-gray-500 italic text-sm">No members assigned to this position</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No committee positions yet</h3>
                <p class="text-gray-600 mb-4">Create your first committee position to get started</p>
                <button onclick="document.getElementById('createPositionModal').classList.remove('hidden')" 
                        class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Create Position
                </button>
            </div>
        @endforelse
    </div>

    <!-- Create Position Modal -->
    <div id="createPositionModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Create Committee Position</h3>
                <button onclick="document.getElementById('createPositionModal').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('organisations.committee.positions.store', $organisation->id) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Position Title</label>
                    <input type="text" name="title" placeholder="e.g., Treasurer, Equipment Officer" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" rows="3" placeholder="Optional description of the role"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Permissions</label>
                    <div class="grid grid-cols-2 gap-2 max-h-60 overflow-y-auto p-2 border rounded">
                        @foreach($availablePermissions as $key => $label)
                            <label class="flex items-center space-x-2 p-2 hover:bg-gray-50 rounded">
                                <input type="checkbox" name="permissions[]" value="{{ $key }}" 
                                       class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('createPositionModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Create Position
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Position Modal -->
    <div id="editPositionModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Edit Committee Position</h3>
                <button onclick="document.getElementById('editPositionModal').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form method="POST" id="editPositionForm">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Position Title</label>
                    <input type="text" name="title" id="editTitle" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                    <textarea name="description" id="editDescription" rows="3"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Permissions</label>
                    <div class="grid grid-cols-2 gap-2 max-h-60 overflow-y-auto p-2 border rounded" id="editPermissionsContainer">
                        @foreach($availablePermissions as $key => $label)
                            <label class="flex items-center space-x-2 p-2 hover:bg-gray-50 rounded">
                                <input type="checkbox" name="permissions[]" value="{{ $key }}" 
                                       class="edit-permission rounded text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('editPositionModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Update Position
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Assign Member Modal -->
    <div id="assignMemberModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Assign Member</h3>
                <button onclick="document.getElementById('assignMemberModal').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form method="POST" id="assignMemberForm">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">User Email</label>
                    <input type="email" name="user_email" placeholder="Enter user email" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('assignMemberModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Assign
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditPositionModal(id, title, description, permissions) {
            const modal = document.getElementById('editPositionModal');
            const form = document.getElementById('editPositionForm');
            
            form.action = "{{ route('organisations.committee.positions.update', [$organisation->id, ':positionId']) }}".replace(':positionId', id);
            document.getElementById('editTitle').value = title;
            document.getElementById('editDescription').value = description || '';
            
            // Clear all checkboxes first
            document.querySelectorAll('.edit-permission').forEach(cb => cb.checked = false);
            
            // Check the permissions for this position
            permissions.forEach(permission => {
                const checkbox = document.querySelector(`.edit-permission[value="${permission}"]`);
                if (checkbox) checkbox.checked = true;
            });
            
            modal.classList.remove('hidden');
        }

        function openAssignMemberModal(positionId) {
            const modal = document.getElementById('assignMemberModal');
            const form = document.getElementById('assignMemberForm');
            
            form.action = "{{ route('organisations.committee.positions.members.assign', [$organisation->id, ':positionId']) }}".replace(':positionId', positionId);
            modal.classList.remove('hidden');
        }
    </script>
@endsection