<!DOCTYPE html>
<html>
<head>
    <meta charset = "utf-8"/>
    <title>Page Title</title>
    <link rel = "stylesheet" type = "text/css" href="calStyleSheet.css">
</head>
<body>
    <div id = "wrapper">
        
        <div id = "header">
            Title Here
        </div>
        
        <div id = "main">
            
            <div id = "nav">
                Natigation <br>
                Bar 
            </div>
            
            <div id = "cal">
                
                
                <?php
                    require "monthly.html";
                ?>
                
            </div>
        </div>
    </div>
</body>
</html>
