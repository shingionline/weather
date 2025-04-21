# Weather App

A Laravel-based weather dashboard and API platform with user authentication, rate limiting, and caching.

![Weather App Screenshot](https://res.cloudinary.com/web900/image/upload/v1745230615/files/avqyxl4z0vezcbi5czbo.png)


## 🚀 Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/shingionline/weather.git
   cd weather
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install Node dependencies:
   ```bash
   npm install
   npm run dev
   ```

4. Run migrations:
   ```bash
   php artisan migrate
   ```

5. Start the app using Docker:
   ```bash
   docker-compose up -d
   ```

> The dashboard will be available on **http://localhost:8000**


## 🔐 Authentication

Visit the dashboard and either **register** or **login** with your account to access weather data.

## 📥 Postman Collection

[Download Postman Collection](https://res.cloudinary.com/web900/raw/upload/v1745228547/files/yeyweaccefxjmfndryzp.json)


## 📬 API Endpoints

Use the provided **Postman collection** to test the API:

- `POST /api/v1/login`
- `POST /api/v1/weather`
- `POST /api/v1/forecast`
- `POST /api/v1/history`
- `POST /api/v1/search`
- `GET  /api/v1/user`
- `POST /api/v1/register`
- `POST /api/v1/logout`

## 🌟 Features

- ✅ Mobile and desktop friendly responsive UI
- ✅ API rate limit: **41 requests/hour**
- ✅ Secured with **personal access tokens**
- ✅ Normalized **database schema with indexes**
- ✅ API request **caching**
- ✅ Weather **location search**
- ✅ **User authentication**
- ✅ **Versioned API**
- ✅ **Postman collection** included
- ✅ Uses **.env** for configuration
- ✅ **HTTPS & secure headers** (production only)
- ✅ **Dockerized** setup with `docker-compose.yml`

## ⛔ Not Implemented (Due to Time Constraints)

- ❌ Data aggregation
- ❌ Interactive maps
- ❌ Dynamic charts
- ❌ Real-time updates
