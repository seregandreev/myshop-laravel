<template>
    <div>
        Example!!!asdasd
        <br>
        {{ name }}
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: 'Sergey',
                age: 31
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
<style scoped>

</style>