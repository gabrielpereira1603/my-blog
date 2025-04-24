<section class="w-full overflow-y-auto px-4 py-6 max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-[#1F2937] mb-8">Painel Administrativo</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500">Total de Usuários</p>
            <h2 class="text-2xl font-bold text-[#14B8A6]">{{ $counts['users'] }}</h2>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500">Total de Autores</p>
            <h2 class="text-2xl font-bold text-[#14B8A6]">{{ $counts['developers'] }}</h2>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500">Total de Artigos</p>
            <h2 class="text-2xl font-bold text-[#14B8A6]">{{ $counts['articles'] }}</h2>
        </div>
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow hover:shadow-lg transition">
            <p class="text-sm text-gray-500">Usuário Mais Ativo</p>
            <h2 class="text-xl font-semibold text-[#1F2937]">
                {{ $topUsersNames[0] ?? 'N/A' }} ({{ $topUsersPosts[0] ?? 0 }} artigos)
            </h2>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow">
            <h3 class="text-lg font-semibold text-[#1F2937] mb-4">Artigos publicados por mês</h3>
            <canvas id="postsPerMonthChart"></canvas>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow">
            <h3 class="text-lg font-semibold text-[#1F2937] mb-4">Usuários mais ativos</h3>
            <canvas id="topUsersChart"></canvas>
        </div>
    </div>

    <div class="max-w-3xl mx-auto mb-6">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow">
            <h3 class="text-lg font-semibold text-[#1F2937] mb-4 text-center">Artigos por categoria</h3>
            <canvas id="postsPerCategoryChart"></canvas>
        </div>
    </div>

    <script>
        const postsPerMonthChart = new Chart(document.getElementById('postsPerMonthChart'), {
            type: 'bar',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Artigos por mês',
                    data: @json($postsPerMonth),
                    backgroundColor: '#14B8A6',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        const topUsersChart = new Chart(document.getElementById('topUsersChart'), {
            type: 'doughnut',
            data: {
                labels: @json($topUsersNames),
                datasets: [{
                    label: 'Artigos',
                    data: @json($topUsersPosts),
                    backgroundColor: ['#14B8A6', '#1F2937', '#F59E0B', '#EF4444', '#10B981'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        const postsPerCategoryChart = new Chart(document.getElementById('postsPerCategoryChart'), {
            type: 'bar',
            data: {
                labels: @json($categoryLabels),
                datasets: [{
                    label: 'Artigos por categoria',
                    data: @json($categoryCounts),
                    backgroundColor: '#1F2937',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

    </script>
</section>

