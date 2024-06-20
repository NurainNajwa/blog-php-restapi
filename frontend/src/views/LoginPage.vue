<template>
  <div class="login-container">
    <h2>Login</h2>
    <form @submit.prevent="onLogin">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" v-model="username" required />
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="password" required />
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'LoginPage',
  data() {
    return {
      username: '',
      password: ''
    };
  },
  methods: {
      login() {
      // Basic form validation
      if (!this.username || !this.password) {
          alert('Please enter both username and password.');
          return;
      }
      // Implement login logic here (e.g., send login request to backend)
      const credentials = {
          username: this.username,
          password: this.password
      };
      // Make HTTP POST request to backend login endpoint
      axios.post('http://localhost:80/index.php?action=login', credentials)
              .then(response => {
              // Assuming the backend returns user data upon successful login
              alert(`Login successful! Welcome, ${response.data.user.username}`);
              // Redirect to another page or perform other actions upon successful login
              this.$router.push('/course-materials');
          })
          .catch(error => {
              if (error.response && error.response.status === 401) {
                  alert('Login failed. Incorrect username or password.');
              } else {
                  alert('Login failed. Please try again later.');
              }
              console.error('Error logging in:', error);
          });
  }
  }
}
</script>

<style scoped>
.login-container {
  max-width: 400px;
  margin: auto;
  padding: 1rem;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  margin-top: 50px;
}

h2 {
  text-align: center;
  margin-bottom: 1rem;
}

.form-group {
  margin-bottom: 1rem;
}

label {
  display: block;
  margin-bottom: 0.5rem;
}

input {
  width: 100%;
  padding: 0.5rem;
  box-sizing: border-box;
}

button {
  width: 100%;
  padding: 0.5rem;
  background-color: #ff7200;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #ff7200;
}
</style>
