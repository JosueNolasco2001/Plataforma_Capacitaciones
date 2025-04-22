<a href="/">

          <style>
            @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap");
        
         
        
            .circle-container {
              position: relative;
              width: 190px;
              height: 190px;
              border-radius: 50%;
              background: #4fc1d9;
              box-shadow: 0 0 20px #4fc1d9;
              display: flex;
              flex-direction: column;
              justify-content: center;
              align-items: center;
              padding: 2rem 1.5rem;
              overflow: hidden;
              animation: pulseBackground 5s ease-in-out infinite;
              text-align: center;
            }
        
            @keyframes pulseBackground {
              0%, 100% {
                background-color: #4fc1d9;
                box-shadow: 0 0 20px #4fc1d9;
              }
              50% {
                background-color: #3aa9c4;
                box-shadow: 0 0 40px #3aa9c4;
              }
            }
        
            .logo-text {
              color: white;
              font-weight: 600;
              font-size: 2.75rem;
              line-height: 1;
              user-select: none;
              animation: textFade 5s ease-in-out infinite;
              letter-spacing: 0.05em;
              text-transform: capitalize;
              text-shadow:
                0 0 5px rgba(255, 255, 255, 0.8),
                0 0 10px rgba(255, 255, 255, 0.6);
              margin-bottom: 0.25rem;
            }
            .sub-text {
              color: white;
              font-size: 10px;
              user-select: none;
              animation: textFade 5s ease-in-out infinite;
              text-shadow: 0 0 3px rgba(255, 255, 255, 0.7);
              max-width: 260px;
              margin: 0 auto;
              line-height: 1.2;
            }
        
            @keyframes textFade {
              0%, 100% {opacity: 1;}
              50% {opacity: 0.7;}
            }
        
            .star {
              position: absolute;
              background: white;
              border-radius: 50%;
              opacity: 0.8;
              filter: drop-shadow(0 0 2px white);
              animation-timing-function: linear;
              box-shadow:
                0 0 2px white,
                0 0 5px white;
            }
        
            .star.small {
              width: 2px;
              height: 2px;
              animation-name: twinkleSmall;
              animation-duration: 3s;
              animation-iteration-count: infinite;
            }
            .star.medium {
              width: 3.5px;
              height: 3.5px;
              animation-name: twinkleMedium;
              animation-duration: 4.5s;
              animation-iteration-count: infinite;
            }
            .star.large {
              width: 5px;
              height: 5px;
              animation-name: twinkleLarge;
              animation-duration: 6s;
              animation-iteration-count: infinite;
            }
        
            @keyframes twinkleSmall {
              0%, 100% {opacity: 0.8;}
              50% {opacity: 0.3;}
            }
            @keyframes twinkleMedium {
              0%, 100% {opacity: 0.9;}
              50% {opacity: 0.4;}
            }
            @keyframes twinkleLarge {
              0%, 100% {opacity: 1;}
              50% {opacity: 0.5;}
            }
        
            .shooting-star {
              position: absolute;
              width: 80px;
              height: 2px;
              background: linear-gradient(90deg, white, transparent);
              border-radius: 9999px;
              opacity: 0;
              filter: drop-shadow(0 0 6px white);
              animation: shootingStar 3s ease-in-out infinite;
              box-shadow: 0 0 8px white;
            }
        
            @keyframes shootingStar {
              0% {
                transform: translateX(-100px) translateY(0) rotate(45deg);
                opacity: 0;
              }
              10% {
                opacity: 1;
              }
              100% {
                transform: translateX(300px) translateY(150px) rotate(45deg);
                opacity: 0;
              }
            }
        
            .sparkle {
              position: absolute;
              border-radius: 50%;
              background: white;
              filter: drop-shadow(0 0 4px white);
              opacity: 0.8;
              animation: sparklePulse 4s ease-in-out infinite;
              box-shadow:
                0 0 4px white,
                0 0 10px white;
            }
            .sparkle.small {
              width: 3px;
              height: 3px;
              animation-delay: 0s;
            }
            .sparkle.medium {
              width: 5px;
              height: 5px;
              animation-delay: 1.5s;
            }
            .sparkle.large {
              width: 7px;
              height: 7px;
              animation-delay: 3s;
            }
        
            @keyframes sparklePulse {
              0%, 100% {
                opacity: 0.8;
                transform: scale(1);
                filter: drop-shadow(0 0 4px white);
              }
              50% {
                opacity: 0.4;
                transform: scale(1.3);
                filter: drop-shadow(0 0 12px white);
              }
            }
        
            .float {
              animation: floatMove 10s ease-in-out infinite;
            }
            .float.delay1 {
              animation-delay: 0s;
            }
            .float.delay2 {
              animation-delay: 3.3s;
            }
            .float.delay3 {
              animation-delay: 6.6s;
            }
        
            @keyframes floatMove {
              0%, 100% {
                transform: translateY(0);
              }
              50% {
                transform: translateY(-6px);
              }
            }
        
            /* Additional animated orbiting rings around the circle */
            .orbit-ring {
              position: absolute;
              border: 1.5px solid rgba(255, 255, 255, 0.3);
              border-radius: 50%;
              animation-timing-function: linear;
              animation-iteration-count: infinite;
              box-shadow: 0 0 8px rgba(255, 255, 255, 0.4);
            }
            .orbit1 {
              width: 360px;
              height: 360px;
              top: -20px;
              left: -20px;
              animation-name: spinClockwise;
              animation-duration: 30s;
            }
            .orbit2 {
              width: 280px;
              height: 280px;
              top: 20px;
              left: 20px;
              animation-name: spinCounterClockwise;
              animation-duration: 45s;
            }
            .orbit3 {
              width: 400px;
              height: 400px;
              top: -40px;
              left: -40px;
              animation-name: spinClockwise;
              animation-duration: 60s;
              border-style: dashed;
              opacity: 0.15;
            }
        
            @keyframes spinClockwise {
              0% { transform: rotate(0deg);}
              100% { transform: rotate(360deg);}
            }
            @keyframes spinCounterClockwise {
              0% { transform: rotate(0deg);}
              100% { transform: rotate(-360deg);}
            }
          </style>
  
    
          <div class="circle-container" aria-label="Senacit logo with animated starry space background" role="img">
            <h1 class="logo-text">Senacit</h1>
            <p class="sub-text">Secretaría Nacional de Ciencia, Tecnología e Innovación</p>
        
            <!-- Stars with floating and twinkle -->
            <div class="star small float delay1" style="top: 15%; left: 20%; animation-delay: 0s;"></div>
            <div class="star medium float delay2" style="top: 40%; left: 70%; animation-delay: 1.2s;"></div>
            <div class="star small float delay3" style="top: 60%; left: 30%; animation-delay: 2.5s;"></div>
            <div class="star large float delay1" style="top: 25%; left: 50%; animation-delay: 3.7s;"></div>
            <div class="star medium float delay2" style="top: 75%; left: 80%; animation-delay: 4.1s;"></div>
            <div class="star small float delay3" style="top: 50%; left: 10%; animation-delay: 1.7s;"></div>
            <div class="star large float delay1" style="top: 10%; left: 80%; animation-delay: 2.9s;"></div>
            <div class="star medium float delay2" style="top: 85%; left: 40%; animation-delay: 0.5s;"></div>
            <div class="star small float delay3" style="top: 35%; left: 60%; animation-delay: 3.3s;"></div>
            <div class="star medium float delay1" style="top: 55%; left: 75%; animation-delay: 4.7s;"></div>
        
            <!-- Sparkles with pulse and float -->
            <div class="sparkle small float delay2" style="top: 20%; left: 35%; animation-delay: 0s;"></div>
            <div class="sparkle medium float delay3" style="top: 45%; left: 55%; animation-delay: 1.5s;"></div>
            <div class="sparkle large float delay1" style="top: 70%; left: 25%; animation-delay: 3s;"></div>
        
            <!-- Shooting stars with varied delays -->
            <div class="shooting-star" style="top: 20%; left: -80px; animation-delay: 0s;"></div>
            <div class="shooting-star" style="top: 50%; left: -100px; animation-delay: 5s;"></div>
            <div class="shooting-star" style="top: 35%; left: -90px; animation-delay: 8s;"></div>
        
            <!-- Orbiting rings -->
            <div class="orbit-ring orbit1"></div>
            <div class="orbit-ring orbit2"></div>
            <div class="orbit-ring orbit3"></div>
          </div>
        </a>
