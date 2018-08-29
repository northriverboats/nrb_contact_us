<template>
  <div id="app">
    <router-view/>
    <vue-snotify></vue-snotify>
  </div>
</template>

<script>
export default {
  name: 'app'
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  # text-align: center;
  color: #2c3e50;
  /* margin-top: 30px; */
}

body {
  font-family: Helvetica Neue,Helvetica,Arial,sans-serif;
  color: #c8c8c8;
}

.content h1, .content h2, .content h3, .content h4, .content h5, .content h6 {
  color: #c8c8c8;
}

select {
  /* background-image: none; */
  background-image: url(images/select-arrow.jpg) !important;
  padding-top: 0px;
  padding-bottom: 0px;
}

legend {
    color: #c8c8c8;
}

.button.is-link.is-active, .button.is-link:focus, .button.is-link:hover {
  background-color: #a8a8a8;
}

.button.is-link {
      background-color: #c8c8c8;
    }

.checkbox:hover, .radio:hover {
  color: #a8a8a8;
}

.radio+.radio, .checkbox+.checkbox {
  margin-top: 0px;
}

.radio+.radio {
  margin-left: 30px;
}

.radio, .checkbox {
  min-height: 0px;
  margin-top: 0px;
  margin-bottom: 0px;
}

label {
  color: #e8e8e8;
  font-size: 100%;
  font-weight: 400;
  text-align: left;
  padding: 0px;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="tel"],
input[type="number"] {
  display: block;
  border-radius: 3px;
  -webkit-box-shadow: none;
  box-shadow: none;
  padding: 1px 8px;
  border: 1px solid #d5d5d5;
  height: 32px;
}

.btn {
    border-radius: 3px;
}

.form-control {
  display: block;
  border-radius: 3px;
  -webkit-box-shadow: none;
  box-shadow: none;
  padding: 1px 8px;
  border: 1px solid #d5d5d5;
  height: 32px;
}

.error {
  line-height: 18px;
  margin-bottom: 15px !important;
  border-width: 0px !important;
  padding-top: 0px;
  padding-left: 0px;
  padding-bottom: 0px;
  padding-left: 15px !important;
  background-color: inherit;
  border-color: transparent;
  color: #e94442;
}

.error .form-control {
    border-color: #a94442;
}

.error .form-control:focus {
    border-color: #a94442;
}

.error:before {
  padding-left: 15px !important;
  content: normal;
}

.help-block {
  color: #e94442;
}

.radio-list label {
  display: block;
}

.radio-list input[type="radio"] {
  margin-right: 4px;
}

.vue-form-wizard .wizard-nav-pills>li>a {
    color: #c8c8c8 !important;
}

.vue-form-generator .field-checklist .combobox {
  overflow: auto !important;
}

.vue-form-generator .form-control .info {
  margin: 0px !important;
  border: 0px !important;
  padding: 0px !important;
  width: auto !important;
}

.list-row label {
  color: #555 !important;
  border-color: #000 !important;
}

.list-row label input[type="checkbox"] {
  border-color: #000 !important;
}

.vue-form-generator .form-control .info:before {
  content: none !important;
}

.vue-form-generator .field-checklist .combobox .dropList {
  overflow: visible;
  margin-bottom: 1em;
}

input[type="checkbox"]:checked:before {
  background-image: url('images/check-icon-black.png');
}

/*
.error label  {
    color: #e94442;
}
*/
.btn:hover, .button:hover, .wishlist_table .add_to_cart.button:hover, .wpcf7-submit:hover {
  color: #c8c8c8;
  border: 1px solid #fff;
}

.btn:hover, .btn:focus {
    color: #c8c8c8;
    text-decoration: none;
}


/* ******************************************************** */
/* error column widths */
.error.col-xs-1, .error.col-sm-1, .error.col-md-1, .error.col-lg-1, .error.col-xl-1 {
  width: 8.33333333%;
}

.error.col-xs-2, .error.col-sm-2, .error.col-md-2, .error.col-lg-2, .error.col-xl-2 {
  width: 16.66666667%;
}

.error.col-xs-3, .error.col-sm-3, .error.col-md-3, .error.col-lg-3, .error.col-xl-3 {
  width: 25%;
}

.error.col-xs-4, .error.col-sm-4, .error.col-md-4, .error.col-lg-4, .error.col-xl-4 {
  width: 33.33333333%;
}

.error.col-xs-5, .error.col-sm-5, .error.col-md-5, .error.col-lg-5, .error.col-xl-5 {
  width: 41.66666667%;
}

.error.col-xs-6, .error.col-sm-6, .error.col-md-6, .error.col-lg-6, .error.col-xl-6 {
  width: 50%;
}

.error.col-xs-7, .error.col-sm-7, .error.col-md-7, .error.col-lg-7, .error.col-xl-7 {
  width: 58.3333333%;
}

.error.col-xs-8, .error.col-sm-8, .error.col-md-8, .error.col-lg-8, .error.col-xl-8 {
  width: 66.66666667%;
}

.error.col-xs-9, .error.col-sm-9, .error.col-md-9, .error.col-lg-9, .error.col-xl-9 {
  width: 75%;
}

.error.col-xs-10.g, .error.col-sm-6, .error.col-md-6, .error.col-lg-6, .error.col-xl-6 {
  width: 83.33333333%;
}

.error.col-xs-11, .error.col-sm-11, .error.col-md-11, .error.col-lg-11, .error.col-xl-11 {
  width: 91.66666667%;
}

