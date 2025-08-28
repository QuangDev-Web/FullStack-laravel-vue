import axios from "axios"

export function useApi() {
  const callApi = async (method, url, dataObj = {}) => {
    try {
      return await axios({
        method,
        url,
        data: dataObj,
      })
    } catch (error) {
      console.log('error')
      return error.response
    }
  }

  return { callApi }
}