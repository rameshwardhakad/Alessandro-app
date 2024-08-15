import { app } from './app'
import { createPinia } from 'pinia'
import './plugins'
import './tailwind.css'

const pinia = createPinia()

app.use(pinia).mount('#app')
