<!doctype html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
    <script type="text/javascript" src="script.js"></script>

    <!-- Cargamos Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </head>
  <body>
    
    <form action="#" method="POST" id="payment-form"><input type="hidden" name="token_id" id="token_id">
      <div class="pymnt-itm card active">
        <h2>Tarjeta de crédito o débito</h2>
        <div class="pymnt-cntnt">
          <div class="sctn-row">
            <div class="sctn-col l"><label>Nombre del titular</label><input type="text" placeholder="Como aparece en la tarjeta" autocomplete="off" data-openpay-card="holder_name"></div>
            <div class="sctn-col"><label>Número de tarjeta</label><input type="text" autocomplete="off" data-openpay-card="card_number"></div>
          </div>
          <div class="sctn-row">
            <div class="sctn-col l"><label>Fecha de expiración</label>
              <div class="sctn-col half l"><input type="text" placeholder="Mes" data-openpay-card="expiration_month"></div>
              <div class="sctn-col half l"><input type="text" placeholder="Año" data-openpay-card="expiration_year"></div>
            </div>
            <div class="sctn-col cvv"><label>Código de seguridad</label>
              <div class="sctn-col half l"><input type="text" placeholder="3 dígitos" autocomplete="off" data-openpay-card="cvv2"></div>
            </div>
          </div>
          <div class="openpay">

            <div class="shield">Tus pagos se realizan de forma segura con encriptación de 256 bits</div>
          </div>
          <button class="btn btn-primary" id="pay-button">Pagar</a>
        </div>
      </div>
    </form>

  </body>
</html>
