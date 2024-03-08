<template>
  <div class="p-6">
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

const props = defineProps(['dataIn24', 'dataIn12', 'dataIn1', 'name']);
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
  let backgroundColor = 'rgba(128, 0, 128, 0.2)';
  let borderColor = 'rgb(139, 92, 246)';

  if (selectedInterval.value === '12') {
    selectedData = props.dataIn12;
    backgroundColor = 'rgba(255, 0, 0, 0.2)';
    borderColor = 'rgb(255, 0, 0)';
  } else if (selectedInterval.value === '1') {
    selectedData = props.dataIn1;
    backgroundColor = 'rgba(255, 255, 0, 0.2)';
    borderColor = 'rgb(255, 255, 0)';
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
      plugins: {
        zoom: {
          zoom: {
            wheel: {
              enabled: true,
            },
            pinch: {
              enabled: true,
            },
            mode: 'xy',
          },
          limits: {
            zoom: {
              max: 2, // Set the maximum zoom level
            },
          },
        },
      },
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

watch(() => [props.dataIn24, props.dataIn12, props.dataIn1, selectedInterval.value], () => {
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
