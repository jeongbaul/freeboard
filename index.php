<?php
$debug = false;

function safeParam($param) {
    return preg_replace("/[^a-zA-Z0-9_-]/", "", $param);
}

$context1 = isset($_GET['context1']) ? safeParam($_GET['context1']) : "";
$context2 = isset($_GET['context2']) ? safeParam($_GET['context2']) : "";
$action   = isset($_GET['action'])   ? safeParam($_GET['action'])   : "";

include __DIR__ . "/common/header.php";

if ($debug) {
    echo "<pre>DEBUG MODE\n";
    echo "context1 = {$context1}\n";
    echo "context2 = {$context2}\n";
    echo "action   = {$action}\n";
    echo "</pre>";
}

$basePath = __DIR__ . "/pages";

if ($context1 === "" && $context2 === "" && $action === "") {
    $pagePath = $basePath . "/main.php";
} else {
    $pagePath = $basePath;
    if ($context1 !== "") $pagePath .= "/" . $context1;
    if ($context2 !== "") $pagePath .= "/" . $context2;
    if ($action !== "") {
        $pagePath .= "/" . $action . ".php";
    } else {
        $pagePath .= ".php";
    }
}

if ($debug) {
    echo "<pre>Trying to load: {$pagePath}</pre>";
}

if (file_exists($pagePath)) {
    include $pagePath;
} else {
    http_response_code(404);
    include $basePath . "/error.php";
}

include __DIR__ . "/common/footer.php";
