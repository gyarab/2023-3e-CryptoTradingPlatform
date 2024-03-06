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
  import { onMounted, ref, watch, defineProps } from 'vue';
  import DropdownIntervals from './DropdownIntervals.vue';
  
  const props = defineProps(['dataIn24', 'dataIn12', 'dataIn1', 'name']);
  const cryptoChart = ref(null);
  let myChart = null;
  const selectedInterval = ref('24'); // Default interval
  const scrollPosition = ref(0); // Store scroll position

  const getPrimaryTextColor = () => {
  const root = document.documentElement;
  const primaryTextColor = window.getComputedStyle(root).getPropertyValue('--color-primarytext').trim();
  const rgbaColor = primaryTextColor.replace(/\s+/g, ','); // Replace spaces with commas
  return `rgba(${rgbaColor}, 0.2)`;
};
  
  const getChartData = () => {
    let selectedData = props.dataIn24;
    let backgroundColor = 'rgba(128, 0, 128, 0.2)'; // Purple background color
    let borderColor = 'rgb(139, 92, 246)'; // Purple border color
  
    if (selectedInterval.value === '12') {
      selectedData = props.dataIn12;
      backgroundColor = 'rgba(255, 0, 0, 0.2)'; // Red background color
      borderColor = 'rgb(255, 0, 0)'; // Red border color
    } else if (selectedInterval.value === '1') {
      selectedData = props.dataIn1;
      backgroundColor = 'rgba(255, 255, 0, 0.2)'; // Yellow background color
      borderColor = 'rgb(255, 255, 0)'; // Yellow border color
    }
  
    const labels = selectedData.data.map(entry => {
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
          data: selectedData.data.map(entry => parseFloat(entry.priceUsd)),
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
            color: getPrimaryTextColor(), // Color of the X-axis grid lines
          },
        },
        y: {
          grid: {
            color: getPrimaryTextColor(), // Color of the Y-axis grid lines
          },
        },
      },
      },
    };
  
    myChart = new Chart(
      cryptoChart.value,
      config
    );
  };
  
  onMounted(() => {
    createChart();
  });
  
  watch(() => [props.dataIn24, props.dataIn12, props.dataIn1, selectedInterval.value], () => {
    if (myChart) {
      scrollPosition.value = window.scrollY; // Store the current scroll position
      myChart.destroy(); // Destroy the previous chart instance
    }
    createChart(); // Create a new chart with updated data
    window.scrollTo(0, scrollPosition.value); // Set the scroll position back to its original value
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
  
  
  
  
  



