<?php
session_start();

// MySQL Connection

// Include func files
include "functions/user.func.php";
include "functions/expense.func.php";
include "functions/income.func.php";
include "functions/category.func.php";
$myfile = fopen("newfile.php", "w") or die("Unable to open file!");
$content=array("<?php\nsession_start();\n\$db=mysqli_connect(\"localhost\", \"root\", \"\", \"arbre_expense\");",
               "include \"functions/user.func.php\";",
               "include \"functions/expense.func.php\";",
               "include \"functions/income.func.php\";",
               "include \"functions/category.func.php\";\n?>"
              );
$txt = implode($content, "\n");
fwrite($myfile, $txt);
fclose($myfile);
echo "done";
?>