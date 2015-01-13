<?php
$path = realpath('./logs');
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
$outputHandle = fopen("./StaticVsRM.csv", "w");
fwrite($outputHandle, "type,loadTime\n");
foreach($iterator as $name => $it){
    if ($it->isDir() || ($it->getFilename()[0] == ".")) continue;
    //echo "Processing " . $it->getFilename() . "...\n";

    $inputHandle = fopen($it->getRealPath(), "r");
    if ($inputHandle) {
        while (($line = fgets($inputHandle)) !== false) {
            $pattern = '/(?P<owner>\S+) (?P<bucket>\S+) (?P<time>\[[^]]*\]) (?P<ip>\S+) (?P<requester>\S+) (?P<reqid>\S+) (?P<operation>\S+) (?P<key>\S+) (?P<request>"[^"]*") (?P<status>\S+) (?P<error>\S+) (?P<bytes>\S+) (?P<size>\S+) (?P<totaltime>\S+) (?P<turnaround>\S+) (?P<referrer>"[^"]*") (?P<useragent>"[^"]*") (?P<version>\S)/';
            preg_match($pattern, $line, $matches);

            if (strpos($matches["request"], "loadTime") === false) continue;

            // GET /1px.gif?type=static-image&loadTime=0.2690000534057617&0.7803578798193485 HTTP/1.1
            $requestPattern = "/type=(?<type>.*?)&loadTime=(?<loadTime>.*?)&/";
            preg_match($requestPattern, $matches["request"], $out);

            fwrite($outputHandle, $out["type"].",".$out["loadTime"]."\n");

            //print_r($out); echo "\n";
        }
    } else {
        echo "Error processing file " + $it->getFilename();
    }
    fclose($inputHandle);
}
fclose($outputHandle);