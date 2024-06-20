<template>
  <div class="assessment-container">
    <div class="assessment-content">
      <h1>Assessments</h1>
      <form @submit.prevent="createAssessment" v-if="!editing">
        <div class="form-group">
          <label for="title">Title:</label>
          <input type="text" id="title" v-model="newAssessment.title" required />
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea id="description" v-model="newAssessment.description" required></textarea>
        </div>
        <div class="form-group">
          <label for="dueDate">Due Date:</label>
          <input type="date" id="dueDate" v-model="newAssessment.dueDate" required />
        </div>
        <div class="form-group">
          <label for="submitLink">Submit Link:</label>
          <input type="text" id="submitLink" v-model="newAssessment.submitLink" required />
        </div>
        <button type="submit">Create Assessment</button>
      </form>
      <form @submit.prevent="updateAssessment" v-if="editing">
        <input type="hidden" v-model="editAssessment.id" />
        <div class="form-group">
          <label for="title">Title:</label>
          <input type="text" id="title" v-model="editAssessment.title" required />
        </div>
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea id="description" v-model="editAssessment.description" required></textarea>
        </div>
        <div class="form-group">
          <label for="dueDate">Due Date:</label>
          <input type="date" id="dueDate" v-model="editAssessment.dueDate" required />
        </div>
        <div class="form-group">
          <label for="submitLink">Submit Link:</label>
          <input type="text" id="submitLink" v-model="editAssessment.submitLink" required />
        </div>
        <button type="submit">Update Assessment</button>
        <button @click.prevent="cancelEdit">Cancel</button>
      </form>
      <table v-if="assessments.length > 0">
        <thead>
          <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Due Date</th>
            <th>Submit</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="assessment in assessments" :key="assessment.id">
            <td>{{ assessment.title }}</td>
            <td>{{ assessment.description }}</td>
            <td>{{ assessment.dueDate }}</td>
            <td><a :href="assessment.submitLink" target="_blank">Submit</a></td>
            <td>
              <button @click.prevent="editMode(assessment)">Edit</button>
              <button @click.prevent="deleteAssessment(assessment.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
      <p v-else>No assessments available.</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "AssessmentPage",
  data() {
    return {
      assessments: [],
      newAssessment: {
        title: "",
        description: "",
        dueDate: "",
        submitLink: ""
      },
      editAssessment: {
        id: null,
        title: "",
        description: "",
        dueDate: "",
        submitLink: ""
      },
      editing: false
    };
  },
  mounted() {
    this.fetchAssessments();
  },
  methods: {
    fetchAssessments() {
      axios.get('http://localhost:80/assessment.php?action=getAssessments')
        .then(response => {
          this.assessments = response.data;
        })
        .catch(error => {
          console.error('Error fetching assessments:', error);
        });
    },
    createAssessment() {
      axios.post('http://localhost:80/assessment.php?action=createAssessment', this.newAssessment)
        .then(response => {
          alert(response.data.message);
          this.resetForm();
          this.fetchAssessments();
        })
        .catch(error => {
          alert('Error creating assessment: ' + error.response.data.error);
        });
    },
    updateAssessment() {
      axios.put(`http://localhost:80/assessment.php?action=updateAssessment&id=${this.editAssessment.id}`, this.editAssessment)
        .then(response => {
          alert(response.data.message);
          this.cancelEdit();
          this.fetchAssessments();
        })
        .catch(error => {
          alert('Error updating assessment: ' + error.response.data.error);
        });
    },
    deleteAssessment(id) {
      if (confirm("Are you sure you want to delete this assessment?")) {
        axios.delete(`http://localhost:80/assessment.php?action=deleteAssessment&id=${id}`)
          .then(response => {
            alert(response.data.message);
            this.fetchAssessments();
          })
          .catch(error => {
            alert('Error deleting assessment: ' + error.response.data.error);
          });
      }
    },
    editMode(assessment) {
      this.editing = true;
      this.editAssessment.id = assessment.id;
      this.editAssessment.title = assessment.title;
      this.editAssessment.description = assessment.description;
      this.editAssessment.dueDate = assessment.dueDate;
      this.editAssessment.submitLink = assessment.submitLink;
    },
    cancelEdit() {
      this.editing = false;
      this.editAssessment.id = null;
      this.editAssessment.title = "";
      this.editAssessment.description = "";
      this.editAssessment.dueDate = "";
      this.editAssessment.submitLink = "";
    },
    resetForm() {
      this.newAssessment.title = "";
      this.newAssessment.description = "";
      this.newAssessment.dueDate = "";
      this.newAssessment.submitLink = "";
    }
  }
};
</script>

  <script>
  import axios from 'axios';

export default {
  name: "AssessmentPage",
  data() {
    return {
      assessments: []
    };
  },
  mounted() {
    this.fetchAssessments();
  },
  methods: {
    fetchAssessments() {
      axios.get('http://localhost:80/assessment.php?action=getAssessments')
        .then(response => {
          this.assessments = response.data;
        })
        .catch(error => {
          console.error('Error fetching assessments:', error);
        });
    }
  }
};
  </script>
  
  <style scoped>
  .assessment-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
  }
  
  .assessment-content {
    width: 800px;
    text-align: center;
  }
  
  .assessment-content h1 {
    font-family: "Times New Roman", Times, serif;
    font-size: 36px;
    margin-bottom: 20px;
    color: #ff7200;
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
  