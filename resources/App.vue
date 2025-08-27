<template>
  <div>
    <div class="navbar bg-base-100 shadow-sm">
      <router-link to="/" class="btn btn-ghost text-xl">DevAdmin</router-link>
    </div>
    
    <div role="tablist" class="tabs tabs-box">
      <router-link 
        to="/" 
        role="tab" 
        class="tab"
        :class="{'tab-active' : $route.path === '/'}"
      >
        Dashboard
      </router-link>
      <router-link 
        to="/tags" 
        role="tab" 
        class="tab"
        :class="{'tab-active' : $route.path.startsWith('/tags')}"
      >
        Tags
      </router-link>
    </div>
    <br>
    <!-- Đây là chỗ vue-router render component -->
    <router-view />
  </div>
</template>

<script setup>
// ở Vue 3 với <script setup> thì không cần import gì thêm cho router-view/router-link
</script>
