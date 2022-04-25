import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)
const store = new Vuex.Store({
    state: {
        cartProductsQuantity: 0
    },

    mutations: {
        setCartProductsQuantity(state, data) {
            state.cartProductsQuantity = data
        }
    },

    actions: {
        changeCartProductsQuantity(context, data) {
            context.commit('setCartProductsQuantity', data)
        }
    }
})

export default store
