<?php
$file = 'routes/web.php';
$lines = file($file);

// Validate we are taking out the right chunk
$startLine = 761;
$endLine = 1146;
$length = $endLine - $startLine + 1;

if (strpos($lines[$startLine - 1], "Route::group(['prefix' => 'SMARMANger', 'middleware' => ['roleteacher']], function () {") !== false && strpos($lines[$endLine - 1], "});") !== false) {
    array_splice($lines, $startLine - 1, $length, ["require base_path('routes/teacher.php');\n"]);
    $content = implode("", $lines);
    file_put_contents($file, $content);
    echo "Refactored teacher routes successfully.";
} else {
    echo "Validation failed. Line 761 is: " . $lines[$startLine - 1] . " Line 1146 is: " . $lines[$endLine - 1];
}
