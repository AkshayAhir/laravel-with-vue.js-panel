<template>
<!-- add user -->
<div class="head">
    <DashboardPage />

    <div class="modal2" v-if="hide2">
        <div id="app" style="margin-left:30%;" class="modal2-form">
            <div class="form-group">
                <label for="firstname">First Name<span style="color: red;" margin-left="1%;">*</span></label>
                <input type="text" id="firstname" v-model="item.firstname" placeholder="Enter Your First Name" class="form-control">
                <span v-if="error.firstname" style="color: red;">{{ error.firstname }}</span>
            </div>

            <div class="form-group">
                <label for="lastname">Last Name<span style="color: red;" margin-left="1%;">*</span></label>
                <input type="text" id="lastname" v-model="item.lastname" placeholder="Enter Your Last Name" class="form-control">
                <span v-if="error.lastname" style="color: red;">{{ error.lastname }}</span>
            </div>

            <div class="form-group">
                <label for="email">Email<span style="color: red;" margin-left="1%;">*</span></label>
                <input type="email" id="email" v-model="item.email" placeholder="Enter Your email" class="form-control">
                <span v-if="error.email" style="color: red;">{{ error.email }}</span>
            </div>

            <div class="form-group">
                <label for="address">Address<span style="color: red;" margin-left="1%;">*</span></label>
                <input type="text" id="address" v-model="item.address" placeholder="Enter Your Address" class="form-control">
                <span v-if="error.address" style="color: red;">{{ error.address }}</span>
            </div>

            <div class="form-group">
                <label for="phone">Phone<span style="color: red;" margin-left="1%;">*</span></label>
                <input type="tel" id="phone" v-model="item.phone" placeholder="Enter Your Phone Number" class="form-control">
                <span v-if="error.phone" style="color: red;">{{ error.phone }}</span>
            </div>

            <button class="btn btn-success btn-block" @click="save">Submit</button>

            <button class="btn btn-secondary btn-block" id="closebtn" @click="close">Close</button>
        </div>
    </div>

    <!-- show data  -->
    <div class="modal3" v-if="hide3">
        <div class="modal3-form">

            <!-- <td>
                <img :src="'/storage/image/' + selectedUser.image" alt="User Image" onerror="this.src='/image/userprofile.png'" class="userimg">
            </td> -->

            <label for="firstname">First Name</label><br>
            <input type="text" name="firstname" v-model="selectedUser.firstname" disabled><br><br>

            <label for="lastname">Last Name</label><br>
            <input type="text" name="lastname" v-model="selectedUser.lastname" disabled><br><br>

            <label for="email">Email</label><br>
            <input type="text" name="email" v-model="selectedUser.email" disabled><br><br>

            <label for="address">Address</label><br>
            <input type="text" name="address" v-model="selectedUser.address" disabled><br><br>

            <label for="phone">Phone</label><br>
            <input type="text" name="phone" v-model="selectedUser.phone" disabled><br><br>

            <button class="btn btn-secondary btn-block" id="closebtn" @click="close">Close</button>
        </div>
    </div>

    <!-- update data -->
    <div class="modal1" v-if="hide1">
        <div id="app" style="margin-left:30%;" class="modal1-form">
            <div class="form-group">
                <label for="firstname">First Name<span style="color: red;" margin-left="1%;">*</span></label>
                <input type="text" id="firstname" v-model="selectedUser.firstname" placeholder="Enter your First Name" class="form-control">
                <span v-if="updateerror.firstname" style="color: red;">{{ updateerror.firstname }}</span>
            </div>

            <div class="form-group">
                <label for="lastname">Last Name<span style="color: red;" margin-left="1%;">*</span></label>
                <input type="text" id="lastname" v-model="selectedUser.lastname" placeholder="Enter your Last Name" class="form-control">
                <span v-if="updateerror.lastname" style="color: red;">{{ updateerror.lastname }}</span>
            </div>

            <div class="form-group">
                <label for="email">Email<span style="color: red;" margin-left="1%;">*</span></label>
                <input type="email" id="email" v-model="selectedUser.email" placeholder="Enter your email" class="form-control">
                <span v-if="updateerror.email" style="color: red;">{{ updateerror.email }}</span>
            </div>

            <div class="form-group">
                <label for="address">Address<span style="color: red;" margin-left="1%;">*</span></label>
                <input type="text" id="address" v-model="selectedUser.address" placeholder="Enter your Address" class="form-control">
                <span v-if="updateerror.address" style="color: red;">{{ updateerror.address }}</span>
            </div>

            <div class="form-group">
                <label for="phone">Phone<span style="color: red;" margin-left="1%;">*</span></label>
                <input type="text" id="phone" v-model="selectedUser.phone" placeholder="Enter your Phone Number" class="form-control">
                <span v-if="updateerror.phone" style="color: red;">{{ updateerror.phone }}</span>
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" @change="handleImageChange" accept="image/*" class="form-control">
                <span v-if="updateerror.image" style="color: red;">{{ updateerror.image }}</span>
            </div>

            <button class="btn btn-success btn-block" @click="UpdateUser">Update</button>

            <button class="btn btn-secondary btn-block" id="closebtn" @click="close">Close</button>
        </div>
    </div>

    <!-- selectbox -->
    <div class="success-message" v-if="successMessage">{{ successMessage }}</div>
    <div class="error-message" v-if="errorMessage">{{ errorMessage }}</div>
    <div class="table-container">
        <div class="success-message" v-if="successMessage">{{ successMessage }}</div>
        <div style="display: flex; align-items: center; margin-bottom: -9px;">
            <label for="reverseSearch" style="font-size: 14px; margin-left: 8px; ">
                <h4>Reverse Search:</h4>
            </label>
            <input type="checkbox" name="reverseSearch" class="selectall" v-model="reverseSearch" style="margin-left: 5px;">

            <label for="selectAll">
                <h4 style="font-size: 14px; margin-left: 10px;">Select All:</h4>
            </label>
            <input type="checkbox" name="selectAll" v-model="selectAll" v-on:click="selectall()" style="margin-left: 5px;" class="selectall">
        </div>
        <div v-for="(row, index) in rows" :key="row.id">
            <select class="searchField" v-model="row.field">
                <option selected disabled value="">Select Field</option>
                <option v-for="option in availableOptions(index)" :key="option" :value="option">
                    {{ option }}
                </option>
            </select>
            <input type="text" placeholder="Enter Value" class="searchValue" v-model="row.value">
            <button class="removeRow" @click="removeRow(row.id)" v-if="index > 0">-</button>
            <button class="addRow" @click="addRow()" v-if="index === rows.length - 1">+</button><br><br>
        </div>

        <div style="display: flex; align-items: center; margin-top: -1%; margin-bottom: -2%;">
            <label for="recordPerPage" style="font-size: 14px; margin-left: 10px;">
                <h4>Show
                    <select name="recordPerPage" class="recordPerPage" v-model="itemsPerPage" @change="changeItemsPerPage">
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    Entries</h4>
            </label>

            <label for="action">
                <h4 style="font-size: 14px; margin-left: 10px;">Select Action:</h4>
            </label>

            <select name="action" class="action" v-model="selectedAction" style="margin-left: 10px;">
                <option value="pdf">PDF</option>
                <option value="excel">Excel</option>
            </select>
            <button type="submit" class="actionbtn" style="margin-left: 10px;" @click="handleAction">Go</button>
            <button class="searchbtn" style="margin-left: 10px;" @click="handlesearch">Search</button>
        </div>

        <button class="addbtn" style="margin-left: 93%;" @click="show2()">Add UserData</button>
        <table class="user-table" id="data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Image</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in paginatedList" :key="user.id">
                    <td>
                        <input type="checkbox" class="checkbox" :value="user.id" v-model="selected" v-on:click="select()">
                        <a class="index" v-on:click="show3(user.id)" style="cursor: pointer;">{{ startIndex + index }}</a>
                    </td>
                    <td>{{ user.firstname }}</td>
                    <td>{{ user.lastname }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.address }}</td>
                    <td>{{ user.phone }}</td>
                    <td> <img :src="'/storage/image/' + user.image" alt="User Image" onerror="src='/image/userprofile.png'" style="width: 25%;"></td>
                    <td>
                        <button class="updatebtn" @click="show1(user.id)">Update</button>
                    </td>
                    <td>
                        <button class="deletebtn" @click="deleteUser(user.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination-controls">
            <button v-for="pageNumber in totalPageArray" :key="pageNumber" @click="changePage(pageNumber)">
                {{ pageNumber }}
            </button>
        </div>
    </div>
    <label>
        <h5>Total Record {{ startIndex }} To
            {{ startIndex + paginatedList.length - 1 }} out of {{ lists.length }}</h5>
    </label>
</div>
</template>

<script>
import axios from 'axios';

import DashboardPage from './DashboardPage.vue'

export default {
    name: 'UserdataPage',
    components: {
        DashboardPage,
    },

    data() {
        return {
            lists: [],
            allFields: ["firstname", "lastname", "email", "address", "phone"],
            item: {
                firstname: '',
                lastname: '',
                email: '',
                address: '',
                phone: '',
            },
            hide2: false,
            hide3: false,
            error: {
                firstname: '',
                lastname: '',
                email: '',
                address: '',
                phone: '',
            },

            hide1: false,
            error: {
                firstname: '',
                lastname: '',
                email: '',
                address: '',
                phone: '',
            },

            selectedUser: {
                id: null,
                firstname: null,
                lastname: null,
                email: null,
                address: null,
                phone: null,
                image: '', // Add this line

            },

            updateerror: {
                firstname: '',
                lastname: '',
                email: '',
                address: '',
                phone: '',

            },
            successMessage: '',
            errorMessage: '',
            currentPage: 1,
            itemsPerPage: 3,
            rows: [{
                id: 1
            }],
            selected: [],
            selectAll: false,
            selectedAction: [],
            reverseSearch: false,
            startIndex: 1,
        };
    },

    computed: {
        availableOptions() {
            return index => {
                const selectedFields = this.rows.map(row => row.field);
                return this.allFields.filter(field => !selectedFields.includes(field) || selectedFields.indexOf(field) === index);
            };
        },
        totalPageArray() {
            const totalPageCount = Math.ceil(this.lists.length / this.itemsPerPage);
            return Array.from({
                length: totalPageCount
            }, (_, index) => index + 1);
        },
        paginatedList() {
            const startIndex = (this.currentPage - 1) * this.itemsPerPage;
            const endIndex = startIndex + this.itemsPerPage;
            return this.lists.slice(startIndex, endIndex);
        },
    },

    mounted() {
        this.fetchData();
    },

    watch: {
        currentPage(newPage) {
            this.updateStartIndex(newPage);
        },
    },

    methods: {
        updateStartIndex(newPage) {
            this.startIndex = (newPage - 1) * this.itemsPerPage + 1;
        },

        changePage(pageNumber) {
            this.currentPage = pageNumber;
        },
        validateEmail(email) {
            const emailRegex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/;

            return email.match(emailRegex);
        },
        save() {
            // Reset errors
            this.error = {
                firstname: '',
                lastname: '',
                email: '',
                address: '',
                phone: '',
            };

            this.successMessage = '';
            this.errorMessage = '';

            // Validate the input fields
            let isValid = true;
            if (!this.item.firstname) {
                this.error.firstname = 'First Name is required';
                isValid = false;
            }
            if (!this.item.lastname) {
                this.error.lastname = 'Last Name is required';
                isValid = false;
            }
            if (!this.item.email) {
                this.error.email = 'Email is required';
                isValid = false;
            } else if (!this.validateEmail(this.item.email)) {
                this.error.email = 'Invalid email address';
                isValid = false;
            }
            if (!this.item.address) {
                this.error.address = 'Address is required';
                isValid = false;
            }
            if (!this.item.phone) {
                this.error.phone = 'Phone is required';
                isValid = false;
            }

            if (isValid) {
                axios
                    .post('/userdata', this.item)
                    .then(response => {
                        console.log('Data saved successfully', response);
                        this.item = {
                            firstname: '',
                            lastname: '',
                            email: '',
                            address: '',
                            phone: '',
                        };
                        this.fetchData();
                        this.successMessage = 'UserData created successfully';
                        this.hide2 = false; // Close the modal here

                        setTimeout(() => {
                            this.successMessage = '';
                        }, 2000);
                    })
                    .catch(error => {
                        console.error('Error saving data', error);
                        this.errorMessage = 'Error saving data';
                    });
            }
        },

        deleteUser(Id) {
            if (confirm("Are you sure you want to delete this user?")) {
                axios
                    .delete(`/deleteUser/${Id}`) // Adjust the API endpoint as per your backend
                    .then(response => {
                        console.log(`User with ID ${Id} deleted successfully`);
                        this.fetchData(); // Refresh the user list
                    })
                    .catch(error => {
                        console.error(`Error deleting user with ID ${Id}`, error);
                    });
            }
        },

        fetchData() {
            axios
                .get('/fetchUserData')
                .then(response => {
                    // console.log(response, 'response');
                    this.lists = response.data;
                })
                .catch(error => {
                    console.error('Error fetching data', error);
                });
        },
        close() {
            this.hide2 = false;
            this.hide1 = false;
            this.hide3 = false;

        },
        show2() {
            this.hide2 = true;

        },
        show3(id) {
            const selectedUser = this.lists.find(user => user.id === id);
            if (selectedUser) {
                this.selectedUser = selectedUser;
                this.hide3 = true;
            }
        },
        show1(id) {
            const selectedUser = this.lists.find((user) => user.id === id);
            if (selectedUser) {
                this.selectedUser = {
                    ...selectedUser
                };
                this.updateerror.firstname = '';
                this.updateerror.lastname = '';
                this.updateerror.email = '';
                this.updateerror.address = '';
                this.updateerror.phone = '';
                this.hide1 = true;
            }
        },

        async UpdateUser() {
            // Reset errors
            this.updateerror = {
                firstname: '',
                lastname: '',
                email: '',
                address: '',
                phone: '',
                image: '',
            };
            this.successMessage = '';
            this.errorMessage = '';

            // Declare isValid at a higher scope
            let isValid = true;

            // Validate the input fields
            if (!this.selectedUser.firstname) {
                this.updateerror.firstname = 'First Name is required';
                isValid = false;
            }
            if (!this.selectedUser.lastname) {
                this.updateerror.lastname = 'Last Name is required';
                isValid = false;
            }
            if (!this.selectedUser.email) {
                this.updateerror.email = 'Email is required';
                isValid = false;
            } else if (!this.validateEmail(this.selectedUser.email)) {
                this.updateerror.email = 'Invalid email address';
                isValid = false;
            }
            if (!this.selectedUser.address) {
                this.updateerror.address = 'Address is required';
                isValid = false;
            }
            if (!this.selectedUser.phone) {
                this.updateerror.phone = 'Phone is required';
                isValid = false;
            }

            if (isValid) {
                const formData = new FormData();
                formData.append('id', this.selectedUser.id);
                formData.append('firstname', this.selectedUser.firstname);
                formData.append('lastname', this.selectedUser.lastname);
                formData.append('email', this.selectedUser.email);
                formData.append('address', this.selectedUser.address);
                formData.append('phone', this.selectedUser.phone);
                // formData.append('image', this.selectedUser.image);

                // Check if a new image file is selected
                if (this.selectedUser.imageFile) {
                    formData.append('image', this.selectedUser.imageFile);
                }

                try {
                    const response = await axios.post(`/updateUser/${this.selectedUser.id}`, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        },
                    });

                    this.selectedUser.image = response.data.image;

                    console.log('Data updated successfully', response);
                    this.selectedUser = null;
                    this.hide1 = false;
                    this.fetchData();
                    this.successMessage = 'UserData updated successfully';

                    setTimeout(() => {
                        this.successMessage = '';
                    }, 1000);
                } catch (error) {
                    console.error('Error updating data', error);
                    this.errorMessage = 'Error updating data';
                }
            }
        },

        handleImageChange(event) {
            this.updateerror.image = '';
            const file = event.target.files[0];
            this.selectedUser.imageFile = file;
        },

        changeItemsPerPage() {
            this.currentPage = 1;
        },
        // addRow() {
        //     if (this.rows.length < 5) {
        //         const newId = this.rows[this.rows.length - 1].id + 1;
        //         this.rows.push({
        //             id: newId
        //         });
        //     } else {
        //         alert("You can only add 5 rows.");
        //     }
        // },
        // removeRow(id) {
        //     if (this.rows.length > 1) {
        //         const index = this.rows.findIndex(row => row.id === id);
        //         this.rows.splice(index, 1);
        //     }
        // },
        // isFieldVisible(index) {
        //     const selectedFields = this.rows.map(row => row.field);
        //     return !selectedFields.includes(this.rows[index].field) || selectedFields.indexOf(this.rows[index].field) === index;
        // },
        addRow() {
            if (this.reverseSearch) {
                return;
            }

            if (this.rows.length < 5) {
                const newId = this.rows[this.rows.length - 1].id + 1;
                this.rows.push({
                    id: newId
                });
            } else {
                alert("You can only add 5 rows.");
            }
        },

        removeRow(id) {
            if (this.rows.length > 1) {
                const index = this.rows.findIndex(row => row.id === id);
                this.rows.splice(index, 1);
            }
        },

        isFieldVisible(index) {
            const selectedFields = this.rows.map(row => row.field);
            for (let i = 0; i < this.rows.length; i++) {
                if (i !== index && selectedFields[i] === this.rows[index].field) {
                    return false; // Field is selected in another row
                }
            }
            return true; // Field is not selected in any other row
        },
        handlesearch() {
            if (this.reverseSearch === true) {
                this.reversesearch();
            } else {
                this.search();
            }
        },

        async search() {
            const searchData = this.rows.map(row => ({
                field: row.field,
                value: row.value
            }));

            const fieldSet = new Set();
            for (const data of searchData) {
                if (fieldSet.has(data.field)) {
                    alert("Please select different fields");
                    return;
                }
                fieldSet.add(data.field);
                if (!data.field) {
                    alert("Please select field");
                    return;
                }
                if (!data.value) {
                    alert("Please enter values");
                    return;
                }

            }
            const response = await axios.post('/search', {
                searchData,
            });

            if (response.status === 200) {
                this.lists = response.data;

                if (this.lists.length === 0) {
                    alert("No record found");

                }
            }
        },

        async reversesearch() {
            const searchData = this.rows.map(row => ({
                field: row.field,
                value: row.value
            }));

            const fieldSet = new Set();
            for (const data of searchData) {
                if (fieldSet.has(data.field)) {
                    alert("Please select different fields");
                    return;
                }
                fieldSet.add(data.field);
                if (!data.value) {
                    alert("Please enter values");
                    return;
                }
                if (!data.field) {
                    alert("Please select field");
                    return;
                }
            }

            try {
                const response = await axios.post('/reverseSearch', {
                    searchData,
                });

                if (response.status === 200) {
                    this.lists = response.data; // Update the lists data with the response
                    if (this.lists.length === 0) {
                        alert("No record found");
                    }
                }
            } catch (error) {
                console.error('Error during reverse search:', error);
                // Handle the error as needed
            }
        },

        selectall() {
            this.selected = [];
            if (!this.selectAll) {
                for (let user in this.paginatedList) {
                    this.selected.push(this.paginatedList[user].id);
                }
            }
        },

        select() {
            if (this.selected.length === this.paginatedList.length) {
                this.selectAll = true;
            } else {
                this.selectAll = false;
            }
            if (this.selected.length === this.lists.length) {
                this.selectAllPages = true;
            } else {
                this.selectAllPages = false;
            }
        },

        handleAction() {
            if (this.selected.length === 0) {
                alert('Please select at least one record to perform the action.');
                return;
            }

            if (this.selected.length > 0) {
                const action = this.selectedAction;

                switch (action) {
                    case 'pdf':
                        this.generatePDF();
                        break;

                    case 'excel':
                        this.exportToExcel();
                        break;

                    default:
                        alert("Please select a valid action");
                        break;
                }
            }
        },

        async generatePDF() {
            try {
                // Call your PDF generation endpoint with the selected user IDs
                const response = await axios.post('/generatePDF', {
                    selectedUsers: this.selected,
                });

                if (response.status === 200) {
                    // Construct the URL for the generated PDF
                    const pdfUrl = '/storage/selected_users.pdf';

                    // Create a hidden link to trigger the download
                    const link = document.createElement('a');
                    link.href = pdfUrl;
                    link.target = '_blank'; // Open the link in a new tab
                    link.download = 'selected_users.pdf';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                }
            } catch (error) {
                console.error(error);
            }
        },

        async exportToExcel() {
            try {
                // Call your Excel generation endpoint with the selected user IDs
                const response = await axios.post('/generateExcel', {
                    selectedUsers: this.selected,
                });

                if (response.status === 200) {
                    // Construct the URL for the generated Excel file
                    const excelUrl = '/storage/selected_users.xlsx'; // Adjust the path based on your storage configuration

                    // Create a hidden link to trigger the download
                    const link = document.createElement('a');
                    link.href = excelUrl;
                    link.target = '_blank'; // Open the link in a new tab
                    link.download = 'selected_users.xlsx';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                }
            } catch (error) {
                console.error(error);
            }
        },

    },

};
</script>

<style scoped>
body.user-table {
    width: 60%;
    border-collapse: collapse;
    margin-left: 25%;
    margin-top: 20px;
    /* You can adjust the value as needed */

}

