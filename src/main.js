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
import { faGauge } from "@fortawesome/free-solid-svg-icons"
import { faMap } from "@fortawesome/free-solid-svg-icons"
import { faMapPin } from "@fortawesome/free-solid-svg-icons"
import { faMapMarked } from "@fortawesome/free-solid-svg-icons"
import { faMapMarker } from "@fortawesome/free-solid-svg-icons"
import { faChartArea } from "@fortawesome/free-solid-svg-icons"
import { faChartColumn } from "@fortawesome/free-solid-svg-icons"
import { faFilePdf } from "@fortawesome/free-solid-svg-icons"
import { faFileExcel } from "@fortawesome/free-solid-svg-icons"
// import { faWhatsapp } from "@fortawesome/free-regular-svg-icons"
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
library.add(faGauge)
library.add(faMap)
library.add(faMapPin)
library.add(faMapMarked)
library.add(faMapMarker)
library.add(faChartArea)
library.add(faChartColumn)
library.add(faFilePdf)
library.add(faFileExcel)
// library.add(faWhatsapp)

// import Vuelidate from 'vuelidate'
// Vue.use(Vuelidate)

// import { Vue } from 'vue'
// import BootstrapVue from 'bootstrap-vue'
// import BootstrapVueIcons from 'bootstrap-vue'

// import './assets/main.css'

import VueTheMask from 'vue-the-mask';
import money from 'v-money';

import { faWhatsappSquare } from '@fortawesome/free-brands-svg-icons'

const app = createApp(App);

app.component('font-awesome-icon', FontAwesomeIcon);
app.use(router);
app.use(VueTheMask);
app.use(money, {
    // decimal: ',',
    thousands: '.',
    prefix: 'R$ ',
    precision: 0,
    masked: false
});



app.mount('#app')
