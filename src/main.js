/* import 'babel-polyfill' */
import Vue from 'vue'
import App from './App.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import Snotify from 'vue-snotify'
import 'vue-snotify/styles/dark.css'
import router from './router'
import VueFormGenerator from 'vue-form-generator'
import 'vue-form-generator/dist/vfg.css'
import _ from 'lodash'


Vue.config.productionTip = false

Object.defineProperty(Vue.prototype, '$_', { value: _ })
axios.defaults.baseURL = window.wp_info.rest_url + 'nrb_contact_us/'
Vue.use(VueAxios, axios)
Vue.use(Snotify)
/* no-unused-vars */
Vue.use(VueFormGenerator, {
  validators: {
    phone (value, field, model) {
      if (value === '' && model.email === '') {
        return ['Phone OR Email address is required']
      }
      if (value === '' && model.email !== '') {
        return []
      }
      var phoneRegex = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/
      if (phoneRegex.test(value)) {
        model.phone = value.replace(phoneRegex, '($1) $2-$3')
        return []
      } else {
        // Invalid phone number
        return ['Invalid Phone Number']
      }
    },
    emailVal (value, field, model) {
      if (value === '' && model.phone === '') {
        return ['Phone OR Email address is required']
      } 
      if (value === '' && model.phone !== '') {
        return []
      } 
      let re = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/  // eslint-disable-line no-control-regex
      if (!re.test(value)) {
        return ['Invalid Email Address']
      } else {
        return []
      }
    },
    zipcode: (value, field, model) => {
      if (model.state === 'Not Applicable' && value === '') {
        return []
      }
      if (model.state.match('Alberta|British Columbia|Manitoba|New Brunswick|Newfoundland and Labrador|'
        + 'Nova Scotia|Nunavut|Northwest Territories|Ontario|Prince Edward Island|Quebec|Saskatchewan|Yukon')) {
        let re = /[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJ-NPRSTV-Z][ ]?\d[ABCEGHJ-NPRSTV-Z]\d/
        if (!re.test(value)) {
          return ['Invalid Postal Code']
        } else {
          return []
        }
      }
      let re = /(^\d{5}$)|(^\d{5}-\d{4}$)/
      if (!re.test(value)) {
        return ['Invalid Zip Code.' + model.state ]
      } else {
        return []
      }
    },
    alwaysInvalid: (value, field, model) => { // eslint-disable-line
      return ['I am always invalid:'];
    }
  }
})


new Vue({
  render: h => h(App),
  router,
}).$mount('#app')
