<template>
<div class="container">
    <div class="row">
        <div id="login-form" class="col-md-6 mt-5 mx-auto">
            <form @submit.prevent="login" class="login-form" method="POST">

                <h1 class="h3 mb-3 font-weight-normal">Login Form</h1>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" v-model="email" class="form-control" name="email" placeholder="Email Address">
                    <div v-if="errors.email" class="text-danger" style="color: red;">{{ errors.email }}</div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" v-model="password" class="form-control" name="password" placeholder="Password">
                    <div v-if="errors.password" class="text-danger" style="color: red;">{{ errors.password }}</div>
                </div>

                <div class="form-group" style="display: flex; align-items: center;">
                    <label for="remember" style="margin-right: -160px;">Remember Me</label>
                    <input type="checkbox" v-model="remember" name="remember">
                </div>

                <div v-if="loginError" class="alert alert-danger">
                    {{ loginError }}
                </div>

                <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button><br><br>
                <h5 class="link">If you don't have an account: <router-link to="/register">Register Here</router-link><br><br></h5>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios';
import router from '../router';

export default {
  data() {
    return {
      email: '',
      password: '',
      remember: false,
      loginError: '',
      errors: {},
    };
  },

  methods: {
    login() {
      // Reset validation errors
      this.errors = {};

      axios
        .post('/login', {
          email: this.email,
          password: this.password,
        })
        .then((res) => {
          // Clear the login error if it was previously set
          this.loginError = '';

          const token = res.data.token;

          // Check if "Remember Me" is checked
          if (this.remember) {
            // Store user credentials in localStorage
            localStorage.setItem('rememberedEmail', this.email);
            localStorage.setItem('rememberedPassword', this.password);
          } else {
            // Clear stored credentials if "Remember Me" is not checked
            localStorage.removeItem('rememberedEmail');
            localStorage.removeItem('rememberedPassword');
          }

          sessionStorage.setItem('authenticated', 'true');
          sessionStorage.setItem('userEmail', this.email);

          // Assuming you have a property in the response indicating admin status
          const isAdmin = res.data.isAdmin; // Replace 'isAdmin' with the actual property

          if (isAdmin) {
            sessionStorage.setItem('isAdmin', 'true');
          } else {
            sessionStorage.setItem('isAdmin', 'false');
          }

          // Redirect based on isAdmin status
          if (isAdmin) {
            router.push('/profile'); // Redirect to the profile page for admins
          } else {
            router.push('/header'); // Redirect to a non-admin page if needed
          }
        })
        .catch((err) => {
          this.loginError = err.response.data.message;
        });
    },
  },

  mounted() {
    // Check if the user has opted for "Remember Me"
    const rememberedEmail = localStorage.getItem('rememberedEmail');
    const rememberedPassword = localStorage.getItem('rememberedPassword');

    if (rememberedEmail && rememberedPassword) {
      // Populate the form with stored credentials
      this.email = rememberedEmail;
      this.password = rememberedPassword;
      this.remember = true;
    }

    // Check if the user is authenticated
    const isAuthenticated = sessionStorage.getItem('authenticated');

    if (isAuthenticated === 'true') {
      // User is authenticated, redirect based on isAdmin status
      const isAdmin = sessionStorage.getItem('isAdmin');

      if (isAdmin === 'true') {
        router.push('/profile'); // Redirect to the profile page for admins
      } else {
        router.push('/header'); // Redirect to a non-admin page if needed
      }
    }
  },
};
</script>

<style>
.login-form {
    background: #f3f4f6;
    border: 1px solid #e0e0e0;
    border-radius: 53px;
    max-width: 400px;
    margin: 0 auto;
    padding: 37px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    margin-top: 12%;
}

.login-form h1 {
    text-align: center;
    color: #333;
}

.login-form .form-group {
    margin-bottom: 20px;
}

.login-form label {
    font-weight: bold;
    display: block;
}

.login-form input {
    width: 96%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 18px;
    transition: border-color 0.3s;
}

.login-form input:focus {
    border-color: #007bff;
}

.login-form .text-danger {
    color: red;
}

.login-form button {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.login-form button:hover {
    background-color: #0056b3;
}

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
    padding: 10px;
    border-radius: 3px;
    text-align: center;
}
</style>
