const uploadFile = async (file: Blob) => {
  const formData = new FormData()
  formData.append('file', file)

  const url = import.meta.env.VITE_FTP_SERVER_URL + "/api/upload";
  const res = await fetch(url, {
    method: 'POST',
    body: formData,
  })
  const data = await res.json()

  return data 
}

export default uploadFile