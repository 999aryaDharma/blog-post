<x-layout>
<x-slot:title>{{ $title }}</x-slot:title>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Edit Profile</h2>
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Input for profile photo -->
                    <div>
                        <label for="profile_photo">Profile Photo</label>
                        <input id="profile_photo" name="profile_photo" type="file" accept="image/*">
                    </div>

                    <div class="mt-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="mt-1 block w-full">
                        @error('name')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full disabled:opacity-75">
                        @error('email')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>
</div>

</x-layout>
