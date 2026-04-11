(function () {
    var el = document.getElementById('attendanceChart');

    if (!el || typeof Chart === 'undefined') {
        return;
    }

    new Chart(el, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Present',
                data: [0, 0, 0, 0, 0, 0, 0],
                borderColor: '#58a6ff',
                backgroundColor: 'rgba(88,166,255,0.2)',
                tension: 0.35,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    ticks: { color: '#8b949e' },
                    grid: { color: 'rgba(139,148,158,0.2)' }
                },
                y: {
                    ticks: { color: '#8b949e' },
                    grid: { color: 'rgba(139,148,158,0.2)' }
                }
            }
        }
    });
})();
