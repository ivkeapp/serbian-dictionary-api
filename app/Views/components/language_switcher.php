<style>
    .language-switcher {
        position: relative;
        display: inline-block;
    }

    .language-switcher .dropdown-toggle {
        background: var(--primary-color, #2c5aa0);
        border: 1px solid var(--primary-color, #2c5aa0);
        color: #fff;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .language-switcher .dropdown-toggle:hover {
        background: #234a87;
        border-color: #234a87;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    }

    .language-switcher .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 8px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        min-width: 180px;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .language-switcher .dropdown-menu.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .language-switcher .dropdown-item {
        padding: 12px 20px;
        color: var(--dark-text);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .language-switcher .dropdown-item:hover {
        background: var(--light-bg);
    }

    .language-switcher .dropdown-item.active {
        background: var(--primary-color);
        color: white;
    }

    .language-switcher .dropdown-item i {
        font-size: 18px;
        width: 24px;
        text-align: center;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .language-switcher .dropdown-toggle {
            padding: 6px 12px;
            font-size: 13px;
        }

        .language-switcher .dropdown-menu {
            min-width: 160px;
        }

        .language-switcher .dropdown-item {
            padding: 10px 16px;
            font-size: 14px;
        }
    }
</style>

<div class="language-switcher">
    <button class="dropdown-toggle" id="languageDropdown">
        <i class="fas fa-globe"></i>
        <span id="currentLanguage">
            <?php 
            $locale = session()->get('locale') ?? 'sr-Lat';
            switch($locale) {
                case 'sr-Lat':
                    echo 'Srpski (lat)';
                    break;
                case 'sr-Cyrl':
                    echo 'Српски (ћир)';
                    break;
                default:
                    echo 'English';
            }
            ?>
        </span>
        <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
    </button>
    
    <div class="dropdown-menu" id="languageMenu">
        <a href="<?= base_url('set-language/en') ?>" class="dropdown-item <?= ($locale === 'en') ? 'active' : '' ?>">
            <i class="fas fa-flag-usa"></i>
            <span>English</span>
        </a>
        <a href="<?= base_url('set-language/sr-Lat') ?>" class="dropdown-item <?= ($locale === 'sr-Lat') ? 'active' : '' ?>">
            <i class="fas fa-flag"></i>
            <span>Srpski (latinica)</span>
        </a>
        <a href="<?= base_url('set-language/sr-Cyrl') ?>" class="dropdown-item <?= ($locale === 'sr-Cyrl') ? 'active' : '' ?>">
            <i class="fas fa-flag"></i>
            <span>Српски (ћирилица)</span>
        </a>
    </div>
</div>

<script>
    // Language switcher dropdown functionality
    (function() {
        const dropdown = document.getElementById('languageDropdown');
        const menu = document.getElementById('languageMenu');
        
        if (dropdown && menu) {
            dropdown.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                menu.classList.toggle('show');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.remove('show');
                }
            });
        }
    })();
</script>
