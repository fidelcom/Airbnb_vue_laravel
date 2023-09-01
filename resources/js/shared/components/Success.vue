<template>
    <div class="text-center success">
        <font-awesome-icon icon="thumbs-up" />
        <h1 class="mt-4">Success</h1>
        <h2>
            <slot></slot>
        </h2>
    </div>
</template>

<script>
export default {
    name: "Success"
}
</script>

<style scoped>
.success{
    color: #999;
    font-size: 10rem;
}
</style>
