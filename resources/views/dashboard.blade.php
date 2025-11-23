<div>
    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-gray-100">
        <div class="max-w-4xl mx-auto">
            <div class="mb-16 p-6 sm:p-8 bg-white rounded-lg shadow-md text-center transform transition"
                x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)"
                :class="{ 'opacity-0 translate-y-4': !show, 'opacity-100 translate-y-0': show }">
                <h1 class="mb-4 text-3xl font-extrabold text-gray-900 md:text-4xl lg:text-5xl">
                    Apa itu Pisah.in?</h1>
                <p class="mb-8 text-lg font-normal text-zinc-600 max-w-2xl mx-auto">
                    Pisah.in adalah gerakan kemanusiaan yang bertujuan mengurangi atau setidaknya memperburuk ekonomi
                    pihak-pihak tertentu sebagai bentuk protes atau tekanan sosial.
                    Gerakan ini merupakan bagian dari aksi boikot atau pemulauan, yakni tindakan tidak menggunakan,
                    membeli, atau berurusan dengan produk atau organisasi tertentu sebagai wujud protes terhadap
                    pelanggaran nilai kemanusiaan atau ketidakadilan.
                </p>
                <a href="{{ route('product.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 transition duration-150 ease-in-out transform hover:-translate-y-1 active:translate-y-0">
                    Lihat Rekomendasi Produk Aman
                    <svg class="w-4 h-4 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>

                <!-- <div class="mt-8 mb-12 text-center">
                    <p class="mb-4 text-sm text-gray-600">Selengkapnya:</p>
                    <div class="flex flex-row justify-center items-center space-x-4">
                        <a href="https://linktr.ee/Pisah.in.id" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-center text-green-700 bg-slate-100 shadow-md rounded-lg hover:bg-green-500/75 focus:ring-4 focus:ring-green-300/50 transition duration-150 ease-in-out">
                           Linktree
                        </a>
                        <a href="https://www.instagram.com/Pisah.in.official/" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-center text-pink-700 bg-slate-100 shadow-md rounded-lg hover:bg-pink-500/75 focus:ring-4 focus:ring-pink-300/50 transition duration-150 ease-in-out">
                            Instagram
                        </a>
                    </div>
                </div> -->
            </div>

            <div class="mb-16 p-6 sm:p-8 bg-white rounded-lg shadow-md transform transition ease-in-out hover:shadow-lg"
                x-data="{
                    show: false,
                    openPanels: { 1: false, 2: false, 3: false },
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
                }" x-init="setTimeout(() => show = true, 600)"
                :class="{ 'opacity-0 translate-y-4': !show, 'opacity-100 translate-y-0': show }">
                <h2 class="mb-4 text-2xl font-bold leading-tight tracking-tight text-center text-gray-900 md:text-3xl">
                    Mengapa Pisah.in Penting?
                </h2>

                <div class="mb-4">
                    <button @click="togglePanel(1)"
                        class="flex justify-between items-center w-full p-4 font-medium text-left bg-gray-50 rounded-t-lg hover:bg-gray-100 text-gray-700">
                        <span class="text-lg font-semibold">Pertanyaan Umum</span>
                        <svg :class="{ 'rotate-180': openPanels[1] }" class="w-5 h-5 transition-transform"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div x-show="openPanels[1]" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        class="p-4 border-2 border-t-0 border-gray-200 rounded-b-lg bg-white">
                        <p class="text-center italic text-gray-700">
                            Saat menghadapi daftar produk yang diboikot, pertanyaan utama adalah:
                        </p>
                        <blockquote
                            class="text-center text-xl font-semibold text-gray-800 border-l-4 border-red-500 pl-4 py-2 italic my-4">
                            "Apa alternatif produk yang bisa dipilih?"
                        </blockquote>
                    </div>
                </div>

                <div class="mb-4">
                    <button @click="togglePanel(2)"
                        class="flex justify-between items-center w-full p-4 font-medium text-left bg-gray-50 rounded-t-lg hover:bg-gray-100 text-gray-700">
                        <span class="text-lg font-semibold">Solusi Pisah.in</span>
                        <svg :class="{ 'rotate-180': openPanels[2] }" class="w-5 h-5 transition-transform"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div x-show="openPanels[2]" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        class="p-4 border-2 border-t-0 border-gray-200 rounded-b-lg bg-white">
                        <p class="text-center text-gray-700">
                            <span class="text-red-600 font-semibold">Website ini menyediakan daftar produk alternatif
                                yang dapat menjadi pilihan bagi konsumen</span> agar tetap dapat berbelanja sesuai
                            prinsip tanpa kehilangan pilihan di tengah gerakan boikot.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white rounded-lg shadow-md transform transition duration-700 ease-in-out hover:shadow-lg"
                x-data="{ show: false }" x-init="setTimeout(() => show = true, 900)"
                :class="{ 'opacity-0 translate-y-4': !show, 'opacity-100 translate-y-0': show }">
                <h3
                    class="mb-4 text-xl text-center font-bold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-3xl">
                    Disclaimer
                </h3>
                <ul class="space-y-3 text-md font-normal text-gray-600 list-disc list-inside">
                    <li class="transition-all duration-300 hover:text-red-600">
                        Daftar produk disusun berdasarkan riset independen tanpa afiliasi dengan merk manapun.
                    </li>
                    <li class="transition-all duration-300 hover:text-red-600">
                        Keputusan memilih menggunakan produk dari daftar sepenuhnya ada di tangan konsumen.
                    </li>
                    <li class="transition-all duration-300 hover:text-red-600">
                        Kami tidak disponsori atau bekerjasama dengan merk apapun, murni didasari kepedulian terhadap
                        prinsip kemanusiaan dan pilihan konsumen.
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <button id="back-to-top"
        class="fixed bottom-5 right-5 bg-red-600 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-opacity duration-300 opacity-0 invisible"
        onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>
</div>
