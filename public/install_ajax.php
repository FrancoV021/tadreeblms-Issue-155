<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 0);

$base = realpath(__DIR__ . "/..");     
$dbConfig = __DIR__ . "/db_config.json";
$envFile = $base . "/.env";
$envExample = $base . "/.env.example";

// -----------------------------
// Helper Response
// -----------------------------
function send($arr)
{
    echo json_encode($arr);
    exit;
}

// -----------------------------
// Helper: Run shell commands
// -----------------------------
function run_cmd($cmd)
{
    $output = shell_exec($cmd . " 2>&1");
    if (!$output) $output = "(no output)";
    return htmlspecialchars($output);
}

// -----------------------------
// Detect Composer
// -----------------------------
function find_composer()
{
    $paths = [
        "composer",
        "/usr/local/bin/composer",
        "/usr/bin/composer",
        "php composer.phar",
        "composer.bat",
        "C:\\ProgramData\\ComposerSetup\\bin\\composer.bat"
    ];

    foreach ($paths as $p) {
        $v = @shell_exec("$p --version 2>&1");
        if ($v && stripos($v, "Composer") !== false) return $p;
    }
    return null;
}

// -----------------------------
// Read step
// -----------------------------
$step = $_POST["step"] ?? "check";

// -----------------------------
// STEP: SAVE DATABASE DETAILS
// -----------------------------
if ($step === "db_save") {
    $data = [
        "host" => $_POST["db_host"] ?? "127.0.0.1",
        "name" => $_POST["db_name"] ?? "",
        "user" => $_POST["db_user"] ?? "",
        "pass" => $_POST["db_pass"] ?? ""
    ];

    if(empty($data['name']) || empty($data['user'])){
        send([
            "success" => false,
            "output" => "❌ Database name and username are required",
            "percent" => 30,
            "next" => "db_config",
            "show_db_form" => true
        ]);
    }

    file_put_contents($dbConfig, json_encode($data, JSON_PRETTY_PRINT));

    send([
        "success" => true,
        "output"  => "✔ Database settings saved<br>",
        "percent" => 30,
        "next"    => "env",
        "show_db_form" => false
    ]);
}

// ===========================================================================
// MAIN INSTALLER STEPS
// ===========================================================================
try {
    switch ($step) {

        case "check":
            $out = "✔ PHP version: " . phpversion() . "<br>";
            $required = ["pdo_mysql","openssl","mbstring","tokenizer","xml","ctype","json","bcmath","fileinfo","curl","zip"];
            foreach($required as $e){
                $out .= extension_loaded($e) ? "✔ $e<br>" : "❌ Missing: $e<br>";
            }

            $composer = find_composer();
            if($composer){
                $out .= "✔ Composer found: $composer<br>";
            } else {
                send([
                    "success" => false,
                    "output" => $out . "❌ Composer not found",
                    "percent" => 10,
                    "next" => "composer",
                    "show_db_form" => false
                ]);
            }

            send([
                "success" => true,
                "output" => $out,
                "percent" => 10,
                "next" => "composer",
                "show_db_form" => false
            ]);
            break;

        case "composer":
            $composerCmd = find_composer();
            if(!$composerCmd){
                send([
                    "success" => false,
                    "output" => "❌ Composer not found. Install globally.",
                    "percent" => 20,
                    "next" => "composer",
                    "show_db_form" => false
                ]);
            }

            $cmd = "cd \"$base\" && $composerCmd install --no-interaction --prefer-dist 2>&1";
            $output = shell_exec($cmd);

            if($output === null){
                send([
                    "success" => false,
                    "output" => "❌ Composer failed (shell_exec disabled or permission issue).",
                    "percent" => 20,
                    "next" => "composer",
                    "show_db_form" => false
                ]);
            }

            send([
                "success" => true,
                "output" => "✔ Composer completed<br><pre>".htmlspecialchars($output)."</pre>",
                "percent" => 20,
                "next" => "db_config",
                "show_db_form" => false
            ]);
            break;

        case "env":
            if(!file_exists($dbConfig)){
                send([
                    "success" => false,
                    "output" => "❌ DB configuration missing",
                    "percent" => 40,
                    "next" => "db_config",
                    "show_db_form" => true
                ]);
            }
            $db = json_decode(file_get_contents($dbConfig), true);
            $env = file_exists($envExample) ? file_get_contents($envExample) : "";
            $env .= "\nDB_HOST={$db['host']}\nDB_DATABASE={$db['name']}\nDB_USERNAME={$db['user']}\nDB_PASSWORD={$db['pass']}\n";
            file_put_contents($envFile, $env);

            send([
                "success" => true,
                "output" => "✔ .env created<br>",
                "percent" => 50,
                "next" => "key",
                "show_db_form" => false
            ]);
            break;

        case "key":
            $out = run_cmd("cd $base && php artisan key:generate --force");
            send([
                "success" => true,
                "output" => "✔ APP_KEY generated<br>".nl2br($out),
                "percent" => 60,
                "next" => "migrate",
                "show_db_form" => false
            ]);
            break;

        case "migrate":
            $out = run_cmd("cd $base && php artisan migrate --force");
            send([
                "success" => true,
                "output" => "✔ Migrations complete<br>".nl2br($out),
                "percent" => 75,
                "next" => "seed",
                "show_db_form" => false
            ]);
            break;

        case "seed":
            $out = run_cmd("cd $base && php artisan db:seed --force");
            send([
                "success" => true,
                "output" => "✔ Seeding complete<br>".nl2br($out),
                "percent" => 85,
                "next" => "permissions",
                "show_db_form" => false
            ]);
            break;

        case "permissions":
            @chmod($base."/storage", 0777);
            @chmod($base."/bootstrap/cache", 0777);
            send([
                "success" => true,
                "output" => "✔ Permissions set<br>",
                "percent" => 95,
                "next" => "finish",
                "show_db_form" => false
            ]);
            break;

        case "finish":
            file_put_contents($base."/installed","installed");
            send([
                "success" => true,
                "output" => "🎉 Installation complete!",
                "percent" => 100,
                "next" => "finish",
                "show_db_form" => false
            ]);
            break;

        default:
            send([
                "success" => false,
                "output" => "Unknown step: $step",
                "percent" => 0,
                "next" => "check",
                "show_db_form" => false
            ]);
            break;
    }
} catch(Exception $e){
    send([
        "success" => false,
        "output" => "Installer error: ".$e->getMessage(),
        "percent" => 0,
        "next" => $step,
        "show_db_form" => false
    ]);
}
