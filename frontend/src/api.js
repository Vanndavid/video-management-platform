import axios from "axios";
console.log("API Base URL:", import.meta.env.VITE_API_BASE);
export default axios.create({
  baseURL: import.meta.env.VITE_API_BASE || "https://api.vms.vanndavidteng.com/api",
});
