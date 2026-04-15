<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$req = Illuminate\Http\Request::create('/admin/absensi/scan-proses', 'POST', ['user_id' => 3]);
$controller = new App\Http\Controllers\Admin\AbsensiController();
try {
    $res = $controller->scanProses($req);
    echo "NO ERROR! Response:\n";
    print_r(json_decode($res->getContent(), true));
} catch (\Exception $e) {
    echo "ERROR CAUGHT:\n" . $e->getMessage() . "\n" . $e->getTraceAsString();
} catch (\Throwable $e) {
    echo "THROWABLE CAUGHT:\n" . $e->getMessage() . "\n" . $e->getTraceAsString();
}
