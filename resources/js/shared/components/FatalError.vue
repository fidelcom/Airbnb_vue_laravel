<template>
    <div class="text-center error">
        <font-awesome-icon icon="fa fa-bomb" />
        <h1 class="mt-4">We've encountered a problem</h1>
        <h2>Unfortunately, we cannot proceed</h2>
    </div>
</template>

<script>
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
export default {
    name: "fatalError",
    components: {FontAwesomeIcon}
}
</script>

<style scoped>
    .error{
        color: #999;
        font-size: 10rem;
    }
</style>
