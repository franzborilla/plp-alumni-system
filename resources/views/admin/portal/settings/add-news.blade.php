@if ($errors->any())
    <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
        <strong>Form Errors:</strong>
        <ul class="list-disc ml-6">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<x-app-layout :title="'Settings'" :navType="'admin'">
    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
            {{ __('Settings') }}
        </h2>
        <p class="text-gray-600 text-base mt-1">
            Manage profile, account settings, records, and audit logs
        </p>
    </x-slot>

    <x-settings-tab active="add-news"></x-settings-tab>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-300 text-green-700 rounded-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    <x-white-card class="p-6 mb-4">
        <h3 class="text-2xl font-bold mb-1">News and Announcement</h3>
        <p class="font-light text-sm mb-6">Manage updates and announcements (up to 3 slots)</p>

        @foreach (range(1, 3) as $i)
            @php $entry = $news[$i - 1] ?? null; @endphp

            <div class="mb-10 border border-gray-200 rounded-xl shadow-sm p-6 bg-gray-50">
                <form action="{{ route('settings.news.save', ['id' => $entry->id ?? '']) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="slot_number" value="{{ $i }}">

                    <h4 class="font-semibold text-lg mb-4 text-green-700">News Entry #{{ $i }}</h4>

                    <div class="space-y-4">
                        <div>
                            <x-input-label value="Title" />
                            <x-text-input type="text" name="title" value="{{ $entry->title ?? '' }}"
                                placeholder="Enter news title" class="w-full" />
                        </div>

                        <div>
                            <x-input-label value="Description" />
                            <textarea name="description" rows="4"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-green-600 focus:ring-green-600 resize-none"
                                placeholder="Write the news details here">{{ $entry->description ?? '' }}</textarea>
                        </div>

                        <div>
                            <x-input-label value="Image" />
                            @if (!empty($entry?->image_path))
                                <div class="my-2 flex items-center gap-3">
                                    <img src="{{ asset('storage/' . $entry->image_path) }}" alt="News Image"
                                        class="w-32 h-32 object-cover rounded-lg border shadow-sm">
                                    <p class="text-sm text-gray-500 italic">Current image</p>
                                </div>
                            @endif
                            <input type="file" name="image"
                                class="block w-full text-sm text-gray-500 border border-gray-300 rounded-md file:py-2 file:px-4
                                file:rounded-md file:border-0 file:text-sm file:font-semibold
                                file:bg-green-50 file:text-green-700 hover:file:bg-green-100" />
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 mt-6">
                        @if ($entry)
                            <button type="button" onclick="resetNews({{ $entry->id }})"
                                class="px-5 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                                Reset
                            </button>
                        @endif
                        <x-primary-button type="submit"
                            class="px-8">{{ $entry ? 'Update' : 'Save' }}</x-primary-button>
                    </div>
                </form>
            </div>
        @endforeach
    </x-white-card>

    <form id="reset-news-form" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function resetNews(id) {
            if (confirm('Reset this entry?')) {
                const form = document.getElementById('reset-news-form');
                form.action = "{{ url('admin/settings/news/reset') }}/" + id;
                form.submit();
            }
        }
    </script>
</x-app-layout>
