<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bolder">
            Price Breakdown
        </h6>
        <div v-for="(days, price) in price.breakdown" :key="price" class="pb-2 pt-2 border-bottom border-top d-flex justify-content-between">
            <span>{{ days }} X ${{ price }}</span>
            <span>${{ days * price }}</span>
        </div>

        <div class="pt-2 font-weight-bolder d-flex justify-content-between">
            <span>Total</span>
            <span>${{ price.total }}</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "PriceBreakdown",
    props: {
        price: Object
    }
}
</script>

<style scoped>

</style>
