<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic|Material+Icons">
        <link rel="stylesheet" href="https://unpkg.com/vue-material@beta/dist/vue-material.min.css">
        <link rel="stylesheet" href="https://unpkg.com/vue-material@beta/dist/theme/default.css">
        <style lang="scss" scoped>
            .md-dialog {
                max-width: 768px;
                min-width: 500px;
                padding: 8px;
            }
            .md-select > select{
                z-index: 10;
            }
        </style>
    </head>
    <body>
    <div id="app">
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
                                @{{ user.id }}
                            </div>
                        </md-table-cell>
                        <md-table-cell>
                            <div @click="selectUser(user)">
                                @{{ user.first_name }} @{{ user.last_name }} @{{ user.patronymic }}
                            </div>
                        </md-table-cell>
                        <md-table-cell>@{{ user.user_roles.name}}</md-table-cell>
                        <md-table-cell>Male</md-table-cell>
                    </md-table-row>
                </md-table>
            </div>
        </template>
        <template>
            <div id="modal">
                <md-dialog :md-active.sync="showDialog">
                    <form novalidate class="md-layout" @submit.prevent="validateUser">
                        <md-card class="md-layout-item md-size-50 md-small-size-100">
                            <md-card-header>
                                <div class="md-title">Users</div>
                            </md-card-header>

                            <md-card-content>
                                <div class="md-layout md-gutter">
                                    <div class="md-layout-item md-small-size-100">
                                        <md-field :class="getValidationClass('firstName')">
                                            <label for="first-name">First Name</label>
                                            <md-input name="first-name" id="first-name" autocomplete="given-name" v-model="user.first_name" :disabled="sending" />
                                            <span class="md-error" v-if="!$v.form.firstName.required">The first name is required</span>
                                            <span class="md-error" v-else-if="!$v.form.firstName.minlength">Invalid first name</span>
                                        </md-field>
                                    </div>
                                </div>

                                <div class="md-layout md-gutter">
                                    <div class="md-layout-item md-small-size-100">
                                        <md-field :class="getValidationClass('lastName')">
                                            <label for="last-name">Last Name</label>
                                            <md-input name="last-name" id="last-name" autocomplete="family-name" v-model="user.last_name" :disabled="sending" />
                                            <span class="md-error" v-if="!$v.form.lastName.required">The last name is required</span>
                                            <span class="md-error" v-else-if="!$v.form.lastName.minlength">Invalid last name</span>
                                        </md-field>
                                    </div>
                                </div>
                                <div class="md-layout md-gutter">
                                    <div class="md-layout-item md-small-size-100">
                                        <md-field :class="getValidationClass('patronymic')">
                                            <label for="patronymic">Patronymic</label>
                                            <md-input name="patronymic" id="patronymic" autocomplete="family-name" v-model="user.patronymic" :disabled="sending" />
                                            <span class="md-error" v-if="!$v.form.lastName.required">The patronymic is required</span>
                                            <span class="md-error" v-else-if="!$v.form.lastName.minlength">Invalid patronymic</span>
                                        </md-field>
                                    </div>
                                </div>
                                <div class="md-layout md-gutter">
                                    <div class="md-layout-item md-small-size-100">
                                        <md-field :class="getValidationClass('role')">
                                            <label for="gender">Gender</label>
                                            <md-select name="role" id="role" v-model="user.role" md-dense :disabled="sending">
                                                <md-option v-for="role in roles" v-bind:value="role.id" :selected="role.id == user.role_id">
                                                    @{{ role.name }}
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

                        {{--<md-snackbar :md-active.sync="userSaved">The user @{{ lastUser }} was saved with success!</md-snackbar>--}}
                    </form>
                </md-dialog>

            </div>
        </template>
    </div>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-material@beta"></script>
    <script src="/js/main.js"></script>
    </body>
</html>
