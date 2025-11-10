<script setup>
import { ref, onMounted } from "vue"
import { useRoute } from "vue-router"
import api from "../api"

const route = useRoute()
const id = route.params.id
const video = ref(null)
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
  try {
    const res = await api.get(`/videos/${id}`)
    video.value = res.data
  } catch (e) {
    error.value = e.response?.data?.message || e.message
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <v-container>
    <v-card class="pa-6" max-width="800" v-if="!loading && video">
      <h2 class="text-h5 mb-2">{{ video.title }}</h2>
      <p><strong>Status:</strong> {{ video.status }}</p>

      <v-alert
        v-if="video.status === 'PROCESSING'"
        type="info"
        class="mb-3"
      >
        Video is still processing... please wait.
      </v-alert>

      <v-alert
        v-if="video.status === 'FAILED'"
        type="error"
        class="mb-3"
      >
        Processing failed. Try re-uploading.
      </v-alert>

      <video
        v-if="video.status === 'READY'"
        :src="video.source_url"
        controls
        width="100%"
        class="mb-4"
      ></video>

      <v-divider class="my-4" />

      <h3 class="text-h6 mb-2">Assets</h3>
      <v-list>
        <v-list-item
          v-for="asset in video.assets"
          :key="asset.id"
          :title="asset.type"
          :subtitle="asset.url"
        >
          <template #append>
            <v-btn
              size="small"
              variant="text"
              color="primary"
              :href="asset.url"
              target="_blank"
            >
              Open
            </v-btn>
          </template>
        </v-list-item>
      </v-list>

      <v-divider class="my-4" />
      <p class="text-grey">Created: {{ new Date(video.created_at).toLocaleString() }}</p>
    </v-card>

    <v-skeleton-loader v-else-if="loading" type="article" />
    <v-alert v-else-if="error" type="error">{{ error }}</v-alert>
  </v-container>
</template>
