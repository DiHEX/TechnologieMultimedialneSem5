<HTML>
<HEAD>
</HEAD>
<BODY>
<div id="layer1" style="position:absolute; left: 10px; top:10px; visibility:visible;">
    <svg xmlns="http://www.w3.org/2000/svg">
        <circle cx="10" cy="10" r="10" fill="red">
            <animate attributeName="cx" from="10" to="200" begin="0s" dur=2s repeatCount=indefinite keyTimes="0;1"/>
        </circle>
    </svg>
</div>
<div id="layer2" style="position:absolute; left: 10px; top:40px; visibility:visible;">
    <svg xmlns="http://www.w3.org/2000/svg">
        <circle cx="10" cy="10" r="10" fill="blue">
            <animate attributeName="cx" from="200" to="10" begin="0s" dur=2s repeatCount=indefinite keyTimes="0;1"/>
        </circle>
    </svg>
</div>
<div id="layer3" style="position:absolute; left: 60px; top:60px; visibility:visible;">
    <svg xmlns="http://www.w3.org/2000/svg">
        <circle cx="10" cy="10" r="10" fill="green">
            <animate attributeName="cy" from="10" to="140" begin="0s" dur=2s repeatCount=indefinite keyTimes="0;1"/>
        </circle>
    </svg>
</div>
<div id="layer4" style="position:absolute; left: 100px; top:60px; visibility:visible;">
    <svg xmlns="http://www.w3.org/2000/svg">
        <circle cx="10" cy="10" r="10" fill="orange">
            <animate attributeName="cy" from="140" to="10" begin="0s" dur=2s repeatCount=indefinite keyTimes="0;1"/>
        </circle>
    </svg>
</div>
</BODY>
</HTML>