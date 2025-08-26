<template>
  <div>
    <nav style="margin-bottom: 20px;">
      <router-link to="/">Home</router-link> |
      <router-link to="/about">About</router-link>
    </nav>

    <!-- Đây là chỗ vue-router render component -->
    <router-view />
  </div>
</template>

<script setup>
// ở Vue 3 với <script setup> thì không cần import gì thêm cho router-view/router-link
</script>

<style scoped>
nav a {
  margin: 0 8px;
  text-decoration: none;
  color: #42b983;
}
nav a.router-link-active {
  font-weight: bold;
}
</style>