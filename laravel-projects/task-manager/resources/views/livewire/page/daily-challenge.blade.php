<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Progression du jour ({{ $challengeDate }})</h3>

    @if(session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if($todayEntry && $todayEntry->completed)
        <div class="mb-4 p-3 bg-blue-50 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded">
            <strong>Entrée du jour déjà complétée !</strong><br>
            <span class="block mt-2">Description : {{ $todayEntry->description }}</span>
            <span class="block mt-2">Projets travaillés :
                @if($todayEntry->projects_worked_on)
                    @foreach(json_decode($todayEntry->projects_worked_on) as $pid)
                        @php $p = $allProjects->find($pid); @endphp
                        @if($p)
                            <span class="inline-block px-2 py-1 bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 rounded mr-1">{{ $p->name }}</span>
                        @endif
                    @endforeach
                @else
                    Aucun
                @endif
            </span>
            <span class="block mt-2">Heures codées : {{ $todayEntry->hours_coded }}</span>
            <span class="block mt-2">Apprentissages : {{ $todayEntry->learnings }}</span>
            <span class="block mt-2">Difficultés : {{ $todayEntry->challenges_faced }}</span>
        </div>
    @else
        <form wire:submit.prevent="saveEntry">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description du jour</label>
                <textarea wire:model.defer="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:text-white"></textarea>
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Projets travaillés</label>
                <select wire:model.defer="projectsWorkedOn" multiple class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:text-white">
                    @foreach($allProjects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Heures codées</label>
                <input type="number" min="1" wire:model.defer="hoursCoded" class="mt-1 block w-24 rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:text-white" />
                @error('hoursCoded') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Apprentissages du jour</label>
                <textarea wire:model.defer="learnings" rows="2" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:text-white"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Difficultés rencontrées</label>
                <textarea wire:model.defer="challengesFaced" rows="2" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:text-white"></textarea>
            </div>
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Sauvegarder ma progression</button>
        </form>
    @endif
</div>
