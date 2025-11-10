import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../pages/HomeView.vue";
import ListingsView from "../pages/ListingsView.vue";
import UploadView from "../pages/UploadView.vue";
import VideoDetailView from "../pages/VideoDetailView.vue";

const routes = [
  { path: "/", name: "home", component: HomeView },
  { path: "/listings", name: "listings", component: ListingsView },
  { path: "/upload", name: "upload", component: UploadView },
  { path: "/videos/:id", name: "video-detail", component: VideoDetailView }, 
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
