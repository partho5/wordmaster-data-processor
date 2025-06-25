<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 120" width="100%" height="200">
    <!-- Background wave for context -->
    <path d="M0,60 Q100,30 200,60 Q300,90 400,60" stroke="#a239ca" stroke-width="2" fill="none" opacity="0.3">
        <animate attributeName="d"
                 values="M0,60 Q100,30 200,60 Q300,90 400,60;
                                 M0,65 Q100,35 200,65 Q300,95 400,65;
                                 M0,60 Q100,30 200,60 Q300,90 400,60"
                 dur="4s" repeatCount="indefinite" />
    </path>

    <!-- Floating text elements -->
    <text x="60" y="60" text-anchor="middle" fill="#a239ca" font-size="24" font-weight="bold">
        <animate attributeName="y" values="60;40;60;80;60" dur="2s" repeatCount="indefinite"
                 calcMode="spline" keySplines="0.5 0 0.5 1; 0.5 0 0.5 1; 0.5 0 0.5 1; 0.5 0 0.5 1" />
        GRE
    </text>

    <text x="140" y="60" text-anchor="middle" fill="#d166ff" font-size="20" font-weight="bold">
        <animate attributeName="y" values="60;35;60;85;60" dur="2.3s" repeatCount="indefinite"
                 calcMode="spline" keySplines="0.5 0 0.5 1; 0.5 0 0.5 1; 0.5 0 0.5 1; 0.5 0 0.5 1" />
        IELTS
    </text>

    <text x="220" y="60" text-anchor="middle" fill="#9932cc" font-size="20" font-weight="bold">
        <animate attributeName="y" values="60;30;60;90;60" dur="3s" repeatCount="indefinite"
                 calcMode="spline" keySplines="0.5 0 0.5 1; 0.5 0 0.5 1; 0.5 0 0.5 1; 0.5 0 0.5 1" />
        GMAT
    </text>

    <text x="300" y="60" text-anchor="middle" fill="#d980ff" font-size="28" font-weight="bold">
        <animate attributeName="y" values="60;50;60;70;60" dur="2.7s" repeatCount="indefinite"
                 calcMode="spline" keySplines="0.5 0 0.5 1; 0.5 0 0.5 1; 0.5 0 0.5 1; 0.5 0 0.5 1" />
        Job
    </text>

    <text x="360" y="40" text-anchor="middle" fill="#8a2be2" font-size="18" font-weight="bold">
        <animate attributeName="y" values="40;25;40;55;40" dur="2.5s" repeatCount="indefinite"
                 calcMode="spline" keySplines="0.5 0 0.5 1; 0.5 0 0.5 1; 0.5 0 0.5 1; 0.5 0 0.5 1" />
        SAT
    </text>
</svg>