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

        ctx.lineWidth = 30;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000000';

        ctx.moveTo(pos.x, pos.y); // from
        setPosition(e);
        ctx.lineTo(pos.x, pos.y); // to

        ctx.stroke(); // draw it!
    }

    $( "#send" ).click(function() {

        // $( "#send" ).attr('disabled', true);
        pixelArray = ctx.getImageData(0, 0, 280, 280).data;

        console.log(pixelArray);

        newPixelArray = [];
        for(i = 0; i < pixelArray.length/4; i++) {
            newPixelArray[i] = pixelArray[i*4]
        }

        input = newPixelArray;
        output = [];
        inputSize=280;
        outputSize = 28;
        for (row = 0 ; row < outputSize; row++) {
            for (column = 0 ; column < outputSize ; column++) {

                val = 0;
                for (inputRow = row*(inputSize/outputSize) ; inputRow < (row+1)*(inputSize/outputSize) ; inputRow++) {
                    for (inputColumn = column*(inputSize/outputSize) ; inputColumn < (column+1)*(inputSize/outputSize); inputColumn++) {
                        val += input[inputColumn+(inputRow*inputSize)];
                    }
                }
                output[output.length] = (255 - val/((inputSize/outputSize)*(inputSize/outputSize))) /255*100;

            }
        }
        console.log("Output");
        console.log(output);

        request = jQuery.post('/vdesk_digit_recognize/recognize.php', {request: output});

        request.done(function (data) {
            jQuery('#response').html(data);
            // $( "#send" ).attr('disabled', false);
        });
    });

    $("#clear").click(function () {
        location.reload();
    });

});
