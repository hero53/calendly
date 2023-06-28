<template>
  <div class="row">
    <div class="col">
      <VCalendar
        :max-date="maxDate"
        :color="selectedColor"
        :attributes="attrs"
        @dayclick="handleDayClick"
        :min-date="currentDate"
        locale="en"
        expanded
      />
    </div>
    <div class="col-4 row" v-if="selectedDate">
      <p>Date sélectionnée : {{ selectedDate }}</p>
      <p>heure: {{ heure }}</p>
      <div class="col-6 text-center" v-for="hour in hours" :key="hour.id">
        <button class="btn btn-primary mb-3 mx-3" @click="sayHello(hour.id)">
          {{ hour.lib }}
        </button>
      </div>
    </div>
    <div class="col-4 row" v-if="selectedHoure">
      <form method="#" action="#">
        <h3>Id : {{ hourId }}</h3>
        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input
            type="email"
            class="form-control"
            id="exampleInputEmail1"
            aria-describedby="emailHelp"
            placeholder="Enter email"
          />
          <small id="emailHelp" class="form-text text-muted"
            >We'll never share your email with anyone else.</small
          >
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input
            type="password"
            class="form-control"
            id="exampleInputPassword1"
            placeholder="Password"
          />
        </div>
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1" />
          <label class="form-check-label" for="exampleCheck1"
            >Check me out</label
          >
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios"; // Importez axios
import VueLoaders from "vue-loaders";

const selectedColor = ref("orange");
var heure = null;
const dataTime = [];
const selectedHoure = ref(false);

const hours = ref([]); // Utilisez ref pour déclarer hours

async function getDataByDate(selectedDates) {
  try {
    const response = await axios.post("get_chrono", {
      date: selectedDates,
    });
    hours.value = [];
    var allRequestDate = response.data.data;
    allRequestDate.forEach((element) => {
      hours.value.push({
        // Utilisez hours.value pour accéder à la valeur réactive
        id: element.id,
        // lib: convertTimeFormat(element.heure),
        lib: convertAMtoPM(convertTimeFormat(element.heure)),
      });
    });

    console.log(allRequestDate); // Accédez à la valeur réactive de hours avec hours.value
  } catch (error) {
    console.error(error);
  }
}
//afficher les dates libre
const attrs = ref([]);

async function getCalendatDate() {
  axios
    .get("/get_date")
    .then((response) => {
      var allRequestDate = response.data.data;
      allRequestDate.forEach((element) => {
        if (new Date(element.date) > currentDate) {
          attrs.value.push({
            key: element.id,
            highlight: true,
            dates: new Date(element.date),
          });
        }
      });
    })
    .catch((error) => {
      console.error(error);
    });
}

getCalendatDate();

const selectedDate = ref(null);

function handleDayClick({ date }) {
  selectedHoure.value = false;
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const day = String(date.getDate()).padStart(2, "0");

  selectedDate.value = `${year}/${month}/${day}`;

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
}
function convertAMtoPM(time) {
  // Récupérer les heures et les minutes
  var parts = time.split(":");
  var hours = parseInt(parts[0]);
  var minutes = parseInt(parts[1]);

  // Convertir en PM si l'heure est supérieure ou égale à 12
  if (hours >= 12) {
    hours = hours % 12; // Convertir en format 12 heures
    var convertedTime =
      hours.toString().padStart(2, "0") +
      ":" +
      minutes.toString().padStart(2, "0") +
      " PM";
    return convertedTime;
  }

  return time; // Retourne l'heure d'origine si elle est déjà en format PM
}

function convertTimeFormat(time) {
  // Split the time into hours, minutes, and seconds
  var parts = time.split(":");
  var hours = parts[0];
  var minutes = parts[1];

  // Format the time as "HH:MM"
  var convertedTime = hours + ":" + minutes;

  return convertedTime;
}
const hourId = ref(null);
function sayHello(params) {
  selectedHoure.value = true;
  hourId.value = params;
}
const currentDate = new Date();
const maxDate = new Date(
  currentDate.getFullYear(),
  currentDate.getMonth() + 2,
  currentDate.getDate()
);
const minDate = currentDate;
</script>
