<template>
    <div >
<!--        <div class="row" v-if="error">-->
<!--            Unknown error has occurred, please try again later!-->
<!--        </div>-->
        <success v-if="success" >You've left a review, thank you very much!</success>
        <fatal-error v-if="error" />
        <div class="row" v-if="!success && !error">
            <div :class="[{'col-md-4': twoColumns}, {'d-none': oneColumn}]">
                <div class="card">
                    <div class="card-body">
                        <div v-if="loading">Loading...</div>
                        <div v-if="hasBooking">
                            <div class="card-title">
                                <p>
                                    Stayed at <router-link :to="{name: 'bookable', params: { id: booking.bookable.bookable_id } }">{{ booking.bookable.title }}</router-link>
                                </p>
                                <p>
                                    from {{ booking.from }} to {{ booking.to }}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div :class="[{'col-md-8': twoColumns}, {'col-md-12': oneColumn}]">
                <div v-if="loading">Loading...</div>
                <div v-else>
                    <div v-if="alreadyReviewed">You have already reviewed this booking!</div>
                    <div v-else>
                        <div class="form-group">
                            <label class="text-muted">Select the star rating (1 is worst - 5 is best)</label>
                            <!--            <star-rating :rating="5" class="fa-3x" @rating:changed="onRatingChanged" />-->
                            <!--            <star-rating :rating="review.rating" class="fa-3x" @rating:changed="review.rating = $event" v-model="review.rating" />-->
                            <star-rating :value="review.rating" class="fa-3x" @rating:changed="review.rating = $event" v-model="review.rating" />
                            <!--            <star-rating class="fa-3x" v-model="review.rating" />-->
                        </div>
                        <div class="form-group">
                            <label for="content" class="text-muted">Describe your experience with</label>
                            <textarea name="content" cols="30" rows="10" class="form-control" v-model="review.content" :class="[{'is-invalid': errorFor('content')}]"></textarea>
                            <v-errors :errors="errorFor('content')" />
<!--                            <div class="invalid-feedback" v-for="(error, index) in errorFor('content')" :key="'content' + index">-->
<!--                                {{ error }}-->
<!--                            </div>-->
                        </div>
                        <button class="btn btn-lg btn-primary btn-block" @click.prevent="submit" :disabled="sending">Submit</button>
                    </div>
                </div>
            </div>
        </div>



    </div>
</template>

<script>
import StarRating from "../shared/components/StarRating.vue";
import {is404, is422} from "../shared/utils/response.js";
import FatalError from "../shared/components/FatalError.vue";
import _ from 'lodash';
import VErrors from "../shared/components/ValidationErrors.vue";
import validationErrors from "../shared/mixins/validationErrors.js";
import Success from "../shared/components/Success.vue";
// import axios from 'axios';
export default {
    name: "Review",
    components: {Success, VErrors, FatalError, StarRating},
    mixins: [validationErrors],

    data(){
        return {
            review: {
                id: null,
                rating: 5,
                content: null,
            },
            existingReview: null,
            loading: false,
            booking: null,
            error: false,
            // errors: null,
            sending: false,
            success: false,
            authToken: null,
            // testing: null
        }
    },
    async created() {
        this.review.id = this.$route.params.id
        this.loading = true

        // try {
        //     this.authToken = (await axios.post('https://project.loyaltyview.com/api/auth/login', {
        //         email: 'cojea3018@gmail.com',
        //         password: '45206141Ja.'
        //     })).data.token
        //     try {
        //         const response = await axios.post('https://project.loyaltyview.com/api/cx-transaction/specific-cxs', {
        //             transaction_type_id: 1,
        //             transaction_status_id: 1,
        //         }, {
        //             headers: {
        //                 Authorization: `Bearer ${this.authToken}`
        //             }
        //         })
        //
        //         console.log(response)
        //     }catch (err){
        //         console.log("TXT:" + err)
        //     }
        // }catch (err){
        //     console.log(err)
        // }

        // axios.post('https://project.loyaltyview.com/api/auth/login', {
        //     email: 'cojea3018@gmail.com',
        //     password: '45206141Ja.'
        // }).then(response => {
        //     this.authToken = response.data.token
        //     console.log(this.authToken)
        //     console.log(response)
        //     axios.post('https://project.loyaltyview.com/api/cx-transaction/specific-cxs', {
        //         transaction_type_id: 1,
        //         transaction_status_id: 1,
        //     }, {
        //         headers: {
        //             Authorization: `Bearer ${this.authToken}`
        //         }
        //     })
        //         .then(response => {
        //             console.log(response)
        //         })
        //         .catch(error => {
        //             console.log(error)
        //         });
        //
        // })





        // axios.post('https://project.loyaltyview.com/api/auth/login', {
        //     email: 'cojea3018@gmail.com',
        //     password: '45206141Ja.'
        // })

        // check if review already exist (In reviews table by id)
        try {
            this.existingReview = (await axios.get(`/api/reviews/${this.review.id}`)).data.data
        }catch (err){
            // console.log(err)
            if(is404(err)){
                try {
                    this.booking = (await axios.get(`/api/booking-by-review/${this.review.id}`)).data.data
                }catch (err){
                    console.log(err)
                    this.error = !is404(err)
                }
            }else {
                this.error = true
            }

        }
        this.loading = false

        // axios.get(`/api/reviews/${this.review.id}`)
        //     .then(response => {this.existingReview = response.data.data})
        //     .catch(err => {
        //         // fetch bookings by review key
        //         // if (err.response && err.response.status && 404 === err.response.status)
        //         if (is404(err))
        //         {
        //             return axios.get(`/api/booking-by-review/${this.review.id}`).then(response => {
        //                 this.booking = response.data.data
        //                 // console.log('Booking: ' + this.booking)
        //                 // console.log('Reviewed: ' + this.alreadyReviewed)
        //                 // console.log('has review: ' + this.hasReview)
        //                 // console.log(this.loading)
        //             }).catch(
        //                 (err) => {
        //                     // is404(err) ? {} : (this.error = true);
        //                     this.error = !is404(err)
        //                     // if (!err.response || !err.response.status && 404 !== err.response.status)
        //                     // if (!is404(err))
        //                     // {
        //                     //     this.error = true
        //                     // }
        //                 }
        //             )
        //         }
        //
        //         this.error = true
        //
        //     })
        //     .then(() => {
        //         // console.log(this.booking.booking_id)
        //         // console.log(response)
        //         // console.log('Test: ' + this.testing)
        //         this.loading = false
        //     })
    },
    computed: {
      alreadyReviewed(){
          return this.hasReview || !this.hasBooking
      },
        hasReview(){
            return this.existingReview != null
        },
        hasBooking(){
            return this.booking != null
        },
        oneColumn(){
            return !this.loading && this.alreadyReviewed
        },
        twoColumns(){
            return this.loading || !this.alreadyReviewed
        }
    },

    methods: {

        // store the review
        submit(){
            this.error = null
            this.sending = true
            this.success = false
            axios.post(`/api/reviews`, this.review)
                .then(response => {
                    this.success = 201 === response.status
                    console.log(response)
                })
                .catch((err) => {
                    if (is422(err)){
                        const errors = err.response.data.errors

                        if (errors['content'] && 1 === _.size(errors)){
                            this.errors = errors
                            return
                        }
                    }
                    this.error = true
                })
                .then(() => this.sending = false)
        },
        // errorFor(err){
        //     return null != this.errors && this.errors[err] ? this.errors[err] : null
        // }
    }
}
</script>

<style scoped>

</style>
