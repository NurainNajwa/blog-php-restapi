<template>
    <div class="course-materials-container">
      <div class="course-materials-content">
        <h1>Course Materials</h1>
        <table>
          <thead>
            <tr>
              <th>Title</th>
              <th>Description</th>
              <th>Download</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="material in courseMaterials" :key="material.id">
              <td>{{ material.title }}</td>
              <td>{{ material.description }}</td>
              <td><a :href="material.link" target="_blank">Download</a></td>
              <td>
                <button @click="editMaterial(material)">Edit</button>
                <button @click="deleteMaterial(material.id)">Delete</button>
            </td>
            </tr>
          </tbody>
        </table>
        <h2>{{ editing ? 'Edit' : 'Add' }} Course Material</h2>
        <form @submit.prevent="onSubmit">
          <input v-model="form.id" type="hidden" />
          <div>
            <label>Title:</label>
            <input v-model="form.title" required />
          </div>
          <div>
            <label>Description:</label>
            <input v-model="form.description" required />
          </div>
          <div>
            <label>Link:</label>
            <input v-model="form.link" required />
          </div>
          <button type="submit">{{ editing ? 'Update' : 'Add' }}</button>
          <button @click="resetForm">Cancel</button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  export default {
    name: "CourseMaterialsPage",
    data() {
      return {
        courseMaterials: [],
      form: {
        id: null,
        title: '',
        description: '',
        link: ''
      },
      editing: false
      };
    },
    created() {
      this.fetchCourseMaterials();
    },
    methods: {
      fetchCourseMaterials() {
        axios.get('http://localhost:80/coursematerial.php?action=getCourseMaterials')
          .then(response => {
            this.courseMaterials = response.data;
          })
          .catch(error => {
            console.error('Error fetching course materials:', error);
          });
      },
      onSubmit() {
        if (this.editing) {
          this.updateCourseMaterial();
        } else {
          this.createCourseMaterial();
        }
      },
      createCourseMaterial() {
        axios.post('http://localhost:80/coursematerial.php?action=createCourseMaterial', this.form)
          .then(response => {
            alert('Course material created successfully');
            this.fetchCourseMaterials();
            this.resetForm();
          })
          .catch(error => {
            console.error('Error creating course material:', error);
          });
      },
      updateCourseMaterial() {
        axios.post('http://localhost:80/coursematerial.php?action=updateCourseMaterial', this.form)
          .then(response => {
            alert('Course material updated successfully');
            this.fetchCourseMaterials();
            this.resetForm();
          })
          .catch(error => {
            console.error('Error updating course material:', error);
          });
      },
      deleteCourseMaterial(id) {
        axios.get(`http://localhost:80/coursematerials.php?action=deleteCourseMaterial&id=${id}`)
          .then(response => {
            alert('Course material deleted successfully');
            this.fetchCourseMaterials();
          })
          .catch(error => {
            console.error('Error deleting course material:', error);
          });
      },
      editMaterial(material) {
        this.form = { ...material };
        this.editing = true;
      },
      resetForm() {
        this.form = {
          id: null,
          title: '',
          description: '',
          link: ''
        };
        this.editing = false;
      }
    }
  };
  </script>
  
  <style scoped>
  .course-materials-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
  }
  
  .course-materials-content {
    width: 800px;
    text-align: center;
  }
  
  .course-materials-content h1 {
    font-family: "Times New Roman", Times, serif;
    font-size: 36px;
    margin-bottom: 20px;
    color:#ff7200;
;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
  }
  
  th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }
  
  th {
    background-color: #ff7200;
    color: white;
    font-family: Arial, sans-serif;
  }
  
  td {
    color: white;
    font-family: Arial, sans-serif;
  }
  
  a {
    color: #ff7200;
    text-decoration: none;
  }
  
  a:hover {
    text-decoration: underline;
  }
  </style>
  