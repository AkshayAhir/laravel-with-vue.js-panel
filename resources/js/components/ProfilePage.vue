<template>
<div class="head">
    <DashboardPage />
    <div class="profile">
        <form @submit.prevent="updateAdmin(admin.id)" v-if="admin" :key="admin.id">

            <img :src="'/storage/image/' + admin.image" alt="User Image" onerror="src='/image/userprofile.png'" class="adminimg"><br><br>

            <label for="firstname">First Name</label><span class="star">*</span><br>
            <input type="text" name="firstname" v-model="admin.firstname" :class="{ 'error-border': updateerror.firstname }"><br>
            <span v-if="updateerror.firstname" style="color: red;">{{ updateerror.firstname[0] }}</span><br>

            <label for="lastname">Last Name</label><span class="star">*</span><br>
            <input type="text" name="lastname" v-model="admin.lastname" :class="{ 'error-border': updateerror.lastname }"><br>
            <span v-if="updateerror.lastname" style="color: red;">{{ updateerror.lastname[0] }}</span><br>

            <label for="email">Email</label><span class="star">*</span><br>
            <input type="text" name="email" v-model="admin.email" :class="{ 'error-border': updateerror.email }"><br>
            <span v-if="updateerror.email" style="color: red;">{{ updateerror.email[0] }}</span><br>

            <label for="phone">Phone Number</label><span class="star">*</span><br>
            <input type="text" name="phone" v-model="admin.phone" :class="{ 'error-border': updateerror.phone }"><br>
            <span v-if="updateerror.phone" style="color: red;">{{ updateerror.phone[0] }}</span><br>

            <label for="password">Password</label>
            <input type="password" name="password" v-model="tempPassword" :class="{ 'error-border': updateerror.password }"><br>
            <span v-if="updateerror.password" style="color: red;">{{ updateerror.password[0] }}</span><br>

            <label for="password_confirmation">Conform Password</label><br>
            <input type="password" name="password_confirmation" v-model="admin.password_confirmation" :class="{ 'error-border': passwordMismatchError }"><br>
            <span v-if="passwordMismatchError" style="color: red;">{{ passwordMismatchError }}</span><br>

            <label for="image">Image</label><br>
            <input type="file" name="image" accept="image/*" @change="handleImageUpload" style="border: none;border-radius: 0px;margin-left: 20%;"><br><br>

            <button type="submit" class="updatebtn">Update</button>
        </form>
        <div v-else>
            Loading...
        </div>
    </div>
</div>
</template>

<script>
import axios from 'axios';
import DashboardPage from './DashboardPage.vue';
import router from '../router'; // Import your router instance

export default {
    name: 'ProfilePage',
    components: {
        DashboardPage,
    },
    data() {
        return {
            admin: [],
            updateerror: {
                firstname: null,
                lastname: null,
                email: null,
                phone: null,
                password: null,
            },
            tempPassword: '', // Temporary variable to store the password during update
            passwordMismatchError: null, // Password mismatch error message
        };
    },
    created() {
        this.loadData();
    },
    mounted() {
        // Check if the user is authenticated
        const isAuthenticated = sessionStorage.getItem('authenticated');
        const isAdmin = sessionStorage.getItem('isAdmin');

        if (isAuthenticated !== 'true') {
            // User is not authenticated, redirect to the login page
            router.push('/login');
        } else if (isAdmin !== 'true') {
            // User is not an admin, redirect to the appropriate page (e.g., header)
            router.push('/profile');
        }
    },
    methods: {
        async loadData() {
            try {
                const adminEmail = sessionStorage.getItem('userEmail');
                const Email = adminEmail.replace(/"/g, '');
                const result = await axios.post(`/getUserData/${Email}`);
                this.admin = result.data;
            } catch (error) {
                console.error('Error fetching user data:', error);
            }
        },
        async updateAdmin(id) {
            this.updateerror.firstname = null;
            this.updateerror.lastname = null;
            this.updateerror.email = null;
            this.updateerror.phone = null;
            this.updateerror.password = null; // Reset password error
            this.passwordMismatchError = null; // Reset password mismatch error

            // Check if a password is entered and if password and confirm password match
            if (!this.tempPassword && this.admin.password_confirmation) {
                this.passwordMismatchError = 'Please enter the original password.';
                return; // Stop the update process
            }

            if (this.tempPassword && this.tempPassword !== this.admin.password_confirmation) {
                this.passwordMismatchError = 'Password and confirm password do not match.';
                return; // Stop the update process
            }

            try {
                const formData = new FormData();
                formData.append('firstname', this.admin.firstname);
                formData.append('lastname', this.admin.lastname);
                formData.append('email', this.admin.email);
                formData.append('phone', this.admin.phone);
                formData.append('image', this.admin.image);
                formData.append('password', this.tempPassword); // Use tempPassword as the password during the update
                formData.append('password_confirmation', this.admin.password_confirmation);
                const response = await axios.post(`/updateUserData/${id}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });
                if (response.status === 200) {
                    alert('User data updated successfully');
                    window.location.reload();
                }
            } catch (error) {
                if (error.response.status === 400) {
                    // Handle validation errors
                    this.updateerror = error.response.data.errors;
                }
            }
        },
        handleImageUpload(event) {
            const file = event.target.files[0];
            this.admin.image = file;
        },
    },
};
</script>

<style scoped>
.profile {
    margin-top: 10%;
    margin-left: 50%;
    display: block;
    position: fixed;
    text-align: center;
}

.head {
    position: fixed;
    display: block;
}

.error-border {
    border-color: red;
    border-width: 2px;
}

input {
    text-align: center;
    width: 100%;
    height: 35px;
    border: 1px solid black;
    border-radius: 20px;
}

.star {
    color: red;
    margin-left: 1%;
    font-size: large;
}

.updatebtn {
    background-color: rgb(35, 179, 35);
    color: white;
    width: 33%;
    border-radius: 5px;
    border: 1px solid black;
}

.updatebtn:hover {
    width: 34%;
    height: 60%;
}

.adminimg {
    width: 35%;
    border-radius: 50%;
    height: 100px;
    margin-top: -35%;
}
</style>
