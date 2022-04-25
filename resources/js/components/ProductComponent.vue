<template>
    <div class="col-3">
        <div class="card mb-4" style="width: 15rem; height: 25rem;">
            <img :src="`/storage/${product.picture}`" class="card-img-top" :alt="product.name" style="height: 10rem; padding: 1rem;">
            <div class="card-body">
                <h5 class="card-title">
                    {{product.name}}
                </h5>
                <p class="card-text">
                    {{product.description}}
                </p>
                <div class="product-price">
                    {{ product.price }} руб.
                </div>
            </div>
                <div class="card-footer">
                    <div class="row product-buttons">
                        <div class='col-4 text-center'>
                            <button v-if='cartQuantity' @click="cartAction('removeFrom')" class="btn btn-danger">-</button>
                            <button v-else disabled class="btn btn-danger">-</button>
                        </div>
                        <div class='col-4 text-center'>
                            {{ cartQuantity }}
                        </div>
                        <div class='col-4 text-center'>
                            <button @click="cartAction('addTo')" class="btn btn-success">+</button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['product'],
    data () {
    return {
            cartQuantity: this.product.quantity
        }
    },
    methods: {
        cartAction (type) {
            const params = {
                id: this.product.id
            }
            axios.post(`/api/cart/${type}Cart`, params)
                .then(response => {
                    this.cartQuantity = response.data.productQuantity
                    this.$store.dispatch('changeCartProductsQuantity', response.data.cartProductsQuantity)
                })
        }
    }
}
</script>

<style scoped>

</style>