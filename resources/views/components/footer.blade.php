<footer class="border-t-2 border-solid border-gray-300 dark:border-gray-700">
    <div class="flex flex-col gap-6 text-black dark:text-white mx-auto container py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 divide-y lg:divide-y-0 lg:divide-x divide-gray-300 dark:divide-gray-700">
            <div class="pr-0 lg:pr-8">
                <h2 class="text-2xl font-bold mb-2">Text Logo</h2>
                <p class="text-sm font-light mb-4">
                    About Deskripsi
                </p>
                <div class="flex gap-3">
                    <a
                        href="https://instagram.com"
                        class="rounded-full bg-gray-950 p-2 text-white"
                        target="_blank"
                        rel="noopener noreferrer">
                        <flux:icon.instagram></flux:icon.instagram>
                    </a>
                </div>
            </div>

            <div class="pt-6 lg:pt-0 px-0 lg:px-8">
                <h2 class="text-lg font-semibold mb-3">Navigasi</h2>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:underline">Home</a></li>
                    <li><a href="#" class="hover:underline">Produk</a></li>
                    <li><a href="#" class="hover:underline">Tentang Kami</a></li>
                    <li><a href="#" class="hover:underline">Kontak</a></li>
                </ul>
            </div>

            <div class="pt-6 lg:pt-0 pl-0 lg:pl-8">
                <h2 class="text-lg font-semibold mb-3">Kontak</h2>
                <p class="text-sm">Email: info@reaksi.com</p>
                <p class="text-sm">Phone: +62 888 8888 8888</p>
                <p class="text-sm">Alamat: Jl. Contoh</p>
            </div>
        </div>

        <flux:separator />

        <div class="text-center text-sm text-gray-500 dark:text-gray-400">
            &copy; <span id="year"></span> REAKSI. All rights reserved.
        </div>
    </div>
</footer>

<script>
    document.getElementById("year").textContent = new Date().getFullYear();
</script>
