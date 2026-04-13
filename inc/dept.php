<?php
use Models\Department;
$deptModel = new Department();
$departments = $deptModel->getAll();
?>
<section id="departments" class="departments py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="fw-bold" style="color: var(--primary-color);">Our Departments</h2>
            <p class="text-muted">Explore the various departments and units of the Assembly</p>
        </div>

        <?php if (empty($departments)): ?>
        <div class="text-center">
            <p class="text-muted">No departments listed at the moment.</p>
        </div>
        <?php else: ?>
            <?php foreach ($departments as $index => $dept): ?>
            <section class="sub-units-area <?= $index === 0 ? 'departments-details-area' : '' ?>">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 d-block d-md-none">
                            <h2><?= htmlspecialchars($dept['DeptName']) ?></h2>
                        </div>
                        
                        <!-- Department Head -->
                        <div class="col-lg-2 sub-unit-officers">
                            <div class="sub-unit-officers-wrap">
                                <div class="img-wrap d-flex justify-content-center">
                                    <img class="img-fluid" src="/njsma/dashboard/assets/img/management/<?= htmlspecialchars($dept['HeadImage'] ?? 'default.jpg') ?>" 
                                         alt="<?= htmlspecialchars($dept['HeadName'] ?? '') ?>" 
                                         style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;"> 
                                </div> 
                                <div class="text-wrap mt-3">
                                    <h3><?= htmlspecialchars($dept['HeadName'] ?? 'Not Assigned') ?></h3>
                                    <h5><?= htmlspecialchars($dept['HeadTitle'] ?? 'Head of Department') ?></h5>
                                </div> 
                            </div>
                        </div>

                        <!-- Department Details -->
                        <div class="col-lg-7 sub-unit-text">
                            <h2 class="d-none d-md-block"><?= htmlspecialchars($dept['DeptName']) ?></h2>
                            <div class="sub-unit-text-wrap">
                                <?php if (!empty($dept['Description'])): ?>
                                    <?= $dept['Description'] ?>
                                <?php else: ?>
                                    <p class="text-muted">Department description not available.</p>
                                <?php endif; ?>
                                
                                <?php if (!empty($dept['Functions'])): ?>
                                    <h4 class="mt-4 mb-3">Key Functions</h4>
                                    <?= $dept['Functions'] ?>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mt-3">
                                <a href="<?= SITE_URL ?>/department-details?id=<?= $dept['id'] ?>" class="btn btn-outline-primary btn-sm">
                                    View Details <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Other Departments Sidebar (only on first item) -->
                        <?php if ($index === 0): ?>
                        <div class="d-none d-md-block col-lg-3 other-departments">
                            <section class="other-departments-wrap">
                                <p>Other Departments</p>
                                <ul>
                                    <?php foreach (array_slice($departments, 1, 8) as $otherDept): ?>
                                    <li><a href="<?= SITE_URL ?>/department-details?id=<?= $otherDept['id'] ?>">
                                        <?= htmlspecialchars($otherDept['DeptName']) ?>
                                    </a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </section>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

         
         <!--back to top-->
         <a id="back-to-top" href="#" class="btn btn-success back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><span class="fas fa-angle-up"></span></a>        <!--End back to top-->


        <script src="/njsma/lib/vendor/modernizr/modernizr.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="/njsma/lib/vendor/jquery/jquery.min.js"><\/script>')</script>
        <script src="/njsma/lib/vendor/jquery-ui/jquery-ui.min.js"></script>
       
        <!-- Bootstrap -->
        <script src="/njsma/lib/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- /Bootstrap -->
        <!-- <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script> -->
        <script src="/njsma/lib/vendor/boxicons/js/boxicons.min.js"></script>
        
        <script src="/njsma/lib/vendor/stickyfloat/stickyfloat.js"></script>    
       
        <script src="/njsma/lib/vendor/jquery-sticky/jquery.sticky.js"></script>
        <script src="/njsma/lib/vendor/parallax/parallax.min.js"></script>

        <script src="/njsma/lib/js/plugins.js"></script>
        <script src="/njsma/lib/vendor/unitegallery/ug-theme-slider.js"></script>
        <script src="/njsma/lib/main.js"></script>

        <script>
            $(function(){
                /* var ele = $("#wrapper");
                console.log(ele);
                $('.other-departments-wrap').stickyfloat({
                // scrollArea: ele,//'div.wrapper',
                    startOffset: 180,
                    offsetY: -240,
                    duration:0, //,
                    lockBottom: false
                }); */
            
                var floatEnd = (footerY/4) +  footerY;
                console.log(navY);
                console.log(footerY);
            
                //console.log(bY);
                console.log(floatEnd);
                
                if(($('.sub-units-area').length) || ($('.other-officers').length )){
                    $(".other-departments-wrap").sticky({ 
                        topSpacing: 0,//navY,
                        bottomSpacing: floatEnd,
                        responsiveWidth: true
                        //zIndex: 600//,
                        //wrapperClassName:"the-sticky-wrapper"		
                    });
                    $(".other-departments-wrap").on('sticky-end', function() {
                        $(".sticky-wrapper").css("height",0);
                    });
                }
            });
        </script>

        <!-- Go to www.addthis.com/dashboard to customize your tools -->
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5afed7cc126e5aba"></script>

 
    </body>