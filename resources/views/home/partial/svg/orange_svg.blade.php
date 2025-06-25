<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 80">
    <!-- Orange Theme: Language Lanterns -->
    <defs>
        <linearGradient id="orangeGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#ff9500" />
            <stop offset="100%" stop-color="#ff6d00" />
        </linearGradient>
        <radialGradient id="glowGradient" cx="50%" cy="50%" r="50%" fx="50%" fy="50%">
            <stop offset="0%" stop-color="#ffbe0b" stop-opacity="0.9" />
            <stop offset="70%" stop-color="#ffbe0b" stop-opacity="0.3" />
            <stop offset="100%" stop-color="#ffbe0b" stop-opacity="0" />
        </radialGradient>

        <!-- Animation definitions -->
        <animate id="floatMotion1" attributeName="cy" from="40" to="37" dur="3s" repeatCount="indefinite" begin="0s" values="40;37;40" keyTimes="0;0.5;1" />
        <animate id="floatMotion2" attributeName="cy" from="30" to="27" dur="4s" repeatCount="indefinite" begin="0.5s" values="30;27;30" keyTimes="0;0.5;1" />
        <animate id="floatMotion3" attributeName="cy" from="50" to="47" dur="3.5s" repeatCount="indefinite" begin="1s" values="50;47;50" keyTimes="0;0.5;1" />
        <animate id="floatMotion4" attributeName="cy" from="60" to="57" dur="2.5s" repeatCount="indefinite" begin="0.2s" values="60;57;60" keyTimes="0;0.5;1" />
    </defs>

    <!-- Night sky background -->
    <rect width="180" height="80" fill="#353535" />

    <!-- Stars -->
    <circle cx="15" cy="15" r="1" fill="white" />
    <circle cx="35" cy="10" r="1" fill="white" />
    <circle cx="55" cy="20" r="1" fill="white" />
    <circle cx="75" cy="12" r="1" fill="white" />
    <circle cx="125" cy="15" r="1" fill="white" />
    <circle cx="145" cy="10" r="1" fill="white" />
    <circle cx="165" cy="20" r="1" fill="white" />
    <circle cx="100" cy="12" r="1" fill="white" />

    <!-- Main lantern -->
    <g>
        <circle cx="90" cy="40" r="20" fill="url(#glowGradient)" opacity="0.5">
            <animate attributeName="cy" from="40" to="37" dur="1s" repeatCount="indefinite" begin="0s" values="40;37;40" keyTimes="0;0.5;1" />
        </circle>
        <ellipse cx="90" cy="40" rx="12" ry="15" fill="url(#orangeGradient)">
            <animate attributeName="cy" from="40" to="37" dur="1s" repeatCount="indefinite" begin="0s" values="40;37;40" keyTimes="0;0.5;1" />
        </ellipse>
        <rect x="86" y="25" width="8" height="3" fill="#ff7b00">
            <animate attributeName="y" from="25" to="22" dur="1s" repeatCount="indefinite" begin="0s" values="25;22;25" keyTimes="0;0.5;1" />
        </rect>
        <path d="M90,25 V15" stroke="#ff7b00" stroke-width="1">
            <animate attributeName="d" from="M90,25 V15" to="M90,22 V12" dur="1s" repeatCount="indefinite" begin="0s" values="M90,25 V15;M90,22 V12;M90,25 V15" keyTimes="0;0.5;1" />
        </path>
    </g>

    <!-- Small floating lanterns -->
    <g>
        <circle cx="40" cy="30" r="15" fill="url(#glowGradient)" opacity="0.3">
            <animate attributeName="cy" from="30" to="27" dur="4s" repeatCount="indefinite" begin="0.5s" values="30;27;30" keyTimes="0;0.5;1" />
        </circle>
        <ellipse cx="40" cy="30" rx="7" ry="9" fill="url(#orangeGradient)">
            <animate attributeName="cy" from="30" to="27" dur="4s" repeatCount="indefinite" begin="0.5s" values="30;27;30" keyTimes="0;0.5;1" />
        </ellipse>
        <rect x="38" y="21" width="4" height="2" fill="#ff7b00">
            <animate attributeName="y" from="21" to="18" dur="4s" repeatCount="indefinite" begin="0.5s" values="21;18;21" keyTimes="0;0.5;1" />
        </rect>
        <path d="M40,21 V15" stroke="#ff7b00" stroke-width="1">
            <animate attributeName="d" from="M40,21 V15" to="M40,18 V12" dur="4s" repeatCount="indefinite" begin="0.5s" values="M40,21 V15;M40,18 V12;M40,21 V15" keyTimes="0;0.5;1" />
        </path>
    </g>

    <g>
        <circle cx="140" cy="50" r="15" fill="url(#glowGradient)" opacity="0.3">
            <animate attributeName="cy" from="50" to="47" dur="3.5s" repeatCount="indefinite" begin="1s" values="50;47;50" keyTimes="0;0.5;1" />
        </circle>
        <ellipse cx="140" cy="50" rx="7" ry="9" fill="url(#orangeGradient)">
            <animate attributeName="cy" from="50" to="47" dur="3.5s" repeatCount="indefinite" begin="1s" values="50;47;50" keyTimes="0;0.5;1" />
        </ellipse>
        <rect x="138" y="41" width="4" height="2" fill="#ff7b00">
            <animate attributeName="y" from="41" to="38" dur="3.5s" repeatCount="indefinite" begin="1s" values="41;38;41" keyTimes="0;0.5;1" />
        </rect>
        <path d="M140,41 V35" stroke="#ff7b00" stroke-width="1">
            <animate attributeName="d" from="M140,41 V35" to="M140,38 V32" dur="3.5s" repeatCount="indefinite" begin="1s" values="M140,41 V35;M140,38 V32;M140,41 V35" keyTimes="0;0.5;1" />
        </path>
    </g>

    <!-- Rising lantern -->
    <g>
        <circle cx="65" cy="60" r="10" fill="url(#glowGradient)" opacity="0.3">
            <animate attributeName="cy" from="60" to="57" dur="2.5s" repeatCount="indefinite" begin="0.2s" values="60;57;60" keyTimes="0;0.5;1" />
        </circle>
        <ellipse cx="65" cy="60" rx="5" ry="7" fill="url(#orangeGradient)">
            <animate attributeName="cy" from="60" to="57" dur="2.5s" repeatCount="indefinite" begin="0.2s" values="60;57;60" keyTimes="0;0.5;1" />
        </ellipse>
        <rect x="63" y="53" width="4" height="1.5" fill="#ff7b00">
            <animate attributeName="y" from="53" to="50" dur="2.5s" repeatCount="indefinite" begin="0.2s" values="53;50;53" keyTimes="0;0.5;1" />
        </rect>
        <path d="M65,53 V48" stroke="#ff7b00" stroke-width="1">
            <animate attributeName="d" from="M65,53 V48" to="M65,50 V45" dur="2.5s" repeatCount="indefinite" begin="0.2s" values="M65,53 V48;M65,50 V45;M65,53 V48" keyTimes="0;0.5;1" />
        </path>
    </g>

    <!-- Silhouette of buildings -->
    <path d="M0,80 V65 H10 V70 H20 V60 H25 V65 H35 V70 H45 V63 H55 V73 H70 V68 H80 V75 H90 V67 H100 V72 H110 V70 H120 V65 H130 V75 H140 V70 H150 V65 H160 V68 H170 V75 H180 V80 Z" fill="black" />
</svg>