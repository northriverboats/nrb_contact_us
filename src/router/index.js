import Vue from 'vue'
import Router from 'vue-router'
import Form from '@/components/Contact_form'
import Commercial from '@/components/Commercial_form'
import Thanks from '@/components/Thanks'

Vue.use(Router)

export default new Router({
  /*
  base: window.location.href,
  mode: 'history',
   */
  routes: [
    {
      path: '/',
      name: 'Form',
      component: Form
    },
    {
      path: 'commercial',
      name: 'Commercial',
      component: Commercial
    },
    {
      path: '/thanks',
      name: 'Thanks',
      component: Thanks
    }
  ]
})
