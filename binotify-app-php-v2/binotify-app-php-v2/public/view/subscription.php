<?php

require_once PROJECT_ROOT_PATH . "/src/utils/SoapWrapper.php";
require_once PROJECT_ROOT_PATH . "/src/services/SubscriptionSrv.php";
require_once PROJECT_ROOT_PATH . "/src/clients/BinotifySoapClient.php";

$srv = SubscriptionSrv::getInstance();
$data = $srv->getSubscriptions();

$dataFromSoap = BinotifySoapClient::getInstance()->getSubscriptions();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>subscriptions:</h1>
  <h1>from local</h1>
  <p><?php echo json_encode($data); ?></p>
  <h1>from soap</h1>
  <p><?php echo json_encode($dataFromSoap) ?></p>
  <div>
    <label for="creatorId">Creator Id<br></label>
    <input type="number" name="creatorId" id="input-creatorId" placeholder="Input Creator Id" required>
    <div class="btn-group">
      <button onclick="subscribe(event)">SUBSCRIBE</button>
    </div>
  </div>

  <script defer async src="public/js/lib.js"></script>
  <script defer async src="public/js/subscription.js"></script>
</body>

</html>