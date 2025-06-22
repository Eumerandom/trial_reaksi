<div>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-gray-100 dark:bg-black">
        <div class="max-w-4xl mx-auto">
            {{-- Card 1 --}}
            <div class="mb-16 p-6 sm:p-8 bg-white dark:bg-zinc-800 rounded-lg shadow-md text-center transform transition"
                x-data="{show: false}"
                x-init="setTimeout(() => show = true, 300)"
                :class="{'opacity-0 translate-y-4': !show, 'opacity-100 translate-y-0': show}">

                <div class="mb-6 mx-auto w-24 h-24 overflow-hidden rounded-full transition-transform duration-300 hover:scale-110">
                    <img src="https://ugc.production.linktr.ee/0dfad2d7-f8ce-4ee7-b582-dad733d02cee_PASS-REAKSI-NEW-LOGO-08.jpeg?io=true&size=avatar-v3_0"
                         alt="REAKSI Logo"
                         class="w-full h-full object-cover">
                </div>
                <h1
                    class="mb-4 text-3xl font-extrabold text-gray-900 md:text-4xl lg:text-5xl dark:text-white">
                    Apa itu REAKSI?</h1>
                <p class="mb-8 text-lg font-normal text-zinc-600 dark:text-gray-300 max-w-2xl mx-auto">
                    REAKSI adalah singkatan dari <strong>Rekomendasi Bebas Afiliasi</strong>,
                    <span class="text-red-600 dark:text-red-500 font-semibold">sebuah platform untuk menemukan produk alternatif yang bebas dari afiliasi Zionis.</span>
                    Inisiatif ini lahir sebagai respons terhadap gerakan boikot produk terafiliasi.
                </p>
                <a href="{{ route('product.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900 transition duration-150 ease-in-out transform hover:-translate-y-1 active:translate-y-0">
                    Lihat Rekomendasi Produk
                    <svg class="w-4 h-4 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>

                <div class="mt-8 mb-12 text-center">
                    <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">Selengkapnya:</p>
                    <div class="flex flex-row justify-center items-center space-x-4">
                        <a href="https://linktr.ee/reksi.id" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-center text-green-700 dark:text-green-300 bg-slate-100 shadow-md dark:bg-zinc-700 rounded-lg hover:bg-green-500/75 focus:ring-4 focus:ring-green-300/50 dark:focus:ring-green-800/50 transition duration-150 ease-in-out">
                           <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" id="Linktree--Streamline-Simple-Icons"><desc>Linktree Streamline Icon: https://streamlinehq.com</desc><title>Linktree</title><path d="m13.73635 5.85251 4.00467 -4.11665 2.3248 2.3808 -4.20064 4.00466h5.9085v3.30473h-5.9365l4.22865 4.10766 -2.3248 2.3338L12.0005 12.099l-5.74052 5.76852 -2.3248 -2.3248 4.22864 -4.10766h-5.9375V8.12132h5.9085L3.93417 4.11666l2.3248 -2.3808 4.00468 4.11665V0h3.4727zm-3.4727 10.30614h3.4727V24h-3.4727z" fill="currentColor"></path></svg>
                            Linktree
                        </a>
                        <a href="https://www.instagram.com/rekomendasibebasafiliasi/" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-center text-pink-700 dark:text-pink-300 bg-slate-100 shadow-md dark:bg-zinc-700 rounded-lg hover:bg-pink-500/75 focus:ring-4 focus:ring-pink-300/50 dark:focus:ring-pink-800/50 transition duration-150 ease-in-out">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                               <path d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8A3.6 3.6 0 0 0 7.6 20h8.8A3.6 3.6 0 0 0 20 16.4V7.6A3.6 3.6 0 0 0 16.4 4H7.6m9.65 1.5a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5M12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10m0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"></path>
                            </svg>
                            Instagram
                        </a>
                    </div>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="mb-16 p-6 sm:p-8 bg-white dark:bg-zinc-800 rounded-lg shadow-md transform transition ease-in-out hover:shadow-lg"
                x-data="{
                    show: false,
                    openPanels: {1: false, 2: false, 3: false},
                    isAllOpen: false,
                    toggleAllPanels() {
                        this.isAllOpen = !this.isAllOpen;
                        for (let key in this.openPanels) {
                            this.openPanels[key] = this.isAllOpen;
                        }
                    },
                    togglePanel(id) {
                        this.openPanels[id] = !this.openPanels[id];
                        this.isAllOpen = Object.values(this.openPanels).every(val => val === true);
                    }
                }"
                x-init="setTimeout(() => show = true, 600)"
                :class="{'opacity-0 translate-y-4': !show, 'opacity-100 translate-y-0': show}">
                <h2 class="mb-4 text-2xl font-bold leading-tight tracking-tight text-center text-gray-900 md:text-3xl dark:text-white">
                    Mengapa REAKSI Penting?
                </h2>

                <div class="mb-4">
                    <button @click="togglePanel(1)"
                            class="flex justify-between items-center w-full p-4 font-medium text-left bg-gray-50 dark:bg-zinc-700 rounded-t-lg hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300">
                        <span class="text-lg font-semibold">Pertanyaan Umum</span>
                        <svg :class="{'rotate-180': openPanels[1]}" class="w-5 h-5 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div x-show="openPanels[1]"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         class="p-4 border-2 border-t-0 border-gray-200 dark:border-zinc-700 rounded-b-lg bg-white dark:bg-zinc-800">
                        <p class="text-center italic text-gray-700 dark:text-gray-300">
                            Saat dihadapkan pada daftar produk boikot, banyak yang bertanya:
                        </p>
                        <blockquote class="text-center text-xl font-semibold text-gray-800 dark:text-gray-100 border-l-4 border-red-500 pl-4 py-2 italic my-4">
                            "Lalu, penggantinya apa?"
                        </blockquote>
                    </div>
                </div>

                <div class="mb-4">
                    <button @click="togglePanel(2)"
                            class="flex justify-between items-center w-full p-4 font-medium text-left bg-gray-50 dark:bg-zinc-700 rounded-t-lg hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300">
                        <span class="text-lg font-semibold">Solusi Kami</span>
                        <svg :class="{'rotate-180': openPanels[2]}" class="w-5 h-5 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div x-show="openPanels[2]"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         class="p-4 border-2 border-t-0 border-gray-200 dark:border-zinc-700 rounded-b-lg bg-white dark:bg-zinc-800">
                        <p class="text-center text-gray-700 dark:text-gray-300">
                            <span class="text-red-600 dark:text-red-500 font-semibold">REAKSI hadir sebagai jawaban.</span> Kami menyediakan daftar produk rekomendasi sebagai alternatif bagi Anda yang mencari pengganti produk yang diboikot, memudahkan Anda untuk tetap konsisten dengan pilihan Anda.
                        </p>
                    </div>
                </div>
            </div>
            {{-- Card 3 --}}
            <div class="p-6 sm:p-8 bg-white dark:bg-zinc-800 rounded-lg shadow-md transform transition duration-700 ease-in-out hover:shadow-lg"
                x-data="{show: false}"
                x-init="setTimeout(() => show = true, 900)"
                :class="{'opacity-0 translate-y-4': !show, 'opacity-100 translate-y-0': show}">
                <h3 class="mb-4 text-xl text-center font-bold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-3xl dark:text-white">
                    Disclaimer
                </h3>
                <ul class="space-y-3 text-md font-normal text-gray-600 list-disc list-inside dark:text-gray-300">
                    <li class="transition-all duration-300 hover:text-red-600 dark:hover:text-red-400">
                        Daftar produk rekomendasi ini disusun berdasarkan pertimbangan independen dan merujuk pada semangat
                        <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline inline-flex items-center">
                            Fatwa MUI No 14/Ijtima' Ulama/VII/2024
                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" clip-rule="evenodd"></path>
                                <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path>
                            </svg>
                        </a>
                        tentang "Prioritas Penggunaan Produk dalam Negeri", serta analisis kepemilikan/lisensi perusahaan.
                    </li>
                    <li class="transition-all duration-300 hover:text-red-600 dark:hover:text-red-400">
                        Tidak ada paksaan untuk mengikuti rekomendasi ini. Keputusan akhir ada di tangan Anda.
                    </li>
                    <li class="transition-all duration-300 hover:text-red-600 dark:hover:text-red-400">
                        Platform ini
                        <span class="text-red-600 dark:text-red-500 font-semibold">TIDAK DISPONSORI DAN TIDAK BEKERJA SAMA</span> dengan merek manapun.
                        Murni didasari kepedulian terhadap isu kemanusiaan.
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <button id="back-to-top"
            class="fixed bottom-5 right-5 bg-red-600 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-opacity duration-300 opacity-0 invisible"
            onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>
</div>
