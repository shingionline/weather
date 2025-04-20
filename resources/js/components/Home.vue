<template>
<div class="container py-3">
<div>Hello {{ user.name }}</div>
<div class="row pt-2">
  <div class="col"><b>City</b></div>
  <div class="col"><b>Longitude</b></div>
  <div class="col"><b>Latitude</b></div>
  <div class="col"></div>
</div>
<div class="row pt-2 pb-3">
  <div class="col">
    <input id="city" type="text" class="btn-block py-1 px-2" name="city" v-model="city"></div>
  <div class="col">
    <input id="city" type="text" class="btn-block py-1 px-2" name="longitude" v-model="longitude"></div>
  <div class="col">
    <input id="city" type="text" class="btn-block py-1 px-2" name="latitude" v-model="latitude"></div>
  <div class="col">
    <button type="submit" class="btn btn-primary btn-block" @click="getWeather()">Get Weather</button></div>
</div>

<div class="alert alert-danger text-center" role="alert" v-if="error_message">
    <span v-html="error_message"></span>
</div>

<div v-if="loading" class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i></div>
<div v-else>{{weather}}</div>

</div>
</template>

<script>
export default {
  props: ['user'],

  data() {
    return {
      weather: null,
      loading: false,
      city: null,
      longitude: null,
      latitude: null,
      error_message: null,
    };
  },

  created() {
    this.getWeather();
  },

  methods: {

    getWeather() {

      const auth_token = localStorage.getItem('auth_token') ?? null;
      
      this.weather = null;
      this.loading = true;
      this.error_message = null;

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
          }
          else {
            this.error_message = response.data.message;
          }

          this.loading = false;
        })
        .catch(function () {
          this.loading = false;
        });
    },

  },

}

</script>
