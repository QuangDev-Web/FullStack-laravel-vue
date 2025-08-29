<template>
    <div v-if="isLoading" class="text center">Loading tags ...</div>
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
                Add tag
            </button>
        </div>
    
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 mx-32">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tag name</th>
                        <th>Created at</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->
                    <tr v-if="tags.length" v-for="(tag,i) in tags" :key="tag.id">
                        <th>{{ tag.id }}</th>
                        <td>{{ tag.tagName }}</td>
                        <td>{{ tag.created_at }}</td>
                        <td>
                            <button class="btn btn-success mr-2" @click="openModal(tag)">Edit</button>
                            <button 
                                class="btn btn-error" 
                                @click="deleteTag(tag,i)" 
                                :disabled="tag.isDeleting"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tag modal -->
    <dialog ref="tagModal" id="tag_add_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">{{ isModalEdit ? 'Editing Tag' : 'Adding Tag' }}</h3>
            <p class="py-4">{{ isModalEdit ? 'Editing the form to change the tag' : 'Fill the form to add the tag new:' }}</p>
            <div class="modal-action justify-start w-full mt-0">
                <form @submit.prevent="handleSubmit" class="w-full">
                    <label class="floating-label">
                        <span>Tag Name</span>
                        <input 
                            type="text" 
                            placeholder="Tag Name" 
                            class="input input-md w-full mb-4"  
                            v-model="data.tagName"
                        />
                    </label>
                    <!-- if there is a button in form, it will close the modal -->
                    <div class="justify-self-end">
                        <button
                            class="btn mr-2 btn-info"
                            :disabled="isAddingOREditing"
                            type="submit"
                        >
                            {{ isAddingOREditing ? 'loading..' : isModalEdit ? 'Edit tag' : 'Add Tag'}}
                        </button>
                        <button class="btn" type="button" onclick="tag_add_modal.close()">Close</button>
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
                tagName: ''
            },
            tags: [],
            isLoading: true,
            isModalOpen: false,
            isModalEdit: false,
            isAddingOREditing: false,
        }
    },
    methods: {
        async fetchAllTags() {
            try {
                const res = await callApi('get','/app/get_all_tag');
                if(res.status === 200) {
                    this.tags = res.data;
                }
            } catch (error) {
                toast.error('fetch tags error');
            } finally {
                this.isLoading = false;
            }
        },
        openModal(tag) {
            if(tag) {
                this.isModalEdit = true;
                this.data = {...tag}
            } else {
                this.isModalEdit = false;
                this.data = {id: null, tagName: ''}
            }
            this.$refs.tagModal.showModal()
        },
        async addTag() {
            if(this.data.tagName.trim() === '') return toast.error('Fill the TagName before Add Tag');
            this.isAddingOREditing = true
            const res = await callApi('post','/app/create_tag',this.data)
            if(res.status === 201) {
                console.log('res.data: ',res.data)
                this.tags.unshift(res.data);
                this.data.tagName = '';
                this.isAddingOREditing = false
                tag_add_modal.close()
                toast.success('Add TagName successfully!')
            } else {
                if(res.status === 422) {
                    toast.error(res.data.message);
                } else {
                    toast.error('Add TagName Failed!')
                }
                this.isAddingOREditing = false
            }
        },
        async editTag() {
            if(this.data.tagName.trim() === '') return toast.error('Fill the TagName before Add Tag');
            this.isAddingOREditing = true
            const res = await callApi('post','/app/edit_tag',this.data)
            if(res.status === 200) {
                const index = this.tags.findIndex(tag => tag.id === this.data.id);
                if(index !== -1) {
                    this.tags[index] = JSON.parse(res.config.data);
                }
                this.isAddingOREditing = false
                tag_add_modal.close()
                toast.success('Edit TagName successfully!')
            } else {
                if(res.status === 422) {
                    toast.error(res.data.message);
                } else {
                    toast.error('Edit TagName Failed!')
                }
                this.isAddingOREditing = false
            }
        },
        async handleSubmit() {
            if(this.isModalEdit) {
                await this.editTag()
            } else {
                await this.addTag()
            }
        },
        async deleteTag(tag,i) {
            if(!confirm(`Are you sure you want to delete ${tag.tagName} tag?`)) return
            tag.isDeleting = true;
            const res = await callApi('post','/app/delete_tag',tag)
            if(res.status === 200) {
                this.tags.splice(i,1);
                toast.success('Delete Tag successfully!')
            } else {
                toast.error('Delete TagName Failed!')
                tag.isDeleting = false;
            }
        }
        
    },
    created() {
        this.fetchAllTags()
    }
    
}
</script>
