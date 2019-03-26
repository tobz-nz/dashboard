<?php

namespace App\Http\Controllers\Push\APNS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWage\APNS\Certificate;
use JWage\APNS\Safari\PackageGenerator;

class PushPackageController extends Controller
{
    /**
     * Compile a PushPackage as defined by the APNS documentation
     *
     * @todo Remove the dependancy on jwage/php-apns
     * @param  \Illuminate\Http\Request $request
     * @param  string  $version
     * @param  string  $websitePushID
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $version, $websitePushID)
    {
        $cert = file_get_contents(config('services.apns.register_certificate'));
        $certificate = new Certificate($cert, '');
        $packageGenerator = new PackageGenerator(
            $certificate,
            resource_path('safariPushPackage.base'),
            config('app.domain')
        );

        $userId = (int) $request->get('userId');
        $userhash = sha1($userId); // must be at least 16 chars
        // dump("User: $userId / $userhash");

        // returns JWage\APNS\Safari\Package instance
        $package = $packageGenerator->createPushPackageForUser($userhash);

        // send zip file to the browser
        return response()
            ->download($package->getZipPath())
            ->deleteFileAfterSend();
    }
}
