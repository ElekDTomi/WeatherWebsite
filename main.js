      function addZero(x, n) {
        while (x.toString().length < n) {
          x = "0" + x;
        }
        return x;
      }

      function myFunction() {
        var d = new Date();
        var x = document.querySelector(".t-time");
        var mo = d.getMonth();
        var mo = mo + 1;
        var da = addZero(d.getDate(), 2);
        var h = addZero(d.getHours(), 2);
        var m = addZero(d.getMinutes(), 2);
        var s = addZero(d.getSeconds(), 2);
        x.innerHTML = mo + "/" + da + " " + h + ":" + m + ":" + s;
      }

      setInterval(myFunction, 1000);