<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Diploma de Certificación</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: white;
        }
        
        .diploma-container {
            width: 100%;
            border: 5px solid #DAA520;
            padding: 30px;
            text-align: center;
            background: white;
        }
        
        .title {
            font-size: 2rem;
            color: #2c3e50;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .student-name {
            font-size: 2.5rem;
            color: #B8860B;
            margin: 20px 0;
            font-weight: bold;
        }
        
        .course-title {
            font-size: 1.8rem;
            color: #2c3e50;
            margin: 15px 0;
            font-style: italic;
        }
        
        .instructor {
            font-size: 1.2rem;
            color: #666;
            margin: 15px 0;
        }
        
        .stats {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border: 2px solid #DAA520;
        }
        
        .date {
            font-size: 1rem;
            color: #666;
            margin: 15px 0;
        }
        
        .signatures {
            margin-top: 40px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
            width: 100%;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        
        .signature {
            text-align: center;
            min-width: 200px;
            margin: 10px;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin: 10px auto;
            width: 80%;
        }
        
        .code {
            position: absolute;
            bottom: 10px;
            right: 10px;
            font-size: 0.8rem;
            color: #999;
        }
        
        .imgbody {
            width: 190px; 
            height: 120px; 
        }
    </style>
</head>
<body>
    <div class="diploma-container">
        <h1 class="title">Certificado de Finalización</h1>
        
        <p>Se certifica que</p>
        
        <div class="student-name">{{ $estudiante_nombre }}</div>
        
        <p>ha completado exitosamente el curso</p>
        
        <div class="course-title">{{ $curso_titulo }}</div>
        
        <div class="instructor">
            Impartido por: <strong>{{ $instructor_nombre }}</strong>
        </div>
        
        <div class="stats">
            <strong>Videos completados:</strong> {{ $videos_completados }} de {{ $total_videos }} (100%)
        </div>
        
        <div class="date">
            <strong>Fecha de finalización:</strong> {{ $fecha_completado }}
        </div>
        
        <div class="signatures">
                            <img class="imgbody" src="https://www.shutterstock.com/image-vector/vector-fake-signature-sample-hand-260nw-2539360813.jpg" alt="">

            <div class="signature">
                <div class="signature-line"></div>
                <strong>{{ $instructor_nombre }}</strong><br>
                <small>Instructor</small>
            </div>
        
        </div>
        
        <div class="code">{{ $codigo_diploma }}</div>
    </div>
</body>
</html>