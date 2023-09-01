<template>
    <div class="d-flex">
<!--        <font-awesome-icon icon="star" v-for="star in fullStar" :key="'full' + star" @click="$emit('input', star)" />-->
        <font-awesome-icon icon="star" v-for="star in fullStar" :key="'full' + star" @click="$emit('rating:changed', star)" />
        <font-awesome-icon icon="fa-solid fa-star-half-alt" v-for="star in halfStar" :key="'half' + star" />
<!--        <font-awesome-icon icon="fa-solid fa-star-half-alt" v-for="star in emptyStar" :key="'empty' + star" @click="$emit('input', fullStar + star)" />-->
        <font-awesome-icon icon="fa-solid fa-star-half-alt" v-for="star in emptyStar" :key="'empty' + star" @click="$emit('rating:changed', fullStar + star)" />
    </div>
</template>

<script>
import {faStar} from "@fortawesome/free-regular-svg-icons";

// defineEmits(['update:modelValue'])
export default {
    name: "StarRating",
    components: {faStar},
    props: {
        value: Number
    },
    computed:{
        halfStar(){
            const fraction = Math.round(this.value - Math.floor(this.value) * 100)
            console.log('Fraction for half:' + fraction)
            return fraction > 0 && fraction < 50
        },
        fullStar(){
            console.log(this.value)
            return Math.round(this.value)
        },
        emptyStar(){
            console.log(this.value)
            return 5 - Math.ceil(this.value)
        }
    },

    // created() {
    //     const numbers = [0.9, 4.0, 4.4, 4.5, 4.6, 4.9];
    //
    //     numbers.forEach(n => {
    //         console.log(`round for ${n} is ${Math.round(n)}`)
    //         console.log(`floor for ${n} is ${Math.floor(n)}`)
    //         console.log(`ceil for ${n} is ${Math.ceil(n)}`)
    //         console.log('===========================================================')
    //     })
    // }
}
</script>

<style scoped>

</style>
