<head>
    <title><?php echo $Language->TablePhrase("notica", "titulo"); ?></title>
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <script>
        $(document).ready(function() {
            $("#div_refresh").load("dts_notifica.php");
            setInterval(function() {
                $("#div_refresh").load("dts_notifica.php");
            }, 1000);
        });
    </script>
</head>

<body>
    <div id="div_refresh"></div>
</body>

</html>