.table-container {
    margin: 0 auto;
    /* This will center the container, and the table inside it */
    width: 80%;
    /* Adjust the width of the container as needed */
    padding-top: 13%;
    padding-left: 212px;
}

.user-table {
    width: 100%;
    /* Make the table fill the container width */
}

/* .userimg {

    margin-left: 78%;
} */

.pagination-controls {
    margin-top: 10px;
    text-align: center;
}

.pagination-controls button {
    margin: 0 5px;
}

.container {
    text-align: center;
}

.user-table {
    border-collapse: collapse;
    margin: 1px auto 0;
    color: black;

}

.user-table th,
.user-table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
    border-color: black;
}

/* .user-table th {
    background-color: #f0f0f0;

} */

/* .user-table tbody tr:nth-child(odd) {
    background-color: #f9f9f9;

} */

.showbtn .updatebtn,
.deletebtn {
    padding: 5px 10px;
    margin: 5px;
    border: none;
    cursor: pointer;
    color: #fff;
    border-radius: 5px;
}

.updatebtn {
    background-color: #007BFF;
    cursor: pointer;
}


.deletebtn {
    background-color: #DC3545;
}

.form {
    margin: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin: 10px 0;
}

.form-group label {
    font-weight: bold;
}

.form-group input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.modal2 {
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 100;
    text-align: center;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    /* Center horizontally */
    align-items: center;
    /* Center vertically */
}

