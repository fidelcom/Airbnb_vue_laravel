export default {
    data(){
        return {
            errors: null
        }
    },
    methods:{
        errorFor(err){
            return null != this.errors && this.errors[err] ? this.errors[err] : null
        }
    }
}
