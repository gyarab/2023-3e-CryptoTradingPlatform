<template>
  <div class="p-6 min-h-full w-full bg-secondarybg">
    <DropdownIntervals :selectedInterval="selectedInterval" @update:selectedInterval="handleIntervalChange" />
    <div>
      <canvas ref="cryptoChart"></canvas>
    </div>
  </div>
</template>

<script setup>
import Chart from 'chart.js/auto';
import zoomPlugin from 'chartjs-plugin-zoom';
import { onMounted, ref, watch, defineProps } from 'vue';
import DropdownIntervals from './DropdownIntervals.vue';

Chart.register(zoomPlugin);

const props = defineProps([
  'dataM',
  'dataW',
  'dataIn24',
  'dataIn12',
  'dataIn6',
  'dataIn1',
  'name'
]);
const cryptoChart = ref(null);
let myChart = null;
const selectedInterval = ref('24'); // Default interval
const scrollPosition = ref(0); // Store scroll position
let initialChartConfig = null; // Store initial chart configuration

const getPrimaryTextColor = () => {
  const root = document.documentElement;
  const primaryTextColor = window.getComputedStyle(root).getPropertyValue('--color-primarytext').trim();
  const rgbaColor = primaryTextColor.replace(/\s+/g, ',');
  return `rgba(${rgbaColor}, 0.2)`;
};

const getChartData = () => {
  let selectedData = props.dataIn24;
  let backgroundColor = 'rgba(128, 0, 128, 0.2)'; // Purple
  let borderColor = 'rgb(255,0,219)'; // Purple

  if (selectedInterval.value === '12') {
    selectedData = props.dataIn12;
    backgroundColor = 'rgba(255, 0, 0, 0.2)'; // Red
    borderColor = 'rgb(255, 0, 0)'; // Red
  } else if (selectedInterval.value === '1') {
    selectedData = props.dataIn1;
    backgroundColor = 'rgba(255, 255, 0, 0.2)'; // Yellow
    borderColor = 'rgb(255, 255, 0)'; // Yellow
  } else if (selectedInterval.value === 'M') {
    selectedData = props.dataM;
    backgroundColor = 'rgba(128, 0, 128, 0.2)'; // Deep pink
    borderColor = 'rgb(176,0,255)'; // Deep pink
  } else if (selectedInterval.value === 'W') {
    selectedData = props.dataW;
    backgroundColor = 'rgba(255, 140, 0, 0.2)'; // Dark orange
    borderColor = 'rgb(255, 140, 0)'; // Dark orange
  } else if (selectedInterval.value === '6') {
    selectedData = props.dataIn6;
    backgroundColor = 'rgba(0, 255, 0, 0.2)'; // Lime green
    borderColor = 'rgb(0, 255, 0)'; // Lime green
  }

  const labels = selectedData.data.map((entry) => {
    const date = new Date(entry.time);
    return date.getHours() + ':' + (date.getMinutes() < 10 ? '0' : '') + date.getMinutes();
  });

  const data = {
    labels: labels,
    datasets: [
      {
        label: `Price (USD) X ` + props.name,
        backgroundColor: backgroundColor,
        borderColor: borderColor,
        data: selectedData.data.map((entry) => parseFloat(entry.priceUsd)),
      },
    ],
  };

  return data;
};

const createChart = () => {
  const data = getChartData();
  const config = {
    type: 'line',
    data: data,
    options: {
      scales: {
        x: {
          grid: {
            color: getPrimaryTextColor(),
          },
        },
        y: {
          grid: {
            color: getPrimaryTextColor(),
          },
        },
      },
    },
  };

  initialChartConfig = config;

  myChart = new Chart(cryptoChart.value, config);
};

onMounted(() => {
  createChart();
});

watch(() => [props.dataIn24, props.dataIn12, props.dataIn1, props.dataM, props.dataW, props.dataIn6, selectedInterval.value], () => {
  if (myChart) {
    scrollPosition.value = window.scrollY;
    myChart.destroy();
  }

  createChart();

  window.scrollTo(0, scrollPosition.value);
});

const handleIntervalChange = (interval) => {
  selectedInterval.value = interval;
};
</script>

<script>
import DropdownIntervals from './DropdownIntervals.vue';

export default {
  components: {
    DropdownIntervals,
  },
};
</script>
