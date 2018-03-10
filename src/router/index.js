import Vue from 'vue'
import Router from 'vue-router'
import Demo1 from '@/components/Demo1'
import Demo2 from '@/components/Demo2'

Vue.use(Router)

export default new Router({
  /*
  base: window.location.href,
  mode: 'history',
   */
  routes: [
    {
      path: '/',
      name: 'Demo1',
      component: Demo1
    },
    {
      path: '/pg2',
      name: 'Demo2',
      component: Demo2
    }
  ]
})
