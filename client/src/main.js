import { createApp } from 'vue'
import './global.css'
import './assets/css/option.css'
import 'prismjs';
import 'prismjs/themes/prism-tomorrow.css';
import App from './App.vue'
import router from './router'

createApp(App).use(router).mount('#app')
