<template>
  <div class="container py-3">
    <div class="text-center">Hello {{ user.name }} 👋</div>

    <div class="row pt-2 pb-2">
      <div class="col-md-3">
        <div><b>City</b></div>
        <input
          id="city"
          type="text"
          class="btn-block py-2 px-2"
          name="city"
          v-model="city"
        />
      </div>
      <div class="col-md-3">
        <div><b>Longitude</b></div>
        <input
          id="city"
          type="text"
          class="btn-block py-2 px-2"
          name="longitude"
          v-model="longitude"
        />
      </div>
      <div class="col-md-3">
        <div><b>Latitude</b></div>
        <input
          id="city"
          type="text"
          class="btn-block py-2 px-2"
          name="latitude"
          v-model="latitude"
        />
      </div>
      <div class="col-md-3">
        <div><b>Date & Time</b></div>
        <input
          id="datestring"
          type="datetime-local"
          class="btn-block py-2 px-2"
          name="datestring"
          v-model="datestring"
        />
      </div>
    </div>

    <div class="row pb-3">
      <div class="col-md-3">
        <div><b>Search Term</b></div>
        <input
          id="searchTerm"
          type="text"
          class="btn-block py-2 px-2"
          name="searchTerm"
          v-model="searchTerm"
        />
      </div>
      <div class="col-md-3 pt-4">
        <button
          type="submit"
          class="btn btn-primary btn-block"
          @click="getWeatherForecast()"
        >
          Weather & Forecast
        </button>
      </div>
      <div class="col-md-3 pt-4">
        <button
          type="submit"
          class="btn btn-success btn-block"
          @click="getHistory()"
        >
          History
        </button>
      </div>
      <div class="col-md-3 pt-4">
        <button
          type="submit"
          class="btn btn-dark btn-block"
          @click="searchQuery()"
        >
          Search
        </button>
      </div>
    </div>

    <div
      class="alert alert-danger text-center"
      role="alert"
      v-if="error_message"
    >
      <span v-html="error_message"></span>
    </div>

    <div v-if="loading_weather" class="text-center">
      <i class="fas fa-spinner fa-spin fa-2x"></i>
    </div>
    <div v-else-if="weather" class="weather-card">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <h2 class="card-title">
                <img
                  :src="`https://flagcdn.com/w20/${weather.sys.country.toLowerCase()}.png`"
                  :alt="weather.sys.country"
                  class="country-flag"
                />
                {{ weather.name }}, {{ weather.sys.country }}
              </h2>
              <div class="d-flex align-items-center">
                <img
                  :src="`https://openweathermap.org/img/wn/${weather.weather[0].icon}@2x.png`"
                  alt="Weather icon"
                />
                <div>
                  <h3 class="mb-0">
                    {{ Math.round(weather.main.temp - 273.15) }}°C
                  </h3>
                  <p class="text-capitalize">
                    {{ weather.weather[0].description }}
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="weather-details">
                <div class="detail-item">
                  <i class="fas fa-map-marker-alt"></i>
                  <span
                    >Location: {{ weather.coord.lat }}°N,
                    {{ weather.coord.lon }}°E</span
                  >
                </div>
                <div class="detail-item">
                  <i class="fas fa-temperature-high"></i>
                  <span
                    >Feels like:
                    {{ Math.round(weather.main.feels_like - 273.15) }}°C</span
                  >
                </div>
                <div class="detail-item">
                  <i class="fas fa-tint"></i>
                  <span>Humidity: {{ weather.main.humidity }}%</span>
                </div>
                <div class="detail-item">
                  <i class="fas fa-wind"></i>
                  <span>Wind: {{ weather.wind.speed }} m/s</span>
                </div>
                <div class="detail-item">
                  <i class="fas fa-compress-arrows-alt"></i>
                  <span>Pressure: {{ weather.main.pressure }} hPa</span>
                </div>
                <div class="detail-item">
                  <i class="fas fa-eye"></i>
                  <span>Visibility: {{ weather.visibility / 1000 }} km</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="loading_forecast" class="text-center my-4">
      <i class="fas fa-spinner fa-spin fa-2x"></i>
    </div>
    <div v-else-if="forecast" class="forecast-section my-4">
      <h5>5-Day Forecast</h5>
      <div class="forecast-scroll-container">
        <div class="forecast-container">
          <div
            v-for="(item, index) in forecast.list"
            :key="index"
            class="forecast-card"
          >
            <div class="forecast-time">
              <div class="forecast-day">{{ formatDay(item.dt_txt) }}</div>
              <div class="forecast-date">{{ formatDate(item.dt_txt) }}</div>
              <div class="forecast-hour">{{ formatTime(item.dt_txt) }}</div>
            </div>
            <img
              :src="`https://openweathermap.org/img/wn/${item.weather[0].icon}@2x.png`"
              :alt="item.weather[0].description"
              class="forecast-icon"
            />
            <div class="forecast-temp">
              {{ Math.round(item.main.temp - 273.15) }}°C
            </div>
            <div class="forecast-desc text-capitalize">
              {{ item.weather[0].description }}
            </div>
            <div class="forecast-details">
              <div class="detail-item">
                <i class="fas fa-tint"></i>
                <span>{{ item.main.humidity }}%</span>
              </div>
              <div class="detail-item">
                <i class="fas fa-wind"></i>
                <span>{{ item.wind.speed }} m/s</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="loading_history" class="text-center my-4">
      <i class="fas fa-spinner fa-spin fa-2x"></i>
    </div>
    <div v-else-if="history" class="history-section mt-2 mb-4">
      <h5 class="mb-3">Historical Weather</h5>
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="d-flex align-items-center">
                <img
                  :src="`https://openweathermap.org/img/wn/${history.data[0].weather[0].icon}@2x.png`"
                  :alt="history.data[0].weather[0].description"
                  class="history-icon"
                />
                <div>
                  <h3 class="mb-0">
                    {{ Math.round(history.data[0].temp - 273.15) }}°C
                  </h3>
                  <p class="text-capitalize">
                    {{ history.data[0].weather[0].description }}
                  </p>
                </div>
              </div>
              <div class="history-time mt-3">
                <div class="detail-item">
                  <i class="fas fa-calendar"></i>
                  <span>{{ formatHistoryDate(history.data[0].dt) }}</span>
                </div>
                <div class="detail-item">
                  <i class="fas fa-clock"></i>
                  <span>{{ formatHistoryTime(history.data[0].dt) }}</span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="history-details">
                <div class="detail-item">
                  <i class="fas fa-map-marker-alt"></i>
                  <span
                    >Location: {{ history.lat }}°N, {{ history.lon }}°E</span
                  >
                </div>
                <div class="detail-item">
                  <i class="fas fa-temperature-high"></i>
                  <span
                    >Feels like:
                    {{
                      Math.round(history.data[0].feels_like - 273.15)
                    }}°C</span
                  >
                </div>
                <div class="detail-item">
                  <i class="fas fa-tint"></i>
                  <span>Humidity: {{ history.data[0].humidity }}%</span>
                </div>
                <div class="detail-item">
                  <i class="fas fa-wind"></i>
                  <span
                    >Wind: {{ history.data[0].wind_speed }} m/s ({{
                      getWindDirection(history.data[0].wind_deg)
                    }})</span
                  >
                </div>
                <div class="detail-item">
                  <i class="fas fa-compress-arrows-alt"></i>
                  <span>Pressure: {{ history.data[0].pressure }} hPa</span>
                </div>
                <div class="detail-item">
                  <i class="fas fa-eye"></i>
                  <span
                    >Visibility:
                    {{ history.data[0].visibility / 1000 }} km</span
                  >
                </div>
                <div class="detail-item">
                  <i class="fas fa-cloud"></i>
                  <span>Clouds: {{ history.data[0].clouds }}%</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="loading_search" class="text-center my-4">
      <i class="fas fa-spinner fa-spin fa-2x"></i>
    </div>
    <div v-else-if="searchResults" class="mt-2 mb-4">
      <h5 class="mb-3">
        Search results for <b>{{ searchTerm }}</b>
      </h5>
      <div class="search-results">
        <div
          v-for="(result, index) in searchResults"
          :key="index"
          class="search-card"
        >
          <div class="search-card-header">
            <img
              :src="`https://flagcdn.com/w20/${result.country.toLowerCase()}.png`"
              :alt="result.country"
              class="country-flag"
            />
            <h6 class="mb-0">{{ result.name }}</h6>
          </div>
          <div class="search-card-body">
            <div class="detail-item">
              <i class="fas fa-map-marker-alt"></i>
              <span>Location: {{ result.lat }}°N, {{ result.lon }}°E</span>
            </div>
            <div class="detail-item">
              <i class="fas fa-globe"></i>
              <span>Country: {{ result.country }}</span>
            </div>
            <div v-if="result.state" class="detail-item">
              <i class="fas fa-map"></i>
              <span>State/Region: {{ result.state }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["user"],

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
      searchTerm: "port elizabeth",
      city: "pretoria",
      longitude: "28.1878",
      latitude: "-25.7449",
      datestring: "2025-04-01T19:57",
      error_message: null,
    };
  },

  methods: {
    getWeatherForecast() {
      this.clearAll();
      this.getWeather();
      this.getForecast();
    },

    getWeather() {
      const auth_token = localStorage.getItem("auth_token") ?? null;

      this.loading_weather = true;

      axios
        .post(
          "/api/v1/weather",
          {
            city: this.city,
            longitude: this.longitude,
            latitude: this.latitude,
          },
          {
            headers: {
              Authorization: "Bearer " + auth_token,
            },
          }
        )
        .then((response) => {
          this.weather = response.data.data;
        })
        .catch((error) => {
          this.error_message = error.response.data.message;
        })
        .finally(() => {
          this.loading_weather = false;
        });
    },

    getHistory() {
      const auth_token = localStorage.getItem("auth_token") ?? null;

      this.clearAll();

      this.loading_history = true;

      axios
        .post(
          "/api/v1/history",
          {
            datestring: this.datestring,
            longitude: this.longitude,
            latitude: this.latitude,
          },
          {
            headers: {
              Authorization: "Bearer " + auth_token,
            },
          }
        )
        .then((response) => {
            this.history = response.data.data;
        })
        .catch((error) => {
              this.error_message = error.response.data.message;
        }).finally(() => {
          this.loading_history = false;
        });
    },

    getForecast() {
      const auth_token = localStorage.getItem("auth_token") ?? null;

      this.clearAll();

      this.loading_forecast = true;

      axios
        .post(
          "/api/v1/forecast",
          {
            city: this.city,
            longitude: this.longitude,
            latitude: this.latitude,
          },
          {
            headers: {
              Authorization: "Bearer " + auth_token,
            },
          }
        )
        .then((response) => {
            this.forecast = response.data.data;
        })
        .catch((error) => {
              this.error_message = error.response.data.message;
        }).finally(() => {
          this.loading_forecast = false;
        });
    },

    searchQuery() {
      const auth_token = localStorage.getItem("auth_token") ?? null;

      this.clearAll();

      this.loading_search = true;

      axios
        .post(
          "/api/v1/search",
          {
            searchTerm: this.searchTerm,
          },
          {
            headers: {
              Authorization: "Bearer " + auth_token,
            },
          }
        )
        .then((response) => {
            this.searchResults = response.data.data;
        })
        .catch((error) => {
            this.error_message = error.response.data.message;
        }).finally(() => {
          this.loading_search = false;
        });
    },

    formatTime(dt_txt) {
      const date = new Date(dt_txt);
      return date.toLocaleTimeString([], {
        hour: "2-digit",
        minute: "2-digit",
      });
    },
    formatDay(dt_txt) {
      const date = new Date(dt_txt);
      return date.toLocaleDateString([], { weekday: "short" });
    },
    formatDate(dt_txt) {
      const date = new Date(dt_txt);
      return date.toLocaleDateString([], { month: "short", day: "numeric" });
    },
    formatHistoryDate(timestamp) {
      const date = new Date(timestamp * 1000);
      return date.toLocaleDateString([], {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
      });
    },
    formatHistoryTime(timestamp) {
      const date = new Date(timestamp * 1000);
      return date.toLocaleTimeString([], {
        hour: "2-digit",
        minute: "2-digit",
        hour12: false,
      });
    },
    getWindDirection(degrees) {
      const directions = [
        "N",
        "NNE",
        "NE",
        "ENE",
        "E",
        "ESE",
        "SE",
        "SSE",
        "S",
        "SSW",
        "SW",
        "WSW",
        "W",
        "WNW",
        "NW",
        "NNW",
      ];
      const index = Math.round(degrees / 22.5) % 16;
      return directions[index];
    },

    clearAll() {
      this.weather = null;
      this.forecast = null;
      this.history = null;
      this.searchResults = null;
      this.error_message = null;
    },
  },
};
</script>

