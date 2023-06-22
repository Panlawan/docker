<!DOCTYPE html>
<html>
<head>
  <title>Gauge Demo</title>
  <style>
    #gauge {
      width: 200px;
      height: 200px;
      position: relative;
      background-color: lightgray;
      border-radius: 50%;
    }
    
    #gauge::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 100px;
      height: 100px;
      background-color: gray;
      border-radius: 50%;
    }
    
    #gauge::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 90px;
      height: 90px;
      background-color: white;
      border-radius: 50%;
    }
  </style>
</head>
<body>
  <div id="gauge"></div>

  <script>
    function updateGauge(value) {
      var gaugeElement = document.getElementById('gauge');
      var angle = (value / 100) * 360;

      gaugeElement.style.transform = 'rotate(' + angle + 'deg)';
    }

    function fetchData() {
      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'values.php', true);

      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            var value = parseFloat(xhr.responseText);
            updateGauge(value);
          }
        }
      };

      xhr.send();
    }

    // Fetch data immediately
    fetchData();

    // Fetch data every 5 seconds
    setInterval(fetchData, 5000);
  </script>
</body>
</html>
