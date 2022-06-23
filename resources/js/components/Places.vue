<template>
    <div class="container my5">
        <h2>Establecimientos</h2>

        <div class="row">
            <div class="col-md-4 mt-4" v-for="place in arrayPlaces" :key="place.id">
                <div class="card">
                    <img class="card-img-top" alt="estableciento" :src="`storage/${place.image}`">
                    <div class="card-body">
                        <h3 class="card-title-text-primary font-weight-bold">{{place.name}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Categories",
    data() {
        return {
            arrayPlaces: [],
        };
    },
    methods: {
        async getCategories(){
            try{
                const data = await fetch("/api/places/");
                const array = await data.json();
                this.arrayPlaces = array;
                console.log(array)
            }catch (error){
                console.log(error);
            }
        }
    },
    created() {
        this.getCategories();
    }
}
</script>

<style scoped>

</style>
