<template>
    <div class="mx-32 mb-5">
        <button class="btn" onclick="tag_add_modal.showModal()">
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
                <tr v-if="tags.length" v-for="tag in tags" :key="tag.id">
                    <th>{{ tag.id }}</th>
                    <td>{{ tag.tagName }}</td>
                    <td>{{ tag.created_at }}</td>
                    <td>
                        <button class="btn btn-success mr-2">Edit</button>
                        <button class="btn btn-error">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Tag adding modal -->
    <dialog id="tag_add_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Adding Tag</h3>
            <p class="py-4">Fill the form to add the tag new:</p>
            <div class="modal-action justify-start w-full mt-0">
                <form @submit.prevent="addTag" class="w-full">
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
                            :disabled="isAdding"
                            :loading="isAdding"
                            type="submit"
                        >
                            {{ isAdding ? 'Adding..' : 'Add Tag'}}
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
                tagName: ''
            },
            tags: [],
            isAdding: false,
        }
    },
    methods: {
        async addTag() {
            if(this.data.tagName.trim() === '') return toast.error('Fill the TagName before Add Tag');
            this.isAdding = true
            const res = await callApi('post','/app/create_tag',this.data)
            if(res.status === 201) {
                this.tags.unshift(res.data);
                this.data.tagName = '';
                this.isAdding = false
                tag_add_modal.close()
                toast.success('Add TagName successfully!')
            } else {
                toast.error('Add TagName Failed!')
                this.isAdding = false
            }
        }
    },
    async created() {
        const res = await callApi('get','/app/get_all_tag');
        if(res.status === 200) {
            this.tags = res.data;
        } else {
            toast.error('fetch tags error')
        }
    }
    
}
</script>
