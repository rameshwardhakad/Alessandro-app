import { app } from './app'
import { createPinia } from 'pinia'
import { router } from './router'
import { createSpack } from 'spack'
import './plugins'
import 'cooltipz-css'
import 'flatpickr/dist/flatpickr.css'
import './css/tailwind.css'
import './css/style.css'

const pinia = createPinia()

app.use(createSpack).use(pinia).use(router).mount('#app')
