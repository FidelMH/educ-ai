import axios from 'axios'

// Créer une instance axios avec la configuration de base
const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  withCredentials: true, // Important pour les cookies (Sanctum)
})

// Intercepteur de requête pour ajouter le token si disponible
apiClient.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('auth_token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

// Intercepteur de réponse pour gérer les erreurs
apiClient.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      // Token expiré ou invalide
      localStorage.removeItem('auth_token')
      // Rediriger vers la page de connexion si nécessaire
      // window.location.href = '/login'
    }
    return Promise.reject(error)
  }
)

// Exemple de service API
export default {
  // Authentification
  async login(credentials) {
    // CSRF Cookie pour Laravel Sanctum
    await apiClient.get('/sanctum/csrf-cookie')
    return apiClient.post('/api/login', credentials)
  },

  async register(userData) {
    return apiClient.post('/api/register', userData)
  },

  async logout() {
    return apiClient.post('/api/logout')
  },

  async getUser() {
    return apiClient.get('/api/user')
  },

  // Exemple de requêtes CRUD
  async getItems() {
    return apiClient.get('/api/items')
  },

  async getItem(id) {
    return apiClient.get(`/api/items/${id}`)
  },

  async createItem(data) {
    return apiClient.post('/api/items', data)
  },

  async updateItem(id, data) {
    return apiClient.put(`/api/items/${id}`, data)
  },

  async deleteItem(id) {
    return apiClient.delete(`/api/items/${id}`)
  },
}

// Export également l'instance axios pour des requêtes personnalisées
export { apiClient }
