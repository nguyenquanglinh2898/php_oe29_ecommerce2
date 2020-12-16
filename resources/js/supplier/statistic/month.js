function currencyFormat(number) {
    return new Number(number).toLocaleString('en-US');
}

$(function() {
    window.onload = function () {
        Chart.defaults.global.defaultFontColor = '#000000';
        Chart.defaults.global.defaultFontFamily = 'Arial';

        let lineChart = document.getElementById('line-chart');
        let revenues = JSON.parse($('#revenues').val());
        let months = JSON.parse($('#months').val());

        let myChart = new Chart(lineChart, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [
                    {
                        label: $('#statistic-sentence').val(),
                        data: revenues,
                        backgroundColor: 'rgba(0, 128, 128, 0.3)',
                        borderColor: 'rgba(0, 128, 128, 0.7)',
                        borderWidth: 1,
                        ticks: {
                            callback: function(value, index, values) {
                                return currencyFormat(value);
                            }
                        }
                    },
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value, index, values) {
                                return currencyFormat(value);
                            }
                        }
                    }]
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function (tooltipItem, data) {
                            return currencyFormat(tooltipItem.yLabel);
                        }
                    }
                },
            }
        });
    };
});
