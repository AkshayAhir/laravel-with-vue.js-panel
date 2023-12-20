<template>
<div class="container">
    <div class="row">
        <!-- Display success message if registered is true -->
        <div v-if="registered" class="alert alert-success" style="color: green;">
            Register Successfully
        </div>
        <div class="col-md-6 mt-5 mx-auto">
            <form @submit.prevent="register" class="registration-form" method="POST">

                <h1 class="h3 mb-3 font-weight-normal">Register Form</h1>

                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" v-model="firstname" class="form-control" name="firstname" placeholder="First Name">
                    <div v-if="errors.firstname" class="text-danger" style="color: red;">{{ errors.firstname[0] }}</div>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" v-model="lastname" class="form-control" name="lastname" placeholder="Last Name">
                    <div v-if="errors.lastname" class="text-danger" style="color: red;">{{ errors.lastname[0] }}</div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" v-model="email" class="form-control" name="email" placeholder="Email Address">
                    <div v-if="errors.email" class="text-danger" style="color: red;">{{ errors.email[0] }}</div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" v-model="password" class="form-control" name="password" placeholder="Password">
                    <div v-if="errors.password" class="text-danger" style="color: red;">{{ errors.password[0] }}</div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Conform Password</label>
                    <input type="password" v-model="password_confirmation" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                    <div v-if="errors.password_confirmation" class="text-danger" style="color: red;">{{ errors.password_confirmation[0] }}</div>
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" v-model="phone" class="form-control" name="phone" placeholder="Phone number">
                    <div v-if="errors.phone" class="text-danger" style="color: red;">{{ errors.phone[0] }}</div>
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button><br><br>
                <h5>If you go to: <router-link to="/login">Login Page</router-link><br><br></h5>
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
      firstname: '',
      lastname: '',
      email: '',
      password: '',
      password_confirmation: '',
      phone: '',
      errors: {},
      registered: false, // Initialize to false
    };
  },
  methods: {
    register() {
      // Send a POST request to the '/register' route with user data
      axios
        .post('/register', {
          firstname: this.firstname,
          lastname: this.lastname,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
          phone: this.phone,
        })
        .then((res) => {
          // Registration successful, clear fields and display success message
          this.registered = true;
          this.firstname = '';
          this.lastname = '';
          this.email = '';
          this.password = '';
          this.password_confirmation = '';
          this.phone = '';
          // Redirect to the 'Login' page using Vue Router
          router.push({
            name: 'Login',
          });
        })
        .catch((err) => {
          if (err.response.status === 400) {
            // Handle validation errors sent from the server
            this.errors = err.response.data.errors;
          } else {
            console.log(err);
          }
        });
    },
  },
  mounted() {
    // Check if the user is authenticated
    const isAuthenticated = sessionStorage.getItem('authenticated');

    if (isAuthenticated === 'true') {
      // User is authenticated, redirect to the appropriate page
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
.registration-form {
    background: #f3f4f6;
    border: 1px solid #e0e0e0;
    border-radius: 53px;
    max-width: 400px;
    margin: 0 auto;
    padding: 37px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);

}

/* Add your styling for form elements, labels, and buttons here */

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
    padding: 10px;
    border-radius: 3px;
    text-align: center;
}

h5 {
    text-align: center;
    margin-top: 20px;
}
</style>

<style>
.registration-form {
    background: #f3f4f6;
    border: 1px solid #e0e0e0;
    border-radius: 53px;
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    margin-top: 6%;
}

.registration-form h1 {
    text-align: center;
    color: #333;
}

.registration-form .form-group {
    margin-bottom: 20px;
}

.registration-form label {
    font-weight: bold;
    display: block;
}

.registration-form input {
    width: 96%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 18px;
    transition: border-color 0.3s;
}

.registration-form input:focus {
    border-color: #007bff;
}

.registration-form .text-danger {
    color: red;
}

.registration-form button {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.registration-form button:hover {
    background-color: #0056b3;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
    padding: 10px;
    border-radius: 3px;
    text-align: center;
}

h5 {
    text-align: center;
    margin-top: 20px;
}
</style>