.modal2-form {
    background: rgb(224, 205, 205);
    border: 2px solid black;
    width: 25%;
    padding: 15px;
    /* border-radius: 40px; */
    margin-right: 30%;
}

.modal2-form h2 {
    margin: 0 0 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid black;
}

#closebtn {
    margin-right: 95%;
}

.modal1 {
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 100;
    text-align: center;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal1-form {
    background: rgb(224, 205, 205);
    border: 2px solid black;
    width: 25%;
    padding: 15px;
    margin-right: 30%;
}

.modal1-form h2 {
    margin: 0 0 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid black;
}

/* .recordPerPage {
    margin-left: 19%;
} */

.modal3 {
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 100;
    text-align: center;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal3-form {
    background: rgb(224, 205, 205);
    border: 2px solid black;
    width: 25%;
    padding: 15px;
    /* border-radius: 40px; */
}

.modal3-form h2 {
    margin: 0 0 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid black;
}

.success-message {
    background-color: green;
    color: white;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
}

.searchField {
    border: 1px solid black;
}

.searchValue {
    width: 11%;
    margin-left: 1%;
    height: 15px;
    border: 1px solid black;
}

.searchbtn {
    width: 4%;
    color: rgb(224, 205, 205);
    background-color: rgb(68, 33, 33);
    border: 1px solid rgb(68, 33, 33);
    border-radius: 5px;
    margin-left: 5%;
}

.searchbtn:hover {
    background-color: rgb(224, 205, 205);
    color: rgb(68, 33, 33);
}

.removeRow {
    background-color: rgb(255, 66, 66);
    color: white;
    width: 1.8%;
    margin-left: 1%;
    font-weight: bold;
    border: 1px solid black;
}

.addRow {
    background-color: rgb(35, 179, 35);
    color: white;
    width: 2%;
    margin-left: 1%;
    font-weight: bold;
    border: 1px solid black;
}

h5 {

    margin-left: -60%;
    margin-top: -8px;
}
</style>
