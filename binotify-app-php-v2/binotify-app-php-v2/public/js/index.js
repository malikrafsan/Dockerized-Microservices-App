alert('this is from js');

const libObj = new Lib();

const fecthMockData = async () => {
  const response = await libObj.promiseAjax('files/mock.json', false);
  const json = JSON.parse(response);
  console.log("res for fetch mock data:", json);

  const p = document.createElement('p');
  p.innerText = JSON.stringify(json)
  document.body.appendChild(p);
}

fecthMockData();
