<script setup>
import { ref, onMounted } from 'vue'
import api from '../api'

const health = ref('Checking...')
const topVideos = ref([])
const loading = ref(true)

onMounted(async () => {
  try {
    const res = await api.get('/health')
    health.value = res.data.ok ? '✅ API Connected' : '❌ Offline'

    const topRes = await api.get('/analytics/top-videos')
    topVideos.value = topRes.data
  } catch (e) {
    health.value = '❌ API Offline'
  } finally {
    loading.value = false
  }
})
import { useRouter } from 'vue-router'
const router = useRouter()
function openVideo(id) {
  router.push(`/videos/${id}`)
}
</script>

<template>
  <v-container>
    <!-- System Status -->
    <v-card class="pa-4 mb-6">
      <h2 class="text-h6 mb-2">System Status</h2>
      <p class="text-h5">{{ health }}</p>
    </v-card>

    <!-- Top Videos Analytics -->
    <v-card class="pa-4">
      <h2 class="text-h6 mb-4">Top 5 Videos by Plays</h2>

      <v-skeleton-loader v-if="loading" type="list-item@5" />

      <v-list v-else two-line>
        <v-list-item
          v-for="v in topVideos"
          :key="v.video_id"
          class="border-b"
        >
          <template #prepend>
            <v-avatar color="deep-purple-accent-4" class="mr-3">
              <span class="text-white font-bold">
                {{ v.plays }}
              </span>
            </v-avatar>
          </template>

          <v-list-item-title>Video ID: {{ v.video_id }}</v-list-item-title>
          <v-list-item-subtitle>Plays: {{ v.plays }}</v-list-item-subtitle>

          <template #append>
            <v-btn
              variant="text"
              color="primary"
              @click="openVideo(v.video_id)"
            >
              View
            </v-btn>
          </template>
        </v-list-item>

        <v-alert
          v-if="!topVideos.length && !loading"
          type="info"
          class="mt-4"
        >
          No analytics data yet — play some videos!
        </v-alert>
      </v-list>
    </v-card>
  </v-container>
</template>
