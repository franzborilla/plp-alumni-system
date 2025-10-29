<x-onboard-layout :title="'Add Skills'" :navType="'alumni'" :showSkipButton="'true'" :pageTitle="'Alumni Portal'" :width="'w-full lg:max-w-4xl'"
    :loginMessage="'List skills to complete your profile and unlock personalized job recommendations.'">

    <form method="POST" action="{{ route('alumni.skills.store') }}" x-data="skillsComponent()">
        @csrf

        <!-- Success message -->
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 10000)" x-show="show"
                class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 transition-opacity duration-500">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search input -->
        <div class="my-4 relative">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"
                xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 4.5 4.5a7.5 7.5 0 0 0 12.15 12.15z" />
            </svg>

            <input x-model="search" placeholder="Search and add skills"
                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-green-500 text-sm md:text-base">

        </div>

        <!-- Selected skills (always on top) -->
        <div class="flex flex-wrap gap-2 mb-4">
            <template x-for="skillId in selectedSkills" :key="skillId">
                <div x-text="allSkills.find(s => s.id === skillId).name" @click="toggleSkill(skillId)"
                    class="px-4 py-2 rounded-full cursor-pointer bg-plp-green text-white hover:opacity-80 transition-all">
                </div>
            </template>
        </div>

        <!-- Scrollable skill list -->
        <div class="flex flex-wrap gap-2 max-h-64 overflow-y-auto border p-3 rounded-md">
            <template x-for="skill in filteredSkills()" :key="skill.id">
                <div x-text="skill.name" @click="toggleSkill(skill.id)"
                    :class="selectedSkills.includes(skill.id) ?
                        'bg-plp-green text-white' :
                        'border-green-300 bg-green-100 text-green-800'"
                    class="px-4 py-2 rounded-full cursor-pointer hover:opacity-80 transition-all">
                </div>
            </template>
        </div>

        <!-- Hidden inputs to submit selected skills -->
        <template x-for="skillId in selectedSkills" :key="skillId">
            <input type="hidden" name="skills[]" :value="skillId" />
        </template>

        <!-- Done button -->
        <div class="flex justify-center items-center mt-8 w-full">
            <x-primary-button type="submit" class="w-1/2">Done</x-primary-button>
        </div>
    </form>

    <script>
        function skillsComponent() {
            return {
                search: '',
                allSkills: @json($skills),
                selectedSkills: @json($userSkills ?? []),

                filteredSkills() {
                    if (!this.search) return this.allSkills.filter(s => !this.selectedSkills.includes(s.id));
                    return this.allSkills.filter(skill =>
                        !this.selectedSkills.includes(skill.id) &&
                        skill.name.toLowerCase().includes(this.search.toLowerCase())
                    );
                },

                toggleSkill(id) {
                    if (this.selectedSkills.includes(id)) {
                        this.selectedSkills = this.selectedSkills.filter(s => s !== id);
                    } else {
                        this.selectedSkills.push(id);
                    }
                }
            }
        }
    </script>
</x-onboard-layout>