<style scoped>
.weather-card {
  margin: 20px 0;
}

.weather-card .card {
  border-radius: 15px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.weather-card .card-body {
  padding: 20px;
}

.weather-card img {
  margin-right: 5px;
}

.weather-details {
  margin-top: 20px;
}

.detail-item {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

.detail-item i {
  width: 30px;
  color: #6c757d;
  margin-right: 10px;
}

.text-capitalize {
  text-transform: capitalize;
}

.country-flag {
  width: 20px;
  height: 14px;
  margin-right: 10px;
  vertical-align: middle;
  border: 1px solid #dee2e6;
}

.forecast-section {
  position: relative;
}

.forecast-header {
  position: sticky;
  left: 0;
  z-index: 1;
  background: white;
  padding-right: 20px;
}

.forecast-scroll-container {
  overflow-x: auto;
  padding: 10px 0;
  margin-left: -20px;
  padding-left: 20px;
}

.forecast-container {
  display: flex;
  gap: 15px;
  padding: 10px;
  min-width: min-content;
}

.forecast-card {
  min-width: 150px;
  background: white;
  border-radius: 10px;
  padding: 15px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.forecast-time {
  font-weight: bold;
  margin-bottom: 10px;
}

.forecast-day {
  font-size: 1.1em;
  color: #333;
}

.forecast-date {
  font-size: 0.9em;
  color: #666;
  margin: 2px 0;
}

.forecast-hour {
  font-size: 0.8em;
  color: #888;
}

.forecast-icon {
  width: 50px;
  height: 50px;
  margin: 5px 0;
}

.forecast-temp {
  font-size: 1.2em;
  font-weight: bold;
  margin: 5px 0;
}

.forecast-desc {
  font-size: 0.9em;
  color: #666;
  margin-bottom: 10px;
}

.forecast-details {
  font-size: 0.8em;
  color: #666;
}

.forecast-details .detail-item {
  margin: 5px 0;
  justify-content: center;
}

.forecast-details .detail-item i {
  width: 20px;
  margin-right: 5px;
}

.history-section .card {
  border-radius: 15px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.history-section .card-body {
  padding: 20px;
}

.history-icon {
  width: 100px;
  height: 100px;
  margin-right: 15px;
}

.history-time {
  margin-top: 15px;
}

.history-details {
  margin-top: 20px;
}

.history-time .detail-item {
  margin-bottom: 8px;
}

.history-time .detail-item i {
  width: 20px;
  color: #6c757d;
  margin-right: 10px;
}

.search-results {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.search-card {
  background: white;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

.search-card-header {
  padding: 15px;
  background: #f8f9fa;
  border-bottom: 1px solid #dee2e6;
  display: flex;
  align-items: center;
  gap: 10px;
}

.search-card-body {
  padding: 15px;
}
</style>
