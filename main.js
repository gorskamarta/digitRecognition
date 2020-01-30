$( document ).ready(function() {
    var canvas = document.getElementById('toRecognize');
    var ctx = canvas.getContext('2d');
    ctx.fillStyle = "#ffffff";
    ctx.fillRect(0, 0, 280, 280);

    var pos = { x: 0, y: 0 };

    document.addEventListener('mousemove', draw);
    document.addEventListener('mousedown', setPosition);
    document.addEventListener('mouseenter', setPosition);

    function setPosition(e) {
        pos.x = e.clientX - canvas.offsetLeft;
        pos.y = e.clientY - canvas.offsetTop;
    }

    function draw(e) {
        if (e.buttons !== 1) return;

        ctx.beginPath(); // begin

        ctx.lineWidth = 20;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000000';

        ctx.moveTo(pos.x, pos.y); // from
        setPosition(e);
        ctx.lineTo(pos.x, pos.y); // to

        ctx.stroke(); // draw it!
    }

    $( "#send" ).click(function() {
        pixelArray = ctx.getImageData(0, 0, 280, 280).data;
        newPixelArray = [];
        for (row = 0; row < 28; row++) {
            for (column = 0; column < 28; column++) {

                pixelValue = 0;
                for (i = row ; i < row+10; i++) {
                    for (j = column ; j < column+10; j++) {
                        nr = (i*280)+j;
                        pixelValue += (pixelArray[nr*4] + pixelArray[(nr*4)+1] + pixelArray[(nr*4)+2]) / 3;
                    }
                }
                newPixelArray[(row*28)+column] = pixelValue/100;
            }
        }

        request = jQuery.post('/vdesk_digit_recognize/recognize.php', {request: newPixelArray});

        request.done(function (data) {
            jQuery('#response').html(data);
        });
    });

    $("#clear").click(function () {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        jQuery('#response').html('');
    });

});
