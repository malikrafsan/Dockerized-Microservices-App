function onChange(e) {
  console.log(document.getElementById('input-song-album').value);
}

function createPreview() {
  const audioFile = document.getElementById('input-file-song').files[0];

  const audioURL = URL.createObjectURL(audioFile);

  document.getElementById('audio-preview').setAttribute('src', audioURL);
}

async function submitForm(e) {
  e.preventDefault();

  const lib = new Lib();

  const button = document.getElementById('submit-button');
  button.disabled = true;

  const coverFile = document.getElementById('input-file-cover').files[0];

  let coverUploadResJson;
  if (coverFile) {
    const coverUploadRes = await lib.uploadFile(coverFile, '/api/upload');
    coverUploadResJson = JSON.parse(coverUploadRes);
    if (!coverUploadResJson.success) {
      alert(coverUploadResJson.message);
      return;
    }
  }

  const songFile = document.getElementById('input-file-song').files[0];
  const songUploadRes = await lib.uploadFile(songFile, '/api/upload');
  const songUploadResJson = JSON.parse(songUploadRes);
  if (!songUploadResJson.success) {
    alert(songUploadResJson.message);
    return;
  }

  const duration = document.getElementById('audio-preview').duration;

  const title = document.getElementById('input-song-title').value;
  const artist = document.getElementById('input-song-artist').value;
  const releaseDate = document.getElementById('input-song-release-date').value;
  const genre = document.getElementById('input-song-genre').value;

  const payload = {
    judul: title,
    duration: duration,
    penyanyi: artist,
    tanggal_terbit: releaseDate,
    audio_path: songUploadResJson.data,
  };

  if (coverFile) payload.image_path = coverUploadResJson.data;
  if (genre) payload.genre = genre;

  const res = await lib.post('/api/song/create', payload);
  const json = JSON.parse(res);

  if (json.success === false) {
    alert(json.message);
    button.disabled = false;
  } else {
    alert('Song inserted successfully!');
    window.location.reload();
  }
}
