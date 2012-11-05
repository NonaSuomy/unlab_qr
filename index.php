<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <h1>Welcome to the QR-Generator</h1>
            <p>
                Please fill out the form an click on "Create QR". Afterwords a QR code should be generated and appear on the
                right hand side. To decode it you can either use <a href="http://zxing.org/w/decode.jspx" target="_blank">ZXing.org</a> by copying the URL of the code
                or go to our decode page <a href="reader.php">here</a>.
            </p>
            <div class="row">
                <div class="span6">
                    <h2>Generate</h2>
                    <form id="qrGeneratorForm" method="" action="">
                        <fieldset>
                            <legend>Base Settings</legend>
                            <label>ID Number</label>
                            <input type="text" id="qTerm" placeholder="Example: 0123456">
                            <span class="help-block">Put here the Item ID Number</span>
                        </fieldset>
                        <fieldset>
                            <legend>Extra Settings</legend>
                            <label>QR Size</label>
                            <input type="text" id="size" placeholder="Example: 250">
                            <span class="help-block">This is used as a square size in PX for the Result</span>

                            <label>Logo Scale</label>
                            <input type="text" id="scale" placeholder="Example: 0.25">
                            <span class="help-block">Please insert a number from 0 - 1</span>
                        </fieldset>
                        <button type="submit" class="btn">Create QR</button>
                    </form>
                </div>
                <div class="span6">
                    <h2>Your generated QR</h2>
                    <div id="resultCNT"  style="display:none">
                        <img id="imgBox" />
                        <input type="text" id="url" class="span6"/>
                    </div>
                </div>
            </div>
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
    </body>
</html>
