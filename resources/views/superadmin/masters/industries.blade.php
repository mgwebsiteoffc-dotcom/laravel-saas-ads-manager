{{-- resources/views/superadmin/masters/industries.blade.php --}}
@extends('layouts.app')

@section('title', 'Manage Industries')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Industries Master</h1>
                <p class="text-gray-600 mt-1">Manage industry categories</p>
            </div>
            <button 
                onclick="openCreateModal()"
                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold"
            >
                <i class="fas fa-plus mr-2"></i> Add Industry
            </button>
        </div>

        <!-- Industries Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($industries as $industry)
            <div class="bg-white rounded-lg shadow-md p-6 relative group">
                <!-- Active Badge -->
                <div class="absolute top-4 right-4">
                    @if($industry->is_active)
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                            Active
                        </span>
                    @else
                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">
                            Inactive
                        </span>
                    @endif
                </div>

                <!-- Icon -->
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl" 
                     style="background-color: {{ $industry->color }}20;">
                    {{ $industry->icon }}
                </div>

                <!-- Name -->
                <h3 class="text-lg font-semibold text-gray-900 text-center mb-2">{{ $industry->name }}</h3>
                <p class="text-sm text-gray-500 text-center mb-4">{{ $industry->slug }}</p>

                <!-- Stats -->
                <div class="text-center mb-4">
                    <span class="text-xs text-gray-600">Order: {{ $industry->order }}</span>
                </div>

                <!-- Actions -->
                <div class="flex gap-2">
                    <button 
                        onclick="openEditModal({{ $industry->id }}, '{{ $industry->name }}', '{{ $industry->icon }}', '{{ $industry->color }}', {{ $industry->is_active ? 'true' : 'false' }})"
                        class="flex-1 px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 text-sm font-medium"
                    >
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <form method="POST" action="{{ route('superadmin.industries.destroy', $industry) }}" class="flex-1" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit"
                            class="w-full px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 text-sm font-medium"
                        >
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($industries->hasPages())
        <div class="mt-8">
            {{ $industries->links() }}
        </div>
        @endif

    </div>
</div>

<!-- Create Modal -->
<div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <h2 class="text-2xl font-bold mb-4">Add New Industry</h2>
        
        <form method="POST" action="{{ route('superadmin.industries.store') }}" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Industry Name <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="name"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="e.g., Real Estate"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Icon (Emoji)
                </label>
                <input
                    type="text"
                    name="icon"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="🏠"
                    maxlength="10"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Color
                </label>
                <input
                    type="color"
                    name="color"
                    value="#3B82F6"
                    class="w-full h-10 border border-gray-300 rounded-lg"
                >
            </div>

            <div class="flex gap-3 pt-4">
                <button
                    type="button"
                    onclick="closeCreateModal()"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 font-semibold"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold"
                >
                    Create
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Industry</h2>
        
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Industry Name <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="name"
                    id="edit_name"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Icon (Emoji)
                </label>
                <input
                    type="text"
                    name="icon"
                    id="edit_icon"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    maxlength="10"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Color
                </label>
                <input
                    type="color"
                    name="color"
                    id="edit_color"
                    class="w-full h-10 border border-gray-300 rounded-lg"
                >
            </div>

            <div class="flex items-center">
                <input
                    type="checkbox"
                    name="is_active"
                    id="edit_is_active"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                >
                <label for="edit_is_active" class="ml-2 block text-sm text-gray-900">
                    Active
                </label>
            </div>

            <div class="flex gap-3 pt-4">
                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 font-semibold"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold"
                >
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openCreateModal() {
    document.getElementById('createModal').classList.remove('hidden');
}

function closeCreateModal() {
    document.getElementById('createModal').classList.add('hidden');
}

function openEditModal(id, name, icon, color, isActive) {
    document.getElementById('editForm').action = `/superadmin/industries/${id}`;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_icon').value = icon;
    document.getElementById('edit_color').value = color;
    document.getElementById('edit_is_active').checked = isActive;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Close modals on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCreateModal();
        closeEditModal();
    }
});
</script>
@endpush
@endsection