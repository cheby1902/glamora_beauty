<?php

namespace App\Services;

class ContentBasedService
{
    public function buatDokumenProduk($produk)
{
    $dokumen =
    $produk->nama_produk . ' ' . $produk->brand;

    if ($produk->jenisKulit) {

       $dokumen .= ' ' .
    $produk->jenisKulit->nama_jenis_kulit;

    }

    if ($produk->masalahKulit) {

        $dokumen .= ' ' .
    $produk->masalahKulit->nama_masalah_kulit;

    }

    foreach ($produk->produkVarian as $varian) {

        if ($varian->warnaKulit) {

           $dokumen .= ' ' .
    $varian->warnaKulit->nama_warna_kulit;
        }

    }
    return $dokumen;
}

    public function tokenisasi($dokumen)
{
    // ==========================
    // 1. Case Folding
    // ==========================
    $dokumen = strtolower($dokumen);

    // ==========================
    // 2. Cleaning
    // Menghapus tanda baca dan karakter selain huruf, angka, dan spasi
    // ==========================
    $dokumen = preg_replace('/[^a-z0-9\s]/', ' ', $dokumen);

    // Menghapus spasi berlebih
    $dokumen = preg_replace('/\s+/', ' ', $dokumen);

    // Menghapus spasi di awal dan akhir
    $dokumen = trim($dokumen);

    // ==========================
    // 3. Tokenisasi
    // ==========================
    return explode(' ', $dokumen);
}

    public function hitungTF($token)
    {
        return array_count_values($token);
    }

    public function hitungIDF($semuaTF)
    {
        $jumlahDokumen = count($semuaTF);

        $documentFrequency = [];

        foreach ($semuaTF as $tf) {

            foreach ($tf as $kata => $jumlah) {

                if (!isset($documentFrequency[$kata])) {
                    $documentFrequency[$kata] = 0;
                }
                $documentFrequency[$kata]++;
            }
        }

        $idf = [];

        foreach ($documentFrequency as $kata => $df) {
            $idf[$kata] = log(
                $jumlahDokumen / $df
            );
        }
        return $idf;
    }

    public function hitungTFIDF($semuaTF, $idf)
    {
        $tfidf = [];
        foreach ($semuaTF as $idProduk => $tf) {
            foreach ($tf as $kata => $nilaiTF) {
                $tfidf[$idProduk][$kata] =
                    $nilaiTF * $idf[$kata];
            }
        }
        return $tfidf;
    }

public function hitungTFIDFUser($tfUser, $idf)
{
    $hasil = [];

    foreach ($tfUser as $kata => $tf) {

        if (isset($idf[$kata])) {

            $hasil[$kata] =
                $tf * $idf[$kata];

        }

    }

    return $hasil;
}

public function hitungCosineSimilarity($vektor1, $vektor2)
{
    $dotProduct = 0;

    $panjang1 = 0;

    $panjang2 = 0;

    foreach ($vektor1 as $kata => $nilai) {

        $panjang1 += pow($nilai, 2);

        if (isset($vektor2[$kata])) {

            $dotProduct +=
                $nilai * $vektor2[$kata];

        }

    }

    foreach ($vektor2 as $nilai) {

        $panjang2 += pow($nilai, 2);

    }

    if ($panjang1 == 0 || $panjang2 == 0) {

        return 0;

    }

    return $dotProduct /
        (sqrt($panjang1) * sqrt($panjang2));
}

}