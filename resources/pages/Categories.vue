<template>
    <div v-if="isLoading" class="text center">Loading categories ...</div>
    <div v-else>
        <div class="mx-32 mb-5">
            <button class="btn" @click="openModal()">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke-width="2.5" 
                    stroke="currentColor" 
                    class="size-[1.2em]">
                <path stroke-linecap="round" 
                        stroke-linejoin="round" 
                        d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Add categories
            </button>
        </div>
    
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 mx-32">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category name</th>
                        <th>Created at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->
                    <tr v-if="categories.length" v-for="(category,i) in categories" :key="category.id">
                        <th>{{ category.id }}</th>
                        <td>{{ category.categoryName }}</td>
                        <td>{{ category.created_at }}</td>
                        <td>
                            <button class="btn btn-success mr-2" @click="openModal(category)">Edit</button>
                            <button 
                                class="btn btn-error" 
                                @click="deleteCategory(category,i)" 
                                :disabled="category.isDeleting"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Category modal -->
    <dialog ref="categoryModal" id="category_add_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">{{ isModalEdit ? 'Editing Category' : 'Adding Category' }}</h3>
            <p class="py-4">{{ isModalEdit ? 'Editing the form to change the Category' : 'Fill the form to add the Category new:' }}</p>
            <div class="modal-action justify-start w-full mt-0">
                <form @submit.prevent="handleSubmit" class="w-full">
                    <label class="floating-label">
                        <span>Category Name</span>
                        <input 
                            type="text" 
                            placeholder="Category Name" 
                            class="input input-md w-full mb-4"  
                            v-model="data.categoryName"
                        />
                    </label>
                    <!-- if there is a button in form, it will close the modal -->
                    <div class="justify-self-end">
                        <button
                            class="btn mr-2 btn-info"
                            :disabled="isAddingOREditing"
                            type="submit"
                        >
                            {{ isAddingOREditing ? 'loading..' : isModalEdit ? 'Edit Category' : 'Add Category'}}
                        </button>
                        <button class="btn" type="button" onclick="category_add_modal.close()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </dialog>
</template>

<script>
import { useApi } from '../js/composables/useApi';
import { useToast } from 'vue-toastification';
const { callApi } = useApi();
const toast = useToast();
export default {
    data() {
        return {
            data: {
                id: null,
                categoryName: ''
            },
            categories: [],
            isLoading: true,
            isModalOpen: false,
            isModalEdit: false,
            isAddingOREditing: false,
        }
    },
    methods: {
        async fetchAllCategories() {
            try {
                const res = await callApi('get','/api/categories');
                if(res.status === 200) {
                    this.categories = res.data;
                }
            } catch (error) {
                toast.error('fetch categories error');
            } finally {
                this.isLoading = false;
            }
        },
        openModal(category) {
            if(category) {
                this.isModalEdit = true;
                this.data = {...category}
            } else {
                this.isModalEdit = false;
                this.data = {id: null, categoryName: ''}
            }
            this.$refs.categoryModal.showModal()
        },
        async addCategory() {
            if(this.data.categoryName.trim() === '') return toast.error('Fill the CategoryName before Add Category');
            this.isAddingOREditing = true
            const res = await callApi('post','/api/categories',this.data)
            if(res.status === 201) {
                this.categories.unshift(res.data);
                this.data.categoryName = '';
                this.isAddingOREditing = false
                category_add_modal.close()
                toast.success('Add Category successfully!')
            } else {
                if(res.status === 422) {
                    toast.error(res.data.message);
                } else {
                    toast.error('Add Category Failed!')
                }
                this.isAddingOREditing = false
            }
        },
        async editCategory() {
            if(this.data.categoryName.trim() === '') return toast.error('Fill the CategoryName before Add Tag');
            this.isAddingOREditing = true
            const res = await callApi('put',`/api/categories/${this.data.id}`,this.data)
            if(res.status === 200) {
                const index = this.categories.findIndex(category => category.id === this.data.id);
                if(index !== -1) {
                    this.categories[index] = JSON.parse(res.config.data);
                }
                this.isAddingOREditing = false
                category_add_modal.close()
                toast.success('Edit Category successfully!')
            } else {
                if(res.status === 422) {
                    toast.error(res.data.message);
                } else {
                    toast.error('Edit Category Failed!')
                }
                this.isAddingOREditing = false
            }
        },
        async handleSubmit() {
            if(this.isModalEdit) {
                await this.editCategory()
            } else {
                await this.addCategory()
            }
        },
        async deleteCategory(category,i) {
            if(!confirm(`Are you sure you want to delete ${category.categoryName} Category?`)) return
            category.isDeleting = true;
            const res = await callApi('delete',`/api/categories/${category.id}`,category)
            if(res.status === 200) {
                this.categories.splice(i,1);
                toast.success('Delete Category successfully!')
            } else {
                toast.error('Delete Category Failed!')
                category.isDeleting = false;
            }
        }
        
    },
    created() {
        this.fetchAllCategories()
    }
    
}
</script>
