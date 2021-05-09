<?php

namespace App\Observers;

use App\Models\item;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use GpsLab\Component\Base64UID\Base64UID;

class TransactionObserver
{

    private function kurangiJumlahProduk(int $produk_id, int $jumlah) {
        try {
            $produk = item::find($produk_id);
            $produk['stok'] -= $jumlah;
            $produk->save();
        } catch (Exception $e) {
            dd($e);
        }
    }

    private function kurangiJumlahBeberapaProduk(Transaction $transaction) {
        if($transaction['done']) {
            $list_produk = $transaction['data'];
            foreach ($list_produk as $produk) {
                foreach ($produk as $id => $jumlah) {
                    $item = item::find($id);
                    if($item == NULL) continue;
                    $this->kurangiJumlahProduk($id, $jumlah);
                }
            }
        }
    }

    /**
     * Handle the Transaction "created" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        //
        $transaction['id_transaksi'] = Base64UID::generate(11);
        try {
            $list_produk = $transaction['data'];
            $transaction['total_harga'] = 0;
            foreach ($list_produk as $produk) {
                foreach ($produk as $id => $jumlah) {
                    $item = item::find($id);
                    if($item == NULL) continue;
                    $transaction['total_harga'] += $jumlah * $item['harga'];
                }
            }
            $transaction->save();
        } catch (Exception $e) {
            dd($e);
        }
        $this->kurangiJumlahBeberapaProduk($transaction);
    }

    /**
     * Handle the Transaction "updated" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function updated(Transaction $transaction)
    {
        //
        $this->kurangiJumlahBeberapaProduk($transaction);
    }

    /**
     * Handle the Transaction "deleted" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function deleted(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function restored(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function forceDeleted(Transaction $transaction)
    {
        //
    }
}
