<template>
    <div class="contact-container">
      <div class="contact-content">
        <h1>Contact Us</h1>
        <form @submit.prevent="submitForm">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" v-model="form.name" required />
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" v-model="form.email" required />
          </div>
          <div class="form-group">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" v-model="form.subject" required />
          </div>
          <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" v-model="form.message" required></textarea>
          </div>
          <button type="submit">Submit</button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "ContactUs",
    data() {
      return {
        form: {
          name: "",
          email: "",
          subject: "",
          message: ""
        }
      };
    },
    methods: {
      submitForm() {
      axios.post('http://localhost:80/contactus.php?action=submitForm', this.form)
        .then(response => {
          alert(response.data.message);
          this.resetForm();
        })
        .catch(error => {
          alert('Error submitting form: ' + error.response.data.error);
        });
    },
    resetForm() {
      this.form.name = '';
      this.form.email = '';
      this.form.subject = '';
      this.form.message = '';
    }
    }
  };
  </script>
  
  <style scoped>
  .contact-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    height: 90vh;
  }
  
  .contact-content {
    width: 600px;
    background-color: rgba(52, 73, 94, 0.7);
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
  }
  
  .contact-content h1 {
    font-family: "Times New Roman", Times, serif;
    font-size: 36px;
    margin-bottom: 20px;
    color:#ff7200;

  }
  
  .form-group {
    margin-bottom: 15px;
    text-align: left;
  }
  
  .form-group label {
    display: block;
    font-family: Arial, sans-serif;
    font-size: 16px;
    color: white;
    margin-bottom: 5px;
  }
  
  .form-group input,
  .form-group textarea {
    width: 97%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
  }
  
  .form-group textarea {
    resize: vertical;
    height: 100px;
  }
  
  button {
    padding: 10px 20px;
    font-size: 16px;
    color: white;
    background-color: #ff7200;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  button:hover {
    background-color: #e67e22;
  }
  </style>
  