<template>
    <div>
        <nav class="navbar navbar-expand-lg bg-white border-bottom navbar-light">
            <router-link class="navbar-brand me-auto" :to="{ name: 'home'}">Airbnb</router-link>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link class="nav-link" :to="{name: 'basket'}">
                        Basket
                        <span v-if="itemsInBasket" class="btn btn-xs py-0 px-1 btn-secondary">{{ itemsInBasket }}</span>
                    </router-link>
                </li>
                <li class="nav-item" v-if="!isLoggedIn">
                    <router-link :to="{name: 'register'}" class="nav-link">Register</router-link>
                </li>
                <li class="nav-item" v-if="!isLoggedIn">
                    <router-link :to="{name: 'login'}" class="nav-link">Sign-in</router-link>
                </li>
                <li class="nav-item" v-if="isLoggedIn">
                    <a href="#" @click.prevent="logout" class="nav-link">Logout</a>
                </li>
            </ul>

        </nav>
        <div class="container mt-4 mb-4 ps-4 pe-4">
            <router-view></router-view>
        </div>

    </div>
</template>

<script>
import {mapState, mapGetters} from "vuex";
import {logout} from "./shared/utils/auth.js";

export default {
    name: "Index",
    data(){
        return {
            lastSearch: this.$store.state.lastSearch
        }
    },
    computed: {
        ...mapState({
            lastSearchComputed: "lastSearch",
            isLoggedIn: "isLoggedIn"
        }),
        ...mapGetters({
            itemsInBasket: 'itemsInBasket'
        }),
        somethingElse(){
            return 1 + 3
        }
    },
    methods:{
        async logout(){
            try{
                await axios.post('/logout')
                // logout()
                this.$store.dispatch('logout')
            }catch (err){
                this.$store.dispatch('logout')
            }
        }
    }
}
</script>

<style scoped>

</style>
