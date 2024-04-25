<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import FAQ from '@/Components/FAQ.vue';
import ApplicationName from '@/Components/ApplicationName.vue';

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
  cryptocurrencies: {
    type: Array
  }
});
</script>

<template>
  <div class="">

    <Head title="Welcome" />

    <div
      class="text-primarytext sticky flex justify-between border-b border-border p-2 left-0 right-0 top-0 bg-bg items-center pr-4">
      <!--Header-->
      <div class="inline-flex items-center px-4 sm:px-6 lg:px-8">
        <ApplicationLogo class="w-16 h-16" />
        <ApplicationName />
      </div>
      <div v-if="canLogin" class="">
        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
          class="font-semibold text-secondarytext/80 hover:text-hovertext focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 h-full">
        Dashboard</Link>

        <template v-else>
          <Link :href="route('login')"
            class="font-semibold text-secondarytext/80 hover:text-hovertext focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
          Log in</Link>

          <Link v-if="canRegister" :href="route('register')"
            class="ms-4 font-semibold text-secondarytext/80 hover:text-hovertext focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
          Register</Link>
        </template>
      </div>
    </div>
    <div class="pt-12 pr-12 pl-12 s:h-dvh min-h-screen h-full text-primarytext bg-bg pb-10"> 
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        <div>
          <h1 class="text-2xl sm:text-4xl mb-2">Welcome to Cryptonest</h1>
          <p class="text-xl sm:text-3xl mb-4">Learn how to trade!!!</p>
          <p class="sm:text-lg text-secondarytext">Cryptonest is a user-friendly web application designed for
            individuals
            who want to gain practical experience in trading cryptocurrencies without the risk of real financial loss.
            <br>
            With Cryptonest, users can create an account and access a simulated trading environment where they can buy
            and
            sell various cryptocurrencies using virtual funds.</p>
        </div>

        <div class="justify-center overflow-x-auto shadow-md rounded-lg">
          <table class="border-none min-w-full text-left text-sm font-light bg-secondarybg">
            <thead class="border-none border-b font-medium text-xs uppercase">
              <tr>
                <th scope="col" class="px-6 py-3">
                  Cryptocurrency
                </th>
                <th scope="col" class="px-6 py-3 hidden sm:table-cell">
                  Shortcut
                </th>
                <th scope="col" class="px-6 py-3">
                  Price in USD
                </th>
              </tr>
            </thead>
            <tbody>
              <tr class="bg-secondarybg" v-for="currency in cryptocurrencies">
                <td scope="row" class="px-6 py-4 font-medium text-primarytext">
                  {{ currency["name"] }}
                </td>
                <td class="px-6 py-4 hidden sm:table-cell">
                  {{ currency["symbol"] }}
                </td>
                <td class="px-6 py-4">
                  <span class="text-green-500">$</span>{{
                    parseFloat(currency["priceUsd"]).toFixed(2) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="mt-8">
        <h2 class="text-3xl ml-4">
          Freqently Asked Questions
        </h2>
        <FAQ question="How does Cryptonest work?"
          answer="After registration you should head into the profile tab and give yourself some amount of fictional funds which can then be used invested into crypto. However, the values of the cryptocurrencies are real." />
        <FAQ question="Why choose Cryptonest?"
          answer="Cryptonest offers a risk-free enviroment, which is suitable even for complete beginners." />
        <FAQ question="How do I add funds to my profile?"
          answer="You can add funds to your account within the profile tab. We advise our users to use this function as scarcely as possible to ensure an authentic learning experience" />
        <FAQ question="Is Cryptonest free to use?" answer="Yes, Cryptonest is completely free to use." />
        <FAQ question="Can I customize my trading dashboard on Cryptonest"
          answer="You can customize your dashboard by adding Cryptocurrencies to your list allowing for easy access to buying and selling crypto" />
      </div>
    </div>
  </div>
</template>
