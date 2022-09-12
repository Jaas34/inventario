<template>
    <section class="py-5 container">
        <div class="row">
            <h4 class="mb-3">Detalle - {{product.name}}</h4>

            <div class="mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" class="btn btn-outline-secondary" @click="$router.back()">Regresar</button>
            </div>

            <div class="card mb-3" style="max-width: 80%;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="https://preview.pixlr.com/images/800wm/1464/1/1464166851.jpg" class="img-fluid rounded-start mt-3">
                        <div class="card-body">
                            <label for="rating" class="form-label" >Establecer calificación {{rating}}</label>
                            <input type="range" class="form-range" min="1" max="5" id="rating" v-model="rating" v-on:input="onChangeRating($event)">
                            <button type="button" class="btn btn-warning" :disabled="isRating" v-on:click="setRating(product.id)">
                                <i class="bi bi-heart"></i> Calificar
                            </button>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ product.name }}</h5>
                            <p class="card-text">
                                <small class="text-muted">SKU: {{product.sku}}</small>
                            </p>
                            <p class="card-text">${{ product.price }} -
                                <span v-html="starRating(product.rating)"></span>
                                {{product.rating}} de 5
                            </p>
                            <p class="card-text">
                                <span class="badge rounded-pill" :class="product.stock ? 'badge-custom-success' : 'badge-custom-danger'">
                                    {{ product.stock ? 'Disponible' : 'No disponible'}}
                                </span>
                            </p>
                            <p class="card-text">{{ product.description }}</p>
                            <p class="card-text"><small class="text-muted"> {{product.categories}}</small></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</template>

<script>
    import { starRating } from '../common/global';
    export default {
        name: 'Show',
        data() {
            return {
                product: {},
                rating: 1,
                isRating: false
            }
        },
        mounted() {
            this.getProductById()
        },
        methods: {
            starRating,
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
                this.isRating = true;
                await axios.post(`/api/products/${id}/rating`, {rating: this.rating}).then((response) => {
                    if (response.status === 200) {
                        this.getProductById();
                        setTimeout(() => {
                            this.isRating = false;
                        }, 3000);
                    }
                }).catch(error => {
                    this.isRating = false;
                    alert(error.message)
                })
            }
        }
    }
</script>
