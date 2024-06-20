<template>
    <div class="main">
      <div class="navbar">
        <div class="icon">
          <h2 class="logo">W.Tech.</h2>
        </div>
    
        <div class="menu">
          <ul>
            <li v-for="item in menuItems" :key="item.text">
              <a :href="item.link">{{ item.text }}</a>
            </li>
          </ul>
        </div>
  
        <div class="search">
          <input class="srch" type="search" name="" placeholder="Type To Find" v-model="searchQuery">
          <button class="btn" @click="onSearch">Find</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'NavBar',
    data() {
      return {
        menuItems: [
          { text: 'HOME', link: '/' },
          { text: 'ABOUT', link: '/about' },
          { text: 'COURSE MATERIALS', link: '/course-materials' },
          { text: 'ASSESSMENT', link: '/assessment' },
          { text: 'CONTACT US', link: '/contact-us' },
          { text: 'LOGIN', link: '/login' }
        ],
        searchQuery: ''
      };
    },
    methods: {
      onSearch() {
        alert(`Searching for: ${this.searchQuery}`);
      }
    }
  }
  </script>
  
  <style scoped>
  * {
    margin: 0;
    padding: 0;
  }
  
  /* .main{
    width: 100%;
    background: linear-gradient(to top, rgba(0,0,0,0.5)50%,rgba(0,0,0,0.5)50%),url('~@/assets/3.jpg');
    background-position: center;
    background-size: cover;
    height: 100vh;
    }  */

  .navbar {
    width: 100%;
    height: 75px;
    margin: auto;
    display: flex;
    justify-content: space-between; /* Align items horizontally */
    align-items: center; /* Center items vertically */
  }
  
  .icon {
    width: 200px;
    height: 70px;
  }
  
  .logo {
    color: #fc8d1e;
    font-size: 20px;
    font-family: Cambria;
    padding-left: 50px;
    padding-top: 10px;
    margin-top: 5px;
  }
  
  .menu {
    flex: 1; /* Take remaining space */
    display: flex;
    justify-content: center;
  }
  
  .menu ul {
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .menu ul li {
    list-style: none;
    margin-left: 30px;
    margin-top: 27px;
    font-size: 14px;
  }
  
  .menu ul li a {
    text-decoration: none;
    color: #fff;
    font-family: Arial;
    font-weight: bold;
    transition: 0.4s ease-in-out;
  }
  
  .menu ul li a:hover {
    color: #ff7200;
  }
  
  .search {
    display: flex;
    align-items: center;
    margin-right: 10px;
  }
  
  .srch {
    font-family: 'Times New Roman', Times, serif;
    width: 150px;
    height: 30px;
    background: transparent;
    border: 1px solid #ff7200;
    margin-top: 20px;
    color: #fff;
    border-right: none;
    font-size: 16px;
    padding: 10px;
    border-bottom-left-radius: 5px;
    border-top-left-radius: 5px;
  }
  
  .btn {
    width: 80px;
    height: 30px;
    background: #ff7200;
    border: 2px solid #ff7200;
    margin-top: 20px; 
    color: #fff;
    font-size: 15px;
    border-bottom-right-radius: 5px;
    border-top-right-radius: 5px;
    transition: 0.2s ease;
    cursor: pointer;
  }
  
  .btn:hover {
    color: #000;
  }
  
  .btn:focus,
  .srch:focus {
    outline: none;
  }
  </style>
  
