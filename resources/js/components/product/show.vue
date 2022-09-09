<template>
    <section class="py-5 container">
        <div class="row">
            <h4 class="mb-3">Detalle - {{product.name}}</h4>

            <div class="mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" class="btn btn-secondary" @click="$router.back()">Regresar</button>
            </div>

            <div class="card" style="width: 25rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ product.name }}</h5>
                    <p class="card-text">{{ product.description }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">SKU: {{product.sku}}</li>
                    <li class="list-group-item">{{ product.stock ? 'Con existencias' : 'Sin existencias'}} - {{product.quantity}} unidades</li>
                    <li class="list-group-item">Precio: {{ product.price }}</li>
                    <li class="list-group-item">Calificación: 5</li>
                    <li class="list-group-item">Categorías: {{product.categories}}</li>
                </ul>
            </div>

        </div>
    </section>
</template>

<script>
    export default {
        name: 'Show',
        data(){
            return {
                product: {}
            }
        },
        mounted() {
            this.getProductById()
        },
        methods: {
            async getProductById() {
                let url = `http://127.0.0.1:8000/api/products/${this.$route.params.id}`;

                await axios.get(url).then((response) => {
                    if (response.status === 200) {
                        this.product = response.data.data
                    }
                }).catch(error => {
                    alert('Producto no encontrado: ' + error.message)
                })
            }
        }
    }
</script>
