<template>
    <div>
        <success v-if="success">
            Congratulations!!! Your reservation was successful!
        </success>
        <div class="row" v-else>
            <div class="col-md-8" v-if="itemsInBasket">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="first_name">First Name</label>
                        <input v-model="customer.first_name" type="text" class="form-control" name="first_name" :class="[{'is-invalid': errorFor('customer.first_name')}]">
                        <v-errors :errors="errorFor('customer.first_name')" />
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="last_name">Last Name</label>
                        <input v-model="customer.last_name" type="text" class="form-control" name="last_name" :class="[{'is-invalid': errorFor('customer.last_name')}]">
                        <v-errors :errors="errorFor('customer.last_name')" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="email">Email</label>
                        <input v-model="customer.email" type="email" class="form-control" name="email" :class="[{'is-invalid': errorFor('customer.email')}]">
                        <v-errors :errors="errorFor('customer.email')" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="street">Street</label>
                        <input v-model="customer.street" type="text" class="form-control" name="street" :class="[{'is-invalid': errorFor('customer.street')}]">
                        <v-errors :errors="errorFor('customer.street')" />
                    </div>
                    <div class="col-md-6">
                        <label for="city">City</label>
                        <input v-model="customer.city" type="text" class="form-control" name="city" :class="[{'is-invalid': errorFor('customer.city')}]">
                        <v-errors :errors="errorFor('customer.city')" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="country">County</label>
                        <input v-model="customer.country" type="text" class="form-control" name="country" :class="[{'is-invalid': errorFor('customer.country')}]">
                        <v-errors :errors="errorFor('customer.country')" />
                    </div>
                    <div class="col-md-4">
                        <label for="state">State</label>
                        <input v-model="customer.state" type="text" class="form-control" name="state" :class="[{'is-invalid': errorFor('customer.state')}]">
                        <v-errors :errors="errorFor('customer.state')" />
                    </div>
                    <div class="col-md-2">
                        <label for="zip">Zip</label>
                        <input v-model="customer.zip" type="text" class="form-control" name="zip" :class="[{'is-invalid': errorFor('customer.zip')}]">
                        <v-errors :errors="errorFor('customer.zip')" />
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <button type="submit" class="btn btn-lg btn-primary btn-block" @click.prevent="book" :disabled="loading">Book now!</button>
                    </div>
                </div>
            </div>
            <div class="col-md-8" v-else>
                <div class="jumbotron jumbotron-fluid text text-center">
                    <hi>Empty</hi>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex justify-content-between">
                    <h6 class="text-uppercase text-secondary font-weight-bolder">Your cart</h6>
                    <h6 class="btn btn-secondary btn-xs py-0 text-uppercase">
                        <span v-if="itemsInBasket">Items {{ itemsInBasket }}</span>
                        <span v-else>Empty</span>
                    </h6>
                </div>
                <transition name="slide-fade">
                    <div>
                        <div v-for="item in basket" :key="item.bookable.id">
                            <div class="pt-2 pb-2 border-top d-flex justify-content-between">
                        <span>
                            <router-link :to="{name: 'bookable', params: {id: item.bookable.id}}">{{ item.bookable.title }}</router-link>
                        </span>
                                <span class="font-weight-bolder">${{ item.price.total }}</span>
                            </div>
                            <div class="pt-2 pb-2 d-flex justify-content-between">
                        <span>
                            From {{ item.dates.from }}
                        </span>
                                <span>
                            T0 {{ item.dates.to }}
                        </span>
                            </div>
                            <div class="py-2 text-right">
                                <button class="btn btn-sm btn-outline-secondary" @click="$store.dispatch('removeFromBasket', item.bookable.id)">
                                    <font-awesome-icon icon="fa-trash-alt" />
                                </button>
                            </div>
                        </div>
                    </div>

                </transition>
            </div>
        </div>

    </div>
</template>

<script>
import {mapGetters, mapState} from "vuex";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import validationErrors from "../shared/mixins/validationErrors.js";
import Success from "../shared/components/Success.vue";

export default {
    name: "Basket",
    mixins: [validationErrors],
    data(){
        return {
            customer: {
                first_name: null,
                last_name: null,
                email: null,
                street: null,
                city: null,
                state: null,
                country: null,
                zip: null,
            },
            loading: false,
            bookingAttempted: false
        }
    },
    components: {Success, FontAwesomeIcon},
    computed: {
        ...mapGetters(["itemsInBasket"]),
        ...mapState({
            basket: state => state.basket.items
        }),
        success(){
            return !this.loading && 0 === this.itemsInBasket && this.bookingAttempted
        }
    },
    methods:{
        async book(){
            this.loading = true
            this.errors = null
            this.bookingAttempted = false
            try {
                await axios.post(`/api/checkout`, {
                    customer: this.customer,
                    bookings: this.basket.map(basketItem => ({
                        bookable_id: basketItem.bookable.id,
                        from: basketItem.dates.from,
                        to: basketItem.dates.to
                    }))
                })

                this.$store.dispatch("clearBasket")
                // this.bookingAttempted = true
            }catch(err){
                // console.log(err.response.data.errors)
                this.errors = err.response && err.response.data.errors
            }
            this.loading = false
            this.bookingAttempted = true
        }
    }
}
</script>

<style scoped>
    h6 .badge{
        font-size: 100%;
        color: #0a3622;
    }
    a{
        color: #000000;
    }
</style>
