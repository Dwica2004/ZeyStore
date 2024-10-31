<div>
    <footer class="bg-white bg-opacity-20 backdrop-filter backdrop-blur-lg text-white py-8 mt-auto">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-between items-center">
                <div class="w-full md:w-1/3 text-center md:text-left mb-6 md:mb-0">
                    <h2 class="text-2xl font-bold mb-2">ZeyStore</h2>
                    <p class="text-sm">Toko digital terbaik untuk kebutuhan Anda</p>
                </div>
                <div class="w-full md:w-1/3 text-center mb-6 md:mb-0">
                </div>
                <div class="w-full md:w-1/3 text-center md:text-right">
                    <h3 class="text-lg font-semibold mb-2">Hubungi Kami</h3>
                    <p class="text-sm">Email: info@zeystore.com</p>
                    <p class="text-sm">Telepon: +62 85706717028</p>
                </div>
            </div>
            <div class="border-t border-white border-opacity-20 mt-8 pt-8 text-center text-sm">
                <p>&copy; 2024  By. ZeyStore.</p>
            </div>
        </div>
    </footer>
    <script>
        function toggleMenu() {
            var menu = document.getElementById('menu');
            menu.classList.toggle('hidden');
        }

        // Animasi GSAP untuk footer
        gsap.from("footer", {duration: 1, opacity: 0, y: 50, ease: "power3.out", scrollTrigger: {
            trigger: "footer",
            start: "top bottom",
            end: "bottom bottom",
            scrub: true
        }});
    </script>
</body>
</html> 