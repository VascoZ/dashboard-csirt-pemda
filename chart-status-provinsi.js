document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('statusPieChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: window.statusChartLabels,
            datasets: [{
                data: window.statusChartData,
                backgroundColor: [
                    '#4e73df', // Teregistrasi
                    '#1cc88a', // Terbentuk
                    '#f6c23e', // Proses
                    '#e74a3b'  // Belum Terbentuk
                ],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const value = context.parsed;
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
