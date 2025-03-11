<html>
<head>
    <style>
        .myDiv { border: 1px outset black; width: auto; }
    </style>
</head>
<body>
<div class=myDiv id='x0'></div> <br />
<div class=myDiv id='x1'></div> <br />
<div class=myDiv id='x2'></div> <br />
<div class=myDiv id='x3'></div> <br />
<div class=myDiv id='x4'></div> <br />
<div class=myDiv id='x5'></div> <br />

<script>
    var evtSource = new EventSource('csv_from_db.php');
    evtSource.onmessage = function(e)
    {
        var data = e.data;
        data = data.split("\t");
        x0.innerHTML = data;
        x1.innerHTML = data[0];
        x2.innerHTML = data[1];
        x3.innerHTML = data[2];
        x4.innerHTML = data[3];
        x5.innerHTML = data[4];
    };
    evtSource.onerror = function() { evtSource.close(); console.log('Done!'); };
</script>
</body>
</html>