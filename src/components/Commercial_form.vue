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
      countries: [],
      states: [],
      model: {
        name: '',
        title: '',
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
            label: 'Title',
            model: 'Title',
            placeholder: 'Title',
            featured: false,
            required: false,
            styleClasses: 'col-xs-2'
          },
          {
            type: 'input',
            inputType: 'text',
            label: 'Company',
            model: 'company',
            placeholder: 'Company Name or leave blank',
            featured: false,
            required: false,
            styleClasses: 'col-xs-5'
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
              return model && model.country === 'US'
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
              return model && model.country === 'US'
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
            required: true,
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
      if (this.model.country !== 'US') {
        this.model.state = ''
        this.model.zip = ''
      }
      if (!this.model.rfq_neeed) {
        this.model.rfq_deadline = ''
      }
      if (!this.model.current_boat) {
        this.model.current_boat = ''
      }
      if (!this.model.hear_about_us.includes('Other')) {
        this.model.hear_about_us_other = ''
      }
      // note on server delete current_boat rfq_needed
      this.axios.post('commercial', this.model).then((response) => {
        this.$snotify.success('Contact Us from sent', 'Mail Sent')
        .on('destroyed', () => this.$router.push({name: 'Thanks'}))
      })
    },
    getCountries () {
      return [
        {name: 'United States', id: 'United States'},
        {name: 'Afghanistan', id: 'Afghanistan'},
        {name: 'Åland Islands', id: 'AX'},
        {name: 'Albania', id: 'AL'},
        {name: 'Algeria', id: 'DZ'},
        {name: 'American Samoa', id: 'AS'},
        {name: 'AndorrA', id: 'AD'},
        {name: 'Angola', id: 'AO'},
        {name: 'Anguilla', id: 'AI'},
        {name: 'Antarctica', id: 'AQ'},
        {name: 'Antigua and Barbuda', id: 'AG'},
        {name: 'Argentina', id: 'AR'},
        {name: 'Armenia', id: 'AM'},
        {name: 'Aruba', id: 'AW'},
        {name: 'Australia', id: 'AU'},
        {name: 'Austria', id: 'AT'},
        {name: 'Azerbaijan', id: 'AZ'},
        {name: 'Bahamas', id: 'BS'},
        {name: 'Bahrain', id: 'BH'},
        {name: 'Bangladesh', id: 'BD'},
        {name: 'Barbados', id: 'BB'},
        {name: 'Belarus', id: 'BY'},
        {name: 'Belgium', id: 'BE'},
        {name: 'Belize', id: 'BZ'},
        {name: 'Benin', id: 'BJ'},
        {name: 'Bermuda', id: 'BM'},
        {name: 'Bhutan', id: 'BT'},
        {name: 'Bolivia', id: 'BO'},
        {name: 'Bosnia and Herzegovina', id: 'BA'},
        {name: 'Botswana', id: 'BW'},
        {name: 'Bouvet Island', id: 'BV'},
        {name: 'Brazil', id: 'BR'},
        {name: 'British Indian Ocean Territory', id: 'IO'},
        {name: 'Brunei Darussalam', id: 'BN'},
        {name: 'Bulgaria', id: 'BG'},
        {name: 'Burkina Faso', id: 'BF'},
        {name: 'Burundi', id: 'BI'},
        {name: 'Cambodia', id: 'KH'},
        {name: 'Cameroon', id: 'CM'},
        {name: 'Canada', id: 'CA'},
        {name: 'Cape Verde', id: 'CV'},
        {name: 'Cayman Islands', id: 'KY'},
        {name: 'Central African Republic', id: 'CF'},
        {name: 'Chad', id: 'TD'},
        {name: 'Chile', id: 'CL'},
        {name: 'China', id: 'CN'},
        {name: 'Christmas Island', id: 'CX'},
        {name: 'Cocos (Keeling) Islands', id: 'CC'},
        {name: 'Colombia', id: 'CO'},
        {name: 'Comoros', id: 'KM'},
        {name: 'Congo', id: 'CG'},
        {name: 'Congo, The Democratic Republic of the', id: 'CD'},
        {name: 'Cook Islands', id: 'CK'},
        {name: 'Costa Rica', id: 'CR'},
        {name: 'Cote D\'Ivoire', id: 'CI'},
        {name: 'Croatia', id: 'HR'},
        {name: 'Cuba', id: 'CU'},
        {name: 'Cyprus', id: 'CY'},
        {name: 'Czech Republic', id: 'CZ'},
        {name: 'Denmark', id: 'DK'},
        {name: 'Djibouti', id: 'DJ'},
        {name: 'Dominica', id: 'DM'},
        {name: 'Dominican Republic', id: 'DO'},
        {name: 'Ecuador', id: 'EC'},
        {name: 'Egypt', id: 'EG'},
        {name: 'El Salvador', id: 'SV'},
        {name: 'Equatorial Guinea', id: 'GQ'},
        {name: 'Eritrea', id: 'ER'},
        {name: 'Estonia', id: 'EE'},
        {name: 'Ethiopia', id: 'ET'},
        {name: 'Falkland Islands (Malvinas)', id: 'FK'},
        {name: 'Faroe Islands', id: 'FO'},
        {name: 'Fiji', id: 'FJ'},
        {name: 'Finland', id: 'FI'},
        {name: 'France', id: 'FR'},
        {name: 'French Guiana', id: 'GF'},
        {name: 'French Polynesia', id: 'PF'},
        {name: 'French Southern Territories', id: 'TF'},
        {name: 'Gabon', id: 'GA'},
        {name: 'Gambia', id: 'GM'},
        {name: 'Georgia', id: 'GE'},
        {name: 'Germany', id: 'DE'},
        {name: 'Ghana', id: 'GH'},
        {name: 'Gibraltar', id: 'GI'},
        {name: 'Greece', id: 'GR'},
        {name: 'Greenland', id: 'GL'},
        {name: 'Grenada', id: 'GD'},
        {name: 'Guadeloupe', id: 'GP'},
        {name: 'Guam', id: 'GU'},
        {name: 'Guatemala', id: 'GT'},
        {name: 'Guernsey', id: 'GG'},
        {name: 'Guinea', id: 'GN'},
        {name: 'Guinea-Bissau', id: 'GW'},
        {name: 'Guyana', id: 'GY'},
        {name: 'Haiti', id: 'HT'},
        {name: 'Heard Island and Mcdonald Islands', id: 'HM'},
        {name: 'Holy See (Vatican City State)', id: 'VA'},
        {name: 'Honduras', id: 'HN'},
        {name: 'Hong Kong', id: 'HK'},
        {name: 'Hungary', id: 'HU'},
        {name: 'Iceland', id: 'IS'},
        {name: 'India', id: 'IN'},
        {name: 'Indonesia', id: 'ID'},
        {name: 'Iran, Islamic Republic Of', id: 'IR'},
        {name: 'Iraq', id: 'IQ'},
        {name: 'Ireland', id: 'IE'},
        {name: 'Isle of Man', id: 'IM'},
        {name: 'Israel', id: 'IL'},
        {name: 'Italy', id: 'IT'},
        {name: 'Jamaica', id: 'JM'},
        {name: 'Japan', id: 'JP'},
        {name: 'Jersey', id: 'JE'},
        {name: 'Jordan', id: 'JO'},
        {name: 'Kazakhstan', id: 'KZ'},
        {name: 'Kenya', id: 'KE'},
        {name: 'Kiribati', id: 'KI'},
        {name: 'Korea, Democratic People\'S Republic of', id: 'KP'},
        {name: 'Korea, Republic of', id: 'KR'},
        {name: 'Kuwait', id: 'KW'},
        {name: 'Kyrgyzstan', id: 'KG'},
        {name: 'Lao People\'S Democratic Republic', id: 'LA'},
        {name: 'Latvia', id: 'LV'},
        {name: 'Lebanon', id: 'LB'},
        {name: 'Lesotho', id: 'LS'},
        {name: 'Liberia', id: 'LR'},
        {name: 'Libyan Arab Jamahiriya', id: 'LY'},
        {name: 'Liechtenstein', id: 'LI'},
        {name: 'Lithuania', id: 'LT'},
        {name: 'Luxembourg', id: 'LU'},
        {name: 'Macao', id: 'MO'},
        {name: 'Macedonia, The Former Yugoslav Republic of', id: 'MK'},
        {name: 'Madagascar', id: 'MG'},
        {name: 'Malawi', id: 'MW'},
        {name: 'Malaysia', id: 'MY'},
        {name: 'Maldives', id: 'MV'},
        {name: 'Mali', id: 'ML'},
        {name: 'Malta', id: 'MT'},
        {name: 'Marshall Islands', id: 'MH'},
        {name: 'Martinique', id: 'MQ'},
        {name: 'Mauritania', id: 'MR'},
        {name: 'Mauritius', id: 'MU'},
        {name: 'Mayotte', id: 'YT'},
        {name: 'Mexico', id: 'MX'},
        {name: 'Micronesia, Federated States of', id: 'FM'},
        {name: 'Moldova, Republic of', id: 'MD'},
        {name: 'Monaco', id: 'MC'},
        {name: 'Mongolia', id: 'MN'},
        {name: 'Montserrat', id: 'MS'},
        {name: 'Morocco', id: 'MA'},
        {name: 'Mozambique', id: 'MZ'},
        {name: 'Myanmar', id: 'MM'},
        {name: 'Namibia', id: 'NA'},
        {name: 'Nauru', id: 'NR'},
        {name: 'Nepal', id: 'NP'},
        {name: 'Netherlands', id: 'NL'},
        {name: 'Netherlands Antilles', id: 'AN'},
        {name: 'New Caledonia', id: 'NC'},
        {name: 'New Zealand', id: 'NZ'},
        {name: 'Nicaragua', id: 'NI'},
        {name: 'Niger', id: 'NE'},
        {name: 'Nigeria', id: 'NG'},
        {name: 'Niue', id: 'NU'},
        {name: 'Norfolk Island', id: 'NF'},
        {name: 'Northern Mariana Islands', id: 'MP'},
        {name: 'Norway', id: 'NO'},
        {name: 'Oman', id: 'OM'},
        {name: 'Pakistan', id: 'PK'},
        {name: 'Palau', id: 'PW'},
        {name: 'Palestinian Territory, Occupied', id: 'PS'},
        {name: 'Panama', id: 'PA'},
        {name: 'Papua New Guinea', id: 'PG'},
        {name: 'Paraguay', id: 'PY'},
        {name: 'Peru', id: 'PE'},
        {name: 'Philippines', id: 'PH'},
        {name: 'Pitcairn', id: 'PN'},
        {name: 'Poland', id: 'PL'},
        {name: 'Portugal', id: 'PT'},
        {name: 'Puerto Rico', id: 'PR'},
        {name: 'Qatar', id: 'QA'},
        {name: 'Reunion', id: 'RE'},
        {name: 'Romania', id: 'RO'},
        {name: 'Russian Federation', id: 'RU'},
        {name: 'RWANDA', id: 'RW'},
        {name: 'Saint Helena', id: 'SH'},
        {name: 'Saint Kitts and Nevis', id: 'KN'},
        {name: 'Saint Lucia', id: 'LC'},
        {name: 'Saint Pierre and Miquelon', id: 'PM'},
        {name: 'Saint Vincent and the Grenadines', id: 'VC'},
        {name: 'Samoa', id: 'WS'},
        {name: 'San Marino', id: 'SM'},
        {name: 'Sao Tome and Principe', id: 'ST'},
        {name: 'Saudi Arabia', id: 'SA'},
        {name: 'Senegal', id: 'SN'},
        {name: 'Serbia and Montenegro', id: 'CS'},
        {name: 'Seychelles', id: 'SC'},
        {name: 'Sierra Leone', id: 'SL'},
        {name: 'Singapore', id: 'SG'},
        {name: 'Slovakia', id: 'SK'},
        {name: 'Slovenia', id: 'SI'},
        {name: 'Solomon Islands', id: 'SB'},
        {name: 'Somalia', id: 'SO'},
        {name: 'South Africa', id: 'ZA'},
        {name: 'South Georgia and the South Sandwich Islands', id: 'GS'},
        {name: 'Spain', id: 'ES'},
        {name: 'Sri Lanka', id: 'LK'},
        {name: 'Sudan', id: 'SD'},
        {name: 'Suriname', id: 'SR'},
        {name: 'Svalbard and Jan Mayen', id: 'SJ'},
        {name: 'Swaziland', id: 'SZ'},
        {name: 'Sweden', id: 'SE'},
        {name: 'Switzerland', id: 'CH'},
        {name: 'Syrian Arab Republic', id: 'SY'},
        {name: 'Taiwan, Province of China', id: 'TW'},
        {name: 'Tajikistan', id: 'TJ'},
        {name: 'Tanzania, United Republic of', id: 'TZ'},
        {name: 'Thailand', id: 'TH'},
        {name: 'Timor-Leste', id: 'TL'},
        {name: 'Togo', id: 'TG'},
        {name: 'Tokelau', id: 'TK'},
        {name: 'Tonga', id: 'TO'},
        {name: 'Trinidad and Tobago', id: 'TT'},
        {name: 'Tunisia', id: 'TN'},
        {name: 'Turkey', id: 'TR'},
        {name: 'Turkmenistan', id: 'TM'},
        {name: 'Turks and Caicos Islands', id: 'TC'},
        {name: 'Tuvalu', id: 'TV'},
        {name: 'Uganda', id: 'UG'},
        {name: 'Ukraine', id: 'UA'},
        {name: 'United Arab Emirates', id: 'AE'},
        {name: 'United Kingdom', id: 'GB'},
        {name: 'United States Minor Outlying Islands', id: 'UM'},
        {name: 'Uruguay', id: 'UY'},
        {name: 'Uzbekistan', id: 'UZ'},
        {name: 'Vanuatu', id: 'VU'},
        {name: 'Venezuela', id: 'VE'},
        {name: 'Viet Nam', id: 'VN'},
        {name: 'Virgin Islands, British', id: 'VG'},
        {name: 'Virgin Islands, U.S.', id: 'VI'},
        {name: 'Wallis and Futuna', id: 'WF'},
        {name: 'Western Sahara', id: 'EH'},
        {name: 'Yemen', id: 'YE'},
        {name: 'Zambia', id: 'ZM'},
        {name: 'Zimbabwe', id: 'ZW'}
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
