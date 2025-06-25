<svg viewBox="0 0 400 500" xmlns="http://www.w3.org/2000/svg">
    <!-- Paper background with subtle texture -->
    <rect x="50" y="100" width="300" height="350" fill="#ffffff" stroke="#e0e0e0" stroke-width="1"/>
    <pattern id="paperTexture" width="10" height="10" patternUnits="userSpaceOnUse" patternTransform="rotate(45)">
        <rect width="10" height="10" fill="#ffffff"/>
        <path d="M 0,0 L 1,0 L 1,1 L 0,1 Z" fill="#f0f0f0"/>
    </pattern>
    <rect x="50" y="100" width="300" height="350" fill="url(#paperTexture)" opacity="0.3"/>

    <!-- Paper lines -->
    <g stroke="#e6f5e6" stroke-width="1">
        <line x1="50" y1="150" x2="350" y2="150"/>
        <line x1="50" y1="200" x2="350" y2="200"/>
        <line x1="50" y1="250" x2="350" y2="250"/>
        <line x1="50" y1="300" x2="350" y2="300"/>
        <line x1="50" y1="350" x2="350" y2="350"/>
        <line x1="50" y1="400" x2="350" y2="400"/>
    </g>

    <!-- Writing paths for multiple lines -->
    <path id="writingPath1" d="M100,200 C150,180 170,230 200,210 C230,190 240,220 270,200 C300,180 320,210 330,190" stroke="none" fill="none"/>
    <path id="writingPath2" d="M100,250 C140,270 180,240 220,260 C260,280 290,250 330,240" stroke="none" fill="none"/>
    <path id="writingPath3" d="M100,300 C130,290 160,315 190,295 C220,275 250,320 280,300 C310,280 325,300 330,290" stroke="none" fill="none"/>

    <!-- Animated text being written (3 different lines) -->
    <text id="writtenText1" font-family="cursive" font-size="28" fill="#086f08">
        <textPath href="#writingPath1" startOffset="0%">
            Win Your
            <animate id="anim1" attributeName="startOffset" from="0%" to="100%" dur="4s" begin="0s" fill="freeze"/>
        </textPath>
    </text>

    <text id="writtenText2" font-family="cursive" font-size="28" fill="#086f08">
        <textPath href="#writingPath2" startOffset="0%">
            Dream Job
            <animate id="anim2" attributeName="startOffset" from="0%" to="100%" dur="4s" begin="anim1.end" fill="freeze"/>
        </textPath>
    </text>

    <text id="writtenText3" font-family="cursive" font-size="28" fill="#086f08">
        <textPath href="#writingPath3" startOffset="0%">
            Higher Study
            <animate id="anim3" attributeName="startOffset" from="0%" to="100%" dur="4s" begin="anim2.end" fill="freeze"/>
            <animate id="resetAnim" attributeName="startOffset" from="100%" to="100%" dur="0.1s" begin="anim3.end" fill="remove"/>
        </textPath>
    </text>

    <!-- Animation reset trigger -->
    <animate id="restartTrigger"
             attributeName="visibility"
             from="visible" to="visible"
             dur="0.1s"
             begin="resetAnim.end"
             onend="setTimeout(function() {
             document.getElementById('anim1').beginElement();
           }, 1000)"/>

    <!-- Pen -->
    <g id="pen">
        <!-- Pen body -->
        <polygon points="80,170 95,155 110,160 95,175" fill="#228B22" stroke="#1e7a1e" stroke-width="1.5"/>
        <!-- Pen tip -->
        <path d="M80,170 L75,175 L85,185 L95,175 Z" fill="#0d5c0d" stroke="#0d5c0d" stroke-width="1"/>

        <!-- Complex pen movement animation for all three lines -->
        <animateMotion id="penAnim1"
                       path="M100,200 C150,180 170,230 200,210 C230,190 240,220 270,200 C300,180 320,210 330,190"
                       dur="4s"
                       begin="0s"
                       fill="freeze"
                       rotate="auto"/>

        <animateMotion id="penAnim2"
                       path="M100,250 C140,270 180,240 220,260 C260,280 290,250 330,240"
                       dur="4s"
                       begin="penAnim1.end"
                       fill="freeze"
                       rotate="auto"/>

        <animateMotion id="penAnim3"
                       path="M100,300 C130,290 160,315 190,295 C220,275 250,320 280,300 C310,280 325,300 330,290"
                       dur="4s"
                       begin="penAnim2.end"
                       fill="freeze"
                       rotate="auto"/>

        <animateMotion id="penReset"
                       path="M330,290 L100,200"
                       dur="0.01s"
                       begin="penAnim3.end+1s"
                       fill="freeze"
                       rotate="auto"/>
    </g>

    <!-- Ink trails for each line -->
    <path id="inkPath1" d="M0,0" stroke="#18891B" stroke-width="2.5" stroke-linecap="round" fill="none">
        <animate attributeName="d"
                 from="M100,200 L100,200"
                 to="M100,200 C150,180 170,230 200,210 C230,190 240,220 270,200 C300,180 320,210 330,190"
                 dur="4s"
                 begin="0s"
                 fill="freeze"/>
    </path>

    <path id="inkPath2" d="M0,0" stroke="#18891B" stroke-width="2.5" stroke-linecap="round" fill="none">
        <animate attributeName="d"
                 from="M100,250 L100,250"
                 to="M100,250 C140,270 180,240 220,260 C260,280 290,250 330,240"
                 dur="4s"
                 begin="penAnim1.end"
                 fill="freeze"/>
    </path>

    <path id="inkPath3" d="M0,0" stroke="#18891B" stroke-width="2.5" stroke-linecap="round" fill="none">
        <animate attributeName="d"
                 from="M100,300 L100,300"
                 to="M100,300 C130,290 160,315 190,295 C220,275 250,320 280,300 C310,280 325,300 330,290"
                 dur="4s"
                 begin="penAnim2.end"
                 fill="freeze"/>
    </path>

    <!-- Animation reset -->
    <animate
            id="resetAnimation"
            attributeName="visibility"
            from="visible"
            to="visible"
            dur="0.1s"
            begin="penAnim3.end+1s"
            onend="setTimeout(function() {
      document.getElementById('inkPath1').setAttribute('d', 'M0,0');
      document.getElementById('inkPath2').setAttribute('d', 'M0,0');
      document.getElementById('inkPath3').setAttribute('d', 'M0,0');
      document.getElementById('penAnim1').beginElement();
      document.getElementById('anim1').beginElement();
    }, 500)"/>

    <!-- Paper shadow -->
    <rect x="55" y="105" width="300" height="350" fill="none" stroke="#d0d0d0" stroke-width="3" opacity="0.3"/>

    <text x="200" y="70" font-family="Arial, sans-serif" font-size="24" fill="#228B22" text-anchor="middle" font-weight="bold">{{ config('app.name') }}</text>


</svg>