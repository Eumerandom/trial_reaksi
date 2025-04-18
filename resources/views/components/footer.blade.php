<footer class="border-t mx-auto border-zinc-300 dark:border-zinc-800 container">
    <div class="flex flex-col text-black dark:text-white mx-auto container py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 md:divide-x md:divide-zinc-300 md:dark:divide-zinc-800">
            <div class="pr-0 md:pr-8">
                <h2 class="text-2xl font-bold mb-2">REAKSI</h2>
                <p class="text-sm font-light mb-4">
                    REAKSI (Rekomendasi Bebas Afiliasi) hadir sebagai solusi mencari produk pengganti yang bebas dari afiliasi Zionis, sebagai respons terhadap aksi boikot.
                </p>
                <div class="flex gap-3">
                    <a
                        href="https://www.instagram.com/rekomendasibebasafiliasi/"
                        class="rounded-full bg-gray-950 dark:bg-white p-2 text-white dark:text-black"
                        target="_blank"
                        rel="noopener noreferrer">
                        <flux:icon.instagram></flux:icon.instagram>
                    </a>
                </div>
            </div>

            <div class="md:pl-8">
                <h3 class="text-lg font-semibold mb-3">Navigasi</h3>
                <ul class="space-y-2 text-sm font-light">
                    <li>
                        <a href="{{ route('dashboard') }}"
                           class="relative hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors
                                  after:content-[''] after:absolute after:bottom-[-1px] after:left-0 after:h-[1px] after:w-0
                                  after:bg-zinc-600 dark:after:bg-zinc-300
                                  after:transition-all after:duration-300 hover:after:w-full">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('product.index') }}"
                           class="relative hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors
                                  after:content-[''] after:absolute after:bottom-[-1px] after:left-0 after:h-[1px] after:w-0
                                  after:bg-zinc-600 dark:after:bg-zinc-300
                                  after:transition-all after:duration-300 hover:after:w-full">
                            Produk
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('berita.index') }}"
                           class="relative hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors
                                  after:content-[''] after:absolute after:bottom-[-1px] after:left-0 after:h-[1px] after:w-0
                                  after:bg-zinc-600 dark:after:bg-zinc-300
                                  after:transition-all after:duration-300 hover:after:w-full">
                            Berita
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <flux:separator />
        <div class="text-center text-sm text-zinc-800 dark:text-zinc-400 mt-8">
            &copy; <span id="year"></span> REAKSI. All rights reserved.
        </div>
    </div>
</footer>

<script>
    document.getElementById("year").textContent = new Date().getFullYear();
</script>
