            </div>
        </div>
    </div>

    <!-- Bootstrap + Icons + JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        .border-left-primary { border-left: .25rem solid #4e73df !important; }
        .border-left-success { border-left: .25rem solid #1cc88a !important; }
        .border-left-info { border-left: .25rem solid #36b9cc !important; }
        .border-left-warning { border-left: .25rem solid #f6c23e !important; }
        .text-primary { color: #4e73df !important; }
        .text-success { color: #1cc88a !important; }
        .text-info { color: #36b9cc !important; }
        .text-warning { color: #f6c23e !important; }
        .nav-link.active { background-color: rgba(255, 255, 255, 0.1) !important; }
        .text-xs { font-size: 0.75rem; }
        .font-weight-bold { font-weight: 700 !important; }
        .text-gray-800 { color: #5a5c69 !important; }
        .shadow { box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important; }
    </style>
    
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
