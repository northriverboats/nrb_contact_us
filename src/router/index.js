import Vue from 'vue'
import Router from 'vue-router'
import Form from '@/components/Contact_form'
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
      path: '/thanks',
      name: 'Thanks',
      component: Thanks
    }
  ]
})
