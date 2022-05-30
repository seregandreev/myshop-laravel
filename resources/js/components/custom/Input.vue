<template>
  <input v-model='v' @input="$emit('input', $event.target.value)" class="form-control">
</template>

<script>
export default {
    props: ['val'],
    model: {
        prop: 'val',
        event: 'input'
    },
    data () {
        return {
            v: this.val
        }
    },
    mounted () {
        console.log(this.val)
    }
}
</script>