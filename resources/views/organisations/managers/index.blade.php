@extends('layouts.organisationlayout')

@section('title')
    Managers
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Managers</h1>
                    <p class="text-gray-600 mt-2">Owners and administrators for {{ $organisation->name }}</p>
                </div>
                <button onclick="document.getElementById('addManagerModal').classList.remove('hidden')" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Add Manager
                </button>
            </div>
        </div>

        <!-- Owners Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded mr-2 text-sm">Owners</span>
                Full control over organisation
            </h2>
            <div class="space-y-3">
                @forelse($organisation->owners as $owner)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <div class="flex items-center">
                            <div class="bg-purple-100 rounded-full w-12 h-12 flex items-center justify-center mr-4">
                                <span class="text-purple-600 font-bold text-lg">{{ substr($owner->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $owner->name }}</p>
                                <p class="text-sm text-gray-500">{{ $owner->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm font-medium rounded-full">Owner</span>
                            @if($organisation->owners()->count() > 1)
                                <form method="POST" action="{{ route('organisations.managers.destroy', [$organisation->id, $owner->id]) }}" 
                                      onsubmit="return confirm('Are you sure you want to remove this owner?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 p-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 italic">No owners</p>
                @endforelse
            </div>
        </div>

        <!-- Admins Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded mr-2 text-sm">Admins</span>
                Can manage most aspects of the organisation
            </h2>
            <div class="space-y-3">
                @forelse($organisation->admins as $admin)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <div class="flex items-center">
                            <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mr-4">
                                <span class="text-blue-600 font-bold text-lg">{{ substr($admin->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $admin->name }}</p>
                                <p class="text-sm text-gray-500">{{ $admin->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">Admin</span>
                            <button onclick="openEditModal({{ $admin->id }}, 'admin')" 
                                    class="text-gray-600 hover:text-gray-800 p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <form method="POST" action="{{ route('organisations.managers.destroy', [$organisation->id, $admin->id]) }}" 
                                  onsubmit="return confirm('Are you sure you want to remove this admin?');">
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
                @empty
                    <p class="text-gray-500 italic">No admins</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Add Manager Modal -->
    <div id="addManagerModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Add Manager</h3>
                <button onclick="document.getElementById('addManagerModal').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('organisations.managers.store', $organisation->id) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">User</label>
                    <input type="text" name="user_email" placeholder="Enter user email" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                    <select name="role" required
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="admin">Admin</option>
                        <option value="owner">Owner</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('addManagerModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Add Manager
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Manager Modal -->
    <div id="editManagerModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Edit Manager Role</h3>
                <button onclick="document.getElementById('editManagerModal').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form method="POST" id="editManagerForm">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                    <select name="role" id="editRole" required
                            class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="admin">Admin</option>
                        <option value="owner">Owner</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('editManagerModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(userId, currentRole) {
            const modal = document.getElementById('editManagerModal');
            const form = document.getElementById('editManagerForm');
            const roleSelect = document.getElementById('editRole');
            
            form.action = "{{ route('organisations.managers.update', [$organisation->id, ':userId']) }}".replace(':userId', userId);
            roleSelect.value = currentRole;
            modal.classList.remove('hidden');
        }
    </script>
@endsection