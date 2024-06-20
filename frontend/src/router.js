import { createRouter, createWebHistory } from 'vue-router';
import HomePage from './views/HomePage.vue';
import AboutPage from './views/AboutPage.vue';
import CourseMaterials from './views/CourseMaterialsPage.vue';
import AssessmentPage from './views/AssessmentPage.vue';
import ContactUs from './views/ContactUs.vue';
import RegisterForm from './views/RegisterForm.vue';
import LoginPage from './views/LoginPage.vue';

const routes = [
  { path: '/', name: 'HomePage', component: HomePage },
  { path: '/about', name: 'AboutPage', component: AboutPage },
  { path: '/course-materials', name: 'CourseMaterials', component: CourseMaterials },
  { path: '/assessment', name: 'AssessmentPage', component: AssessmentPage },
  { path: '/contact-us', name: 'ContactUs', component: ContactUs },
  { path: '/registerForm', name: 'RegisterForm', component: RegisterForm },
  { path: '/login', name: 'LoginPage', component: LoginPage }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
