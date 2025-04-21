<template>
<div class="container py-3">
<div class="text-center">Hello {{ user.name }} 👋</div>

<div class="row pt-2 pb-2">
  <div class="col-md-3">
    <div><b>City</b></div>
    <input id="city" type="text" class="btn-block py-2 px-2" name="city" v-model="city"></div>
  <div class="col-md-3">
    <div><b>Longitude</b></div>
    <input id="city" type="text" class="btn-block py-2 px-2" name="longitude" v-model="longitude"></div>
  <div class="col-md-3">
    <div><b>Latitude</b></div>
    <input id="city" type="text" class="btn-block py-2 px-2" name="latitude" v-model="latitude"></div>
  <div class="col-md-3">
    <div><b>Date & Time</b></div>
    <input id="datestring" type="datetime-local" class="btn-block py-2 px-2" name="datestring" v-model="datestring" />
    </div>
</div>

<div class="row pb-3">
  <div class="col-md-3">
    <div><b>Search Term</b></div>
    <input id="searchTerm" type="text" class="btn-block py-2 px-2" name="searchTerm" v-model="searchTerm"></div>
<div class="col-md-3 pt-4"><button type="submit" class="btn btn-primary btn-block" @click="getWeatherForecast()">Weather & Forecast</button></div>
<div class="col-md-3 pt-4"><button type="submit" class="btn btn-success btn-block" @click="getHistory()">History</button></div>
<div class="col-md-3 pt-4"><button type="submit" class="btn btn-dark btn-block" @click="searchQuery()">Search</button></div>
</div>

<div class="alert alert-danger text-center" role="alert" v-if="error_message">
    <span v-html="error_message"></span>
</div>

<div v-if="loading_weather" class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i></div>
<div v-else-if="weather">
  <h5>Weather</h5>
  {{weather}}
  </div>

<div v-if="loading_forecast" class="text-center my-4"><i class="fas fa-spinner fa-spin fa-2x"></i></div>
<div v-else-if="forecast" class="my-4">
  <h5>Forecast</h5>
  {{forecast}}
  </div>

<div v-if="loading_history" class="text-center my-4"><i class="fas fa-spinner fa-spin fa-2x"></i></div>
<div v-else-if="history" class="mt-2 mb-4">
  <h5>History</h5>
  {{history}}
  </div>

<div v-if="loading_search" class="text-center my-4"><i class="fas fa-spinner fa-spin fa-2x"></i></div>
<div v-else-if="searchResults" class="mt-2 mb-4">
  <h5>Search results for <b>{{searchTerm}}</b></h5>
  {{searchResults}}
  </div>

</div>
</template>

<script>
export default {
  props: ['user'],

  data() {
    return {
      weather: null,
      forecast: null,
      history: null,
      searchResults: null,
      loading_weather: false,
      loading_forecast: false,
      loading_history: false,
      loading_search: false,
      searchTerm: 'cape',
      city: 'Pretoria',
      longitude: '28.1878',
      latitude: '-25.7449',
      datestring: '2025-04-01T19:57',
      error_message: null,
    };
  },

  methods: {

    getWeatherForecast() {
      this.weather = null;
      this.forecast = null;
      this.history = null;
      this.searchResults = null;
      this.error_message = null;
      this.getWeather();
      this.getForecast();
    },

    getWeather() {
  const auth_token = localStorage.getItem('auth_token') ?? null;

  
  this.loading_weather = true;

  axios
    .post('/api/v1/weather', {
      city: this.city,
      longitude: this.longitude,
      latitude: this.latitude,
    }, {
      headers: {
        'Authorization': 'Bearer ' + auth_token,
      }
    })
    .then((response) => {
      if (response.data.success) {
        this.weather = response.data.data;
      } else {
        this.error_message = response.data.message;
      }

      this.loading_weather = false;
    })
    .catch((error) => {
      this.loading_weather = false;

      if (error.response) {
        if (error.response.status === 429) {
          this.error_message = error.response.data?.message || "Too many requests. Please try again later.";
        } else {
          this.error_message = error.response.data?.message || "An error occurred.";
        }
      } else {
        this.error_message = "Unable to connect to the server.";
      }
    });
},

getHistory() {
  const auth_token = localStorage.getItem('auth_token') ?? null;

  this.history = null;
  this.weather = null;
  this.forecast = null;
  this.searchResults = null;
  this.error_message = null;

  this.loading_history = true;

  axios
    .post('/api/v1/history', {
      datestring: this.datestring,
      longitude: this.longitude,
      latitude: this.latitude,
    }, {
      headers: {
        'Authorization': 'Bearer ' + auth_token,
      }
    })
    .then((response) => {
      if (response.data.success) {
        this.history = response.data.data;
      } else {
        this.error_message = response.data.message;
      }

      this.loading_history = false;
    })
    .catch((error) => {
      this.loading_history = false;

      if (error.response) {
        if (error.response.status === 429) {
          this.error_message = error.response.data?.message || "Too many requests. Please try again later.";
        } else {
          this.error_message = error.response.data?.message || "An error occurred.";
        }
      } else {
        this.error_message = "Unable to connect to the server.";
      }
    });
},


    getForecast() {

      const auth_token = localStorage.getItem('auth_token') ?? null;
      
      this.forecast = null;
      this.loading_forecast = true;
      this.error_message = null;

      axios
        .post('/api/v1/forecast', {
          city: this.city,
          longitude: this.longitude,
          latitude: this.latitude,
        }, {
          headers: {
            'Authorization': 'Bearer ' + auth_token,
          }
        })
        .then((response) => {
          if (response.data.success) {
            this.forecast = response.data.data;
          }
          else {
            this.error_message = response.data.message;
          }

          this.loading_forecast = false;
        })
        .catch((error) => {

          this.loading_forecast = false;

          if (error.response) {
            if (error.response.status === 429) {
              this.error_message = error.response.data?.message || "Too many requests. Please try again later.";
            } else {
              this.error_message = error.response.data?.message || "An error occurred.";
            }
          } else {
            this.error_message = "Unable to connect to the server.";
          }
      });
    },

    searchQuery() {

      const auth_token = localStorage.getItem('auth_token') ?? null;
      
      this.forecast = null;
      this.history = null;
      this.loading_search = true;
      this.error_message = null;

      axios
        .post('/api/v1/search', {
          searchTerm: this.searchTerm,
        }, {
          headers: {
            'Authorization': 'Bearer ' + auth_token,
          }
        })
        .then((response) => {
          if (response.data.success) {
            this.searchResults = response.data.data;
          }
          else {
            this.error_message = response.data.message;
          }

          this.loading_search = false;
        })
        .catch((error) => {

          this.loading_search = false;

          if (error.response) {
            if (error.response.status === 429) {
              this.error_message = error.response.data?.message || "Too many requests. Please try again later.";
            } else {
              this.error_message = error.response.data?.message || "An error occurred.";
            }
          } else {
            this.error_message = "Unable to connect to the server.";
          }
      });
    },

  },

}

</script>
