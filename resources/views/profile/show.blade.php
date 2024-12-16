<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>
<div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-8">
    <!-- Profile Card -->
    <div class="bg-white shadow-md sm:rounded-lg p-6 border border-gray-200">
        <div class="flex items-center space-x-4">
            <!-- Profile Picture -->
            @if (auth()->user()->profile_photo)
                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}" class="rounded-full w-20 h-20 object-fit">
            @endif


            <!-- Profile Details -->
            <div>
                <p class="text-2xl font-semibold text-gray-900">{{ $user->name }}</p>
                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                <p class="text-sm text-gray-500 mt-2">Joined on {{ $user->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <!-- Edit Profile Link -->
        <div class="mt-6">
            <a href="{{ route('profile.edit') }}"><x-primary-button class="rounded hover:bg-gray-700 ml-2 mt-1">
                Edit Profile
            </x-primary-button></a>
        </div>
    </div>
</div>



</x-layout>


