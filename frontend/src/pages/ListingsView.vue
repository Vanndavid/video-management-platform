<script setup>
import { ref, onMounted } from 'vue'
import api from '../api'

const listings = ref([])

onMounted(async () => {
  try {
    const res = await api.get('/listings')
    listings.value = res.data
  } catch (err) {
    console.error('Failed to fetch listings:', err)
  }
})

async function logPlay(videoId) {
  try {
    await api.post(`/videos/${videoId}/events`, { event_type: 'PLAY' })
  } catch (err) {
    console.error('Failed to log play event:', err)
  }
}
</script>

<template>
  <v-container>
    <h1 class="text-h5 mb-6">All Listings &amp; Videos</h1>

    <v-row v-if="listings.length">
      <v-col
        v-for="listing in listings"
        :key="listing.id"
        cols="12"
      >
        <v-card class="mb-6">
          <v-card-title>
            {{ listing.title }}
          </v-card-title>
          <v-card-subtitle>
            {{ listing.address }}
          </v-card-subtitle>

          <v-divider></v-divider>

          <v-card-text>
            <div v-if="listing.videos.length">
              <v-row>
                <v-col
                  v-for="v in listing.videos"
                  :key="v.id"
                  cols="12"
                  md="6"
                >
                  <v-card variant="outlined">
                    <v-card-title>{{ v.title }}</v-card-title>
                    <v-card-subtitle>
                      Status:
                      <span
                        :class="v.status === 'READY' ? 'text-success' : 'text-warning'"
                      >
                        {{ v.status }}
                      </span>
                    </v-card-subtitle>

                    <v-card-text>
                      <video
                        v-if="v.status === 'READY'"
                        :src="v.source_url"
                        controls
                        width="100%"
                        @play="logPlay(v.id)"
                      />
                      <div v-else class="text-grey mt-2">
                        Processing...
                      </div>
                    </v-card-text>
                  </v-card>
                </v-col>
              </v-row>
            </div>

            <div v-else class="text-grey">
              No videos uploaded yet.
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <div v-else class="text-center mt-10">
      Loading listings...
    </div>
  </v-container>
</template>
