<template>
    <div class="mx-32 mb-5">
        <button class="btn">
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
                <tr>
                    <th>1</th>
                    <td>Cy Ganderton</td>
                    <td>Quality Control Specialist</td>
                    <td>
                        <button class="btn btn-success mr-2">Edit</button>
                        <button class="btn btn-error">Delete</button>
                    </td>
                </tr>
                <!-- row 2 -->
                <tr>
                    <th>2</th>
                    <td>Hart Hagerty</td>
                    <td>Desktop Support Technician</td>
                    <td>
                        <button class="btn btn-success mr-2">Edit</button>
                        <button class="btn btn-error">Delete</button>
                    </td>
                </tr>
                <!-- row 3 -->
                <tr>
                    <th>3</th>
                    <td>Brice Swyre</td>
                    <td>Tax Accountant</td>
                    <td>
                        <button class="btn btn-success mr-2">Edit</button>
                        <button class="btn btn-error">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
// có thể viết script Vue ở đây
</script>

<style scoped>
/* h1 {
  color: #42b983;
} */
</style>