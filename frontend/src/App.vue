<script setup>
import { ref, onMounted } from "vue";
import api from "./api";

const health = ref("Checking...");
onMounted(async () => {
  try {
    const res = await api.get("/health");
    health.value = res.data.ok ? "✅ API Connected" : "❌ Offline";
  } catch {
    health.value = "❌ API Offline";
  }
});
</script>

<template>
  <v-app>
    <v-app-bar color="deep-purple accent-4" dark app>
      <v-app-bar-title>REA Video Console {{ health }}</v-app-bar-title>
      <v-spacer />
      <v-btn variant="text" to="/" router>Home</v-btn>
      <v-btn variant="text" to="/listings" router>Listings</v-btn>
      <v-btn variant="text" to="/upload" router>Upload</v-btn>
    </v-app-bar>

    <v-main class="pa-4">
      <router-view />
    </v-main>
  </v-app>
</template>
