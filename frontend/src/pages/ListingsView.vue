<script setup>
import { ref, onMounted } from 'vue'
import api from '../api'

const videos = ref([])

onMounted(async () => {
  const res = await api.get('/listings/1/videos') // single demo listing
  videos.value = res.data
})
</script>

<template>
  <v-container>
    <h2 class="text-h5 mb-4">Videos for Listing #1</h2>

    <v-row>
      <v-col cols="12" md="6" v-for="v in videos" :key="v.id">
        <v-card>
          <v-card-title>{{ v.title }}</v-card-title>
          <v-card-subtitle>Status: {{ v.status }}</v-card-subtitle>
          <v-card-text>
            <video v-if="v.status === 'READY'" :src="v.source_url" controls width="100%" @play="api.post(`/videos/${v.id}/events`, { event_type: 'PLAY' })"/>
          </v-card-text>
          <v-card-actions>
            <v-btn
                variant="text"
                color="primary"
                :to="`/videos/${v.id}`"
            >
                View Details
            </v-btn>
        </v-card-actions>

        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
