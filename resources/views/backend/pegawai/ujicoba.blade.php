<div class="mb-3">
                        <label for="tambah_file_path" class="block text-sm font-medium text-gray-700">Upload Dokumen</label>
                        <div class= "w-full flex items-center border border-gray-300 rounded-md shadow-sm px-3 bg-white text-sm text-gray-900 mt-1">
                            <button type="button" id="custom-upload" class="text-green-700 rounded-md bg-green-50">Pilih File</button>
                            <hr style="border: 1px solid #ccc; height: 40px; margin-right: 10px; margin-left: 10px;" >
                            <span id="file-name">{{ $dokumen->file_path ?? 'Tidak ada file yang dipilih' }}</span>
                        </div>
                        <input type="file" name="file_path" id="tambah_file_path" class="hidden" required accept=".pdf,.doc,.docx,.jpg,.png">
                        />
                        @error('file_path')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>