<?php
// Simple test file to check if CakePHP bootstraps correctly
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Starting bootstrap test...\n";

try {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
    echo "Autoloader loaded successfully\n";

    use Cake\Core\Configure;
    use Cake\Core\Configure\Engine\PhpConfig;

    // Load configuration
    Configure::setConfig('default', new PhpConfig());
    Configure::load('app', 'default', false);

    echo "Configuration loaded successfully\n";

    use App\Application;
    use Cake\Http\Server;

    echo "Application classes imported\n";

    // Try to create application
    $application = new Application(dirname(__FILE__) . '/config');
    echo "Application created successfully\n";

} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}