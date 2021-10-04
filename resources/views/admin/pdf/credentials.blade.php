<!DOCTYPE html>
<html lang="es">
<!--------------https://www.convertir-unidades.info/convertidor-de-unidades.php?tipo=schriftgroesse--->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        *{
            margin: 0;
            padding: 0;
        }
      
        .main-page{
            width: 793px;
            border:1px solid #000;
            display: flex;
           
        }
        table{
         
            margin-left: 30px;
            margin-top: 30px;
            border-collapse: separate;
            border-spacing: 20px;
            
        }
        table tr > td{
            width: 321px;
            height: 150px;
            border: 1px solid #000;
            padding-right: 10px;  
        }
        p{
            padding: 3px;
        }
       
     
        
    </style>
</head>
<body>
 
 <?php 
    $maxWorkers = $workers->count();
    $i=0;
 ?>
    <div class="main-page">
        <table class="a">
            <tr>
            @foreach($workers as $worker)
                @if( $i==2)
                    </tr>
                    @if($i+1 < $maxWorkers)
                        <tr>
                    @endif
                    <?php $i=0?>
                @endif
                <td>
                    <p style="text-align: center;"><b>{{$denomination}}</b></p>
                    <p><b>Folio:</b>{{$worker->id}}</p>
                    <p><b>Nombre:</b> {{$worker->worker}}</p>
                    <p><b>NSS:</b> {{$worker->nss}}</p>
                    <p><b>CURP:</b> {{$worker->curp}}</p>
                    <p><b>Fecha de Ingreso:</b>{{$worker->entry}}</p>
                </td>
                <?php $i++?>
            @endforeach
            @if($maxWorkers % 2 != 0)
                </tr>
            @endif
        </table>
    </div>
</body>
</html>