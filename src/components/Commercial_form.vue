<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 text-center">
        <h1 class="bm-1">COMMERCIAL BOAT INQUIRY</h1>
        <h5><router-link :to="{name: 'Form'}">CLICK HERE FOR RECREATIONAL BOAT INQUIRY</router-link></h5>
        &nbsp;
      </div>
      <div class="col-md-8">
        <vue-form-generator :schema="schema" :model="model" :options="formOptions" ref="contact"></vue-form-generator>
      </div>
      <div class="col-md-8 text-right">
        <br />
        <div class="col-xs-12 text-right">
          <button class="btn btn-primary" @click="mySubmit" :disabled="isFormValid == 0">Send</button>
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
      isFormValid: true,
      countries: [],
      states: [],
      model: {
        submitted: '',
        title: '',
        name: '',
        agency_business: '',
        address: '',
        city: '',
        state: '',
        zip: '',
        country: '',
        phone: '',
        email: '',
        rfq_needed: '',
        rfq_deadline: '',
        intended_use: '',
        requirements: '',
        current_boat: '',
        current_type: '',
        model_interest: '',
        comments: '',
        contact_method: '',
        hear_about_us: [],
        hear_about_us_other: ''
      },
      schema: {
        fields: [
          {
            type: 'input',
            inputType: 'text',
            label: 'Title',
            model: 'title',
            placeholder: 'Title',
            featured: false,
            required: false,
            maxlength: 64,
            styleClasses: 'col-xs-2'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'Name',
            model: 'name',
            placeholder: 'Your name',
            featured: false,
            required: true,
            validator: VueFormGenerator.validators.string,
            styleClasses: 'col-xs-5'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'Company',
            model: 'agency_business',
            placeholder: 'Company Name or leave blank',
            featured: false,
            required: true,
            styleClasses: 'col-xs-5'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'Address',
            model: 'address',
            placeholder: 'Address',
            featured: false,
            required: true,
            styleClasses: 'col-xs-12'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'City',
            model: 'city',
            placeholder: 'City',
            featured: false,
            required: true,
            styleClasses: 'col-xs-4'
          },
          {
            type: 'select',
            label: 'Country',
            model: 'country',
            values: this.getCountries(),
            featured: false,
            required: true,
            placeholder: 'State',
            validator: VueFormGenerator.validators.string,
            styleClasses: 'col-xs-3'
          },
          {
            type: 'select',
            label: 'State',
            model: 'state',
            values: this.getStates(),
            featured: false,
            required: true,
            placeholder: 'State',
            visible: function (model) {
              return model && (model.country === 'United States' || model.country === 'Canada')
            },
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
            visible: function (model) {
              return model && (model.country === 'United States' || model.country === 'Canada')
            },
            validator: this.zipcode,
            styleClasses: 'col-xs-2'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'Phone',
            model: 'phone',
            placeholder: 'Phone Number',
            featured: false,
            required: true,
            validator: VueFormGenerator.validators.string,
            styleClasses: 'col-xs-5'
          },
          {
            type: 'input',
            inputType: 'email',
            label: 'E-mail',
            model: 'email',
            placeholder: 'E-Mail Address',
            required: true,
            validator: this.email,
            styleClasses: 'col-xs-7'
          },
          {
            type: 'switch',
            imputType: 'text',
            label: 'Will we need to respond to an RFQ?',
            model: 'rfq_needed',
            textOn: 'Yes',
            textOff: 'No',
            styleClasses: 'col-xs-12'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'RFQ Deadline',
            model: 'rfq_deadline',
            placeholder: 'RFQ Deadline',
            featured: false,
            required: true,
            maxlength: 64,
            visible: function (model) {
              return model && model.rfq_needed
            },
            validator: VueFormGenerator.validators.string,
            styleClasses: 'col-xs-12'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'Intended Use',
            model: 'intended_use',
            placeholder: 'Intended Use',
            featured: false,
            maxlength: 128,
            validator: VueFormGenerator.validators.string,
            styleClasses: 'col-xs-12'
          },
          {
            type: 'textArea',
            label: 'Features/Requirementss',
            model: 'requirements',
            placeholder: '',
            min: 5,
            max: 4092,
            rows: 8,
            featured: false,
            validator: VueFormGenerator.validators.string,
            styleClasses: 'col-xs-12'
          },
          {
            type: 'switch',
            imputType: 'text',
            label: 'Do You Currently Have A Boat?',
            model: 'current_boat',
            textOn: 'Yes',
            textOff: 'No',
            styleClasses: 'col-xs-12'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'What type of boat',
            model: 'current_type',
            placeholder: 'What type of boat',
            featured: false,
            required: true,
            visible: function (model) {
              return model && model.current_boat
            },
            maxlength: 128,
            validator: VueFormGenerator.validators.string,
            styleClasses: 'col-xs-12'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'What Model Interests You Most?',
            model: 'model_interest',
            placeholder: 'What model interests you most',
            featured: false,
            maxlength: 128,
            validator: VueFormGenerator.validators.string,
            styleClasses: 'col-xs-12'
          },
          {
            type: 'textArea',
            label: 'Comments',
            model: 'comments',
            placeholder: '',
            min: 5,
            max: 4092,
            rows: 8,
            featured: false,
            required: false,
            validator: VueFormGenerator.validators.string,
            styleClasses: 'col-xs-12'
          },
          {
            type: 'select',
            label: 'How Would You Like Us To Contact You',
            model: 'contact_method',
            values: function () {
              return [
                { id: 'Please call me', name: 'Call me' },
                { id: 'Please mail me information', name: 'Mail me information' },
                { id: 'Please return email with questions answered', name: 'Email me with questions answered' }
              ]
            },
            featured: false,
            required: true,
            placeholder: 'State',
            validator: VueFormGenerator.validators.string,
            styleClasses: 'col-xs-12'
          },
          {
            type: 'checklist',
            label: 'How Did You Hear Aobut Almar By Northriver?',
            model: 'hear_about_us',
            multi: true,
            required: true,
            multiSelect: true,
            values: [
              'Referral',
              'Tradeshow',
              'Website',
              'Magazine Ad',
              'Radio Ad',
              'TV Ad',
              'Mailer',
              'Other'
            ],
            styleClasses: 'col-xs-3'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'How did you hear about us?',
            model: 'hear_about_us_other',
            placeholder: 'How did you hear about us',
            featured: false,
            required: true,
            maxlength: 128,
            validator: VueFormGenerator.validators.string,
            visible: function (model) {
              return model && model.hear_about_us.includes('Other')
            },
            styleClasses: 'col-xs-9'
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
      if (this.model.state === 'Not Applicable' && value === '') {
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
      let re = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/
      if (!re.test(value)) {
        return ['Invalid Email Address']
      } else {
        return []
      }
    },
    mySubmit () {
      this.$refs.contact.validate()
      if (this.$refs.contact.errors.length > 0) {
        return
      }
      this.isFormValid = false
      if (!(this.model.country === 'United States' || this.model.country === 'Canada')) {
        this.model.state = ''
        this.model.zip = ''
      }
      if (this.model.rfq_neeed === false) {
        this.model.rfq_deadline = ''
      }
      if (this.model.current_boat === false) {
        this.model.current_boat = ''
      }
      if (!this.model.hear_about_us.includes('Other')) {
        this.model.hear_about_us_other = ''
      }
      this.axios.post('commercial', this.model).then((response) => {
        this.$snotify.success('Contact Us form sent', 'Mail Sent')
        .on('destroyed', () => this.$router.push({name: 'Thanks'}))
      })
    },
    getCountries () {
      return [
        {name: 'United States', id: 'United States'},
        {name: 'Afghanistan', id: 'Afghanistan'},
        {name: 'Åland Islands', id: 'Åland Islands'},
        {name: 'Albania', id: 'Albania'},
        {name: 'Algeria', id: 'Algeria'},
        {name: 'American Samoa', id: 'American Samoa'},
        {name: 'AndorrA', id: 'AndorrA'},
        {name: 'Angola', id: 'Angola'},
        {name: 'Anguilla', id: 'Anguilla'},
        {name: 'Antarctica', id: 'Antarctica'},
        {name: 'Antigua and Barbuda', id: 'Antigua and Barbuda'},
        {name: 'Argentina', id: 'Argentina'},
        {name: 'Armenia', id: 'Armenia'},
        {name: 'Aruba', id: 'Aruba'},
        {name: 'Australia', id: 'Australia'},
        {name: 'Austria', id: 'Austria'},
        {name: 'Azerbaijan', id: 'Azerbaijan'},
        {name: 'Bahamas', id: 'Bahamas'},
        {name: 'Bahrain', id: 'Bahrain'},
        {name: 'Bangladesh', id: 'Bangladesh'},
        {name: 'Barbados', id: 'Barbados'},
        {name: 'Belarus', id: 'Belarus'},
        {name: 'Belgium', id: 'Belgium'},
        {name: 'Belize', id: 'Belize'},
        {name: 'Benin', id: 'Benin'},
        {name: 'Bermuda', id: 'Bermuda'},
        {name: 'Bhutan', id: 'Bhutan'},
        {name: 'Bolivia', id: 'Bolivia'},
        {name: 'Bosnia and Herzegovina', id: 'Bosnia and Herzegovina'},
        {name: 'Botswana', id: 'Botswana'},
        {name: 'Bouvet Island', id: 'Bouvet Island'},
        {name: 'Brazil', id: 'Brazil'},
        {name: 'British Indian Ocean Territory', id: 'British Indian Ocean Territory'},
        {name: 'Brunei Darussalam', id: 'Brunei Darussalam'},
        {name: 'Bulgaria', id: 'Bulgaria'},
        {name: 'Burkina Faso', id: 'Burkina Faso'},
        {name: 'Burundi', id: 'Burundi'},
        {name: 'Cambodia', id: 'Cambodia'},
        {name: 'Cameroon', id: 'Cameroon'},
        {name: 'Canada', id: 'Canada'},
        {name: 'Cape Verde', id: 'Cape Verde'},
        {name: 'Cayman Islands', id: 'Cayman Islands'},
        {name: 'Central African Republic', id: 'Central African Republic'},
        {name: 'Chad', id: 'Chad'},
        {name: 'Chile', id: 'Chile'},
        {name: 'China', id: 'China'},
        {name: 'Christmas Island', id: 'Christmas Island'},
        {name: 'Cocos (Keeling) Islands', id: 'Cocos (Keeling) Islands'},
        {name: 'Colombia', id: 'Colombia'},
        {name: 'Comoros', id: 'Comoros'},
        {name: 'Congo', id: 'Congo'},
        {name: 'Congo, The Democratic Republic of the', id: 'Congo, The Democratic Republic of the'},
        {name: 'Cook Islands', id: 'Cook Islands'},
        {name: 'Costa Rica', id: 'Costa Rica'},
        {name: 'Cote D\'Ivoire', id: 'Cote D\'Ivoire'},
        {name: 'Croatia', id: 'Croatia'},
        {name: 'Cuba', id: 'Cuba'},
        {name: 'Cyprus', id: 'Cyprus'},
        {name: 'Czech Republic', id: 'Czech Republic'},
        {name: 'Denmark', id: 'Denmark'},
        {name: 'Djibouti', id: 'Djibouti'},
        {name: 'Dominica', id: 'Dominica'},
        {name: 'Dominican Republic', id: 'Dominican Republic'},
        {name: 'Ecuador', id: 'Ecuador'},
        {name: 'Egypt', id: 'Egypt'},
        {name: 'El Salvador', id: 'El Salvador'},
        {name: 'Equatorial Guinea', id: 'Equatorial Guinea'},
        {name: 'Eritrea', id: 'Eritrea'},
        {name: 'Estonia', id: 'Estonia'},
        {name: 'Ethiopia', id: 'Ethiopia'},
        {name: 'Falkland Islands (Malvinas)', id: 'Falkland Islands (Malvinas)'},
        {name: 'Faroe Islands', id: 'Faroe Islands'},
        {name: 'Fiji', id: 'Fiji'},
        {name: 'Finland', id: 'Finland'},
        {name: 'France', id: 'France'},
        {name: 'French Guiana', id: 'French Guiana'},
        {name: 'French Polynesia', id: 'French Polynesia'},
        {name: 'French Southern Territories', id: 'French Southern Territories'},
        {name: 'Gabon', id: 'Gabon'},
        {name: 'Gambia', id: 'Gambia'},
        {name: 'Georgia', id: 'Georgia'},
        {name: 'Germany', id: 'Germany'},
        {name: 'Ghana', id: 'Ghana'},
        {name: 'Gibraltar', id: 'Gibraltar'},
        {name: 'Greece', id: 'Greece'},
        {name: 'Greenland', id: 'Greenland'},
        {name: 'Grenada', id: 'Grenada'},
        {name: 'Guadeloupe', id: 'Guadeloupe'},
        {name: 'Guam', id: 'Guam'},
        {name: 'Guatemala', id: 'Guatemala'},
        {name: 'Guernsey', id: 'Guernsey'},
        {name: 'Guinea', id: 'Guinea'},
        {name: 'Guinea-Bissau', id: 'Guinea-Bissau'},
        {name: 'Guyana', id: 'Guyana'},
        {name: 'Haiti', id: 'Haiti'},
        {name: 'Heard Island and Mcdonald Islands', id: 'Heard Island and Mcdonald Islands'},
        {name: 'Holy See (Vatican City State)', id: 'Holy See (Vatican City State)'},
        {name: 'Honduras', id: 'Honduras'},
        {name: 'Hong Kong', id: 'Hong Kong'},
        {name: 'Hungary', id: 'Hungary'},
        {name: 'Iceland', id: 'Iceland'},
        {name: 'India', id: 'India'},
        {name: 'Indonesia', id: 'Indonesia'},
        {name: 'Iran, Islamic Republic Of', id: 'Iran, Islamic Republic Of'},
        {name: 'Iraq', id: 'Iraq'},
        {name: 'Ireland', id: 'Ireland'},
        {name: 'Isle of Man', id: 'Isle of Man'},
        {name: 'Israel', id: 'Israel'},
        {name: 'Italy', id: 'Italy'},
        {name: 'Jamaica', id: 'Jamaica'},
        {name: 'Japan', id: 'Japan'},
        {name: 'Jersey', id: 'Jersey'},
        {name: 'Jordan', id: 'Jordan'},
        {name: 'Kazakhstan', id: 'Kazakhstan'},
        {name: 'Kenya', id: 'Kenya'},
        {name: 'Kiribati', id: 'Kiribati'},
        {name: 'Korea, Democratic People\'S Republic of', id: 'Korea, Democratic People\'S Republic of'},
        {name: 'Korea, Republic of', id: 'Korea, Republic of'},
        {name: 'Kuwait', id: 'Kuwait'},
        {name: 'Kyrgyzstan', id: 'Kyrgyzstan'},
        {name: 'Lao People\'S Democratic Republic', id: 'Lao People\'S Democratic Republic'},
        {name: 'Latvia', id: 'Latvia'},
        {name: 'Lebanon', id: 'Lebanon'},
        {name: 'Lesotho', id: 'Lesotho'},
        {name: 'Liberia', id: 'Liberia'},
        {name: 'Libyan Arab Jamahiriya', id: 'Libyan Arab Jamahiriya'},
        {name: 'Liechtenstein', id: 'Liechtenstein'},
        {name: 'Lithuania', id: 'Lithuania'},
        {name: 'Luxembourg', id: 'Luxembourg'},
        {name: 'Macao', id: 'Macao'},
        {name: 'Macedonia, The Former Yugoslav Republic of', id: 'Macedonia, The Former Yugoslav Republic of'},
        {name: 'Madagascar', id: 'Madagascar'},
        {name: 'Malawi', id: 'Malawi'},
        {name: 'Malaysia', id: 'Malaysia'},
        {name: 'Maldives', id: 'Maldives'},
        {name: 'Mali', id: 'Mali'},
        {name: 'Malta', id: 'Malta'},
        {name: 'Marshall Islands', id: 'Marshall Islands'},
        {name: 'Martinique', id: 'Martinique'},
        {name: 'Mauritania', id: 'Mauritania'},
        {name: 'Mauritius', id: 'Mauritius'},
        {name: 'Mayotte', id: 'Mayotte'},
        {name: 'Mexico', id: 'Mexico'},
        {name: 'Micronesia, Federated States of', id: 'Micronesia, Federated States of'},
        {name: 'Moldova, Republic of', id: 'Moldova, Republic of'},
        {name: 'Monaco', id: 'Monaco'},
        {name: 'Mongolia', id: 'Mongolia'},
        {name: 'Montserrat', id: 'Montserrat'},
        {name: 'Morocco', id: 'Morocco'},
        {name: 'Mozambique', id: 'Mozambique'},
        {name: 'Myanmar', id: 'Myanmar'},
        {name: 'Namibia', id: 'Namibia'},
        {name: 'Nauru', id: 'Nauru'},
        {name: 'Nepal', id: 'Nepal'},
        {name: 'Netherlands', id: 'Netherlands'},
        {name: 'Netherlands Antilles', id: 'Netherlands Antilles'},
        {name: 'New Caledonia', id: 'New Caledonia'},
        {name: 'New Zealand', id: 'New Zealand'},
        {name: 'Nicaragua', id: 'Nicaragua'},
        {name: 'Niger', id: 'Niger'},
        {name: 'Nigeria', id: 'Nigeria'},
        {name: 'Niue', id: 'Niue'},
        {name: 'Norfolk Island', id: 'Norfolk Island'},
        {name: 'Northern Mariana Islands', id: 'Northern Mariana Islands'},
        {name: 'Norway', id: 'Norway'},
        {name: 'Oman', id: 'Oman'},
        {name: 'Pakistan', id: 'Pakistan'},
        {name: 'Palau', id: 'Palau'},
        {name: 'Palestinian Territory, Occupied', id: 'Palestinian Territory, Occupied'},
        {name: 'Panama', id: 'Panama'},
        {name: 'Papua New Guinea', id: 'Papua New Guinea'},
        {name: 'Paraguay', id: 'Paraguay'},
        {name: 'Peru', id: 'Peru'},
        {name: 'Philippines', id: 'Philippines'},
        {name: 'Pitcairn', id: 'Pitcairn'},
        {name: 'Poland', id: 'Poland'},
        {name: 'Portugal', id: 'Portugal'},
        {name: 'Puerto Rico', id: 'Puerto Rico'},
        {name: 'Qatar', id: 'Qatar'},
        {name: 'Reunion', id: 'Reunion'},
        {name: 'Romania', id: 'Romania'},
        {name: 'Russian Federation', id: 'Russian Federation'},
        {name: 'RWANDA', id: 'RWANDA'},
        {name: 'Saint Helena', id: 'Saint Helena'},
        {name: 'Saint Kitts and Nevis', id: 'Saint Kitts and Nevis'},
        {name: 'Saint Lucia', id: 'Saint Lucia'},
        {name: 'Saint Pierre and Miquelon', id: 'Saint Pierre and Miquelon'},
        {name: 'Saint Vincent and the Grenadines', id: 'Saint Vincent and the Grenadines'},
        {name: 'Samoa', id: 'Samoa'},
        {name: 'San Marino', id: 'San Marino'},
        {name: 'Sao Tome and Principe', id: 'Sao Tome and Principe'},
        {name: 'Saudi Arabia', id: 'Saudi Arabia'},
        {name: 'Senegal', id: 'Senegal'},
        {name: 'Serbia and Montenegro', id: 'Serbia and Montenegro'},
        {name: 'Seychelles', id: 'Seychelles'},
        {name: 'Sierra Leone', id: 'Sierra Leone'},
        {name: 'Singapore', id: 'Singapore'},
        {name: 'Slovakia', id: 'Slovakia'},
        {name: 'Slovenia', id: 'Slovenia'},
        {name: 'Solomon Islands', id: 'Solomon Islands'},
        {name: 'Somalia', id: 'Somalia'},
        {name: 'South Africa', id: 'South Africa'},
        {name: 'South Georgia and the South Sandwich Islands', id: 'South Georgia and the South Sandwich Islands'},
        {name: 'Spain', id: 'Spain'},
        {name: 'Sri Lanka', id: 'Sri Lanka'},
        {name: 'Sudan', id: 'Sudan'},
        {name: 'Suriname', id: 'Suriname'},
        {name: 'Svalbard and Jan Mayen', id: 'Svalbard and Jan Mayen'},
        {name: 'Swaziland', id: 'Swaziland'},
        {name: 'Sweden', id: 'Sweden'},
        {name: 'Switzerland', id: 'Switzerland'},
        {name: 'Syrian Arab Republic', id: 'Syrian Arab Republic'},
        {name: 'Taiwan, Province of China', id: 'Taiwan, Province of China'},
        {name: 'Tajikistan', id: 'Tajikistan'},
        {name: 'Tanzania, United Republic of', id: 'Tanzania, United Republic of'},
        {name: 'Thailand', id: 'Thailand'},
        {name: 'Timor-Leste', id: 'Timor-Leste'},
        {name: 'Togo', id: 'Togo'},
        {name: 'Tokelau', id: 'Tokelau'},
        {name: 'Tonga', id: 'Tonga'},
        {name: 'Trinidad and Tobago', id: 'Trinidad and Tobago'},
        {name: 'Tunisia', id: 'Tunisia'},
        {name: 'Turkey', id: 'Turkey'},
        {name: 'Turkmenistan', id: 'Turkmenistan'},
        {name: 'Turks and Caicos Islands', id: 'Turks and Caicos Islands'},
        {name: 'Tuvalu', id: 'Tuvalu'},
        {name: 'Uganda', id: 'Uganda'},
        {name: 'Ukraine', id: 'Ukraine'},
        {name: 'United Arab Emirates', id: 'United Arab Emirates'},
        {name: 'United Kingdom', id: 'United Kingdom'},
        {name: 'United States Minor Outlying Islands', id: 'United States Minor Outlying Islands'},
        {name: 'Uruguay', id: 'Uruguay'},
        {name: 'Uzbekistan', id: 'Uzbekistan'},
        {name: 'Vanuatu', id: 'Vanuatu'},
        {name: 'Venezuela', id: 'Venezuela'},
        {name: 'Viet Nam', id: 'Viet Nam'},
        {name: 'Virgin Islands, British', id: 'Virgin Islands, British'},
        {name: 'Virgin Islands, U.S.', id: 'Virgin Islands, U.S.'},
        {name: 'Wallis and Futuna', id: 'Wallis and Futuna'},
        {name: 'Western Sahara', id: 'Western Sahara'},
        {name: 'Yemen', id: 'Yemen'},
        {name: 'Zambia', id: 'Zambia'},
        {name: 'Zimbabwe', id: 'Zimbabwe'}
      ]
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
