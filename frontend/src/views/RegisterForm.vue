<template>
    <div class="register-container">
      <h2>Register</h2>
      <form @submit.prevent="onSubmit">
        <div class="form-group">
          <label for="fullName">Full Name:</label>
          <input type="text" id="fullName" v-model="fullName" required />
        </div>
        <div class="form-group">
          <label for="username">UserName:</label>
          <input type="text" id="username" v-model="username" required />
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="email" required />
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" v-model="password" required />
        </div>
        <div class="form-group">
          <label for="matricNumber">Matric Number:</label>
          <input type="text" id="matricNumber" v-model="matricNumber" required />
        </div>
        <div class="form-group">
          <label for="yearOfStudy">Year of Study:</label>
          <input type="number" id="yearOfStudy" v-model="yearOfStudy" required />
        </div>
        <button type="submit">Register</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  export default {
    name: 'RegisterForm',
    data() {
      return {
        fullName: '',
        username: '',
        email: '',
        password: '',
        matricNumber: '',
        yearOfStudy: ''
      };
    },
    methods: {
      onSubmit() {
        // Basic form validation
        if (!this.fullName || !this.username || !this.email || !this.password || !this.matricNumber || !this.yearOfStudy) {
            alert('Please fill out all fields.');
            return;
        }

        // Implement registration logic here
        const formData = {
          fullName: this.fullName,
          username: this.username,
          email: this.email,
          password: this.password,
          matricNumber: this.matricNumber,
          yearOfStudy: this.yearOfStudy
        };
        // Make HTTP POST request to backend registration endpoint
        axios.post('http://localhost:80/index.php?action=createUser', formData)
            .then(response => {
            alert(`Registration successful! Welcome, ${response.data.fullName}`);
            // Redirect to login page or perform other actions upon successful registration
            this.$router.push('/login');
            })
            .catch(error => {
            alert('Registration failed. Please try again.');
            console.error('Error registering:', error);
            });
      }
    }
  }
  </script>
  
  <style scoped>
  .register-container {
    max-width: 400px;
    margin: auto;
    padding: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
  