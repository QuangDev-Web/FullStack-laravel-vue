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
      return error.response
    }
  }

  return { callApi }
}