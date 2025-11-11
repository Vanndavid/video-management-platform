<script setup>
import { ref, onMounted } from 'vue'
import api from '../api'

const health = ref('Checking...')
const topVideos = ref([])
const loading = ref(true)

async function fetchData() {
  try {
    // API health check
    const res = await api.get('/health')
    health.value = res.data.ok ? '✅ API Connected' : '❌ Offline'

    // Get top 5 videos by plays
    const topRes = await api.get('/analytics/top-videos')
    const rows = topRes.data

    // Fetch detailed info (with listing + assets)
    const details = []
    for (const row of rows) {
      const v = await api.get(`/videos/${row.video_id}`)
      details.push({
        ...v.data,
        plays: row.plays,
      })
    }
    topVideos.value = details
  } catch (e) {
    console.error('Error fetching data', e)
    health.value = '❌ API Offline'
  } finally {
    loading.value = false
  }
}

onMounted(fetchData)

async function logPlay(videoId) {
  try {
    await api.post(`/videos/${videoId}/events`, { event_type: 'PLAY' })
  } catch (e) {
    console.warn('Failed to log play event', e)
  }
}
</script>

<template>
  <v-container>
    <!-- Top Videos -->
    <v-card class="pa-4">
      <h2 class="text-h6 mb-4">Top 5 Videos by Plays</h2>

      <v-skeleton-loader v-if="loading" type="list-item@5" />

      <v-row v-else>
        <v-col
          v-for="v in topVideos"
          :key="v.id"
          cols="12"
          md="6"
          lg="4"
        >
          <v-card elevation="3" class="rounded-lg overflow-hidden">
            <v-img
              v-if="v.thumbnail_url"
              :src="v.thumbnail_url"
              height="180"
              cover
            ></v-img>

            <v-card-title class="font-bold">
              {{ v.title }}
            </v-card-title>

            <!-- Listing info -->
            <v-card-subtitle class="text-caption">
              <span v-if="v.listing">
                🏠 {{ v.listing.title }} — {{ v.listing.address }}
              </span>
              <span v-else>
                (No listing info)
              </span>
            </v-card-subtitle>

            <!-- Play stats -->
            <v-card-subtitle class="text-caption mb-1">
              Plays: {{ v.plays }} |
              Status:
              <span :class="v.status === 'READY' ? 'text-success' : 'text-warning'">
                {{ v.status }}
              </span>
            </v-card-subtitle>

            <v-card-text>
              <video
                v-if="v.status === 'READY'"
                :src="v.source_url"
                controls
                width="100%"
                class="rounded"
                @play="logPlay(v.id)"
              />
              <v-alert
                v-else
                type="info"
                class="mt-2"
              >
                Video still processing...
              </v-alert>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>

      <v-alert
        v-if="!topVideos.length && !loading"
        type="info"
        class="mt-4"
      >
        No analytics data yet — play some videos to see them here!
      </v-alert>
    </v-card>
  </v-container>
</template>
