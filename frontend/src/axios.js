import axios from 'axios';
import router from './router.js';


export const API_URL = import.meta.env.VITE_API_BASE_URL
const axiosClient = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json',
  },
  withXsrf: true
});

// Request Interceptor: Attach the token to every request if it exists
axiosClient.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('auth_token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Response Interceptor: Handle global errors (like token expiration)
axiosClient.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response && error.response.status === 401) {
      // Token expired or invalid -> Clear storage and redirect to login
      localStorage.removeItem('auth_token');
      window.location.href = '/login'; 
    }
    return Promise.reject(error);
  }
);

export default axiosClient;