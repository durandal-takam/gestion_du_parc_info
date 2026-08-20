function initSignaturePad(canvasId, hiddenId) {
    var canvas = document.getElementById(canvasId);
    var ctx = canvas.getContext('2d');
    var dessin = false;
    var aTouche = false;

    canvas.addEventListener('mousedown', function (e) { dessin = true; commencer(e.offsetX, e.offsetY); });
    canvas.addEventListener('mousemove', function (e) { if (dessin) tracer(e.offsetX, e.offsetY); });
    document.addEventListener('mouseup', function () { dessin = false; });

    canvas.addEventListener('touchstart', function (e) { e.preventDefault(); dessin = true; aTouche = true; commencer(touchX(e), touchY(e)); });
    canvas.addEventListener('touchmove', function (e) { e.preventDefault(); if (dessin) tracer(touchX(e), touchY(e)); });
    canvas.addEventListener('touchend', function () { dessin = false; });

    function touchX(e) { return e.touches[0].clientX - canvas.getBoundingClientRect().left; }
    function touchY(e) { return e.touches[0].clientY - canvas.getBoundingClientRect().top; }

    function commencer(x, y) { aTouche = true; ctx.beginPath(); ctx.moveTo(x, y); }
    function tracer(x, y) {
        ctx.lineTo(x, y);
        ctx.strokeStyle = '#1e3a5f';
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.stroke();
    }

    document.getElementById('form-fiche').addEventListener('submit', function () {
        document.getElementById(hiddenId).value = aTouche
            ? canvas.toDataURL('image/png').replace('data:image/png;base64,', '')
            : '';
    });

    document.getElementById('btn-effacer-' + canvasId).addEventListener('click', function () {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        aTouche = false;
        document.getElementById(hiddenId).value = '';
    });
}