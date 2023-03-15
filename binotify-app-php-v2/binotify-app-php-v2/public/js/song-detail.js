const onEdit = () => {
  const nameElmt = document.getElementsByClassName("song-info-name")[0];
  const yearElmt = document.getElementsByClassName("song-info-year")[0];
  const genreElmt = document.getElementsByClassName("song-info-genre")[0];

  const songName = nameElmt.innerText;
  const year = yearElmt.innerText;
  const genre = genreElmt.innerText;

  const inputSongName = document.createElement("input");
  inputSongName.setAttribute("type", "text");
  inputSongName.setAttribute("value", songName);
  inputSongName.setAttribute("class", "input-song-name");

  const inputDate = document.createElement("input");
  inputDate.setAttribute("type", "date");
  inputDate.setAttribute("class", "input-song-year");
  inputDate.value = year;

  const inputGenre = document.createElement("input");
  inputGenre.setAttribute("type", "text");
  inputGenre.setAttribute("value", genre);
  inputGenre.setAttribute("class", "input-song-genre");

  
  nameElmt.replaceWith(inputSongName);
  yearElmt.replaceWith(inputDate);
  genreElmt.replaceWith(inputGenre);

  const editBtn = document.getElementsByClassName("song-detail-edit-btn")[0];
  editBtn.setAttribute("hidden", true);
  const saveBtn = document.getElementsByClassName("song-detail-save-btn")[0];
  saveBtn.removeAttribute("hidden");
  const cancelBtn = document.getElementsByClassName("song-detail-cancel-btn")[0];
  cancelBtn.removeAttribute("hidden");

  const inputAudioSong = document.getElementsByClassName("input-audio-song")[0];
  inputAudioSong.removeAttribute("hidden");

  const inputCoverSong = document.getElementsByClassName("input-cover-song")[0];
  inputCoverSong.removeAttribute("hidden");

  const songDetailCover = document.getElementsByClassName("song-detail-cover")[0];
  songDetailCover.setAttribute("hidden", true);

  const changeSongContainer = document.getElementsByClassName("song-detail-change-album-container")[0];
  changeSongContainer.removeAttribute("hidden");
};

const onSave = async () => {
  const inputSongName = document.getElementsByClassName("input-song-name")[0];
  const infoArtist = document.getElementsByClassName("song-info-artist")[0];
  const inputDate = document.getElementsByClassName("input-song-year")[0];
  const inputGenre = document.getElementsByClassName("input-song-genre")[0];

  const inputAudioSong = document.getElementsByClassName("input-audio-song")[0];
  const musicAudioSong = document.getElementsByClassName("song-detail-audio")[0];

  const inputCoverSong = document.getElementsByClassName("input-cover-song")[0];
  const imgSongCover = document.getElementsByClassName("song-detail-cover")[0];
  const chosenAlbum = document.getElementsByClassName("song-detail-select-album")[0];

  const songName = inputSongName.value;
  const artist = infoArtist.innerText.trim();
  const year = inputDate.value;
  const genre = inputGenre.value;

  const audioSong = inputAudioSong.files[0];
  const curAudioPath = musicAudioSong.src;
  const curDuration = musicAudioSong.duration;

  const coverSong = inputCoverSong.files[0];
  const curImagePath = imgSongCover.src;
  const curAlbumId = document.getElementById("album_id").innerText.trim();
  const chosenAlbumId = chosenAlbum.value;

  const nameElmt = document.createElement("span");
  nameElmt.setAttribute("class", "song-info-name");
  nameElmt.innerText = songName;

  const artistElmt = document.createElement("span");
  artistElmt.setAttribute("class", "song-info-artist");
  artistElmt.innerText = artist;
  
  const yearElmt = document.createElement("span");
  yearElmt.setAttribute("class", "song-info-year");
  yearElmt.innerText = year;
  
  const genreElmt = document.createElement("span");
  genreElmt.setAttribute("class", "song-info-genre");
  genreElmt.innerText = genre;
  
  inputSongName.replaceWith(nameElmt);
  inputDate.replaceWith(yearElmt);
  inputGenre.replaceWith(genreElmt);

  const song_id = document.getElementById("song_id").innerText.trim();
  const payload = {
    judul: songName,
    penyanyi: artist,
    tanggal_terbit: year,
    genre: genre,
    duration: curDuration,
    audio_path: curAudioPath,
    image_path: curImagePath,
    album_id: curAlbumId,
  };

  const lib = new Lib();
  if (audioSong) {
    const uploadResAS = await lib.uploadFile(audioSong, "/api/upload");
    const uploadResASJson = JSON.parse(uploadResAS);
    console.log("uploadResAS", uploadResASJson);
    if (!uploadResASJson.success) {
      alert(uploadResASJson.message);
    }

    const audio_path = uploadResASJson.data;
    payload.audio_path = audio_path;
  }
  
  if (coverSong) {
    const uploadRes = await lib.uploadFile(coverSong, "/api/upload");
    const uploadResJson = JSON.parse(uploadRes);
    console.log("uploadRes", uploadResJson);
    if (!uploadResJson.success) {
      alert(uploadResJson.message);
    }

    const image_path = uploadResJson.data;
    payload.image_path = image_path;
  }

  if (chosenAlbumId){
    payload.album_id = chosenAlbumId;
  }

  const res = await lib.put("/api/song/" + song_id, payload);
  console.log(res);

  const editBtn = document.getElementsByClassName("song-detail-edit-btn")[0];
  editBtn.removeAttribute("hidden");
  const saveBtn = document.getElementsByClassName("song-detail-save-btn")[0];
  saveBtn.setAttribute("hidden", true);
  const changeSongContainer = document.getElementsByClassName(
    "song-detail-change-album-container"
  )[0];
  changeSongContainer.setAttribute("hidden", true);
  window.location.reload();
};

const onDelete = async () => {
  const song_id = document.getElementById("song_id").innerText.trim();

  const lib = new Lib();
  const res = await lib.delete("/api/song/" + song_id);
  console.log(res);
  window.location.href = "/";
};

const onCancel = () => {
  window.location.reload();
};

const setBg = () => {
  const randomColor = Math.floor(Math.random() * 16777215).toString(16);
  const content = document.getElementById("content");
  content.style.background =
    "linear-gradient(#" + randomColor + ", transparent)";
};

setBg();
