<html>
        <head>
                <title>Test Page</title>
        </head>
        <body>
                <h1>PHP Test Page</h1>

                <?php

                $test = '3" x 4.25"  .009 Clear E1 Vinyl  Laminate Zone Coat to Back for Pocket  Packed in Groups of 10/ea.  FGI#1086Â FGI#1086 (Refill)';

                $before = explode("FGI#", $test);
                $after = explode("(Refill)", $before['1']);
                $fgi =$after['0'];

                echo $fgi;
                echo "<br/>";
               $fgi = preg_replace('/[^a-zA-Z0-9]/s', '', $fgi);
                if (strlen($fgi) > 3)
                {
                        echo "yes - " . $fgi;
                }
                else
                {
                        echo "no - " . $fgi;
                }


                ?>
        </body>
</html>