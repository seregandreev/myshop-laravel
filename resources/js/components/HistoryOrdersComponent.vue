<template>
    <div>
        <div v-if="orders.length < 1" class="alert alert-info" role="alert">
            В истории заказов пусто
        </div>
        <div v-else>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>№ заказа</th>
                        <th>Дата/время</th>
                        <th>Наименование</th>
                        <th>Цена</th>
                        <th>Кол-во</th>
                        <th>Повторить</th>
                    </tr>
                </thead>

            </table>
                <ul v-for="order in orders" :key="order.id">
                    <li v-for="product in order.products" :key="product.id">
                        <span>{{order.id}}</span>
                        <span>{{order.created_at}}</span>
                        <span>{{product.name}}</span>
                        <span>{{product.price}}</span>
                        <span>{{product.description}}</span>
                        <span><button @click="cartAction('addTo')" class="btn btn-success">Повторить</button></span>
                    </li>
                </ul>
        </div>
    </div>  
</template>

<script>
export default {
    props: ['orders', 'orderProducts'],
    data () {
    return {
            //cartQuantity: this.product.quantity
        }
    },
    methods: {
        cartAction (type) {
            const params = {
                id: this.product.id
            }
            axios.post(`/cart/${type}Cart`, params)
                .then(response => {
                    //this.cartQuantity = response.data
                })
        }
    }
}
</script>

<style scoped>

</style>