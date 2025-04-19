<template>
<div class="container py-3">
<p>Hello {{ user.name }}</p>
<div v-if="loading" class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i></div>
<div v-else-if="!weather" class="text-center">No data</div>
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
    };
  },

  created() {
    this.getWeather();
  },

  methods: {

    getWeather() {
      this.loading = true;

      axios
        .get('/weather')
        .then((response) => {
          this.weather = response.data;
          this.loading = false;
        })
        .catch(function () {
          this.loading = false;
        });
    },

  },

}

</script>
