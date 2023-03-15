async function submitForm(e) {
  e.preventDefault();

  const lib = new Lib();

  const button = document.getElementById('submit-button');
  button.disabled = true;

  const cover = document.getElementById('input-file-cover').files[0];

  const uploadRes = await lib.uploadFile(cover, '/api/upload');
  const uploadResJson = JSON.parse(uploadRes);
  if (!uploadResJson.success) {
    alert(uploadResJson.message);
    return;
  }

  const title = document.getElementById('input-song-title').value;
  const artist = document.getElementById('input-song-artist').value;
  const releaseDate = document.getElementById('input-song-release-date').value;
  const genre = document.getElementById('input-song-genre').value;

  const payload = {
    judul: title,
    penyanyi: artist,
    total_duration: 0,
    image_path: uploadResJson.data,
    tanggal_terbit: releaseDate,
  };

  if (genre) payload.genre = genre;

  const res = await lib.post('/api/album/create', payload);
  const json = JSON.parse(res);

  if (json.success === false) {
    alert(json.message);
    button.disabled = false;
  } else {
    alert('Album inserted successfully!');
    window.location.reload();
  }
}
