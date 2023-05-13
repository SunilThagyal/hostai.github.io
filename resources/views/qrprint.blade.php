<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        @page { margin: 0px; }
        body { margin: 0px; }
    </style>
    <title>Document</title>
</head>
<body>
    
    <div style=" margin:0 auto;width:100%;max-width:100%;height:100%;text-align:center;">
        <div style="padding-top:30px;margin:0 auto;text-align:center;"><img src="data:image/png;base64,{{DNS2D::getBarcodePNG($url, 'QRCODE' , 5,5) }}" alt="barcode"   />  </div>
        <br>
        <span style="line-height: 12px;font-size: 12px"> NAME: {{ strtoupper($user->first_name.' '. $user->last_name) }} </span><br>
        <span style="line-height: 12px;font-size: 12px">CONTRACTOR: {{ strtoupper($user->Worker->workerContractor->first_name) }}</span>
        </div>
</body>
</html>
    
  



