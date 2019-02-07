Vue.use(VueMaterial.default);
//const axios = require('axios');

const users = [];

import { validationMixin } from 'vuelidate'
import {
    required,
    email,
    minLength,
    maxLength
} from 'vuelidate/lib/validators'

new Vue({
    el: '#app',
    name: 'FormValidation',
    mixins: [validationMixin],
    data() {
        return {
            name: 'formPost',
            roles: [],
            user: [],
            users: [],
            showDialog: false,
            modalVisibility: false,
            res : [],
            form: {
                firstName: null,
                lastName: null,
                patronymic: null,
                role: null,
            },
            userSaved: false,
            sending: false,
        };
    },
    validations: {
        form: {
            firstName: {
                required,
                minLength: minLength(3)
            },
            lastName: {
                required,
                minLength: minLength(3)
            },
            patronymic: {
                required,
                minLength: minLength(3)
            },
            role: {
                required
            }
        }
    },
    mounted() {
        axios
            .get('/api/users')
            .then(response => (this.users = response.data));
        axios
            .get('/api/roles')
            .then(response => (this.roles = response.data));
    },
    methods: {
        selectUser(user) {
            this.showDialog = true;
            this.user = user;
        },
        editUser(){
            // axios.post('http://localhost:3030/api/new/post',
            //     this.name, // the data to post
            //     { headers: {
            //             'Content-type': 'application/x-www-form-urlencoded',
            //         }
            //     }).then(response => (this.res = response.data));
            console.log(this.name);
            this.showDialog = false;
        },
        getValidationClass (fieldName) {
            const field = this.$v.form[fieldName];

            if (field) {
                return {
                    'md-invalid': field.$invalid && field.$dirty
                }
            }
        },
        clearForm () {
            this.$v.$reset();
            this.form.firstName = null;
            this.form.lastName = null;
            this.form.patronymic = null;
            this.form.role = null;
        },
        saveUser () {
            this.sending = true;

            // Instead of this timeout, here you can call your API
            window.setTimeout(() => {
                this.lastUser = `${this.form.firstName} ${this.form.lastName}`;
                this.userSaved = true;
                this.sending = false;
                this.clearForm()
            }, 1500)
        },
        validateUser () {
            this.$v.$touch();

            if (!this.$v.$invalid) {
                this.saveUser()
            }
        }
    }
});