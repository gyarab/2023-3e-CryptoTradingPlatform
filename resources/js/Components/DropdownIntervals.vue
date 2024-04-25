<template>
    <div>
        <label for="interval" class="text-primarytext text-lg mb-2 mr-2">Select Interval:</label>
        <select v-model="selectedInterval" @change="handleChange" class="p-2 border-2 rounded bg-purple-500 text-white cursor-pointer focus:border-purple-500 active:border-purple-500 focus:ring focus:ring-purple-300">
            <option value="M">Last Month</option>
            <option value="W">Last Week</option>
            <option value="24">1 Day</option>
            <option value="12">12 Hours</option>
            <option value="6">6 Hours</option>
            <option value="1">1 Hour</option>
        </select>
    </div>
</template>

<script setup>
import { ref, defineEmits } from 'vue';

const emit = defineEmits();
const selectedInterval = ref('24');

const handleChange = () => {
    emit('update:selectedInterval', selectedInterval.value);
};
</script>
