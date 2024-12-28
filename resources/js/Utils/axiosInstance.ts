export const axiosInstance = axios.create({
    headers: {
        'X-Requested-With': 'XMLHttpRequest'
    }
})