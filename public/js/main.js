Vue.use(VueMaterial.default);
//const axios = require('axios');

const users = [];

new Vue({
    el: '#app',
    data() {
        return {
            roles: [],
            user: [],
            users: [],
            showDialog: false,
            modalVisibility: false
        };
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
        }
    }
});