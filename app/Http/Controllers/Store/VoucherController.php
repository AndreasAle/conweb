<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Store\Concerns\InteractsWithCurrentStore;
use App\Http\Requests\Store\VoucherRequest;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    use InteractsWithCurrentStore;

    public function index(Request $request)
    {
        $store = $this->currentStore($request);
        $vouchers = $store->vouchers()->latest()->paginate(15);

        return view('store.dashboard.vouchers.index', compact('store', 'vouchers'));
    }

    public function create(Request $request)
    {
        $store = $this->currentStore($request);
        $voucher = new Voucher(['type' => Voucher::TYPE_PERCENTAGE, 'is_active' => true]);

        return view('store.dashboard.vouchers.form', compact('store', 'voucher'));
    }

    public function store(VoucherRequest $request)
    {
        $store = $this->currentStore($request);

        $data = $request->validated();
        $data['code'] = strtoupper($data['code']);
        $data['is_active'] = $request->boolean('is_active');
        $store->vouchers()->create($data);

        return redirect()->route('store-dashboard.vouchers.index')
            ->with('success', 'Voucher berhasil dibuat.');
    }

    public function edit(Request $request, Voucher $voucher)
    {
        $store = $this->currentStore($request);
        $this->authorizeStoreOwnership($request, $voucher);

        return view('store.dashboard.vouchers.form', compact('store', 'voucher'));
    }

    public function update(VoucherRequest $request, Voucher $voucher)
    {
        $this->authorizeStoreOwnership($request, $voucher);

        $data = $request->validated();
        $data['code'] = strtoupper($data['code']);
        $data['is_active'] = $request->boolean('is_active');
        $voucher->update($data);

        return redirect()->route('store-dashboard.vouchers.index')
            ->with('success', 'Voucher berhasil diperbarui.');
    }

    public function destroy(Request $request, Voucher $voucher)
    {
        $this->authorizeStoreOwnership($request, $voucher);
        $voucher->delete();

        return redirect()->route('store-dashboard.vouchers.index')
            ->with('success', 'Voucher dihapus.');
    }
}
