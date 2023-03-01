import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
// import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from "@fortawesome/fontawesome-svg-core"
import { faPhone } from "@fortawesome/free-solid-svg-icons"
import { faHome } from "@fortawesome/free-solid-svg-icons"
import { faStar } from "@fortawesome/free-solid-svg-icons"
import { faList } from "@fortawesome/free-solid-svg-icons"
import { faRectangleList } from "@fortawesome/free-solid-svg-icons"
import { faUser } from "@fortawesome/free-solid-svg-icons"
import { faGear } from "@fortawesome/free-solid-svg-icons"
import { faThumbtack } from "@fortawesome/free-solid-svg-icons"
import { faSearch } from "@fortawesome/free-solid-svg-icons"
import { faBriefcase } from "@fortawesome/free-solid-svg-icons"
import { faBell } from "@fortawesome/free-solid-svg-icons"
import { faDownload } from "@fortawesome/free-solid-svg-icons"
import { faCircleDown } from "@fortawesome/free-solid-svg-icons"
library.add(faPhone)
library.add(faHome)
library.add(faStar)
library.add(faList)
library.add(faRectangleList)
library.add(faUser)
library.add(faGear)
library.add(faThumbtack)
library.add(faSearch)
library.add(faBriefcase)
library.add(faBell)
library.add(faDownload)
library.add(faCircleDown)


// import { Vue } from 'vue'
// import BootstrapVue from 'bootstrap-vue'
// import BootstrapVueIcons from 'bootstrap-vue'

// import './assets/main.css'

const app = createApp(App)

app.component('font-awesome-icon', FontAwesomeIcon)
app.use(router)



app.mount('#app')
