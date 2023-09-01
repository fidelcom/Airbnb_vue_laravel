<template>
    <div class="d-flex w-50 m-auto align-items-center">
        <div class="card card-body">
            <form>
                <div class="form-group">
                    <label for="email">Name</label>
                    <input type="text" name="name" class="form-control" v-model="user.name" placeholder="Enter your name" :class="[{'is-invalid': errorFor('name')}]">
                    <v-errors :errors="errorFor('name')" />
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" v-model="user.email" placeholder="Enter your email" :class="[{'is-invalid': errorFor('email')}]">
                    <v-errors :errors="errorFor('email')" />
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" v-model="user.password" placeholder="Enter your password" :class="[{'is-invalid': errorFor('password')}]">
                    <v-errors :errors="errorFor('password')" />
                </div>
                <div class="form-group">
                    <label for="password">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" v-model="user.password_confirmation" placeholder="Confirm your password" :class="[{'is-invalid': errorFor('password_confirmation')}]">
                    <v-errors :errors="errorFor('password_confirmation')" />
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block" :disabled="loading" @click="register">Register</button>

                <hr>
                <div class="text-nowrap">
                    Already have an account?
                    <router-link :to="{name: 'login'}" class="font-weight-bold">Login</router-link>
                </div>

<!--                <div class="text-nowrap">-->
<!--                    Forgotten password?-->
<!--                    <router-link to="" class="font-weight-bold">Reset password</router-link>-->
<!--                </div>-->
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
            user: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
            },
            loading: false
        }
    },
    methods: {
        async register() {
            this.loading = true
            this.errors = null
            try{
                // await axios.get('/sanctum/csrf-cookie');
                const response = await axios.post('/register', this.user);
                if (201 === response.status){
                    login()
                    this.$store.dispatch("loadUser")
                    this.$router.push({name: "home"})
                }
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
