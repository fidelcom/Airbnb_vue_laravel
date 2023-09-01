<template>
    <div class="d-flex w-50 m-auto align-items-center">
        <div class="card card-body">
            <form>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" v-model="email" placeholder="Enter your email" :class="[{'is-invalid': errorFor('email')}]">
                    <v-errors :errors="errorFor('email')" />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" v-model="password" placeholder="Enter your password" :class="[{'is-invalid': errorFor('password')}]">
                    <v-errors :errors="errorFor('password')" />
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block" :disabled="loading" @click="login">Login</button>

                <hr>
                <div class="text-nowrap">
                    No account yet?
                    <router-link :to="{name: 'register'}" class="font-weight-bold">Register</router-link>
                </div>

                <div class="text-nowrap">
                    Forgotten password?
                    <router-link to="" class="font-weight-bold">Reset password</router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import validationErrors from "../shared/mixins/validationErrors.js";
import VErrors from "../shared/components/ValidationErrors.vue";
import { login, logout } from "../shared/utils/auth.js";

export default {
    name: "Login",
    components: {VErrors},
    mixins: [validationErrors],
    data(){
        return {
            email: null,
            password: null,
            loading: false
        }
    },
    methods: {
        async login() {
            this.loading = true
            this.errors = null
            try{
                // await axios.get('/sanctum/csrf-cookie');
                await axios.post('/login', {
                    email: this.email,
                    password: this.password
                });
                login()
                this.$store.dispatch("loadUser")
                this.$router.push({name: "home"})
                // router.push({ name: 'home' });
                // await axios.get('/api/user');
            }catch (err){
                this.errors = err.response && err.response.data.errors
            }
            this.loading = false

        }
    }
}
</script>

<style scoped>

</style>
