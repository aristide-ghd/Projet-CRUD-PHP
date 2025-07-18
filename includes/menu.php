<style>
    .offcanvas-custom-width {
        width: 220px !important;
    }
    .offcanvas-header {
        padding-left: 24px;
    }
    .offcanvas-body a.btn {
        transition: background-color 0.3s, color 0.3s;
        border-radius: 8px;
    }

    .offcanvas-body a.btn:hover {
        background-color: #dee2e6; /* Gris très clair */
        color: #000;
    }
    .offcanvas.offcanvas-start { /**Effet de glissement fluide a l'ouverture du menu */
        transition: transform 0.4s ease-in-out;
    }

</style>

<!-- Bouton pour ouvrir le menu -->
<nav class="navbar bg-light shadow-sm fixed-top">
    <div class="container-fluid">
        <button id="openSidebarBtn" class="btn btn-outline-dark" type="button">
            <i class="fas fa-bars"></i>
            <span class="navbar-text text-dark">Menu</span>
        </button>
    </div>
</nav>

<!-- Menu latéral (offcanvas Bootstrap) btn-outline-secondary -->
<div class="offcanvas offcanvas-start bg-light text-dark offcanvas-custom-width shadow-sm" tabindex="-1" id="sidebar">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold"><i class="fas fa-bars me-2"></i> Navigation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column gap-2">
        <!-- Liens principaux -->
        <a href="index.php" class="btn btn-light border text-start"><i class="fas fa-home me-2"></i> Accueil</a>
        <a href="listUsers.php" class="btn btn-light border text-start"><i class="fas fa-users me-2"></i> Liste des utilisateurs</a>
        <a href="createUserPage.php" class="btn btn-light border text-start"><i class="fas fa-user-plus me-2"></i> Ajouter un utilisateur</a>

        <!-- Spacer pour pousser Déconnexion en bas -->
        <div class="mt-auto">
        <a href="#" class="btn btn-danger border w-100"><i class="fas fa-sign-out-alt me-2"></i> Déconnexion</a>
        </div>
    </div>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const openBtn = document.getElementById('openSidebarBtn');

    openBtn.addEventListener('mouseenter', () => {
        const bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(sidebar);
        bsOffcanvas.show();
    });

    // Optionnel : refermer si la souris sort du menu
    sidebar.addEventListener('mouseleave', () => {
        const bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(sidebar);
        bsOffcanvas.hide();
    });
</script>

