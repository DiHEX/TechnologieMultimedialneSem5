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
    var evtSource = new EventSource('json_from_db.php');
    evtSource.onmessage = function(e)
    {
        var data = e.data;
        console.log(data);
        data = data.split("\t");
        const dataDestringified = JSON.parse(e.data)
        x0.innerHTML = data;
        x1.innerHTML = dataDestringified["x1"];
        x2.innerHTML = dataDestringified["x2"];
        x3.innerHTML = dataDestringified["x3"];
        x4.innerHTML = dataDestringified["x4"];
        x5.innerHTML = dataDestringified["x5"];
    };
    evtSource.onerror = function() { evtSource.close(); console.log('Done!'); };
</script>
</body>
</html>