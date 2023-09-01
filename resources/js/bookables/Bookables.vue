<template>
    <div v-if="bookables">
        <div class="row mb-4" v-for="row in rows" :key="'row' + row">
            <div class="col d-flex align-items-stretch" v-for="(bookable, column) in bookablesInRow(row)"
                 :key="'row' + row + column"
            >
<!--                <bookable-list-item-->
<!--                    :title="bookable.title"-->
<!--                    :description="bookable.description"-->
<!--                    :id="bookable.id" />-->
                <bookable-list-item v-bind="bookable" />
<!--                <table>-->
<!--                    <tr>-->
<!--                        <th>Title</th>-->
<!--                        <th>Description</th>-->
<!--                        <th>Action</th>-->
<!--                    </tr>-->
<!--                    <tr>-->
<!--                        <td>{{ bookable.title }}</td>-->
<!--                        <td>{{ bookable.description }}</td>-->
<!--                        <td>-->
<!--                            <button @click="alert(bookable)"-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                </table>-->
            </div>
            <div class="col" v-for="p in placeholdersInRow(row)" :key="'placeholder' + row + p"></div>
        </div>
    </div>
</template>

<script>
import BookableListItem from "./BookableListItem.vue";
export default {
    components: {BookableListItem},
    data() {
        return {
            bookables: null,
            loading: false,
            columns: 3,
        }
    },
    computed: {
        rows() {
            return this.bookables == null ? 0 : Math.ceil(this.bookables.length / this.columns)
        }
    },
    methods: {
      bookablesInRow(row){
          return this.bookables.slice((row - 1) * this.columns, row * this.columns);
      },
        placeholdersInRow(row){
          return this.columns - this.bookablesInRow(row).length;
        }
    },
    // beforeCreate() {
    //     console.log('before create');
    // },
    created() {
        console.log('created');
        this.loading = true;

        // const p = new Promise((resolve, reject) => {
        //     console.log(resolve);
        //     console.log(reject);
        //     setTimeout(() => resolve("Heello!"), 3000);
        // }).then(result => console.log(`success ${result}`)).catch(result => console.log(`Error ${result}`));
        // console.log(p);

        const request = axios.get('/api/bookables').then(response => this.bookables = response.data.data);
        console.log(request);

        // setTimeout(() => {
        //     this.bookables = [{
        //         title: 'Expensive Villa',
        //         content: 'A very cheap villa!'
        //     },
        //    {
        //         title: 'Expensive Villa',
        //         content: 'A very expensive villa!'
        //     },
        //     {
        //         title: 'Very Expensive Villa',
        //         content: 'A medium expensive villa'
        //     },
        //     {
        //         title: 'Very Expensive Villa',
        //         content: 'A medium expensive villa'
        //     },
        //     {
        //         title: 'Very Expensive Villa',
        //         content: 'A medium expensive villa'
        //     },
        //     {
        //         title: 'Very Expensive Villa',
        //         content: 'A medium expensive villa'
        //     },
        //     {
        //         title: 'Very Expensive Villa',
        //         content: 'A medium expensive villa'
        //     },
        //     {
        //         title: 'Very Expensive Villa',
        //         content: 'A medium expensive villa'
        //     },
        //     {
        //         title: 'Very Expensive Villa',
        //         content: 'A medium expensive villa'
        //     },
        //     ]
        // }, 500)
    },
    // beforeMount() {
    //     console.log('before mount');
    // },
    // mounted() {
    //     console.log('mounted');
    // },
    // beforeUpdate() {
    //     console.log('before update');
    // },
    // updated() {
    //     console.log('updated');
    // },
    // beforeDestroy() {
    //     console.log('before destroy');
    // },
    // destroyed() {
    //     console.log('destroyed')
    // }
}
</script>

<style scoped>

</style>
