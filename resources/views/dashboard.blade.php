<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <p>{{ __("You're logged in!") }}</p>
                    
                    <div class="flex space-x-4 mt-6">
                        <a href="{{ route('posts.index') }}" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
                            View All Posts
                        </a>

                        @can('is-admin')
                            <a href="{{ route('admin.dashboard') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-500 transition">
                                Admin Dashboard
                            </a>
                        @endcan
                    </div>

                    <div class="mt-8">
                        <h3 class="font-bold text-lg mb-2">Instructions for Testing Gates/Policies:</h3>
                        <ul class="list-disc ml-6 space-y-1">
                            <li><strong>Admin:</strong> Can see "Admin Dashboard" button and delete any post.</li>
                            <li><strong>Author:</strong> Can create posts and edit/delete their own posts.</li>
                            <li><strong>User:</strong> Can only view posts.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
