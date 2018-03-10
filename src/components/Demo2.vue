<template>
  <div class="container">
    <h1>Page 2</h1>
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <label class="label">Name</label>
        <p class="control">
          <input class="input" type="text" placeholder="Text input">
        </p>
        <label class="label">Username</label>
        <p class="control has-icon has-icon-right">
          <input class="input is-success" type="text" placeholder="Text input" value="bulma">
          <i class="fa fa-check"></i>
          <span class="help is-success">This username is available</span>
        </p>
        <label class="label">Email</label>
        <p class="control has-icon has-icon-right">
          <input class="input is-danger" type="text" placeholder="Email input" value="hello@">
          <i class="fa fa-warning"></i>
          <span class="help is-danger">This email is invalid</span>
        </p>
        <label class="label">Subject</label>
        <p class="control">
          <span class="select">
            <select>
              <option>Select dropdown</option>
              <option>With options</option>
            </select>
          </span>
        </p>
        <label class="label">Message</label>
        <p class="control">
          <textarea class="textarea" placeholder="Textarea"></textarea>
        </p>
        <p class="control">
          <label class="checkbox">
            <input type="checkbox">
            Remember me
          </label>
        </p>
        <p class="control">
          <label class="radio">
            <input type="radio" name="question">
            Yes
          </label>
          <label class="radio">
            <input type="radio" name="question">
            No
          </label>
        </p>
        <p class="control">
          <router-link :to="{ name: 'Demo1' }" class="button is-primary">Submit</router-link>
          <button class="button is-link">Cancel</button>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Demo',
  data () {
    return {
      msg: 'Fredrick W. Warren'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
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
</style>
