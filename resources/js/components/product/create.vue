<template>
    <section class="py-5 container">
        <div class="row">
            <h4 class="mb-3">Crear Producto</h4>
            <div class="alert alert-danger" role="alert" v-if="errors.length !== 0">
                <ul class="mb-0">
                    <li v-for="(errorArray, idx) in errors" :key="idx">
                        <div v-for="(allErrors, idx) in errorArray" :key="idx">
                            {{allErrors}}
                        </div>
                    </li>
                </ul>
            </div>
            <div class="card w-75">
                <div class="card-body">
                    <form class="needs-validation" @submit.prevent="storeProduct">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="category_id" class="form-label">Categoría</label>
                                <select id="category_id" v-model="form.category_id" class="form-control" required>
                                    <option value="">Selecciona una opción</option>
                                    <option :value="category.id" v-for="category in categories" :key="category.id">{{ category.name }}</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="sku" class="form-label">SKU</label>
                                <input type="text" class="form-control" id="sku" v-model="form.sku" required>
                            </div>

                            <div class="col-12">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="name" v-model="form.name" required>
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea class="form-control" id="description" cols="3" v-model="form.description" required></textarea>
                            </div>

                            <div class="col-12">
                                <label for="price" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="price" min="0"  v-model="form.price" required>
                            </div>

                            <div class="col-12">
                                <label for="quantity" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="quantity" min="0"  v-model="form.quantity" required>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="form.stock" id="stock">
                                    <label class="form-check-label" for="stock">
                                        Estado (Disponibilidad)
                                    </label>
                                </div>
                            </div>

                        </div>

                        <hr class="my-4">

                        <button class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-outline-secondary ms-md-3" @click="$router.back()">Regresar</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: 'Create',
        data(){
            return {
                form: {},
                categories: [],
                errors: [],
            }
        },
        mounted() {
            this.setInitialValues(),
            this.getCategories()
        },
        methods: {
            setInitialValues() {
                this.form = {
                    category_id: '',
                    sku: '',
                    name: '',
                    description: '',
                    price: 0,
                    quantity: 0,
                    stock: true,
                }
            },
            getCategories() {
                axios.get('/api/categories').then(response => {
                    this.categories = response.data.data
                }).catch(errors => {
                    this.errors = errors.data
                })
            },
            async storeProduct() {
                let formData = new FormData();
                for (let key in this.form) {
                    formData.append(key, this.form[key]);
                }

                let url = 'http://127.0.0.1:8000/api/products';
                await axios.post(url, formData).then((response) => {
                    if (response.status === 200) {
                        this.setInitialValues()
                    }
                }).catch(error => {
                    console.log(error)
                    this.errors = error.response.data.errors
                })
            }
        }
    }
</script>
