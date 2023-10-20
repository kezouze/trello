import './bootstrap';
import { createApp } from 'vue'
import AppComponent from './components/AppComponent.vue';
import router from './router/index';

createApp(AppComponent).use(router).mount('#app');
