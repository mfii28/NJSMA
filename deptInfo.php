<?php 
require_once __DIR__ . '/src/init.php';

use Models\Department;
$deptModel = new Department();
$departments = $deptModel->getAll();

$pageTitle = "Departments | " . SITE_NAME;
include VIEW_PATH . '/partials/header.php';

// Grouping logic for filter
function getCategory($name) {
    $name = strtolower($name);
    if (strpos($name, 'admin') !== false || strpos($name, 'finance') !== false || strpos($name, 'budget') !== false || strpos($name, 'human resource') !== false) {
        return 'filter-admin';
    } elseif (strpos($name, 'health') !== false || strpos($name, 'social') !== false || strpos($name, 'education') !== false || strpos($name, 'waste') !== false) {
        return 'filter-services';
    } else {
        return 'filter-technical';
    }
}
?>

<main id="main">
    <section class="page-header text-center">
        <div class="container">
            <h1>Municipal Departments</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center bg-transparent">
                    <li class="breadcrumb-item"><a href="<?= SITE_URL ?>/" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Departments</li>
                </ol>
            </nav>
        </div>
    </section>

    <section id="departments-isotope" class="departments-isotope pb-5 pt-5">
        <div class="container" data-aos="fade-up">
            
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-center">
                    <ul id="department-filters" class="list-unstyled d-flex gap-3 mb-5 filter-nav flex-wrap justify-content-center">
                        <li data-filter="*" class="filter-active btn btn-primary rounded-pill active">All Departments</li>
                        <li data-filter=".filter-admin" class="btn btn-outline-primary rounded-pill">Administration</li>
                        <li data-filter=".filter-services" class="btn btn-outline-primary rounded-pill">Social Services</li>
                        <li data-filter=".filter-technical" class="btn btn-outline-primary rounded-pill">Technical & Works</li>
                    </ul>
                </div>
            </div>

            <div class="row department-container" data-aos="fade-up" data-aos-delay="100">
                <?php foreach ($departments as $dept): ?>
                    <div class="col-lg-4 col-md-6 department-item <?= getCategory($dept['DeptName']) ?> mb-4">
                        <div class="content-card shadow-sm h-100 text-center hover-up">
                            <div class="dept-icon mb-3">
                                <?php
                                $cat = getCategory($dept['DeptName']);
                                $icon = 'bi-building';
                                if($cat == 'filter-admin') $icon = 'bi-briefcase';
                                if($cat == 'filter-services') $icon = 'bi-heart-pulse';
                                if($cat == 'filter-technical') $icon = 'bi-tools';
                                ?>
                                <i class="bi <?= $icon ?> fs-1 text-primary"></i>
                            </div>
                            <h4 class="fw-bold mb-3"><?= htmlspecialchars($dept['DeptName']) ?></h4>
                            <p class="text-muted small mb-4" style="line-height: 1.6;">
                                <?= htmlspecialchars(substr($dept['Description'], 0, 100)) ?>...
                            </p>
                            <a href="<?= SITE_URL ?>/department-details?id=<?= $dept['id'] ?>" class="btn btn-sm btn-light border rounded-pill px-4">View Details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let departmentContainer = document.querySelector('.department-container');
    if (departmentContainer && typeof Isotope !== 'undefined') {
        let departmentIsotope = new Isotope(departmentContainer, {
            itemSelector: '.department-item',
            layoutMode: 'fitRows'
        });

        let departmentFilters = document.querySelectorAll('#department-filters li');

        departmentFilters.forEach(function(filter) {
            filter.addEventListener('click', function(e) {
                e.preventDefault();
                departmentFilters.forEach(function(el) {
                    el.classList.remove('active', 'btn-primary', 'filter-active');
                    el.classList.add('btn-outline-primary');
                });
                this.classList.add('active', 'btn-primary', 'filter-active');
                this.classList.remove('btn-outline-primary');

                departmentIsotope.arrange({
                    filter: this.getAttribute('data-filter')
                });
                departmentIsotope.on('arrangeComplete', function() {
                    AOS.refresh()
                });
            });
        });
    }
});
</script>

<?php include VIEW_PATH . '/partials/footer.php'; ?>