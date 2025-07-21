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

<nav class="navbar bg-light shadow-sm fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Bouton pour ouvrir le menu (offcanvas) -->
        <button id="openSidebarBtn" class="btn btn-outline-dark" type="button">
            <i class="fas fa-bars"></i>
            <span class="navbar-text text-dark">Menu</span>
        </button>

        <!-- Section utilisateur (nom + bouton déconnexion) -->
        <div class="d-flex align-items-center">
            <span class="navbar-text text-dark me-3">
                Bienvenue, <?php echo htmlspecialchars($nom); ?>
            </span>
            <a href="<?= $basePath ?>actions/logout.php" class="btn btn-outline-danger">
                <i class="fas fa-sign-out-alt me-1"></i> Déconnexion
            </a>
        </div>
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
        <?php if($_SESSION['role'] === 'admin'): ?>
            <a href="<?= $basePath ?>pages/admin/dashboard.php" class="btn btn-light border text-start"><i class="fas fa-home me-2"></i> Accueil</a>
            <a href="<?= $basePath ?>pages/admin/listUsers.php" class="btn btn-light border text-start"><i class="fas fa-users me-2"></i> Liste des utilisateurs</a>
            <a href="<?= $basePath ?>forms/createUserPage.php" class="btn btn-light border text-start"><i class="fas fa-user-plus me-2"></i> Ajouter un utilisateur</a>
        <?php endif; ?>

        
        <div class="mt-auto">
            <div class="dropdown w-100">
                <a class="btn btn-light border w-100 text-center dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-cogs me-2"></i> Paramètres
                </a>

                <ul class="dropdown-menu w-100 p-3 shadow-sm">
                    <!-- Interrupteur Langue -->
                    <li class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-language me-2 text-primary"></i>
                            <span id="langLabel">Français / Anglais</span>
                        </div>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" id="langSwitch">
                        </div>
                    </li>

                    <!-- Interrupteur Thème -->
                    <li class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-moon me-2 text-warning"></i>
                            <span>Thème sombre</span>
                        </div>
                        <div class="form-check form-switch m-0">
                            <input class="form-check-input" type="checkbox" id="themeSwitch">
                        </div>
                    </li>

                </ul>
            </div>

            <!-- Bouton de déconnexion -->
            <a href="<?= $basePath ?>actions/logout.php" class="btn btn-danger border w-100 mt-2">
                <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
            </a>
        </div>
    </div>
</div>

<!-- Script pour derouler dynamiquement le menu latéral -->
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

<!-- Script pour le theme sombre/clair -->
<script>
    const themeSwitch = document.getElementById('themeSwitch');

    // Fonction d'application du thème
    function appliquerTheme(theme) {
        if (theme === 'dark') {
        document.body.classList.add('bg-dark', 'text-light');
        document.body.classList.remove('bg-light', 'text-dark');
        themeSwitch.checked = true;
        } else {
        document.body.classList.add('bg-light', 'text-dark');
        document.body.classList.remove('bg-dark', 'text-light');
        themeSwitch.checked = false;
        }
    }

    // Vérifier le thème au chargement de la page
    const themeSauvegarde = localStorage.getItem('theme') || 'light';
    appliquerTheme(themeSauvegarde);

    // Quand l'utilisateur change le thème
    themeSwitch.addEventListener('change', function () {
        const themeChoisi = this.checked ? 'dark' : 'light';
        localStorage.setItem('theme', themeChoisi);
        appliquerTheme(themeChoisi);
    });
</script>

<!-- Script pour changer la langue -->
<script>
    // Récupère les éléments
    const langSwitch = document.getElementById('langSwitch');
    const langLabel = document.getElementById('langLabel');

    // Fonction pour appliquer la langue
    function setLang(lang) {
        if (lang === 'fr') {
        langLabel.textContent = 'Français';
        langSwitch.checked = false;
        // TODO : ici tu peux traduire d'autres éléments en français
        } else if (lang === 'en') {
        langLabel.textContent = 'English';
        langSwitch.checked = true;
        // TODO : ici tu peux traduire d'autres éléments en anglais
        }
        localStorage.setItem('langue', lang);
    }

    // Événement lors du changement
    langSwitch.addEventListener('change', () => {
        const selectedLang = langSwitch.checked ? 'en' : 'fr';
        setLang(selectedLang);
        // Tu peux aussi recharger la page si nécessaire : location.reload();
    });

    // Appliquer la langue mémorisée au chargement
    const savedLang = localStorage.getItem('langue') || 'fr';
    setLang(savedLang);
</script>
