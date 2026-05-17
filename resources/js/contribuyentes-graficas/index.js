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
            label: 'Eventos aceptados',
            data: Array(12).fill(0),
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    color: '#0055A4', // color del texto (leyenda)
                    font: {
                        size: 14 // tamaño leyenda
                    }
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: '#0055A4', // meses
                    font: {
                        size: 14 // 👈 aumenta tamaño
                    }
                },
                stacked: true, // 👈 Apilar en X
                grid: {
                    color: 'rgba(255,255,255,0.1)'
                }
            },
            y: {
                ticks: {
                    color: '#0055A4', // números eje Y
                    font: {
                        size: 14
                    }
                },
                stacked: true, // 👈 Apilar en 
                beginAtZero: true,
                grid: {
                    color: 'rgba(255,255,255,0.1)'
                }
            }
        }
    },
    plugins: {
        title: {
            display: true,
            text: 'Eventos Métricas',
            color: '#0055A4',
            font: {
                size: 18,
                weight: 'bold'
            }
        },
        legend: {
            display: true,
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

    // --- TRANSFORMACIÓN DE DATOS ---
    
    // 1. Obtener nombres únicos de las parroquias que vinieron en los datos
    const nombresParroquias = [...new Set(data.map(item => item.parroquia))];

    // 2. Crear los datasets (uno por parroquia)
    const datasets = nombresParroquias.map((nombre, index) => {
        // Creamos el array de 12 ceros para esta parroquia
        const dataMensual = Array(12).fill(0);

        // Llenamos los meses donde esta parroquia tuvo eventos
        data.filter(item => item.parroquia === nombre).forEach(item => {
            const indiceMes = parseInt(item.month) - 1;
            dataMensual[indiceMes] = item.total;
        });

        // Retornamos el objeto de dataset para Chart.js
        return {
            label: nombre,
            data: dataMensual,
            backgroundColor: getColor(index), // Función para asignar colores distintos
            borderWidth: 1
        };
    });

    // 3. Actualizar la gráfica
    chart.data.datasets = datasets; 
    chart.update();
});

function getColor(index) {
    const colors = [
        '#0055A4', '#34D399', '#F87171', '#FBBF24', '#818CF8', '#A78BFA'
    ];
    return colors[index % colors.length];
}