<template>
<div>
    <div class="head">
        <div class="pageName">
            <h1>{{ currentPageName }}</h1>
        </div>

        <img :src="'storage/image/' + admin.image" onerror="this.src='/image/userprofile.png'" class="profile" v-on:click="displayOption()">

        <div class="online"></div>

       <div class="option" v-if="show">
            <ul>
                <li style="margin-top:13%;">
                    <router-link to="/profile" class="list">Profile</router-link>
                </li>
                <li style="margin-top:10%;">
                    <a href="" class="list" v-on:click="logout()">Logout</a>
                </li>
            </ul>
        </div>
    </div>
    <nav class="navbar">
        <img src="/image/logo.jpg" class="logo">
        <router-link to="/header" class="linkbtn">Home</router-link>
        <router-link to="/userdata" class="linkbtn">UserData</router-link>
    </nav>
</div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'dashboardpage',
    data() {
        return {
            show: false,
            admin: [],
        }
    },
    computed: {
        currentPageName() {
            // Check the current route path and return the appropriate header text
            if (this.$route.path === '/header') {
                return 'Home Page';
            } else if (this.$route.path === '/userdata') {
                return 'UserData Information'; // Display "Home Page" on the "User Data" page
            } else if (this.$route.path === '/profile') {
                return 'Profile Update'; // Display "Home Page" on the "User Data" page
            }
        }
    },
     mounted() {
        this.loadData();
    },
    methods: {
        logout() {
            sessionStorage.clear();
            this.$router.push('/login');
        },
        displayOption() {
            this.show = !this.show;
        },
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
    },
}
</script>

<style scoped>
.navbar {
    background-color: slategray;
    width: 13%;
    height: 102%;
    position: fixed;
    display: block;
    margin-top: -1%;
    margin-left: -1%;
}

.logo {
    margin-bottom: 7%;
    width: 32%;
    border-radius: 50px;
    margin-top: 6%;
    margin-left: 34%;
}

.linkbtn {
    display: block;
    margin-bottom: 12%;
    height: 4%;
    width: 90%;
    margin-left: 4%;
    background-color: rgb(68, 33, 33);
    color: rgb(224, 205, 205);
    text-decoration: none;
    text-align: center;
    font-size: x-large;
    border-radius: 50px;
    margin-top: 10%;
}

.linkbtn:hover {
    width: 97.5%;
    margin-left: 1%;
}

.head {
    background-color:slategray;
    color: #ece1e1;
    width: 100%;
    height: 10%;
    margin-left: 12%;
    display: block;
    position: fixed;
    margin-top: -1%;
}

.pageName {
    position: absolute;
    display: inline-block;
    margin-top: 1.5%;
    margin-left: 2%;
    color: rgb(68, 33, 33);
}

.profile {
    margin-bottom: 7%;
    height: 86%;
    width: 4.5%;
    margin-top: 0.6%;
    border-radius: 50px;
    margin-left: 82%;
    position: relative;
    cursor: pointer;
}

.online {
    position: absolute;
    display: inline-block;
    /* background-color: rgb(31, 194, 31); */
    height: 15%;
    width: 0.8%;
    border-radius: 50px;
    margin-top: 0.9%;
    margin-left: -0.7%;
}

.option {
    background-color: rgb(68, 33, 33);
    width: 5.5%;
    margin-left: -4.9%;
    margin-top: 85px;
    position: absolute;
    display: inline-block;
}

.list {
    text-decoration: none;
    color: rgb(224, 205, 205);
    text-align: center;
    cursor: pointer;
}

.list:hover {
    background-color: rgb(224, 205, 205);
    color: rgb(68, 33, 33);
}
</style>
