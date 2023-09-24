import './bootstrap';
import { createApp } from 'vue';
import app from'./components/app.vue';

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* import specific icons */
import {faEdit, faMagnifyingGlass, faPlus, faPrint, faTrash, faUserSecret,  } from '@fortawesome/free-solid-svg-icons'

library.add(faUserSecret,faPlus,faMagnifyingGlass,faPrint,faEdit,faTrash)

import router from './components/router/index.js'

createApp(app)
.component('font-awesome-icon', FontAwesomeIcon)
.use(router)
.mount("#app")
