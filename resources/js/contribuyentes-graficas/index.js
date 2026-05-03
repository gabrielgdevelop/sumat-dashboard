"use strict";

const ctx = document.getElementById('chart').getContext('2d');

let chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            'Ene','Feb','Mar','Abr','May','Jun',
            'Jul','Ago','Sep','Oct','Nov','Dic'
        ],
        datasets: [{
            label: 'Contribuyentes aceptados',
            data: Array(12).fill(0),
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    color: '#ffffff', // color del texto (leyenda)
                    font: {
                        size: 14 // tamaño leyenda
                    }
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: '#ffffff', // meses
                    font: {
                        size: 14 // 👈 aumenta tamaño
                    }
                },
                grid: {
                    color: 'rgba(255,255,255,0.1)'
                }
            },
            y: {
                ticks: {
                    color: '#ffffff', // números eje Y
                    font: {
                        size: 14
                    }
                },
                grid: {
                    color: 'rgba(255,255,255,0.1)'
                }
            }
        }
    },
    plugins: {
        title: {
            display: true,
            text: 'Contribuyentes Aceptados',
            color: '#ffffff',
            font: {
                size: 18,
                weight: 'bold'
            }
        }
    }
});

document.getElementById('yearSelect').addEventListener('change', async e => {

    const year = e.target.value;
    if (!year) return;

    const res = await fetch('/grafica/year', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ year })
    });

    const data = await res.json();

    // 🔥 actualizar gráfico
    chart.data.datasets[0].data = data;
    chart.data.datasets[0].label = `Aceptados en ${year}`;
    chart.update();
});