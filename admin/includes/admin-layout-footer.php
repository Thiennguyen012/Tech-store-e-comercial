            </div>
        </div>
    </div>

    <!-- Bootstrap + Icons + JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    

    
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');

        if(toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
            });
        }
    </script>

</body>
</html>
