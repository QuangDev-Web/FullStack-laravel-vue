<template>
  <div>
    <h1 ref='myref1'>Hello từ Vue 3 Hook Tutorial trong Laravel 10 + Vite 5 🚀</h1>
    <h2 ref='myref2'>name: {{name}}</h2>
    <h3>App increase/decrease Number: </h3>
    <div>Number: {{counter}}</div>
    <br>
    <button @click="changeNumber(1)">Increase</button> |
    <button @click="changeNumber(-1)">Decrease</button>
    <hr>
    <h3>Blogs: </h3>
    <div v-for="(blog) in blogs" :key="blog.id" v-if="blogs.length">
        <h4>{{blog.title}}</h4>
        <p>{{blog.post}}</p>
    </div>
    <div v-else>
        <h4>Don't have blogs any</h4>
    </div>
    <hr>
    <h3>Turn: </h3>
    <div v-if="isOn">On</div>
    <div v-else="isOn">Off</div>
    <br>
    <button @click="changeIsOn()">Turn</button>
  </div>
</template>

<script>
// có thể viết script Vue ở đây
export default {
    data() {
        return {
            name: 'QuangDev',
            counter: 0,
            blogs: [],
            isOn: false
        }
    },
    methods: {
        changeNumber(number) {
            this.counter += number
        },
        changeIsOn() {
            this.isOn = !this.isOn
        }
    },
    // chạy ngay khi component bắt đầu khởi tạo
    // data,method,computed chưa sẵn sàng
    // Hầu như ko dùng trong thực tế
    beforeCreate() {
        console.log('variable name: ', this.name)
    },
    // created là một lifecycle hook (hàm chạy ở một thời điểm nhất định trong vòng đời component).
    // chạy ngay sau khi component được khởi tạo, trước khi render HTML ra DOM.
    // ý nghĩa: created() → dữ liệu (data, methods) đã sẵn sàng, nhưng DOM chưa render.
    // Thường dùng để gọi API, chuẩn bị dữ liệu ban đầu
    created() {
        // call mostly initial data from it ...
        console.log('data and other function is available but not html', this.name)
        this.counter = 10
        let posts = [
            {
                title: "Title of blog 1", post: "The post of blog 1", id: 1
            },
            {
                title: "Title of blog 2", post: "The post of blog 2", id: 2
            },
            {
                title: "Title of blog 3", post: "The post of blog 3", id: 3
            },
            {
                title: "Title of blog 4", post: "The post of blog 4", id: 4
            }
        ]
        this.blogs = posts
    },
    // Chạy trước khi component render ra
    // cũng ít khi dùng
    beforeMount() {

    },
    // Chạy khi DOM đã render -> có thể truy cập và thao tác trực tiếp vào HTML (document.querySelector, ref)
    // Thường dùng cho : thư viện UI bên ngoài như canvas, chart ...
    mounted() {
        console.log('access in DOM: ', this.$refs.myref1)
        console.log('access in DOM: ', this.$refs.myref2)
    },
    // Chạy trước khi dữ liệu reactive thay đổi sẽ làm cập nhật DOM.
    // Có thể kiểm tra giá trị cũ trước khi cập nhật UI.
    beforeUpdate() {

    },
    // Chạy sau khi DOM cập nhật xong khi dữ liệu thay đổi.
    // Thường dùng để xử lý logic phụ thuộc UI sau update.
    updated() {

    },
    // Chạy ngay trước khi component bị gỡ bỏ khỏi DOM.
    // Dùng để dọn dẹp (clearInterval, remove event listener…).
    beforeUnmount() {

    },
    // Component đã gỡ bỏ hoàn toàn.
    unmounted() {

    }
}
</script>

<style scoped>
h1 {
  color: #42b983;
}
</style>