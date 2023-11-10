<template>
  <div>
    <router-view>
      <price />
    </router-view>
  </div>
</template>

<script>
import Price from "./components/Price.vue";
export default {
  name: "App",
  components: {
    Price
  }
};
</script>

