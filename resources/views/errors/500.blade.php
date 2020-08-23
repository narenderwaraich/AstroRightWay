<html>
  <head>
    <title>{{ config('backpack.base.project_name') }} Error 500</title>

    <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

    <style>
      body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        color: #B0BEC5;
        display: table;
        font-weight: 100;
        font-family: 'Lato';
      }

      .container {
        text-align: center;
        display: table-cell;
        vertical-align: middle;
      }

      .content {
        text-align: center;
        display: inline-block;
      }

      .title {
        font-size: 156px;
      }

      .quote {
        font-size: 36px;
      }

      .explanation {
        font-size: 24px;
      }
      .form-btn{
        text-transform: uppercase;
    background: #ce2350;
    color: #ffffff;
    border: 2px solid #ce2350;
    margin: auto;
    text-align: center;
    border-radius: 0px;
    padding: .6180469716em 1.41575em;
    font-size: 17px;
    font-weight: 600;
    font-family: 'Montserrat', sans-serif;
    display: inline-block !important;
    width: auto !important;
      }
      .form-btn:hover{
        background-color: transparent;
        color: #ce2350;
         border: 2px solid #ce2350;
        cursor: pointer;
      }
      img.error-page-web-log {
        width: 400px;
     }
@media (max-width: 767px){
    img.error-page-web-log {
        width: 250px;
    }
}
    </style>
  </head>
  <body>
    <div class="container">
      <div class="content">
        <div class="title">500</div>
        <div class="quote">Sorry Page not found</div>
        <div class="explanation">
          <br>
          <small>
            <center>
              <a href="/"><img src="{{env('APP_URL')}}/public/images/icons/logo.png" alt="Logo" class="error-page-web-log"></a>
            </center>
            <br>
           <a href="/"><button type="button" class="btn form-btn">Go to Home</button></a>
         </small>
       </div>
      </div>
    </div>
  </body>
</html>