.error.col-xs-12, .error.col-sm-12, .error.col-md-12, .error.col-lg-12, .error.col-xl-12 {
  width: 100%;
}




/* ******************************************************** */
/* Borrowed from Bootstrap 4 */
.w-25 {
  width: 25% !important;
}

.w-50 {
  width: 50% !important;
}

.w-75 {
  width: 75% !important;
}

.w-100 {
  width: 100% !important;
}

.h-25 {
  height: 25% !important;
}

.h-50 {
  height: 50% !important;
}

.h-75 {
  height: 75% !important;
}

.h-100 {
  height: 100% !important;
}

.mw-100 {
  max-width: 100% !important;
}

.mh-100 {
  max-height: 100% !important;
}

.m-0 {
  margin: 0 !important;
}

.mt-0,
.my-0 {
  margin-top: 0 !important;
}

.mr-0,
.mx-0 {
  margin-right: 0 !important;
}

.mb-0,
.my-0 {
  margin-bottom: 0 !important;
}

.ml-0,
.mx-0 {
  margin-left: 0 !important;
}

.m-1 {
  margin: 0.25rem !important;
}

.mt-1,
.my-1 {
  margin-top: 0.25rem !important;
}

.mr-1,
.mx-1 {
  margin-right: 0.25rem !important;
}

.mb-1,
.my-1 {
  margin-bottom: 0.25rem !important;
}

.ml-1,
.mx-1 {
  margin-left: 0.25rem !important;
}

.m-2 {
  margin: 0.5rem !important;
}

.mt-2,
.my-2 {
  margin-top: 0.5rem !important;
}

.mr-2,
.mx-2 {
  margin-right: 0.5rem !important;
}

.mb-2,
.my-2 {
  margin-bottom: 0.5rem !important;
}

.ml-2,
.mx-2 {
  margin-left: 0.5rem !important;
}

.m-3 {
  margin: 1rem !important;
}

.mt-3,
.my-3 {
  margin-top: 1rem !important;
}

.mr-3,
.mx-3 {
  margin-right: 1rem !important;
}

.mb-3,
.my-3 {
  margin-bottom: 1rem !important;
}

.ml-3,
.mx-3 {
  margin-left: 1rem !important;
}

.m-4 {
  margin: 1.5rem !important;
}

.mt-4,
.my-4 {
  margin-top: 1.5rem !important;
}

.mr-4,
.mx-4 {
  margin-right: 1.5rem !important;
}

.mb-4,
.my-4 {
  margin-bottom: 1.5rem !important;
}

.ml-4,
.mx-4 {
  margin-left: 1.5rem !important;
}

.m-5 {
  margin: 3rem !important;
}

.mt-5,
.my-5 {
  margin-top: 3rem !important;
}

.mr-5,
.mx-5 {
  margin-right: 3rem !important;
}

.mb-5,
.my-5 {
  margin-bottom: 3rem !important;
}

.ml-5,
.mx-5 {
  margin-left: 3rem !important;
}

.p-0 {
  padding: 0 !important;
}

.pt-0,
.py-0 {
  padding-top: 0 !important;
}

.pr-0,
.px-0 {
  padding-right: 0 !important;
}

.pb-0,
.py-0 {
  padding-bottom: 0 !important;
}

.pl-0,
.px-0 {
  padding-left: 0 !important;
}

.p-1 {
  padding: 0.25rem !important;
}

.pt-1,
.py-1 {
  padding-top: 0.25rem !important;
}

.pr-1,
.px-1 {
  padding-right: 0.25rem !important;
}

.pb-1,
.py-1 {
  padding-bottom: 0.25rem !important;
}

.pl-1,
.px-1 {
  padding-left: 0.25rem !important;
}

.p-2 {
  padding: 0.5rem !important;
}

.pt-2,
.py-2 {
  padding-top: 0.5rem !important;
}

.pr-2,
.px-2 {
  padding-right: 0.5rem !important;
}

.pb-2,
.py-2 {
  padding-bottom: 0.5rem !important;
}

.pl-2,
.px-2 {
  padding-left: 0.5rem !important;
}

.p-3 {
  padding: 1rem !important;
}

.pt-3,
.py-3 {
  padding-top: 1rem !important;
}

.pr-3,
.px-3 {
  padding-right: 1rem !important;
}

.pb-3,
.py-3 {
  padding-bottom: 1rem !important;
}

.pl-3,
.px-3 {
  padding-left: 1rem !important;
}

.p-4 {
  padding: 1.5rem !important;
}

.pt-4,
.py-4 {
  padding-top: 1.5rem !important;
}

.pr-4,
.px-4 {
  padding-right: 1.5rem !important;
}

.pb-4,
.py-4 {
  padding-bottom: 1.5rem !important;
}

.pl-4,
.px-4 {
  padding-left: 1.5rem !important;
}

.p-5 {
  padding: 3rem !important;
}

.pt-5,
.py-5 {
  padding-top: 3rem !important;
}

.pr-5,
.px-5 {
  padding-right: 3rem !important;
}

.pb-5,
.py-5 {
  padding-bottom: 3rem !important;
}

.pl-5,
.px-5 {
  padding-left: 3rem !important;
}

.m-auto {
  margin: auto !important;
}

.mt-auto,
.my-auto {
  margin-top: auto !important;
}

.mr-auto,
.mx-auto {
  margin-right: auto !important;
}

.mb-auto,
.my-auto {
  margin-bottom: auto !important;
}

.ml-auto,
.mx-auto {
  margin-left: auto !important;
}
</style>
