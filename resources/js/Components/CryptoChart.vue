<script setup>
import Chart from 'chart.js/auto';
import { onMounted } from 'vue';

const labels = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
];

const data = {
    labels: labels,
    datasets: [{
        label: 'Data set',
        backgroundColor: 'rgb(255.99.132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [0, 10, 5, 20, 30, 45],
    }]
};

const config = {
  type: 'line',
  data: data,
  options: {}
};

onMounted(() => {
    const myChart = new Chart(
    document.getElementById('myChart'),
    config
    );
})

</script>

<template>
    <h3>Chart</h3>
    <div>
        <canvas id="myChart"></canvas>
    </div>
</template>
