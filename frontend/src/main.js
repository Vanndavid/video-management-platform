import { createApp } from 'vue'
import './style.css'
import router from "./router";
import App from './App.vue'
import vuetify from './plugins/vuetify'

createApp(App)
.use(router)
.use(vuetify)
.mount('#app')
