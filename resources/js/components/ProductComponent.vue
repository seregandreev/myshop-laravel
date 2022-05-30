<template>
    <div class="col-3">
        <div class="card mb-4" style="width: 18rem;">
            <img :src="`/storage/${product.picture}`" class="card-img-top" :alt="product.name">
            <div class="card-body">
                <h5 class="card-title">
                    {{product.name}}
                </h5>
                <p class="card-text">
                    {{ product.description }}
                </p>
                <div class="product-price">
                    {{ product.price }} руб.
                </div>
                <div class="product-buttons">
                    <button v-if='cartQuantity' @click="cartAction('removeFrom')" class="btn btn-danger">-</button>
                    <button v-else disabled class="btn btn-danger">-</button>
                    {{ cartQuantity }}
                    <button @click="cartAction('addTo')" class="btn btn-success">+</button>
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
            cartQuantity: JSON.parse(localStorage.getItem('cart'))[this.product.id] || 0
        }
    },
    methods: {
        cartAction (type) {
            let cart = JSON.parse(localStorage.getItem('cart'))
            if (type == 'addTo') {
                if (!cart)
                    cart = {}
                if (typeof cart[this.product.id] ==  'undefined') {
                    cart[this.product.id] = 1
                } else {
                    cart[this.product.id] += 1
                }
                localStorage.setItem('cart', JSON.stringify(cart))
                this.cartQuantity = cart[this.product.id]
            } else if (type == 'removeFrom') {
                if (cart[this.product.id] == 1) {
                    delete cart[this.product.id]
                } else {
                    cart[this.product.id] -= 1
                }
                localStorage.setItem('cart', JSON.stringify(cart))
                this.cartQuantity = cart[this.product.id] || 0
            }
            let quantity = 0
            for (let key in cart) {
                quantity += cart[key]
            }
            this.$store.dispatch('changecartProductsQuantity', quantity)
        }
    }
}
</script>

<style>
</style>