<template lang="">
    <div class="container">
         <div class="products__create ">

             <div class="products__create__titlebar dflex justify-content-between align-items-center">
                 <div class="products__create__titlebar--item">

                     <h1 class="my-1">Add Product</h1>
                 </div>
                 <div class="products__create__titlebar--item">

                     <button class="btn btn-secondary ml-1" @click="saveProduct()">
                         Save
                     </button>
                 </div>
             </div>

             <div class="products__create__cardWrapper mt-2">
                 <div class="products__create__main">
                     <div class="products__create__main--addInfo card py-2 px-2 bg-white">
                         <p class="mb-1">Name</p>
                         <input type="text" class="input" v-model="form.name">

                         <p class="my-1">Description (optional)</p>
                         <textarea cols="10" rows="5" class="textarea" v-model="form.description"></textarea>

                         <div class="products__create__main--media--images mt-2">
                            <ul class="products__create__main--media--images--list list-unstyled">
                                <li class="products__create__main--media--images--item">
                                    <div class="products__create__main--media--images--item--imgWrapper">
                                        <img class="products__create__main--media--images--item--img" :src="getPhoto()" alt="" />
                                    </div>
                                </li>
                                <!-- upload image small -->
                                <li class="products__create__main--media--images--item">
                                    <form class="products__create__main--media--images--item--form">
                                        <label class="products__create__main--media--images--item--form--label" for="myfile">Add Image</label>
                                        <input class="products__create__main--media--images--item--form--input" type="file" id="myfile" @change="onFileSelected">
                                    </form>
                                </li>
                            </ul>
                        </div>

                     </div>

                 </div>
                 <div class="products__create__sidebar">
                     <!-- Product Organization -->
                     <div class="card py-2 px-2 bg-white">

                         <!-- Product unit -->
                         <div class="my-3">
                             <p>Product type</p>
                             <input type="text" class="input" v-model="form.type">
                         </div>
                         <hr>

                         <!-- Product invrntory -->
                         <div class="my-3">
                             <p>Inventory</p>
                             <input type="text" class="input" v-model="form.quantity">
                         </div>
                         <hr>

                         <!-- Product Price -->
                         <div class="my-3">
                             <p>Price</p>
                             <input type="text" class="input" v-model="form.price">
                         </div>
                     </div>

                 </div>
             </div>
             <!-- Footer Bar -->
             <div class="dflex justify-content-between align-items-center my-3">
                 <p ></p>
                 <button class="btn btn-secondary" @click="saveProduct()">Save</button>
             </div>

     </div>
    </div>
</template>
<script>

import { ref } from 'vue';
import { useRouter } from 'vue-router';

export default {
    data() {
        return {
            selectedFile: null,
            router: useRouter(),
            form: ref({
                name: '',
                description: '',
                photo: '',
                type: '',
                quantity: '',
                price: '',
            }),
        }
    },
    methods: {
        onFileSelected(event) {
            this.selectedFile = event.target.files[0];
            this.updatePhoto(event);
            console.log(this.selectedFile)
        },
        getPhoto() {
            let photo = "/upload/image.png";
            if (this.form.photo) {
                if (this.form.photo.indexOf('base64') != -1) {
                    photo = this.form.photo;
                } else {
                    photo = this.form.photo
                }
            }

            return photo;
        },
        updatePhoto(e) {
            let file = e.target.files[0];
            let reader = new FileReader();
            let limit = 1024 * 1024 * 2;
            if (file['size'] > limit) {
                return false;
            }
            reader.onload = (file) => {
                this.form.photo = reader.result;
            };
            reader.readAsDataURL(file);
        },
        saveProduct() {
            const formData = new FormData();
            formData.append('name', this.form.name);
            formData.append('description', this.form.description);
            formData.append('photo', this.selectedFile);
            formData.append('type', this.form.type);
            formData.append('quantity', this.form.quantity);
            formData.append('price', this.form.price);

            axios.post("/api/v1/product", formData, {
                onUploadProgress: uploadEvent => {
                    console.log('Upload Progress: ' + Math.round(uploadEvent.loaded / uploadEvent.total * 100) + '%')
                }
            })
                .then((response) => {
                    this.form = ref({
                        name: '',
                        description: '',
                        photo: '',
                        type: '',
                        quantity: '',
                        price: '',
                    });
                    this.router.push('/');
                    toast.fire({
                        icon: 'success',
                        title: 'Product add  successfully'
                    })
                })
                .catch((error) => {

                })
        },
    },

}
</script>
<style lang="">

</style>
