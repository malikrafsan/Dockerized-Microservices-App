const onPlay = (newTitle, newPath, songId) => {
  const audio = document.getElementsByClassName("song-detail-audio")[0];

  if (!audio.paused) {
    document.getElementById("play-icon").click();
    document.getElementById("audio-title").innerHTML = newTitle;
    const audioPlayerPath = document.querySelector(".song-detail-audio");
    audioPlayerPath.setAttribute("src", newPath);
    document.getElementById("play-icon").click();

  } else {
    document.getElementById("audio-title").innerHTML = newTitle;
    const audioPlayerPath = document.querySelector(".song-detail-audio");
    audioPlayerPath.setAttribute("src", newPath);
    document.getElementById("play-icon").click();
  }
}

function updateAudio() {
  const audioFile =
    document.getElementsByClassName("input-audio-song")[0].files[0];
  const audioURL = URL.createObjectURL(audioFile);
  document.getElementsByClassName("song-detail-audio")[0].src = audioURL;
}

const setBg = () => {
  const randomColor = Math.floor(Math.random() * 16777215).toString(16);
  const content = document.getElementById("content");
  content.style.background =
    "linear-gradient(#" + randomColor + ", transparent)";
};

setBg();

const calculateTime = (secs) => {
  const minutes = Math.floor(secs / 60);
  const seconds = Math.floor(secs % 60);
  const returnedSeconds = seconds < 10 ? `0${seconds}` : `${seconds}`;
  return `${minutes}:${returnedSeconds}`;
};

const controlAudio = () => {
  const btnPlaySrc = "/public/assets/icons/play-icon.svg";
  const btnPauseSrc = "/public/assets/icons/pause-icon.svg";
  const btnUnmuteSrc = "/public/assets/icons/speaker.svg";
  const btnMuteSrc = "/public/assets/icons/speaker-mute.svg";

  const playIconContainer = document.getElementById("play-icon");
  const songListIconPlay = document.getElementsByClassName("song-list-icon-play");
  const audioPlayerContainer = document.getElementById(
    "audio-player-container"
  );
  const audioPlayerImg = document.querySelector(
    ".audio-btn-play-container img"
  );
  const audioMuteImg = document.querySelector("#mute-icon img");
  const seekSlider = document.getElementById("seek-slider");
  const volumeSlider = document.getElementById("volume-slider");
  const muteIconContainer = document.getElementById("mute-icon");
  let playState = "play";
  let muteState = "unmute";

  playIconContainer.addEventListener("click", () => {
    if (playState === "play") {
      audio.play();
      audioPlayerImg.setAttribute("src", btnPauseSrc);
      requestAnimationFrame(whilePlaying);
      playState = "pause";
    } else {
      audio.pause();
      audioPlayerImg.setAttribute("src", btnPlaySrc);
      cancelAnimationFrame(raf);
      playState = "play";
    }
  });

  muteIconContainer.addEventListener("click", () => {
    if (muteState === "unmute") {
      audio.muted = true;
      muteState = "mute";
      audioMuteImg.setAttribute("src", btnMuteSrc);
    } else {
      audio.muted = false;
      muteState = "unmute";
      audioMuteImg.setAttribute("src", btnUnmuteSrc);
    }
  });

  const showRangeProgress = (rangeInput) => {
    if (rangeInput === seekSlider)
      audioPlayerContainer.style.setProperty(
        "--seek-before-width",
        (rangeInput.value / rangeInput.max) * 100 + "%"
      );
    else
      audioPlayerContainer.style.setProperty(
        "--volume-before-width",
        (rangeInput.value / rangeInput.max) * 100 + "%"
      );
  };

  seekSlider.addEventListener("input", (e) => {
    showRangeProgress(e.target);
    // audio.currentTime = 50;
  });
  volumeSlider.addEventListener("input", (e) => {
    showRangeProgress(e.target);
  });

  const audio = document.getElementsByClassName("song-detail-audio")[0];
  const durationContainer = document.getElementById("duration");
  const currentTimeContainer = document.getElementById("current-time");
  const outputContainer = document.getElementById("volume-output");
  let raf = null;

  const calculateTime = (secs) => {
    const minutes = Math.floor(secs / 60);
    const seconds = Math.floor(secs % 60);
    const returnedSeconds = seconds < 10 ? `0${seconds}` : `${seconds}`;
    return `${minutes}:${returnedSeconds}`;
  };

  const displayDuration = () => {
    durationContainer.textContent = calculateTime(audio.duration);
  };

  const setSliderMax = () => {
    seekSlider.max = Math.floor(audio.duration);
  };

  const whilePlaying = () => {
    seekSlider.value = Math.floor(audio.currentTime);
    currentTimeContainer.textContent = calculateTime(seekSlider.value);
    audioPlayerContainer.style.setProperty(
      "--seek-before-width",
      `${(seekSlider.value / seekSlider.max) * 100}%`
    );
    raf = requestAnimationFrame(whilePlaying);
  };

  if (audio.readyState > 0) {
    displayDuration();
    setSliderMax();
  } else {
    audio.addEventListener("loadedmetadata", () => {
      displayDuration();
      setSliderMax();
    });
  }

  seekSlider.addEventListener("input", () => {
    currentTimeContainer.textContent = calculateTime(seekSlider.value);
    if (!audio.paused) {
      cancelAnimationFrame(raf);
    }
  });

  seekSlider.addEventListener("change", () => {
    console.log(seekSlider.value);
    console.log(audio.currentTime);
    audio.currentTime = parseInt(seekSlider.value);
    console.log(audio.currentTime);
    console.log(audio);
    if (!audio.paused) {
      requestAnimationFrame(whilePlaying);
    }
  });

  volumeSlider.addEventListener("input", (e) => {
    const value = e.target.value;

    outputContainer.textContent = value;
    audio.volume = value / 100;
  });

  // audio.currentTime = 100;
};

controlAudio();
