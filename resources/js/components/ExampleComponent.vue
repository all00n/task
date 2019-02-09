<template>
    <div>
        <md-table>
            <md-table-row>
                <md-table-head md-numeric>ID</md-table-head>
                <md-table-head>Name</md-table-head>
                <md-table-head>Role</md-table-head>
                <md-table-head>remove</md-table-head>
            </md-table-row>

            <md-table-row
                    v-for="user in users"
                    :key="user.id"
            >
                <md-table-cell md-numeric>
                    <div @click="selectUser(user)">
                        {{ user.id }}
                    </div>
                </md-table-cell>
                <md-table-cell>
                    <div @click="selectUser(user)">
                        {{ user.first_name }} {{ user.last_name }} {{ user.patronymic }}
                    </div>
                </md-table-cell>
                <md-table-cell>{{ user.user_roles.name}}</md-table-cell>
                <md-table-cell>Male</md-table-cell>
            </md-table-row>
        </md-table>
    </div>
    <div id="modal">
        <md-dialog :md-active.sync="showDialog">
            <form novalidate class="md-layout" submit.prevent="validateUser">
                <md-card class="md-layout-item md-size-50 md-small-size-100">
                    <md-card-header>
                        <div class="md-title">Users</div>
                    </md-card-header>

                    <md-card-content>
                        <div class="md-layout md-gutter">
                            <div class="md-layout-item md-small-size-100">
                                <md-field :class="getValidationClass('first_name')">
                                    <label for="first-name">First Name</label>
                                    <md-input name="first-name" id="first-name" autocomplete="given-name" v-model="user.first_name" :disabled="sending" />
                                    <span class="md-error" v-if="!$v.form.first_name.required">The first name is required</span>
                                    <span class="md-error" v-else-if="!$v.form.first_name.minLength">Invalid first name</span>
                                </md-field>
                            </div>
                        </div>

                        <div class="md-layout md-gutter">
                            <div class="md-layout-item md-small-size-100">
                                <md-field :class="getValidationClass('last_name')">
                                    <label for="last-name">Last Name</label>
                                    <md-input name="last-name" id="last-name" autocomplete="family-name" v-model="user.last_name" :disabled="sending" />
                                    <span class="md-error" v-if="!$v.form.last_name.required">The last name is required</span>
                                    <span class="md-error" v-else-if="!$v.form.last_name.minLength">Invalid last name</span>
                                </md-field>
                            </div>
                        </div>
                        <div class="md-layout md-gutter">
                            <div class="md-layout-item md-small-size-100">
                                <md-field :class="getValidationClass('patronymic')">
                                    <label for="patronymic">Patronymic</label>
                                    <md-input name="patronymic" id="patronymic" autocomplete="family-name" v-model="user.patronymic" :disabled="sending" />
                                    <span class="md-error" v-if="!$v.form.patronymic.required">The patronymic is required</span>
                                    <span class="md-error" v-else-if="!$v.form.patronymic.minLength">Invalid patronymic</span>
                                </md-field>
                            </div>
                        </div>
                        <div class="md-layout md-gutter">
                            <div class="md-layout-item md-small-size-100">
                                <md-field :class="getValidationClass('role')">
                                    <md-select name="role" v-model="user.role" md-dense :disabled="sending">
                                        <md-option v-for="role in roles" v-bind:value="role.id">
                                            {{ role.name }}
                                        </md-option>
                                    </md-select>
                                    <span class="md-error">The role is required</span>
                                </md-field>
                            </div>
                        </div>
                    </md-card-content>

                    <md-progress-bar md-mode="indeterminate" v-if="sending" />

                    <md-card-actions>
                        <md-button type="submit" class="md-primary" :disabled="sending">save</md-button>
                    </md-card-actions>
                </md-card>

                <!--<md-snackbar :md-active.sync="userSaved">The user {{ lastUser }} was saved with success!</md-snackbar>-->
            </form>
        </md-dialog>

    </div>
</template>

<script>
    import { validationMixin } from 'vuelidate'
    import { required, minLength } from 'vuelidate/lib/validators'
    import axios from 'axios'

    export default {
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
                    first_name: null,
                    last_name: null,
                    patronymic: null,
                    role: null,
                },
                userSaved: false,
                sending: false,
            };
        },
        validations: {
            form: {
                first_name: {
                    required,
                    minLength: minLength(3)
                },
                last_name: {
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
                this.form.first_name = null;
                this.form.last_name = null;
                this.form.patronymic = null;
                this.form.role = null;
            },
            saveUser () {
                this.sending = true;

                // Instead of this timeout, here you can call your API
                window.setTimeout(() => {
                    this.lastUser = `${this.form.first_name} ${this.form.last_name}`;
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
    }

</script>
