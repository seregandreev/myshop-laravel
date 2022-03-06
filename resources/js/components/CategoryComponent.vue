<template>
        <div class="col-3">
            <div class="card mb-3" style="width: 15rem; height: 25rem;">
                <img :src="`/storage/${category.picture}`" class="card-img-top" :alt="category.name" style="height: 200px">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ category.name }}
                    </h5>
                    <p class="card-text">
                        {{ category.description }}
                    </p>
                </div>
                <div class="card-footer">
                    <a :href="`${routeCategory}/${category.id}`" class="btn btn-primary w-100">Перейти</a>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    props: ['category', 'routeCategory']
}
</script>

<style scoped>

</style>