<template>
    <div style="padding: 1.25rem">
        <h6 class="text-uppercase text-secondary font-weight-bolder pt-4">Review List</h6>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <div v-for="(review, index) in reviews" class="border-bottom d-none d-md-block" :key="index">
                <div class="row pt-4">
                    <div class="col-md-6">Name</div>
                    <div class="col-md-6 d-flex justify-content-end">
<!--                        {{ review.rating }}-->
                        <StarRating :value="review.rating" class="fa-lg" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">{{ review.created_at | fromNow }}</div>
                </div>
                <div class="row py-4">
                    <div class="col-md-12">{{ review.content }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import StarRating from "../shared/components/StarRating.vue";
export default {
    name: "ReviewList",
    components: {StarRating},
    props: {
        bookableId: [String, Number],
    },
    data(){
        return {
            loading: false,
            reviews: null,
        }
    },
    created() {
        this.loading = true
        axios.get(`/api/bookables/${this.bookableId}/reviews`).then(response => this.reviews = response.data.data).then(() => this.loading = false)
    },
    filters: {
        fromNow(value){
            return moment.value.fromNow();
        }
    }
}
</script>

<style scoped>

</style>
