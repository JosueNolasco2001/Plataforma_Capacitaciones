<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diploma SENACIT</title>
    <style>
        @page {
            margin: 15mm;
        }
        
        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #fdfbf7 0%, #f9f5ed 100%);
        }

        .diploma {
            border: 8px double #d4af37;
            padding: 30px;
            background: 
                radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(212, 175, 55, 0.05) 0%, transparent 50%),
                linear-gradient(to bottom, #fdfbf7, #faf8f2);
            text-align: center;
            min-height: 900px;
            position: relative;
            overflow: hidden;
        }

        /* Patrón sutil de fondo */
        .diploma::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 15% 15%, rgba(212, 175, 55, 0.03) 2px, transparent 2px),
                radial-gradient(circle at 85% 85%, rgba(212, 175, 55, 0.03) 2px, transparent 2px);
            background-size: 60px 60px;
            z-index: 0;
        }

        .corner {
            position: relative;
        }

        .header {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 3px solid #d4af37;
            position: relative;
            z-index: 1;
        }

        .seal {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
            border: 4px solid #d4af37;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .institution {
            font-size: 12px;
            color: #8b6914;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .title {
            font-size: 52px;
            color: #2c1810;
            letter-spacing: 12px;
            margin: 15px 0;
            font-weight: normal;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .subtitle {
            font-size: 14px;
            color: #8b6914;
            font-style: italic;
        }

        .divider {
            width: 250px;
            height: 3px;
            background: #d4af37;
            margin: 20px auto;
            position: relative;
            z-index: 1;
        }

        .content {
            margin: 35px 20px;
            position: relative;
            z-index: 1;
        }

        .text {
            font-size: 18px;
            color: #4a4a4a;
            margin: 15px 0;
        }

        .name {
            font-size: 38px;
            font-weight: bold;
            color: #2c1810;
            margin: 25px 0;
            padding-bottom: 10px;
            border-bottom: 4px solid #d4af37;
            display: inline-block;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .course {
            font-size: 30px;
            font-weight: bold;
            color: #8b6914;
            margin: 25px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
            line-height: 1.4;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .instructor-section {
            margin-top: 35px;
            font-size: 16px;
            color: #4a4a4a;
        }

        .instructor-name {
            font-size: 22px;
            font-weight: bold;
            color: #2c1810;
            margin-top: 10px;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 3px solid #d4af37;
            position: relative;
            z-index: 1;
        }

        .footer-content {
            display: table;
            width: 100%;
        }

        .footer-left,
        .footer-right {
            display: table-cell;
            width: 50%;
            vertical-align: bottom;
        }

        .footer-left {
            text-align: left;
        }

        .footer-right {
            text-align: center;
        }

        .date-label {
            font-size: 11px;
            color: #8b6914;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .date-value {
            font-size: 15px;
            font-weight: bold;
            color: #2c1810;
            margin-top: 5px;
        }

        .signature-line {
            font-family: 'Brush Script MT', 'Lucida Handwriting', cursive;
            font-size: 30px;
            color: #2c1810;
            border-bottom: 2px solid #2c1810;
            padding: 0 20px 5px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .signature-title {
            font-size: 11px;
            color: #5a4a2a;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .code {
            margin-top: 15px;
            font-size: 9px;
            color: #999;
            letter-spacing: 0.5px;
        }

        /* Elementos decorativos en las esquinas */
        .corner-decoration {
            position: absolute;
            width: 80px;
            height: 80px;
            z-index: 0;
        }

        .corner-tl {
            top: 20px;
            left: 20px;
            border-top: 2px solid rgba(212, 175, 55, 0.3);
            border-left: 2px solid rgba(212, 175, 55, 0.3);
        }

        .corner-tr {
            top: 20px;
            right: 20px;
            border-top: 2px solid rgba(212, 175, 55, 0.3);
            border-right: 2px solid rgba(212, 175, 55, 0.3);
        }

        .corner-bl {
            bottom: 20px;
            left: 20px;
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
            border-left: 2px solid rgba(212, 175, 55, 0.3);
        }

        .corner-br {
            bottom: 20px;
            right: 20px;
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
            border-right: 2px solid rgba(212, 175, 55, 0.3);
        }
    </style>
</head>
<body>
    <div class="diploma">
        <!-- Elementos decorativos de esquina -->
        <div class="corner-decoration corner-tl"></div>
        <div class="corner-decoration corner-tr"></div>
        <div class="corner-decoration corner-bl"></div>
        <div class="corner-decoration corner-br"></div>
        
        <div class="header">
            @if(isset($logo_path) && file_exists($logo_path))
                <img src="{{ $logo_path }}" alt="Logo SENACIT" style="width: 260px; height: auto; margin: 0 auto 15px; display: block;">
            @else
                <div class="seal">🎓</div>
            @endif
            <p class="institution">Secretaría Nacional de Ciencia, Tecnología e Innovación</p>
            <h1 class="title">RECONOCIMIENTO</h1>
            <p class="subtitle">por Finalización y Aprobación</p>
        </div>

        <div class="divider"></div>

        <div class="content">
            <p class="text">Se otorga el presente reconocimiento a</p>
            
            <div class="name">{{ $estudiante_nombre ?? 'Juan Carlos Pérez' }}</div>
            
            <p class="text">por haber finalizado exitosamente todos los videos y aprobado el examen del curso</p>
            
            <div class="course">{{ $curso_titulo ?? 'Desarrollo Web Full Stack' }}</div>
            
            <div class="instructor-section">
                <p>Bajo la instrucción de</p>
                <p class="instructor-name">{{ $instructor_nombre ?? 'Dra. María González' }}</p>
            </div>
        </div>

        <div class="footer">
            <div class="footer-content">
                <div class="footer-left">
                    <p class="date-label">Fecha de Expedición</p>
                    <p class="date-value">{{ $fecha_completado ?? '12 de Noviembre, 2024' }}</p>
                </div>
                <div class="footer-right">
                    <div class="signature-line">Luther Castillo Harry</div>
                    <p class="signature-title">Ministro de SENACIT</p>
                </div>
            </div>
            
            @if(isset($codigo_diploma))
            <p class="code">Código: {{ $codigo_diploma }}</p>
            @endif
        </div>
    </div>
</body>
</html>