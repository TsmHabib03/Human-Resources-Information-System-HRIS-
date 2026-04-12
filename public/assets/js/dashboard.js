(function () {
    var el = document.getElementById('attendanceChart');
    var dataEl = document.getElementById('attendanceTrendData');

    if (!el || !dataEl || typeof Chart === 'undefined') {
        return;
    }

    var payload = { labels: [], values: [] };

    try {
        var parsed = JSON.parse(dataEl.textContent || '{}');
        if (Array.isArray(parsed.labels)) {
            payload.labels = parsed.labels;
        }

        if (Array.isArray(parsed.values)) {
            payload.values = parsed.values;
        }
    } catch (error) {
        payload = { labels: [], values: [] };
    }

    if (payload.labels.length === 0 || payload.values.length === 0) {
        payload = {
            labels: ['No data'],
            values: [0]
        };
    }

    new Chart(el, {
        type: 'line',
        data: {
            labels: payload.labels,
            datasets: [{
                label: 'Present',
                data: payload.values,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.14)',
                tension: 0.35,
                fill: true,
                pointRadius: 3,
                pointHoverRadius: 4,
                pointBackgroundColor: '#2563eb'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    ticks: { color: '#64748b' },
                    grid: { color: 'rgba(148, 163, 184, 0.25)' }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#64748b',
                        precision: 0
                    },
                    grid: { color: 'rgba(148, 163, 184, 0.25)' }
                }
            }
        }
    });
})();
