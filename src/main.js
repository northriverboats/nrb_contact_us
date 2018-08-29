// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import 'babel-polyfill'
import Vue from 'vue'
import App from './App'
import axios from 'axios'
import VueAxios from 'vue-axios'
import Snotify from 'vue-snotify'
import 'vue-snotify/styles/dark.css'
import router from './router'
import _ from 'lodash'

Vue.config.productionTip = false

Object.defineProperty(Vue.prototype, '$_', { value: _ })
axios.defaults.baseURL = window.wp_info.rest_url + 'nrb_contact_us/'
Vue.use(VueAxios, axios)
Vue.use(Snotify)

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
})
