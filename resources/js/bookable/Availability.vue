<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bolder">
            Check availability
            <Transition name="fade">
                <div>
                    <span v-if="noAvailability" class="text-danger"> (Not available)</span>
                    <span v-if="availability" class="text-success"> (Available)</span>
                </div>

            </Transition>

        </h6>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="from">From</label>
                <input type="text"
                       name="from" class="form-control form-control-sm"
                       placeholder="Start date"
                       v-model="from"
                       @keyup.enter="check"
                       :class="[{'is-invalid': errorFor('from')}]"
                >
                <v-errors :errors="errorFor('from')" />
<!--                <div class="invalid-feedback" v-for="(error, index) in this.errorFor('from')" :key="'from' + index">{{ error }}</div>-->
            </div>
            <div class="form-group col-md-6">
                <label for="to">To</label>
                <input type="text" name="to"
                       class="form-control form-control-sm"
                       placeholder="End date"
                       v-model="to"
                       @keyup.enter="check"
                       :class="[{'is-invalid': errorFor('to')}]"
                >
                <v-errors :errors="errorFor('to')" />
<!--                <div class="invalid-feedback" v-for="(error, index) in this.errorFor('to')" :key="'to' + index">{{ error }}</div>-->
            </div>
        </div>
        <button class="btn btn-secondary btn-block" @click="check" :disabled="loading">
            <span v-if="!loading">Check!</span>
            <span v-if="loading"><font-awesome-icon class="fa-spin" icon="fa-circle-notch" />  Checking...</span>
        </button>
    </div>
</template>

<script>
import VErrors from "../shared/components/ValidationErrors.vue";
import validationErrors from "../shared/mixins/validationErrors.js";
export default {
    name: "Availability",
    components: { VErrors},
    mixins: [validationErrors],
    props: {
      bookableId: [String, Number]
    },
    data() {
        return {
            from: this.$store.state.lastSearch.from || null,
            to: this.$store.state.lastSearch.to || null,
            loading: false,
            status: null,
            // errors: null,
        }
    },
    methods: {
        async check(){
            // alert('I will check something now!')
            this.loading = true
            this.errors = null
            // console.log(this.$store)

            this.$store.dispatch('setLastSearch', {
                from: this.from,
                to: this.to
            })

            try {
                this.status = (await axios.get(`/api/bookables/${this.bookableId}/availability?from=${this.from}&to=${this.to}`)).status
                this.$emit("availability", this.availability)
            }catch (error){
                if (422 === error.response.status){
                    this.errors = error.response.data.errors
                }
                this.status = error.response.status
                this.$emit("availability", this.availability)
            }
            this.loading = false
            // axios.get(`/api/bookables/${this.bookableId}/availability?from=${this.from}&to=${this.to}`).
            // then(response =>{
            //     this.status = response.status
            // }).catch(error => {
            //     if (422 === error.response.status){
            //         this.errors = error.response.data.errors
            //     }
            //     this.status = error.response.status
            // }).then(() => this.loading = false)

        },
        // errorFor(field){
        //     // console.log(this.errors)
        //     // console.log(this.status)
        //     return this.hasErrors && this.errors[field] ? this.errors[field] : null
        // }
    },
    computed: {
        hasErrors() {
            return 444 === this.status && this.errors != null
        },
        availability(){
            return 200 === this.status
        },
        noAvailability(){
            return 404 === this.status
        }
    }
}
</script>

<style scoped>
    label {
        font-size: 0.7em;
        text-transform: uppercase;
        color: gray;
        font-weight: bolder;
    }
    .is-invalid {
        border-color: #b22222;
        background-image: none;
    }
</style>
