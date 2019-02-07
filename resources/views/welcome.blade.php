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
                    <md-dialog-title>Profile</md-dialog-title>
                    <md-field>
                        <label>First name</label>
                        <md-input v-model="user.first_name"></md-input>
                    </md-field>
                    <md-field>
                        <label>Last name</label>
                        <md-input v-model="user.last_name"></md-input>
                    </md-field>
                    <md-field>
                        <label>Patronymic</label>
                        <md-input v-model="user.patronymic"></md-input>
                    </md-field>
                    <md-field>
                        <md-select v-model="roles" name="roles" id="roles" placeholder="Roles">
                            <md-option>
                                @{{ roles.name }}
                            </md-option>

                        </md-select>
                    </md-field>

                    <md-dialog-actions>
                        <md-button class="md-primary" @click="showDialog = false">Close</md-button>
                        <md-button class="md-primary" @click="showDialog = false">Save</md-button>
                    </md-dialog-actions>
                </md-dialog>

                <md-button class="md-primary md-raised" @click="showDialog = true">Show Dialog</md-button>
            </div>
        </template>
    </div>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-material@beta"></script>
    <script src="/js/main.js"></script>
    </body>
</html>
