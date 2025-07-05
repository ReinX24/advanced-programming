<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Applicant Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Applicant: {{ $applicant->name }}</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        {{-- Profile Photo --}}
                        <div class="flex flex-col items-center">
                            <h3 class="text-xl font-semibold text-gray-800 mb-3">Profile Photo</h3>
                            @if ($applicant->profile_photo)
                                <img src="{{ Storage::url($applicant->profile_photo) }}"
                                    alt="Profile Photo of {{ $applicant->name }}"
                                    class="w-48 h-48 object-cover rounded-full shadow-lg border-4 border-indigo-200">
                            @else
                                <div
                                    class="w-48 h-48 flex items-center justify-center bg-gray-200 text-gray-500 rounded-full shadow-lg border-4 border-gray-300">
                                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500 mt-2">No profile photo available.</p>
                            @endif
                        </div>

                        {{-- Applicant Details --}}
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-3">Personal Information</h3>
                            <p class="text-lg text-gray-700 mb-2"><span class="font-semibold">Name:</span>
                                {{ $applicant->name }}</p>
                            <p class="text-lg text-gray-700 mb-2"><span class="font-semibold">Age:</span>
                                {{ $applicant->age }}</p>
                            <p class="text-lg text-gray-700 mb-2"><span class="font-semibold">Educational
                                    Attainment:</span> {{ $applicant->educational_attainment }}</p>
                            <p class="text-lg text-gray-700 mb-2"><span class="font-semibold">Medical Status:</span>
                                {{ $applicant->medical }}</p>
                            <p class="text-lg text-gray-700 mb-2"><span class="font-semibold">Applicant Status:</span>
                                {{ $applicant->status }}</p>
                        </div>
                    </div>

                    {{-- Working Experience --}}
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Working Experience</h3>
                        <div
                            class="prose max-w-none text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-md shadow-inner">
                            @if ($applicant->working_experience)
                                {!! nl2br(e($applicant->working_experience)) !!}
                            @else
                                <p class="text-gray-500 italic">No working experience provided.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Curriculum Vitae --}}
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Curriculum Vitae</h3>
                        @if ($applicant->curriculum_vitae)
                            <div class="w-full flex flex-col items-start">
                                {{-- Attempt to embed using <embed> tag --}}
                                <embed src="{{ Storage::url($applicant->curriculum_vitae) }}" type="application/pdf"
                                    class="w-full h-screen mb-3 border border-gray-300 rounded-lg shadow-md">

                                {{-- Fallback/Alternative: Button to open in new tab --}}
                                <a href="{{ Storage::url($applicant->curriculum_vitae) }}" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mt-4">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path>
                                    </svg>
                                    View CV (Opens in new tab)
                                </a>
                                <p class="text-sm text-gray-500 mt-2">
                                    If the CV does not display above, please click the "View CV" button to open it in a
                                    new tab.
                                </p>
                            </div>
                        @else
                            <div class="bg-gray-50 p-4 rounded-md shadow-inner text-center text-gray-500 italic">
                                No Curriculum Vitae available.
                            </div>
                        @endif
                    </div>

                    <!-- Timestamps -->
                    <div class="text-sm text-gray-500 mt-6 pt-4 border-t border-gray-200">
                        <p class="mb-1">
                            <span class="font-medium text-gray-700">Created:</span>
                            {{ $applicant->created_at->format('F d, Y H:i:s') }}
                        </p>
                        <p>
                            <span class="font-medium text-gray-700">Last Updated:</span>
                            {{ $applicant->updated_at->format('F d, Y H:i:s') }}
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <!-- Back Button -->
                        <a href="{{ route('applicants.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Applicants
                        </a>

                        <!-- Edit Button -->
                        <a href="{{ route('applicants.edit', $applicant->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                            Edit Applicant
                        </a>

                        <!-- Delete Button (using a form for proper DELETE request) -->
                        <form action="{{ route('applicants.destroy', $applicant) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this applicant?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Delete Applicant
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
