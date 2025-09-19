<div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- En-tête du tableau de bord -->
    <div class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Tableau de bord</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Bienvenue dans votre espace 100DaysOfCode</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Résumé / Statistiques -->
        <div class="px-4 py-6 sm:px-0">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Statistique 1: Nombre de projets -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Projets</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['projectCount'] }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('projects.index') }}" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500">Voir tous les projets</a>
                        </div>
                    </div>
                </div>

                <!-- Statistique 2: Nombre de tâches -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Tâches</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['taskCount'] }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                        <div class="text-sm">
                            <a href="#tasks" class="font-medium text-green-600 dark:text-green-400 hover:text-green-500">Gérer mes tâches</a>
                        </div>
                    </div>
                </div>

                <!-- Statistique 3: Tâches complétées -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Tâches Complétées</dt>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900 dark:text-white">{{ $stats['completedTaskCount'] }}</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                        <div class="text-sm">
                            <span class="font-medium text-indigo-600 dark:text-indigo-400">
                                @php
                                    $percentage = $stats['taskCount'] > 0 ? round(($stats['completedTaskCount'] / $stats['taskCount']) * 100) : 0;
                                @endphp
                                {{ $percentage }}% complété
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Statistique 4: Jours depuis le début -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Jours du défi</dt>
                                    <dd>
                                        @php
                                            $daysSinceStart = $stats['daysSinceStart'];
                                            $daysLeft = max(0, 100 - $daysSinceStart);
                                        @endphp
                                        <div class="text-lg font-medium text-gray-900 dark:text-white">Jour {{ min(100, $daysSinceStart + 1) }}/100</div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                        <div class="text-sm">
                            <span class="font-medium text-purple-600 dark:text-purple-400">{{ $daysLeft }} jours restants</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barre de progression -->
        <div class="px-4 py-2 sm:px-0">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Progression du défi</h3>
                    <div class="mt-3">
                        <div class="relative pt-1">
                            <div class="flex mb-2 items-center justify-between">
                                <div>
                                    <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-indigo-600 bg-indigo-200 dark:text-indigo-200 dark:bg-indigo-800">
                                        Progression
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-semibold inline-block text-indigo-600 dark:text-indigo-300">
                                        {{ min(100, $daysSinceStart + 1) }}%
                                    </span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-indigo-200 dark:bg-gray-700">
                                <div style="width:{{ min(100, $daysSinceStart + 1) }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Suivi quotidien du challenge 100 jours -->
        <div class="px-4 py-6 sm:px-0">
            @livewire('page.daily-challenge')
        </div>

        <!-- Section Projets récents -->
        <div class="px-4 py-6 sm:px-0">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Mes projets récents</h2>
                <a href="{{ route('projects.index') }}" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Tous les projets
                </a>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($recentProjects as $project)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white truncate">{{ $project->name }}</h3>
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $project->tasks->count() }} tâches
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">
                                {{ $project->description ?? 'Aucune description disponible pour ce projet.' }}
                            </p>
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                Créé le {{ $project->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3 flex justify-between">
                            <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500">
                                Voir détails
                            </a>
                            <a href="#" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-500">
                                {{ $project->tasks->where('is_completed', true)->count() }}/{{ $project->tasks->count() }} complétées
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="p-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">Aucun projet</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Commencez par créer votre premier projet pour le défi 100DaysOfCode.</p>
                            <div class="mt-6">
                                <a href="{{ route('projects.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Créer un projet
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Section Tâches récentes -->
        <div class="px-4 py-6 sm:px-0" id="tasks">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Mes tâches récentes</h2>
                <a href="#" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                    Toutes les tâches
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($recentTasks as $task)
                        <li class="px-6 py-4 flex items-center">
                            <div class="min-w-0 flex-1 flex items-center">
                                <div class="flex-shrink-0">
                                    @if($task->is_completed)
                                        <span class="h-8 w-8 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-green-600 dark:text-green-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @else
                                        <span class="h-8 w-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1 px-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $task->title }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Projet: {{ $task->project->name }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-200 dark:bg-indigo-900 dark:text-indigo-200 dark:hover:bg-indigo-800 focus:outline-none">
                                    {{ $task->is_completed ? 'Terminée' : 'À faire' }}
                                </button>
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">Aucune tâche</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Vous n'avez pas encore créé de tâches pour vos projets.</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
