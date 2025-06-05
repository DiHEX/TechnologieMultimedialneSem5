<HTML>
<head>
    <Style>
        #rotate
        {
            width:50px; height:50px; background-color:red; margin:10px; float:left;
            transform:translate(-15px,90px) scale(2);transform-origin:0 100%;transition: all 2s ease;
        }
        #rotate:hover { background-color:black; transform:translate(-15px,0px) scale(1) rotate(50deg); }
        #donot_rotate{ width:50px; height:50px; background-color:yellow; margin:10px; float:left; }

        #rotate360
        {
            width:50px; height:50px; background-color:green; margin:10px; float:left;
            transform:translate(-15px,120px) scale(2);transform-origin:0 100%;transition: all 1s ease;
        }
        #rotate360:hover { background-color:black; transform:translate(-15px,0px) scale(1) rotate(360deg); }

        #rotate720
        {
            width:50px; height:50px; background-color:blue; margin:10px; float:left;
            transform:translate(-15px,180px) scale(2);transform-origin:0 100%;transition: all 1s ease;
        }
        #rotate720:hover { background-color:black; transform:translate(-15px,0px) scale(1) rotate(720deg); }

    </Style>
</head>
<body>
<div id="rotate">1</div> <br/>
<div id="rotate">2</div> <br/>
<div id="donot_rotate">3</div> <br/>
<div id="rotate360">4</div> <br/>
<div id="rotate720">5</div> <br/>

</body>
</HTML>