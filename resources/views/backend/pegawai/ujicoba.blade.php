<?
// 🔍 Validasi field wajib diisi
        $request->validate([
            'golongan_id' => 'required',
            'tmt_golongan' => 'required|date',
            'no_sk' => 'required|string|max:100',
            'tgl_sk' => 'required|date',
            'pejabat' => 'required|string|max:100',
        ], [
            'no_sk.unique' => 'Nomor SK sudah digunakan / Nomor SK harus berbeda dengan yang lain.',
        ]);

        // ✅ Simpan riwayat golongan
        RiwayatPendidikan::create([
            'pegawai_id' => $request->pegawai_id,
            'golongan_id' => $request->golongan_id,
            'tmt_golongan' => $request->tmt_golongan,
            'no_sk' => $request->no_sk,
            'tgl_sk' => $request->tgl_sk,
            'pejabat' => $request->pejabat,
        ]);

        return redirect()->route('backend.riwayat_golongan.show', $request->pegawai_id)
            ->with('success', '✅ Data Riwayat Golongan berhasil ditambahkan.');