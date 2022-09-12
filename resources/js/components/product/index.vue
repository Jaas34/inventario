<template>

    <section class="py-5 container">
        <div class="row">
            <h4 class="mb-3">Listado de productos</h4>

            <div class="mb-3 d-grid gap-2 d-md-flex justify-content-md-end">
                <router-link class="nav-link" to="/create" tag="button">
                <button class="btn btn-primary me-md-2" type="button">Crear producto</button>
                </router-link>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-center table-striped">
                    <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Nombre</th>
                        <th>Categorías</th>
                        <th>Estado</th>
                        <th>Calificación</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody v-if="products">
                    <tr v-for="(product, index) in products.data" :key="index">
                        <td>{{ product.sku }}</td>
                        <td>{{ product.name }}</td>
                        <td>{{ product.categories }}</td>
                        <td>
                            <span class="badge rounded-pill" :class="product.stock ? 'badge-custom-success' : 'badge-custom-danger'">
                                {{ product.stock ? 'Disponible' : 'No disponible'}}
                            </span>
                        </td>
                        <td v-html="starRating(product.rating)">
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Acciones
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <router-link :to="{name: 'Show', params: {id: product.id}}">
                                            <a class="dropdown-item" href="#">Detalle</a>
                                        </router-link>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Editar</a></li>
                                    <li><a class="dropdown-item" :class="{ disabled : !product.stock }" href="#" v-on:click="setAvailability(product.id)">Marcar sin inventario</a></li>
                                    <li><a class="dropdown-item" href="#" v-on:click="deleteProduct(product.id)">Eliminar</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                    <tbody v-else>
                    <tr>
                        <td colspan="3">Sin resultados</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <pagination :data="products" @pagination-change-page="getProducts"/>
        </div>
    </section>
</template>
<script>
import pagination from 'laravel-vue-pagination';
import { starRating } from '../common/global'
export default {
    name: 'Index',
    components: {
        pagination
    },
    data() {
        return {
            products: {},
            currentPage: 1
        }
    },
    mounted() {
        this.getProducts()
    },
    methods: {
        starRating,
        async getProducts(page = 1) {
            this.currentPage = page;
            axios.get(`/api/products?page=${page}`).then((response) => {
                this.products = response.data.data
            }).catch(error =>{
                alert(error.message)
            })
        },
        async setAvailability(id) {
            await axios.post(`/api/products/${id}/stock`).then((response) => {
                if (response.status === 200) {
                    this.getProducts(this.currentPage)
                }
            }).catch(error => {
                alert(error.message)
            })
        },
        async deleteProduct(id) {
            await axios.delete(`/api/products/${id}`).then((response) => {
                if (response.status === 200) {
                    this.getProducts(this.currentPage)
                }
            }).catch(error => {
                alert(error.message)
            })
        }
    }
}
</script>
