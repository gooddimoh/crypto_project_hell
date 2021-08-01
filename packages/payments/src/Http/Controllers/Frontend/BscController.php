<?php

namespace Packages\Payments\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Packages\Payments\Helpers\Ethereum;
use Packages\Payments\Http\Requests\Frontend\StoreBscAddress;
use Packages\Payments\Http\Requests\Frontend\VerifyBscAddress;
use Packages\Payments\Models\BscAddress;

class BscController extends Controller
{
    public function index(Request $request)
    {
        return BscAddress::where('user_id', $request->user()->id)->confirmed()->get();
    }

    /**
     * Create or update an ethereum address
     *
     * @param StoreBscAddress $request
     * @return mixed
     */
    public function store(StoreBscAddress $request)
    {
        return BscAddress::updateOrCreate(
            ['user_id' => $request->user()->id, 'address' => $request->address],
            ['message' => Str::random(20)]
        );
    }

    /**
     * Verify ethereum signtarure to confirm a given address belongs to user
     *
     * @param VerifyBscAddress $request
     * @param BscAddress $bscAddress
     * @return BscAddress
     */
    public function verify(VerifyBscAddress $request, BscAddress $bscAddress)
    {
        if (Ethereum::isSignatureValid($bscAddress->message, $request->signature, $bscAddress->address)) {
            $bscAddress->update(['confirmed' => TRUE]);
        }

        return $bscAddress;
    }
}
