<?
$rph = RiwayatPenghargaan::findOrFail($id);
        // 🔍 Validasi data edit
        $request->validate([
            'nm_penghargaan' => 'required|string|max:255',
            'no_urut' => 'required|string|max:25',
            'no_sertifikat' => 'required|string|max:100|unique:riwayat_penghargaan,no_sertifikat',
            'tgl_sertifikat' => 'required|date',
            'pejabat_penetap' => 'required|string|max:255',
            'link' => 'required|string|max:255',
        ],[
            'no_sertifikat.unique' => 'Nomor sertifikat sudah digunakan / Nomor sertifikat harus berbeda dengan yang lain.',
        ]);

        // ✅ Update data
        $rph->update([
            'nm_penghargaan' => $request->nm_penghargaan,
            'no_urut' => $request->no_urut,
            'no_sertifikat' => $request->no_sertifikat,
            'tgl_sertifikat' => $request->tgl_sertifikat,
            'pejabat_penetap' => $request->pejabat_penetap,
            'link' => $request->link,
        ]);

        return redirect()->route('backend.penghargaan.show', $request->pegawai_id) ->with('success', '✅ Data Riwayat Penghargaan berhasil diperbarui.');