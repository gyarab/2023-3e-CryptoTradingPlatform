<script setup>
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import ToggleButton from '@/Components/ToggleButton.vue';
import { ref } from 'vue'; // Import the ref function to define reactive data
import axios from 'axios'; // Import axios for HTTP requests

const moneyToAdd = ref(''); // Define a reactive reference for the amount of money to add

const addMoney = async () => {
  try {
    const response = await axios.post('/add-money', {
      amount: parseFloat(moneyToAdd.value) // Pass the value of moneyToAdd to the API
    });
    console.log("Money added:", moneyToAdd.value);
    // Reset the text field after successful addition
    moneyToAdd.value = '';
    // Handle success response
  } catch (error) {
    console.error('Error while adding money:', error);
    // Handle error
  }
};
</script>

<template>
    <h2 class="text-lg font-medium text-primarytext">Balance settings</h2>
  
    <p class="mt-1 text-sm text-secondarytext">
      Feel free to add money to your Balance. However, we recommend adding only the amount of money you actually possess. 
      This way, you can simulate investing in cryptocurrency more realistically.
    </p>
  
    <div class="mt-6 space-y-6">
      <InputLabel for="add_money" value="Add to your balance"/>
      <div class="mt-1 block w-full md:w-1/2"> <!-- Apply class directly to the div element -->
        <TextInput
          id="add_money"
          v-model="moneyToAdd" 
        />
      </div>
      <ToggleButton @click="addMoney" :textBefore="'Add Money'" :textAfter="'Money Added'"/>
    </div>
</template>
