const accept = async (e) => {
  e.preventDefault();
  return submit('accept');
}

const reject = async (e) => {
  e.preventDefault();
  return submit('reject');
}

const subscribe = async (creator_id) => {
  const lib = new Lib();
  const res = await lib.post("/api/subscription", {
    creator_id,
  });
  const json = JSON.parse(res);

  console.log(json);
  window.location.reload();
}

const submit = async (action) => {
  const creatorId = document.getElementById('input-creatorId').value;
  const subscriptionId = document.getElementById('input-subscriptionId').value;

  const data = {
    creatorId,
    subscriptionId,
    action,
  };

  const lib = new Lib();
  const res = await lib.post('/api/subscription', data);
  const json = JSON.parse(res);
  console.log(json);
}
