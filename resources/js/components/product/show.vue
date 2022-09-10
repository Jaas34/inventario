<template>
    <section class="py-5 container">
        <div class="row">
            <h4 class="mb-3">Detalle - {{product.name}}</h4>

            <div class="mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" class="btn btn-secondary" @click="$router.back()">Regresar</button>
            </div>

            <div class="card" style="width: 25rem;">
                <img src="https://preview.pixlr.com/images/800wm/1464/1/1464166851.jpg" class="card-img-top mt-3">
                <div class="card-body">
                    <h5 class="card-title">{{ product.name }}</h5>
                    <p class="card-text">{{ product.description }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">SKU: {{product.sku}}</li>
                    <li class="list-group-item">
                        <span class="badge rounded-pill" :class="product.stock ? 'badge-custom-success' : 'badge-custom-danger'">
                            {{ product.stock ? 'Disponible' : 'No disponible'}}
                        </span> {{product.quantity}} unidades
                    </li>
                    <li class="list-group-item">Precio: ${{ product.price }}</li>
                    <li class="list-group-item">Calificación: {{product.rating}} de 5</li>
                    <li class="list-group-item">Categorías: {{product.categories}}</li>
                </ul>
                <div class="card-body">
                    <label for="rating" class="form-label" >Establecer calificación {{rating}}</label>
                    <input type="range" class="form-range" min="1" max="5" id="rating" v-model="rating" v-on:input="onChangeRating($event)">
                    <button type="button" class="btn btn-primary" v-on:click="setRating(product.id)">Calificar</button>
                </div>
            </div>

        </div>
    </section>
</template>

<script>
    export default {
        name: 'Show',
        data() {
            return {
                product: {},
                rating: 1
            }
        },
        mounted() {
            this.getProductById()
        },
        methods: {
            onChangeRating(event) {
                this.rating = event.target.value
            },
            async getProductById() {
                await axios.get(`/api/products/${this.$route.params.id}`).then((response) => {
                    if (response.status === 200) {
                        this.product = response.data.data
                    }
                }).catch(error => {
                    alert('Producto no encontrado: ' + error.message)
                })
            },
            async setRating(id) {
                await axios.post(`/api/products/${id}/rating`, {rating: this.rating}).then((response) => {
                    if (response.status === 200) {
                        this.getProductById()
                    }
                }).catch(error => {
                    alert(error.message)
                })
            }
        }
    }
</script>
