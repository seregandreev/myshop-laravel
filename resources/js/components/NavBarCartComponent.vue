<template>
  <li class="nav-item">
    <a class="nav-link" href="/cart">
        Корзина <span id='cartProductsQuantity'>({{ cartProductsQuantity }})</span>
    </a>
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
      // axios.get('/cart/productsQuantity') 
      //   .then((response) => {
      //     this.$store.dispatch('changeCartProductsQuantity', response.data)
      // }) 
    }

})
</script>

<style scoped>

</style>
