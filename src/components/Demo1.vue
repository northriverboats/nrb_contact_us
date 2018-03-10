<template>
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">

     <h2>Some Content for {{ msg }}</h2>

     <vue-form-generator :schema="schema" :model="model" :options="formOptions"></vue-form-generator>

      </div>
    </div>
  </div>
</template>

<script>
import VueFormGenerator from 'vue-form-generator'

export default {
  name: 'Demo',
  components: {
    'vue-form-generator': VueFormGenerator.component
  },
  data () {
    return {
      msg: 'Fredrick W. Warren',
      wp_info: window.wp_info,
      model: {
        id: 1,
        name: '',
        roles: '',
        password: 'J0hnD03!x4',
        skills: '',
        email: 'john.doe@gmail.com',
        status: true
      },
      schema: {
        fields: [
          {
            type: 'input',
            inputType: 'text',
            label: 'Name',
            model: 'name',
            placeholder: 'Your name',
            featured: true,
            required: true,
            styleClasses: 'col-xs-6'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'Roles',
            model: 'roles',
            placeholder: 'Your Roles',
            featured: true,
            required: true,
            styleClasses: 'col-xs-6'
          },
          {
            type: 'input',
            inputType: 'password',
            label: 'Password',
            model: 'password',
            min: 6,
            required: true,
            hint: 'Minimum 6 characters',
            validator: VueFormGenerator.validators.string,
            styleClasses: 'col-xs-12'
          },
          {
            type: 'radios',
            label: 'Primary Skill',
            model: 'skills',
            values: ['Javascript', 'VueJS', 'CSS3', 'HTML5'],
            styleClasses: 'col-xs-12'

          },
          {
            type: 'input',
            inputType: 'email',
            label: 'E-mail',
            model: 'email',
            placeholder: 'User\'s e-mail address',
            styleClasses: 'col-xs-12'
          },
          {
            type: 'checkbox',
            label: 'Status',
            model: 'status',
            default: true,
            styleClasses: 'col-xs-12'
          }
        ]
      },
      formOptions: {
        validateAfterLoad: true,
        validateAfterChanged: true
      }
    }
  },
  methods: {
    getdata () {
      var url = 'wp/v2/users/' + this.wp_info.current_user_id + '?context=edit'
      this.axios({
        method: 'get',
        url: url,
        headers: {'X-WP-Nonce': this.wp_info.nonce}
      })
      .then(response => {
        this.model.name = response.data.first_name + ' ' + response.data.last_name
        this.model.roles = response.data.roles.toString()
        console.log(response.data)
      })
    }
  },
  mounted: function () {
    this.getdata()
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
</style>
