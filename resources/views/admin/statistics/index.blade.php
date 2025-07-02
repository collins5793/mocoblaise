@extends('admin.layout')

@section('title', 'Statistiques')

@section('content')
<h2>Dashboard Statistiques</h2>

<div style="display:flex; gap: 2rem; flex-wrap: wrap; margin-bottom: 2rem;">
    <div style="flex:1; min-width: 200px; background:#e0f2fe; padding:1rem; border-radius:8px; text-align:center;">
        <h3>{{ $totalUsers }}</h3>
        <p>Utilisateurs inscrits</p>
    </div>
    <div style="flex:1; min-width: 200px; background:#d1fae5; padding:1rem; border-radius:8px; text-align:center;">
        <h3>{{ $activeUsers }}</h3>
        <p>Utilisateurs actifs (30 jours)</p>
    </div>
    <div style="flex:1; min-width: 200px; background:#fef3c7; padding:1rem; border-radius:8px; text-align:center;">
        <h3>{{ $totalCourses }}</h3>
        <p>Cours disponibles</p>
    </div>
    <div style="flex:1; min-width: 200px; background:#fee2e2; padding:1rem; border-radius:8px; text-align:center;">
        <h3>{{ $totalLessons }}</h3>
        <p>Leçons disponibles</p>
    </div>
    <div style="flex:1; min-width: 200px; background:#ddd6fe; padding:1rem; border-radius:8px; text-align:center;">
        <h3>{{ $totalQuizzes }}</h3>
        <p>Quiz créés</p>
    </div>
    <div style="flex:1; min-width: 200px; background:#fbcfe8; padding:1rem; border-radius:8px; text-align:center;">
        <h3>{{ $totalCertificates }}</h3>
        <p>Certificats générés</p>
    </div>
</div>

<div style="max-width: 800px; margin:auto;">
    <canvas id="passRateChart" style="max-width: 100%; height: 300px;"></canvas>
    <canvas id="popularCoursesChart" style="max-width: 100%; height: 300px; margin-top: 3rem;"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxPass = document.getElementById('passRateChart').getContext('2d');
    const passRateChart = new Chart(ctxPass, {
        type: 'doughnut',
        data: {
            labels: ['Réussites', 'Échecs'],
            datasets: [{
                label: 'Taux de réussite',
                data: [{{ $passRate }}, {{ 100 - $passRate }}],
                backgroundColor: ['#4ade80', '#f87171'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Taux de réussite aux quiz (%)'
                }
            }
        }
    });

    const ctxPopular = document.getElementById('popularCoursesChart').getContext('2d');
    const popularCoursesChart = new Chart(ctxPopular, {
        type: 'bar',
        data: {
            labels: {!! json_encode($popularCoursesLabels) !!},
            datasets: [{
                label: 'Nombre d\'inscriptions',
                data: {!! json_encode($popularCoursesData) !!},
                backgroundColor: '#60a5fa'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Top 5 des cours les plus populaires'
                },
                legend: { display: false }
            }
        }
    });
</script>

@endsection
