<script setup>
import { ref, watchEffect } from "vue"
import api from "../api"

const listingId = ref(1)
const title = ref("")
const file = ref(null)
const loading = ref(false)
const message = ref("")
const video = ref(null)
let pollTimer = null
const snack = ref(false)

async function upload() {
  if (!file.value) {
    message.value = "Please choose a file."
    return
  }
  loading.value = true
  message.value = ""
  const form = new FormData()
  form.append("listing_id", listingId.value)
  form.append("title", title.value)
  form.append("file", file.value)

  try {
    const res = await api.post("/videos", form, {
      headers: { "Content-Type": "multipart/form-data" },
    })
    message.value = `✅ Uploaded: ${res.data.data.title}`
    video.value = res.data.data
    startPolling(video.value.id)
  } catch (err) {
    message.value = `❌ ${err.response?.data?.message || err.message}`
  } finally {
    loading.value = false
  }
}

function startPolling(videoId) {
  clearInterval(pollTimer)
  pollTimer = setInterval(async () => {
    try {
      const res = await api.get(`/videos/${videoId}`)
      video.value = res.data
      if (video.value.status === "READY" || video.value.status === "FAILED") {
        if (video.value.status === "READY") {
          snack.value = true
        }
        clearInterval(pollTimer)
      }
    } catch {
      clearInterval(pollTimer)
    }
  }, 2000)
}
</script>

<template>
  <v-container>
    <v-snackbar v-model="snack" color="green" text="Transcode completed!" />

    <v-card class="pa-4" max-width="500">
      <h2 class="text-h6 mb-4">Upload New Video</h2>
      <v-text-field v-model="listingId" label="Listing ID" type="number" />
      <v-text-field v-model="title" label="Video Title" />
      <v-file-input
        v-model="file"
        label="Select Video File"
        accept="video/*"
        show-size
        prepend-icon="mdi-video"
      />
      <v-btn color="primary" :loading="loading" @click="upload">Upload</v-btn>
      <v-alert v-if="message" class="mt-4" type="info">{{ message }}</v-alert>

      <template v-if="video">
        <v-divider class="my-4"></v-divider>
        <div>
          <p><strong>Status:</strong> {{ video.status }}</p>
          <v-progress-circular
            v-if="video.status === 'PROCESSING'"
            indeterminate
            color="blue"
          />
          <video
            v-if="video.status === 'READY'"
            :src="video.source_url"
            controls
            width="100%"
          ></video>
        </div>
      </template>
    </v-card>
  </v-container>
</template>
