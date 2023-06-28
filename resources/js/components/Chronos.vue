<template>
  <div class="row">
    <div class="col">
      <VCalendar
        :max-date="maxDate"
        :color="selectedColor"
        :attributes="attrs"
        @dayclick="handleDayClick"
        :min-date="currentDate"
        expanded
      />
    </div>
    <div class="col-4 row" v-if="selectedDate">
      <p>Date sélectionnée : {{ selectedDate }}</p>
      <p>heure: {{ heure }}</p>
      <div class="col-6 text-center" v-for="hour in hours" :key="hour.id">
        <button class="btn btn-primary mb-3 mx-3">
          {{ hour.lib }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios"; // Importez axios
const app = Vue.createApp({
  data() {
    return {
      selectedColor: "orange",
      heure: null,
      dataTime: [],
      hours: [],
      attrs: [],
      selectedDate: null,
      currentDate: new Date(),
      maxDate: new Date(
        currentDate.getFullYear(),
        currentDate.getMonth() + 2,
        currentDate.getDate()
      ),
      minDate: currentDate,
    };
  },
  methods: {
    async getDataByDate(selectedDate) {
      try {
        const response = await axios.post("get_chrono", {
          date: selectedDate,
        });
        this.hours = [];
        var allRequestDate = response.data.data;
        allRequestDate.forEach((element) => {
          this.hours.push({
            // Utilisez hours.value pour accéder à la valeur réactive
            id: element.id,
            lib: element.heure,
          });
        });
      } catch (error) {
        console.error(error);
      }
    },

    handleDayClick({ date }) {
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, "0");
      const day = String(date.getDate()).padStart(2, "0");

      this.selectedDate = `${year}/${month}/${day}`;

      // Find the selected date key in attrs array
      const selectedDateKey = attrs.value.find(
        (attr) =>
          attr.dates.getFullYear() === date.getFullYear() &&
          attr.dates.getMonth() === date.getMonth() &&
          attr.dates.getDate() === date.getDate()
      );

      if (selectedDateKey) {
        const dateKey = selectedDateKey.key;
        console.log("Selected Date Key:", dateKey);

        // Pass the date key to your POST request
        getDataByDate(dateKey);
      }
    },
  },
});
app.mount("#app");
</script>
