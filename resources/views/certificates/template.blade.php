<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Certificat de Réussite</title>
      <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto&display=swap" rel="stylesheet" />
  <style>
    @page {
      size: A4 landscape;
      margin: 2cm;
    }
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Roboto', sans-serif;
      background: #f6f1e7;
      margin: 0;
      padding: 0;
      /* Pas de flex ni height: 100vh */
    }
    .certificate {
      background-color: #fff8ef;
      color: #222;
      width: 21.3cm;       /* largeur A4 paysage - marges */
      height: 14.6cm;  /* hauteur raisonnable */
      padding: 3cm 4cm;
      border-radius: 12px;
      border: 6px solid #d4af37;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      position: relative;
      text-align: center;
            overflow: hidden;
    }

    .certificate .issuer {
  font-size: 20px;
  font-weight: bold;
  color: #555;
  margin-bottom: 15px;
  text-transform: uppercase;
  letter-spacing: 1px;
}

     .certificate .icon img {
      width: 90px;
      margin-bottom: 20px;
    }

    .certificate h1 {
      font-size: 40px;
      letter-spacing: 1px;
      text-transform: uppercase;
      font-weight: bold;
      color: #111;
      margin-bottom: 20px;
    }

    .certificate .highlight {
      color: #b38700;
      font-weight: 500;
      margin: 30px 0 10px;
      font-size: 25px;
    }

    .certificate .name {
      font-family: 'Playfair Display', serif;
      font-size: 50px;
      font-weight: bold;
      margin: 15px 0;
      color: #000;
    }

    .certificate .description {
      font-size: 20px;
      color: #444;
      margin: 20px 0 10px;
      line-height: 1.6;
    }

    .certificate .course-title {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .certificate .date {
      font-size: 18px;
      color: #333;
      margin-bottom: 40px;
    }

    .footer {
      position: absolute;
      bottom: 2.5cm;
      left: 3cm;
      right: 3cm;
    }

    .footer table {
      width: 100%;
      text-align: center;
      border-collapse: collapse;
    }

    .footer td {
      width: 33%;
      font-size: 15px;
      color: #333;
      vertical-align: bottom;
    }

    .footer .line {
      border-top: 1px solid #999;
      width: 80%;
      margin: auto;
      margin-bottom: 5px;
    }

    .footer img {
      width: 50px;
    }
  </style>
</head>
<body>

  <div class="certificate">
    <div class="issuer">Plateforme QCM Pro+</div>
    <div class="icon">
      <img src="{{ public_path('images/book2.jpg') }}" alt="Livre" />
    </div>

    <h1>CERTIFICAT DE RÉUSSITE</h1>

    <p class="highlight">Cette récompense est remise à</p>

    <div class="name">{{ $user->name }}</div>

    <p class="description">pour avoir complété avec succès le cours</p>
    <p class="course-title">{{ $course->title }}</p>

    <p class="date">Le {{ $date }}</p>

    <div class="footer">
      <table>
        <tr>
          <td>
            <div class="line"></div>
            ROMAIN STÉVENIN<br />
            <small>Doyen de l’université</small>
          </td>
          <td>
            <img src="{{ public_path('images/med2.png') }}" alt="Médaille" />
          </td>
          <td>
            <div class="line"></div>
            JULIE MARNIER<br />
            <small>Proviseure</small>
          </td>
        </tr>
      </table>
    </div>
  </div>

</body>
</html>