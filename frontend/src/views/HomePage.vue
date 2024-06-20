<template>
  <div class="main">
    <div class="content">
      <h1>{{courseCode}}<br><span>{{courseName}}</span> <br>{{courseType}}</h1> 
      <p class="par">
        {{courseDescription}}
      </p>
      <button class="cn">
        <router-link :to="participateLink">
          {{participateText}}
        </router-link></button>
    </div> 
</div>
</template>

<script>
export default {
  name: 'HomePage',
  data() {
    return {
      courseCode: "SECJ3483",
      courseName: "Web Technology",
      courseType: "Course",
      courseDescription: "This course provides an in-depth understanding of modern web technologies, including front-end and back-end development, web frameworks, and best practices for building responsive and user-friendly web applications.",
      participateLink: "/registerForm",
      participateText: "PARTICIPATE"
    };
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
/* content */
.content{
    width: 1200px;
    height: auto;
    margin:auto;
    color: #fff;
    position: relative;
}

.content h1{
    font-family: 'Times New Roman', Times, serif;
    font-size: 55px;
    padding-left: 20px;
    margin-top: 9%;
    letter-spacing: 2px;
}

.content span{
    color: #ff7200;
    font-size: 65px;
}

.content .par{
    padding-left: 20px;
    padding-bottom: 25px;
    font-family: Arial, Helvetica, sans-serif;
    letter-spacing: 1.2px;
    line-height: 30px;
}

.content .cn{
    width: 200px;
    height: 40px;
    background: #ff7200;
    border: none;
    margin-bottom: 10px;
    margin-left: 20px;
    font-size: 18px;
    border-radius: 10px;
    cursor: pointer;
    transition: .4s ease;
}

.content .cn a{
    text-decoration: none;
    color: #000;
    transition: .3s ease;
}

.cn:hover{
    background-color: #fff;
    transform: scale(0.9) translateX(15px) translateY(15px);
} 
</style>
