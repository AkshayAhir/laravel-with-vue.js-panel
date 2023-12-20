<template>
  <div class="head">
    <DashboardPage/>
  </div>
</template>

<script>
import DashboardPage from './DashboardPage.vue'
import router from '../router'; // Import your router instance

export default {
  name: 'HeaderPage',
  components: {
    DashboardPage
  },
  mounted() {
    // Check if the user is authenticated
    const isAuthenticated = sessionStorage.getItem('authenticated');

    if (isAuthenticated !== 'true') {
      // User is not authenticated, redirect to the login page
      router.push('/login');
    //   router.push('/register');
    }
  }
}
</script>
