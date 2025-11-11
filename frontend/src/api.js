import axios from "axios";
export default axios.create({
  baseURL: import.meta.env.VITE_API_BASE || "https://api.vms.vanndavidteng.com/api",
});
