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
                    v-for="(user, key) in users"
                    :key="user.id"
            >
                <md-table-cell md-numeric>
                    <div @click="selectUser(user, key)">
                        {{ user.id }}
                    </div>
                </md-table-cell>
                <md-table-cell>
                    <div @click="selectUser(user, key)">
                        {{ user.first_name }} {{ user.last_name }} {{ user.patronymic }}
                    </div>
                </md-table-cell>
                <md-table-cell>{{ user.user_roles.name}}</md-table-cell>
                <md-table-cell>Male</md-table-cell>
            </md-table-row>
        </md-table>
        <div id="modal">
        <md-dialog :md-active.sync="showDialog">
            <form novalidate class="md-layout" @submit.prevent="validateUser">
                <md-card class="md-layout-item md-size-50 md-small-size-100">
                    <md-card-header>
                        <div class="md-title">User</div>
                    </md-card-header>

                    <md-card-content>
                        <div class="md-layout md-gutter">
                            <div class="md-layout-item md-small-size-100">
                                <md-field :class="getValidationClass('first_name')">
                                    <label for="first-name">First Name</label>
                                    <md-input name="first_name" id="first-name" v-model="form.first_name" :disabled="sending" />
                                    <span class="md-error" v-if="!$v.form.first_name.required">The first name is required</span>
                                    <span class="md-error" v-else-if="!$v.form.first_name.minLength">Invalid first name</span>
                                </md-field>
                            </div>
                        </div>

                        <div class="md-layout md-gutter">
                            <div class="md-layout-item md-small-size-100">
                                <md-field :class="getValidationClass('last_name')">
                                    <label for="last-name">Last Name</label>
                                    <md-input name="last_name" id="last-name" v-model="form.last_name" :disabled="sending" />
                                    <span class="md-error" v-if="!$v.form.last_name.required">The last name is required</span>
                                    <span class="md-error" v-else-if="!$v.form.last_name.minLength">Invalid last name</span>
                                </md-field>
                            </div>
                        </div>
                        <div class="md-layout md-gutter">
                            <div class="md-layout-item md-small-size-100">
                                <md-field :class="getValidationClass('patronymic')">
                                    <label for="patronymic">Patronymic</label>
                                    <md-input name="patronymic" id="patronymic" v-model="form.patronymic" :disabled="sending" />
                                    <span class="md-error" v-if="!$v.form.patronymic.required">The patronymic is required</span>
                                    <span class="md-error" v-else-if="!$v.form.patronymic.minLength">Invalid patronymic</span>
                                </md-field>
                            </div>
                        </div>
                        <div class="md-layout md-gutter">
                            <div class="md-layout-item md-small-size-100">
                                <md-field :class="getValidationClass('role_id')">
                                    <md-select name="role" v-model="form.role_id" md-dense :disabled="sending">
                                        <md-option v-for="role in roles" v-bind:value="role.id" :key="role.id">
                                            {{ role.name }}
                                        </md-option>
                                    </md-select>
                                    <span class="md-error" v-if="!$v.form.role_id.required">The role is required</span>
                                </md-field>
                            </div>
                        </div>
                    </md-card-content>

                    <md-progress-bar md-mode="indeterminate" v-if="sending" />

                    <md-card-actions>
                        <md-button class="md-primary" @click="showDialog = false">Close</md-button>
                        <md-button type="submit" class="md-primary" :disabled="sending">Save</md-button>
                    </md-card-actions>
                </md-card>

            </form>
        </md-dialog>
            <notifications group="error" position="top right"/>
            <notifications group="success" position="top right"/>
    </div>
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
                users: [],
                showDialog: false,
                modalVisibility: false,
                res : [],
                form: {
                    id: null,
                    first_name: null,
                    last_name: null,
                    patronymic: null,
                    role_id: null,
                },
                key: null,
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
                role_id: {
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
            selectUser(user, key) {
                this.form =  Object.assign({}, user);
                this.key = key;
                this.showDialog = true;
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
                this.form.role_id = null;
            },
            saveUser () {
                axios.put('/api/user/' + this.form.id, {
                    first_name: this.form.first_name,
                    last_name: this.form.last_name,
                    patronymic: this.form.patronymic,
                    role_id: this.form.role_id,
                }).then(response => {
                    this.response = response.data.user;
                    console.log(this.response);
                    this.users[this.key].first_name = this.response.first_name;
                    this.users[this.key].last_name = this.response.last_name;
                    this.users[this.key].patronymic = this.response.patronymic;
                    this.users[this.key].role_id = this.response.role_id;
                    this.users[this.key].user_roles = this.response.user_roles;
                    this.$notify({ group: 'success', text: 'successful user change' });
                })
                    .catch(e => {
                        this.$notify({ group: 'error', text: e });
                    })
                ;

                this.showDialog = false;
            },
            validateUser () {
                this.$v.$touch();
                if (!this.$v.$invalid) {
                    this.saveUser();
                }
            }
        }
    }

</script>

<style lang="scss" scoped>
    .md-dialog {
        max-width: 768px;
        background: #dbd4d4;
        color: #fcfcfc;
        min-width: 500px;
    }
    .md-list.md-theme-default.md-dense > li {
        background: #ffecec;
    }
    .md-layout-item.md-size-50 {
        max-width: 100%;
        flex: 100%;
    }
</style>
