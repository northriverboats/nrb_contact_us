<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 text-center">
        <h1 class="bm-1">RECREATIONAL BOAT INQUIRY</h1>
        <h5><router-link :to="{name: 'Commercial'}">CLICK HERE FOR COMMERCIAL BOAT INQUIRY</router-link></h5>
        &nbsp;
      </div>
      <div class="col-md-8">
        <vue-form-generator :schema="schema" :model="model" :options="formOptions" ref="contact"></vue-form-generator>
      </div>
      <div class="col-md-8 text-right">
        <br />
        <div class="col-xs-12 text-right">
          <button class="btn btn-primary" @click="mySubmit" :disabled="submit_locked">Send</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'Demo',
  data () {
    return {
      wp_info: window.wp_info,
      submit_locked: false,
      model: {
        name: '',
        company: '',
        address: '',
        city: '',
        state: '',
        zip: '',
        phone: '',
        email: '',
        subject: 'Parts',
        boat_model: '',
        boat_length: '',
        boat_use: '',
        hull_serial_number: '',
        comments: ''
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
            required: true,
            validator: 'string',
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
            validator: 'string',
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
            validator: 'zipcode',
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
            validator: 'phone',
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
            validator: 'emailVal',
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
            validator: 'string',
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
            validator: 'string',
            styleClasses: 'col-xs-12'
          }
        ]
      },
      formOptions: {
        validateAfterLoad: false,
        validateAfterChanged: true
      }
    }
  },
  methods: {
    mySubmit () {
      this.$refs.contact.validate()
      if (this.$refs.contact.errors.length > 0) {
        return
      }
      this.submit_locked = true
      // hull regex /^([nN][rR][bB])\s?(\d{5})\s?([a-lA-L]\d{3})/
      this.axios.post('contact', this.model).then((response) => { // eslint-disable-line no-unused-vars
        this.$snotify.success('Contact Us form sent', 'Mail Sent')
        .on('destroyed', () => this.$router.push({name: 'Thanks'}))
      })
    },
    getStates () {
      return [
        {id: 'Alabama', name: 'Alabama'},
        {id: 'Alaska', name: 'Alaska'},
        {id: 'Arizona', name: 'Arizona'},
        {id: 'Arkansas', name: 'Arkansas'},
        {id: 'California', name: 'California'},
        {id: 'Colorado', name: 'Colorado'},
        {id: 'Connecticut', name: 'Connecticut'},
        {id: 'Delaware', name: 'Delaware'},
        {id: 'Florida', name: 'Florida'},
        {id: 'Georgia', name: 'Georgia'},
        {id: 'Guam', name: 'Guam'},
        {id: 'Hawaii', name: 'Hawaii'},
        {id: 'Idaho', name: 'Idaho'},
        {id: 'Illinois', name: 'Illinois'},
        {id: 'Indiana', name: 'Indiana'},
        {id: 'Iowa', name: 'Iowa'},
        {id: 'Kansas', name: 'Kansas'},
        {id: 'Kentucky', name: 'Kentucky'},
        {id: 'Louisiana', name: 'Louisiana'},
        {id: 'Maine', name: 'Maine'},
        {id: 'Maryland', name: 'Maryland'},
        {id: 'Massachusetts', name: 'Massachusetts'},
        {id: 'Michigan', name: 'Michigan'},
        {id: 'Minnesota', name: 'Minnesota'},
        {id: 'Mississippi', name: 'Mississippi'},
        {id: 'Missouri', name: 'Missouri'},
        {id: 'Montana', name: 'Montana'},
        {id: 'Nebraska', name: 'Nebraska'},
        {id: 'Nevada', name: 'Nevada'},
        {id: 'New Hampshire', name: 'New Hampshire'},
        {id: 'New Jersey', name: 'New Jersey'},
        {id: 'New Mexico', name: 'New Mexico'},
        {id: 'New York', name: 'New York'},
        {id: 'North Carolina', name: 'North Carolina'},
        {id: 'North Dakota', name: 'North Dakota'},
        {id: 'Ohio', name: 'Ohio'},
        {id: 'Oklahoma', name: 'Oklahoma'},
        {id: 'Oregon', name: 'Oregon'},
        {id: 'Palau', name: 'Palau'},
        {id: 'Pennsylvania', name: 'Pennsylvania'},
        {id: 'Rhode Island', name: 'Rhode Island'},
        {id: 'South Carolina', name: 'South Carolina'},
        {id: 'South Dakota', name: 'South Dakota'},
        {id: 'Tennessee', name: 'Tennessee'},
        {id: 'Texas', name: 'Texas'},
        {id: 'Utah', name: 'Utah'},
        {id: 'Vermont', name: 'Vermont'},
        {id: 'Virginia', name: 'Virginia'},
        {id: 'Washington', name: 'Washington'},
        {id: 'West Virginia', name: 'West Virginia'},
        {id: 'Wisconsin', name: 'Wisconsin'},
        {id: 'Wyoming', name: 'Wyoming'},
        {id: 'Alberta', name: 'Alberta'},
        {id: 'British Columbia', name: 'British Columbia'},
        {id: 'Manitoba', name: 'Manitoba'},
        {id: 'New Brunswick', name: 'New Brunswick'},
        {id: 'Newfoundland and Labrador', name: 'Newfoundland and Labrador'},
        {id: 'Nova Scotia', name: 'Nova Scotia'},
        {id: 'Nunavut', name: 'Nunavut'},
        {id: 'Northwest Territories', name: 'Northwest Territories'},
        {id: 'Ontario', name: 'Ontario'},
        {id: 'Prince Edward Island', name: 'Prince Edward Island'},
        {id: 'Quebec', name: 'Quebec'},
        {id: 'Saskatchewan', name: 'Saskatchewan'},
        {id: 'Yukon', name: 'Yukon'},
        {id: 'Not Applicable', name: 'Not Applicable'} // if selected replace with null
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
