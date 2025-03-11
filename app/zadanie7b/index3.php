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
    var evtSource = new EventSource('xml_from_db.php');
    evtSource.onmessage = function(e)
    {
        var data = e.data;
        console.log(data);
        var parser = new DOMParser();
        var xmlDoc = parser.parseFromString(e.data.toString().replaceAll("\\n", "\n"), "text/xml");

        x0.textContent = data.toString();
        x1.innerHTML = xmlDoc.getElementsByTagName("x1")[0].childNodes[0].nodeValue;
        x2.innerHTML = xmlDoc.getElementsByTagName("x2")[0].childNodes[0].nodeValue;
        x3.innerHTML = xmlDoc.getElementsByTagName("x3")[0].childNodes[0].nodeValue;
        x4.innerHTML = xmlDoc.getElementsByTagName("x4")[0].childNodes[0].nodeValue;
        x5.innerHTML = xmlDoc.getElementsByTagName("x5")[0].childNodes[0].nodeValue;
    };
    evtSource.onerror = function() { evtSource.close(); console.log('Done!'); };
</script>
</body>
</html>