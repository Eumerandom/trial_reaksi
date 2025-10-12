<footer class="border-t mx-auto border-zinc-300 container mt-10">
    <div class="flex flex-col text-black mx-auto container py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 md:divide-x md:divide-zinc-300">
            <div class="pr-0 md:pr-8">
                <h2 class="text-2xl font-bold mb-2">BUYCUT</h2>
                <p class="text-sm font-light mb-4">
BUYCUT adalah inisiatif yang bertujuan membantu mencari produk pengganti yang bebas dari afiliasi Zionis sebagai respons terhadap aksi boikot produk-produk tertentu.
        Inisiatif ini mendukung konsumen untuk memilih produk sesuai nilai kemanusiaan dan solidaritas.                </p>
                <!-- <div class="flex gap-3">
                    <a
                        href="https://www.instagram.com/rekomendasibebasafiliasi/"
                        class="rounded-full bg-gray-950 p-2 text-white"
                        target="_blank"
                        rel="noopener noreferrer">
                        <flux:icon.instagram></flux:icon.instagram>
                    </a>
                    <a
                        href="https://linktr.ee/reaksi.id"
                        class="rounded-full bg-gray-950 p-2 text-white"
                        target="_blank"
                        rel="noopener noreferrer">
                        <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" id="Linktree--Streamline-Simple-Icons"><desc>Linktree Streamline Icon: https://streamlinehq.com</desc><title>Linktree</title><path d="m13.73635 5.85251 4.00467 -4.11665 2.3248 2.3808 -4.20064 4.00466h5.9085v3.30473h-5.9365l4.22865 4.10766 -2.3248 2.3338L12.0005 12.099l-5.74052 5.76852 -2.3248 -2.3248 4.22864 -4.10766h-5.9375V8.12132h5.9085L3.93417 4.11666l2.3248 -2.3808 4.00468 4.11665V0h3.4727zm-3.4727 10.30614h3.4727V24h-3.4727z" fill="currentColor"></path></svg>
                    </a>
                </div> -->
            </div>

            <div class="md:pl-8">
                <h3 class="text-lg font-semibold mb-3">Navigasi</h3>
                <ul class="space-y-2 text-sm font-light">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="relative hover:text-zinc-600 transition-colors
                                  after:content-[''] after:absolute after:-bottom-px after:left-0 after:h-px after:w-0
                                  after:bg-zinc-600
                                  after:transition-all after:duration-300 hover:after:w-full">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('product.index') }}"
                            class="relative hover:text-zinc-600 transition-colors
                                  after:content-[''] after:absolute after:-bottom-px after:left-0 after:h-px after:w-0
                                  after:bg-zinc-600
                                  after:transition-all after:duration-300 hover:after:w-full">
                            Produk
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('berita.index') }}"
                            class="relative hover:text-zinc-600 transition-colors
                                  after:content-[''] after:absolute after:-bottom-px after:left-0 after:h-px after:w-0
                                  after:bg-zinc-600
                                  after:transition-all after:duration-300 hover:after:w-full">
                            Berita
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <flux:separator />
        <div class="text-center text-sm text-zinc-800 mt-8">
            &copy; <span id="year"></span> BUYCUT. All rights reserved. Made with love.
        </div>
    </div>
</footer>

<script>
    document.getElementById("year").textContent = new Date().getFullYear();
</script>