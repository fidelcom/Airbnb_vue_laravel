<template>
    <div class="row">
        <div class="col-md-8 pb-4">
            <div class="card">
                <div class="card-body">
                    <div v-if="!loading">
                        <h2 class="card-title">{{ bookable.title }}</h2>
                        <hr />
                        <article class="card-text">{{ bookable.description }}</article>
                    </div>
                    <div v-else>Loading...</div>
                </div>
            </div>
            <ReviewList :bookable-id="this.$route.params.id" />
        </div>
        <div class="col-md-4 pb-4">
            <Availability :bookable-id="this.$route.params.id" @availability="checkPrice($event)" class="mb-4" />
            <Transition name="fade">
                <PriceBreakdown v-if="price" :price="price" class="mb-4" />
            </Transition>
            <Transition name="fade">
                <button class="btn btn-outline-secondary btn-block" v-if="price" @click="addToBasket" :disabled="inBasketAlready">Book now!</button>
            </Transition>
            <Transition name="fade">
                <button class="btn btn-outline-secondary btn-block" v-if="inBasketAlready" @click="removeFromBasket">Remove from basket</button>
            </Transition>
            <div v-if="inBasketAlready" class="mt-4 text-muted warning">Seems like you've added this object to basket already. If you want to change dates, remove from the basket first.</div>
        </div>
    </div>
</template>

<script>
import Availability from "./Availability.vue";
import ReviewList from "./ReviewList.vue";
import {mapState} from "vuex";
import PriceBreakdown from "./PriceBreakdown.vue";
export default {
    name: "Bookable",
    components: {PriceBreakdown, ReviewList, Availability},
    data(){
        return {
            bookable: null,
            loading: false,
            price: null,
        }
    },
    created() {
        this.loading = true;
        console.log(this.$route.params.id)
        axios.get(`/api/bookables/${this.$route.params.id}`).then(response => {this.bookable = response.data.data, this.loading = false});

    },
    computed: {
        ...mapState({
            lastSearch: "lastSearch",
            // inBasketAlready(state){
            //     if(null == this.bookable){
            //         return false
            //     }
            //     return state.basket.items.reduce((result, item) => result || item.bookable.id === this.bookable.id, false)
            // }
        }),
        inBasketAlready(){
            if(null == this.bookable){
                return false
            }

            return this.$store.getters.inBasketAlready(this.bookable.id)
        }
    },
    methods: {
        async checkPrice(hasAvailability){
            if (!hasAvailability)
            {
                this.price = null
                return
            }

            try{
                this.price = (await axios.get(`/api/bookables/${this.bookable.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`)).data.data
            }catch (err){
                this.price = null
            }
            console.log(hasAvailability)
        },
        addToBasket(){
            // this.$store.commit("addToBasket", {
            this.$store.dispatch("addToBasket", {
                bookable: this.bookable,
                price: this.price,
                dates: this.lastSearch
            })
        },
        removeFromBasket(){
            // this.$store.commit("removeFromBasket", this.bookable.id)
            this.$store.dispatch("removeFromBasket", this.bookable.id)
        }
    }
}
</script>

<style scoped>
    .warning {
        font-size: 0.7rem;
    }
</style>
