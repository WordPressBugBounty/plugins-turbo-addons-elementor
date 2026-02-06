document.addEventListener("DOMContentLoaded", function () {
    var right = document.getElementsByClassName("trad-flip-image-right");
    var si = right.length;
    var z = 1;

    turnRight();

    function turnRight() {
        if (si >= 1) {
            si--;
        } else {
            si = right.length - 1;
            function sttmot(i) {
                setTimeout(function () {
                    right[i].style.zIndex = "auto";
                }, 300);
            }
            for (var i = 0; i < right.length; i++) {
                right[i].className = "trad-flip-image-right";
                sttmot(i);
                z = 1;
            }
        }
        if (right[si]) {
            right[si].classList.add("flip");
            right[si].style.zIndex = ++z;
        }
    }

    function turnLeft() {
        if (si < right.length) {
            si++;
        } else {
            si = 1;
            for (var i = right.length - 1; i > 0; i--) {
                right[i].classList.add("flip");
                right[i].style.zIndex = right.length + 1 - i;
            }
        }
        if (right[si - 1]) {
            right[si - 1].className = "trad-flip-image-right";
            setTimeout(function () {
                right[si - 1].style.zIndex = "auto";
            }, 350);
        }
    }

    // Expose functions globally
    window.turnRight = turnRight;
    window.turnLeft = turnLeft;
});
