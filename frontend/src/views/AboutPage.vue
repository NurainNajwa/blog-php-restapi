<template>
  <div>
    <div class="about-content">
      <h1>{{about}}</h1>
      <p>{{ aboutDetail }}</p>
      <p>{{ aboutContent }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: "AboutPage",
  data(){
    return{
      about: "About Web Technology",
      aboutDetail : "Web technology refers to the various tools and techniques used in the process of communication between different types of devices over the Internet. It encompasses a broad range of technologies that enable the creation, storage, and transfer of data in the web environment.",
      aboutContent: "Web technologies include HTML, CSS, JavaScript, and various frameworks and libraries that help developers build interactive and dynamic websites. These technologies allow for the creation of user-friendly interfaces, robust backend systems, and seamless connectivity between clients and servers."
    };
  },
}
</script>

<style scoped>

.about-content {
    width: 1200px;
    height: auto;
    margin:auto;
    color: #fff;
    position: relative;
    text-align: center;
}

.about-content h1 {
  font-family: "Times New Roman", Times, serif;
  font-size: 36px;
  padding-left: 20px;
    margin-top: 9%;
    letter-spacing: 2px;
  color:  #ff7200;
}

.about-content p {
  font-family: Arial, sans-serif;
  font-size: 18px;
  line-height: 1.6;
  margin-bottom: 10px;
  color: white;
}
</style>
