const setBg = () => {
  const randomColor = Math.floor(Math.random() * 16777215).toString(16);
  // document.body.style.backgroundColor = "#" + randomColor;
  const content = document.getElementById("content");
  // set backgroundColor linear gradient
  content.style.background =
    "linear-gradient(#" + randomColor + ", transparent)";
};

setBg();
