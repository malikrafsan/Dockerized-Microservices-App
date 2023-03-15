const onEdit = () => {
  const nameElmt = document.getElementsByClassName("album-info-name")[0];
  const yearElmt = document.getElementsByClassName("album-info-year")[0];
  const albumChangeContainer = document.getElementsByClassName(
    "album-detail-change-album-wrapper"
  )[0];
  
  const songListDeleteBtnContainer = Array.from(
    document.getElementsByClassName("song-list-delete-btn-container")
  );
  songListDeleteBtnContainer.forEach((e) => {
    e.removeAttribute("hidden");
  });

  albumChangeContainer.removeAttribute("hidden");

  const albumName = nameElmt.innerText;
  const year = yearElmt.innerText;

  const inputAlbumName = document.createElement("input");
  inputAlbumName.setAttribute("type", "text");
  inputAlbumName.setAttribute("value", albumName);
  inputAlbumName.setAttribute("class", "input-album-name");

  const inputDate = document.createElement("input");
  inputDate.setAttribute("type", "date");
  inputDate.setAttribute("class", "input-album-year");
  inputDate.value = year;

  nameElmt.replaceWith(inputAlbumName);
  yearElmt.replaceWith(inputDate);

  const editBtn = document.getElementsByClassName("album-detail-edit-btn")[0];
  editBtn.setAttribute("hidden", true);
  const saveBtn = document.getElementsByClassName("album-detail-save-btn")[0];
  saveBtn.removeAttribute("hidden");
  const cancelBtn = document.getElementsByClassName(
    "album-detail-cancel-btn"
  )[0];
  cancelBtn.removeAttribute("hidden");
  const inputCoverAlbum =
    document.getElementsByClassName("input-cover-album")[0];
  inputCoverAlbum.removeAttribute("hidden");
  const changeAlbumContainer = document.getElementsByClassName(
    "album-detail-change-album-container"
  )[0];
  changeAlbumContainer.removeAttribute("hidden");
};

const onSave = async () => {
  const inputAlbumName = document.getElementsByClassName("input-album-name")[0];
  const inputDate = document.getElementsByClassName("input-album-year")[0];
  const infoArtist = document.getElementsByClassName("album-info-artist")[0];
  const inputCoverAlbum =
    document.getElementsByClassName("input-cover-album")[0];
  const imgAlbumCover = document.getElementsByClassName("album-detail-cover")[0];
  const chosenSong = document.getElementsByClassName("album-detail-select-song")[0];
  const chosenAlbum = document.getElementsByClassName("album-detail-select-album")[0];
  const albumChangeContainer = document.getElementsByClassName(
    "album-detail-change-album-wrapper"
  )[0];

  const songListDeleteBtnContainer = Array.from(document.getElementsByClassName(
    "song-list-delete-btn-container"
  ));
  songListDeleteBtnContainer.forEach((e) => {
    e.setAttribute("hidden", true);
  });

  albumChangeContainer.setAttribute("hidden", true);
  
  const albumName = inputAlbumName.value;
  const year = inputDate.value;
  const artist = infoArtist.innerText.trim();
  const coverAlbum = inputCoverAlbum.files[0];
  const curImagePath = imgAlbumCover.src;
  const chosenSongId = chosenSong.value;
  const chosenAlbumId = chosenAlbum.value;

  const nameElmt = document.createElement("span");
  nameElmt.setAttribute("class", "album-info-name");
  nameElmt.innerText = albumName;

  const yearElmt = document.createElement("span");
  yearElmt.setAttribute("class", "album-info-year");
  yearElmt.innerText = year;

  const artistElmt = document.createElement("span");
  artistElmt.setAttribute("class", "album-info-artist");
  artistElmt.innerText = artist;

  inputAlbumName.replaceWith(nameElmt);
  inputDate.replaceWith(yearElmt);
  // inputArtist.replaceWith(artistElmt);

  const album_id = document.getElementById("album_id").innerText.trim();
  const payload = {
    judul: albumName,
    tanggal_terbit: year,
    penyanyi: artist,
    image_path: curImagePath,
  };

  const lib = new Lib();
  if (coverAlbum) {
    const uploadRes = await lib.uploadFile(coverAlbum, "/api/upload");
    const uploadResJson = JSON.parse(uploadRes);
    console.log("uploadRes", uploadResJson);
    if (!uploadResJson.success) {
      alert(uploadResJson.message);
    }

    const image_path = uploadResJson.data;
    payload.image_path = image_path;
  }

  if (chosenAlbumId && chosenSongId) {
    payload.update_song_id = chosenSongId;
    payload.update_album_id = chosenAlbumId;
  }

  const res = await lib.put("/api/album/" + album_id, payload);
  console.log(res);

  const editBtn = document.getElementsByClassName("album-detail-edit-btn")[0];
  editBtn.removeAttribute("hidden");
  const saveBtn = document.getElementsByClassName("album-detail-save-btn")[0];
  saveBtn.setAttribute("hidden", true);
  const changeAlbumContainer = document.getElementsByClassName(
    "album-detail-change-album-container"
  )[0];
  changeAlbumContainer.setAttribute("hidden", true);
  window.location.reload();
};

const onDelete = async () => {
  const album_id = document.getElementById("album_id").innerText.trim();
  
  const lib = new Lib();
  const res = await lib.delete("/api/album/" + album_id);
  console.log(res);
  window.location.href = "/albums";
};

const onCancel = () => {
  window.location.reload();
};

const onDeleteSong = async (song_id) => {
  const res = await lib.delete("/api/song/" + song_id);
  console.log(res);
  window.location.reload();
}

const setBg = () => {
  const randomColor = Math.floor(Math.random() * 16777215).toString(16);
  // document.body.style.backgroundColor = "#" + randomColor;
  const content = document.getElementById("content");
  // set backgroundColor linear gradient
  content.style.background =
    "linear-gradient(#" + randomColor + ", transparent)";
};

setBg();
