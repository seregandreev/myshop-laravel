<template>
<div>
  <h1>{{pageTitle}}</h1>
      <div class="row">
          <category-component
          v-for='category in categories' 
          :key="category.id"
          :category="category"
          :route-category="routeCategory"
          >
          </category-component>
    </div>
</div>

</template>

<script>
import CategoryComponent from './CategoryComponent.vue'

export default {
  components: { CategoryComponent },
    props: [
        'pageTitle',
        'categories',
        'routeCategory'
    ],
    mounted() {
        //console.log(this.categories)
    }
}
</script>

<style scoped>

</style>