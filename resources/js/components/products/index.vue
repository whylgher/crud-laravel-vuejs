<template>
    <div class="container">
        <div class="products__list table  my-3">

            <div class="customers__titlebar dflex justify-content-between align-items-center">
                <div class="customers__titlebar--item">
                    <h1 class="my-1">Products</h1>
                </div>
                <div class="customers__titlebar--item">
                    <button class="btn btn-secondary my-1 bg-white" @click="newProduct()">
                        Add Product
                    </button>
                </div>
            </div>

            <div class="table--heading mt-2 products__list__heading " style="padding-top: 20px;background:#FFF">
                <!-- <p class="table--heading--col1">&#32;</p> -->
                <p class="table--heading--col1">image</p>
                <p class="table--heading--col2">
                    Product
                </p>
                <p class="table--heading--col4">Type</p>
                <p class="table--heading--col3">
                    Inventory
                </p>
                <!-- <p class="table--heading--col5">&#32;</p> -->
                <p class="table--heading--col5">actions</p>
            </div>

            <!-- product 1 -->
            <div class="table--items products__list__item" v-for="item in products" :key="item.id"
                v-if="products.length > 0">
                <div class="products__list__item--imgWrapper">
                    <img class="products__list__item--img" v-bind:src=item.photo style="height: 40px;"
                        v-if="item.photo">
                </div>
                <a href="# " class="table--items--col2">
                    {{ item.name }}
                </a>
                <p class="table--items--col2">
                    {{ item.type }}
                </p>
                <p class="table--items--col3">
                    {{ item.quantity }}
                </p>
                <div>
                    <button class="btn-icon btn-icon-success" @click="editProduct(item.id)">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button class="btn-icon btn-icon-danger" @click="deleteProduct(item.id)">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </div>
            </div>

            <div class="table--items products__list__item" v-else>
                <p>Product not found</p>
            </div>

        </div>
    </div>
</template>


<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';


export default {
    name: 'App',
    data() {
        return {
            products: ref([]),
            router: useRouter()
        }
    },

    mounted() {
        this.getAllProducts()
    },
    methods: {
        getAllProducts() {
            var page = '/api/v1/product';
            axios.get(page)
                .then(
                    ({ data }) => {
                        this.products = data['products'];
                    }
                )
        },
        newProduct() {
            this.router.push('/product/new');
        },
        editProduct(id) {
            this.router.push('/product/edit/' + id);
        },
        deleteProduct(id) {
            var page = `/api/v1/product/${id}`;
            Swal.fire({
                title: 'Are you sure?',
                text: "You can't go back",
                icon: 'warnind',
                showCancelButton: true,
                confirmButtonColor: "#3085D6",
                cancelButtonColor: "#D33",
                confirmButtonText: 'Yes, delet it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(page)
                        .then(
                            ({ data }) => {
                                this.getAllProducts();
                                toast.fire({
                                    icon: 'success',
                                    title: 'Product deleted successfully'
                                })
                            }
                        )
                }
            })
        },
    }

}
</script>
