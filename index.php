<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@1.0.0/dist/tf.min.js"></script>
    <script type="text/javascript" src="main.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Draw a digit</h1>
        <canvas id="toRecognize" width="280px" height="280px" style="border: solid;black"></canvas>
        <br>
        <button id="send" type="button" class="btn btn-primary">Send</button>
        <button id="clear" type="button" class="btn btn-danger">Clear</button>
        <pre id="response"></pre>
    </div>
</body>
</html>