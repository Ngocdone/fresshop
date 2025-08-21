        </div> <!-- End .main-content -->
    </div> <!-- End .admin-container -->

    <script>
        // Menu active khi click (JS fallback nếu không dùng PHP)
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                const currentActive = document.querySelector('.menu-item.active');
                if (currentActive) currentActive.classList.remove('active');
                this.classList.add('active');
            });
        });

        // Pagination active
        document.querySelectorAll('.page-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!this.textContent.includes('«') && !this.textContent.includes('»')) {
                    const currentActive = document.querySelector('.page-btn.active');
                    if (currentActive) currentActive.classList.remove('active');
                    this.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
