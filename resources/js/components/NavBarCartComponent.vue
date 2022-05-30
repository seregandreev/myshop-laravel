<template>
  <li class="nav-item">
    <router-link class="nav-link" to="/cart">
      Корзина <span id='cartProductsQuantity'>({{ cartProductsQuantity }})</span>
    </router-link>
  </li>
</template>

<script>
export default ({
    computed: {
        cartProductsQuantity () {
            return this.$store.state.cartProductsQuantity
        }
    },

    mounted () {
        let cart = JSON.parse(localStorage.getItem('cart'))
        let quantity = 0
        for (let key in cart) {
            quantity += cart[key]
        }
        this.$store.dispatch('changecartProductsQuantity', quantity)
    }

})
</script>

<style scoped>

</style>
