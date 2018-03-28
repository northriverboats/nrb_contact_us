<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 text-center">
        <h1 class="bm-1">RECREATIONAL BOAT INQUIRY</h1>
        <h5><a href="/commercial-inquiry">CLICK HERE FOR COMMERCIAL BOAT INQUIRY</h5>
        &nbsp;
      </div>
      <div class="col-md-8">
        <vue-form-generator :schema="schema" :model="model" :options="formOptions" ref="contact"></vue-form-generator>
      </div>
      <div class="col-md-8 text-right">
        <br />
        <div class="col-xs-12 text-right">
          <button class="btn btn-primary" @click="mySubmit">Send</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueFormGenerator from 'vue-form-generator'
import 'vue-form-generator/dist/vfg.css'

export default {
  name: 'Demo',
  components: {
    'vue-form-generator': VueFormGenerator.component
  },
  data () {
    return {
      wp_info: window.wp_info,
      model: {
        name: 'Fred Warren',
        company: '',
        address: '',
        city: '',
        state: 'OR',
        zip: '97470',
        phone: '541-671-7517',
        email: '',
        subject: 'Parts',
        boat_model: '',
        boat_length: '',
        boat_use: '',
        hull_serial_number: '',
        comments: 'This is a quick comment.'
      },
      schema: {
        fields: [
          {
            type: 'input',
            inputType: 'text',
            label: 'Name',
            model: 'name',
            placeholder: 'Your name',
            featured: false,
            required: false,
            styleClasses: 'col-xs-6'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'Company',
            model: 'company',
            placeholder: 'Company Name or leave blank',
            featured: false,
            required: false,
            styleClasses: 'col-xs-6'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'Address',
            model: 'address',
            placeholder: 'Address',
            featured: false,
            required: false,
            styleClasses: 'col-xs-12'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'City',
            model: 'city',
            placeholder: 'City',
            featured: false,
            required: false,
            styleClasses: 'col-xs-6'
          },
          {
            type: 'select',
            label: 'State',
            model: 'state',
            values: this.getStates(),
            featured: false,
            required: true,
            placeholder: 'State',
            validator: VueFormGenerator.validators.string,
            styleClasses: 'col-xs-3'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'Postal Code',
            model: 'zip',
            placeholder: 'Postal Code',
            featured: true,
            required: true,
            validator: this.zipcode,
            styleClasses: 'col-xs-3'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'Phone',
            model: 'phone',
            placeholder: 'Phone Number',
            featured: false,
            required: true,
            validator: this.phone,
            styleClasses: 'col-xs-5',
            hint: 'Phone or email is required'
          },
          {
            type: 'input',
            inputType: 'email',
            label: 'E-mail',
            model: 'email',
            placeholder: 'E-Mail Address',
            required: true,
            validator: this.email,
            styleClasses: 'col-xs-7',
            hint: 'Phone or email is required'
          },
          {
            type: 'select',
            label: 'Boat Model',
            model: 'boat_model',
            values: [
              'Seahawk Hardtop',
              'Seahawk Inboard',
              'Seahawk Outboard',
              'Offshore C-Series',
              'Offshore S-Series',
              'Offshorw Walk Around',
              'Cascade',
              'Commander',
              'Osprey',
              'Scout',
              'Other'
            ],
            featured: false,
            required: false,
            styleClasses: 'col-xs-4'
          },
          {
            type: 'select',
            label: 'Boat Length',
            model: 'boat_length',
            values: [
              '16',
              '17',
              '18\'6',
              '19',
              '20',
              '21',
              '21\'6',
              '22',
              '23',
              '24',
              '25',
              '26',
              '27',
              '28',
              '29',
              '30',
              '31',
              '32',
              '33',
              '34',
              '35'
            ],
            featured: false,
            required: false,
            styleClasses: 'col-xs-2'
          },
          {
            type: 'select',
            label: 'Boat Use',
            model: 'boat_use',
            values: [
              'Lake',
              'Ocean',
              'River'
            ],
            featured: false,
            required: false,
            styleClasses: 'col-xs-3'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'Hull Identificaton Number',
            model: 'hull_serial_number',
            placeholder: 'NRB12345A678',
            featured: false,
            required: false,
            styleClasses: 'col-xs-3'
          },
          {
            type: 'select',
            label: 'Subject',
            model: 'subject',
            values: [
              'Parts',
              'Sales',
              'Service'
            ],
            featured: false,
            required: true,
            validator: VueFormGenerator.validators.string,
            styleClasses: 'col-xs-3'
          },
          {
            type: 'textArea',
            label: 'Comments',
            model: 'comments',
            placeholder: '',
            min: 5,
            max: 1000,
            rows: 8,
            featured: false,
            required: true,
            validator: VueFormGenerator.validators.string,
            styleClasses: 'col-xs-12'
          }
        ]
      },
      formOptions: {
        validateAfterLoad: false,
        validateAfterChanged: false
      }
    }
  },
  methods: {
    zipcode (value) {
      if (this.model.state === 'NA' && value === '') {
        return []
      }
      if (this.model.state.match('AB|BC|MB|NB|NL|NS|NU|NT|ON|PE|QC|SK|YT')) {
        let re = '[ABCEGHJKLMNPRSTVXY]d[ABCEGHJ-NPRSTV-Z][ ]?d[ABCEGHJ-NPRSTV-Z]d'
        if (!re.test(value)) {
          return ['Invalid Postal Code']
        } else {
          return []
        }
      }
      let re = /(^\d{5}$)|(^\d{5}-\d{4}$)/
      if (!re.test(value)) {
        return ['Invalid Zip Code.']
      } else {
        return []
      }
    },
    email (value) {
      if (value === '' && this.model.phone === '') {
        return ['Phone OR Email address is required']
      }
      if (value === '' && this.model.phone !== '') {
        return []
      }
      let re = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/
      if (!re.test(value)) {
        return ['Invalid Email Address']
      } else {
        return []
      }
    },
    phone (value) {
      if (value === '' && this.model.email === '') {
        return ['Phone OR Email address is required']
      }
      if (value === '' && this.model.email !== '') {
        return []
      }
      var phoneRegex = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/
      if (phoneRegex.test(value)) {
        this.model.phone = value.replace(phoneRegex, '($1) $2-$3')
        return []
      } else {
        // Invalid phone number
        return ['Invalid Phone Number']
      }
    },
    mySubmit () {
      this.$refs.contact.validate()
      if (this.$refs.contact.errors.length > 0) {
        return
      }
      // hull regex /^([nN][rR][bB])\s?(\d{5})\s?([a-lA-L]\d{3})/
      this.axios.post('contact', this.model).then((response) => {
        this.$snotify.success('Contact Us from sent', 'Mail Sent')
        .on('destroyed', () => this.$router.push({name: 'Thanks'}))
      })
    },
    getStates () {
      return [
        {id: 'AL', name: 'Alabama'},
        {id: 'AK', name: 'Alaska'},
        {id: 'AZ', name: 'Arizona'},
        {id: 'AR', name: 'Arkansas'},
        {id: 'CA', name: 'California'},
        {id: 'CO', name: 'Colorado'},
        {id: 'CT', name: 'Connecticut'},
        {id: 'DE', name: 'Delaware'},
        {id: 'FL', name: 'Florida'},
        {id: 'GA', name: 'Georgia'},
        {id: 'GU', name: 'Guam'},
        {id: 'HI', name: 'Hawaii'},
        {id: 'ID', name: 'Idaho'},
        {id: 'IL', name: 'Illinois'},
        {id: 'IN', name: 'Indiana'},
        {id: 'IA', name: 'Iowa'},
        {id: 'KS', name: 'Kansas'},
        {id: 'KY', name: 'Kentucky'},
        {id: 'LA', name: 'Louisiana'},
        {id: 'ME', name: 'Maine'},
        {id: 'MD', name: 'Maryland'},
        {id: 'MA', name: 'Massachusetts'},
        {id: 'MI', name: 'Michigan'},
        {id: 'MN', name: 'Minnesota'},
        {id: 'MS', name: 'Mississippi'},
        {id: 'MO', name: 'Missouri'},
        {id: 'MT', name: 'Montana'},
        {id: 'NE', name: 'Nebraska'},
        {id: 'NV', name: 'Nevada'},
        {id: 'NH', name: 'New Hampshire'},
        {id: 'NJ', name: 'New Jersey'},
        {id: 'NM', name: 'New Mexico'},
        {id: 'NY', name: 'New York'},
        {id: 'NC', name: 'North Carolina'},
        {id: 'ND', name: 'North Dakota'},
        {id: 'OH', name: 'Ohio'},
        {id: 'OK', name: 'Oklahoma'},
        {id: 'OR', name: 'Oregon'},
        {id: 'PW', name: 'Palau'},
        {id: 'PA', name: 'Pennsylvania'},
        {id: 'RI', name: 'Rhode Island'},
        {id: 'SC', name: 'South Carolina'},
        {id: 'SD', name: 'South Dakota'},
        {id: 'TN', name: 'Tennessee'},
        {id: 'TX', name: 'Texas'},
        {id: 'UT', name: 'Utah'},
        {id: 'VT', name: 'Vermont'},
        {id: 'VA', name: 'Virginia'},
        {id: 'WA', name: 'Washington'},
        {id: 'WV', name: 'West Virginia'},
        {id: 'WI', name: 'Wisconsin'},
        {id: 'WY', name: 'Wyoming'},
        {id: 'AB', name: 'Alberta'},
        {id: 'BC', name: 'British Columbia'},
        {id: 'MB', name: 'Manitoba'},
        {id: 'NB', name: 'New Brunswick'},
        {id: 'NL', name: 'Newfoundland and Labrador'},
        {id: 'NS', name: 'Nova Scotia'},
        {id: 'NU', name: 'Nunavut'},
        {id: 'NT', name: 'Northwest Territories'},
        {id: 'ON', name: 'Ontario'},
        {id: 'PE', name: 'Prince Edward Island'},
        {id: 'QC', name: 'Quebec'},
        {id: 'SK', name: 'Saskatchewan'},
        {id: 'YT', name: 'Yukon'},
        {id: 'NA', name: 'Not Applicable'} // if selected replace with null
      ]
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
.vue-form-generator .hint {
  color: #e8e8e8;
}
</style>
