<template>
    <div class="row" :class="{'m-top': !products.length}">
        <div v-if="!products.length" class="spinner-border text-info" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <product-component 
            v-else
            v-for='product in products' :key="product.id"
            :product="product">
        </product-component>
    </div>
</template>

<script>
import ProductComponent from '../components/ProductComponent.vue'

    export default {
        props: ['category'],
        component: {ProductComponent},
        data() {
            return {
                products: []
            }
        },
        mounted() {
            const id = this.$route.params.id
            axios.get(`/api/category/${id}/getProducts`)
                .then(response => {
                    this.products = response.data
                })
        }
    }
</script>
<style scoped>
    .row {
        justify-content: space-around;
    }
    .m-top {
        margin-top: 30%;
    }
</style>