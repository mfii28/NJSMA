<?php
$result = mysqli_query($conn,"SELECT * FROM mce");
$row = mysqli_fetch_array($result);
?>
   <!-- The Mayor's Area -->
     <section class="the-mayor-details-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 d-block d-lg-none">
                <h2><img src="/njsma/dashboard/assets/img/logo-1.png" class="img-fluid" alt=""> The M.C.E</h2></div>
            <div class="col-lg-4 the-mayor-img">
                <div class="the-mayor-img-wrap d-flex justify-content-center">
                    <img src="/njsma/dashboard/assets/img/profileImg/mce.jpg" class="img-fluid" alt="">
                </div>
                <div class="the-img-text-wrap">
                    <h3>Hon.<?php echo $row["first_name"]; echo " "; echo  $row["last_name"]; ?></h3>
                    <h5>The M.C.E. of <br>NEW JUABEN SOUTH MUNICIPAL ASSEMBLY</h5>
                </div>
            </div>
            <div class="col-lg-6 the-mayor-profile">
                <h2 class="d-none d-lg-block">
                    <img src="/njsma/dashboard/assets/img/logo-1.png" class="img-fluid" alt="">The M.C.E</h2>
                <div class="the-mayor-profile-wrap">
                    <h3>Biography</h3>
                    <p><?php echo nl2br(htmlspecialchars($row['biography'] ?? 'Biography information not available.')); ?></p>
                    
                    <h3>Career Path</h3>
                    <p><?php echo nl2br(htmlspecialchars($row['career'] ?? 'Career information not available.')); ?></p>
                    
                    <h3>Education</h3>
                    <p><?php echo nl2br(htmlspecialchars($row['education'] ?? 'Education information not available.')); ?></p>
                    
                    <h3>Vision</h3>
                    <p><?php echo nl2br(htmlspecialchars($row['vision'] ?? 'Vision statement not available.')); ?></p>
                    
                    <?php if (!empty($row['social_twitter'])): ?>
                    <p><a href="<?php echo htmlspecialchars($row['social_twitter']); ?>" target="_blank"><i class="bi bi-twitter"></i> Twitter</a></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-2 other-links d-none d-lg-block">
                <div class="other-links-wrap">
                    <h3>Other Links</h3>
<ul>
            <!-- <li><a href="department-details.php?d="></a></li> -->
        <li><a href="/njsma/assemblyInfo">The Assembly</a></li>
    <li><a href="/njsma/MCE">The MCE</a></li>
    <li><a href="/njsma/assembly-members">Assembly Members</a></li>
    <li><a href="/njsma/history">The History</a></li>
</ul>                </div>
            </div>
 
        </div><!-- End .row -->
    </div><!-- End .container 

-->
</section> <!-- End .the-mayor-details-area -->
        <!-- End of Sub Metros Area -->