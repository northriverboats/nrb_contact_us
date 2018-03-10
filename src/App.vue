<template>
  <div id="app">
    <router-view/>
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
  margin-top: 30px;
}

body {
  font-family: Helvetica Neue,Helvetica,Arial,sans-serif;
  color: #c8c8c8;
}

.content h1, .content h2, .content h3, .content h4, .content h5, .content h6 {
  color: #c8c8c8;
}

select {
  background-image: none;
  padding-top: 0px;
  padding-bottom: 0px;
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
  padding-left: 15px !important;
  background-color: inherit;
  border-color: transparent;
  color: #e94442;
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

/*
.error label  {
    color: #e94442;
}
*/

</style>
