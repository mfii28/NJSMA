<?php
$result = mysqli_query($conn,"SELECT * FROM mce");
$row = mysqli_fetch_array($result);
?>
   <!-- The Mayor's Area -->
     <section class="the-mayor-details-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 d-block d-lg-none">
                <h2><img src="./dashboard/assets/img/logo-1.png" class="img-fluid" alt=""> The M.C.E</h2></div>
            <div class="col-lg-4 the-mayor-img">
                <div class="the-mayor-img-wrap d-flex justify-content-center">
                    <img src="./dashboard/assets/img/profileImg/mce.jpg" class="img-fluid" alt="">
                </div>
                <div class="the-img-text-wrap">
                    <h3>Hon.<?php echo $row["first_name"]; echo " "; echo  $row["last_name"]; ?></h3>
                    <h5>The M.C.E. of <br>NEW JUABEN SOUTH MUNICIPAL ASSEMBLY</h5>
                </div>
            </div>
            <div class="col-lg-6 the-mayor-profile">
                <h2 class="d-none d-lg-block">
                    <img src="./dashboard/assets/img/logo-1.png" class="img-fluid" alt="">The M.C.E</h2>
                <div class="the-mayor-profile-wrap">
                    <p>Hon. Isaac Appaw – Gyasi  Lorem ipsum, dolor sit amet consectetur adipisicing elit. Velit vero a hic obcaecati doloremque fugit molestiae, fuga optio sed minima id ab sit quo totam iusto, nostrum rerum maiores aliquam. Aperiam doloribus in animi eveniet, facere molestiae possimus cum est!</p>
<h3>Career Path</h3>
<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio, esse. &nbsp;Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint, aut. Nihil, reiciendis. Sunt modi qui officiis exercitationem praesentium, laudantium beatae odit nulla incidunt dolor molestias quae consequuntur magni id, sequi soluta placeat neque labore corporis distinctio illum maiores. Esse, maxime!</p>
<p>Lorem ipsum dolor sit amet consectetur. &nbsp;Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi impedit quae aspernatur accusantium accusamus incidunt id delectus quam animi? Est labore tenetur unde eaque. Adipisci incidunt quaerat blanditiis. Voluptates labore unde, voluptatum suscipit tenetur ad nihil aliquid, mollitia minus ab, reiciendis voluptas possimus? Atque praesentium cupiditate sint distinctio cum maiores autem, harum fugit qui incidunt voluptatibus? Minima, minus nulla. Aliquam id libero consectetur quam quia voluptatum rerum necessitatibus. Sed, neque?&nbsp;</p>
<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque molestiae, numquam quo velit aperiam necessitatibus dolorem repudiandae, ea ex nostrum adipisci porro fuga iusto excepturi ratione deserunt error veritatis nemo?&nbsp;</p>
<h3>Education</h3>
<p>Mr. Isaac Appaw - Gyasi had his Secondary Education at Achimota School from 1981 to 1986.

He proceeded to Canada where he had his Tertiary Education at York University, he became the SRC President of the Atkinson College York University - 1995/1996 academic year and graduated with a Bachelor of Administrative Studies - BAS in 1996..</p>
<p>He became the Chief Executive Officer of Ike’s Compu – Tek Group of Companies, with branches in Kumasi and Koforidua from 1998 to 2016

He was sworn into office as the Municipal Chief Executive of New Juaben South Municipal Assembly – Koforidua on 31st July, 2018 after his nomination and Hundred Percent (100%) endorsement by Assembly members.</p>
<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In, totam?s&rsquo; Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eligendi pariatur optio nisi voluptates sapiente saepe necessitatibus quia tempora dolores nihil at consequatur itaque laboriosam aperiam praesentium nulla, natus eum! Recusandae veniam aut corrupti. Voluptate, voluptatem. Doloremque, blanditiis? Aspernatur, debitis voluptatem.&nbsp;</p>
<h3>Personal Life</h3>
<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eveniet iste doloribus, aperiam et rerum minima modi? Distinctio facilis doloribus esse? Veniam eos voluptate pariatur veritatis dicta nobis eveniet dolores in vel rem, nesciunt esse similique sunt aspernatur hic optio facilis laudantium iure quae incidunt doloribus. Doloremque recusandae ullam corporis eligendi!</p>
<p>&nbsp;</p>
<p><a href="twitter:https://twitter.com/MayorSackey">Twitter:https://twitter.com/MayorSackey</a></p>                </div>
            </div>

            <div class="col-lg-2 other-links d-none d-lg-block">
                <div class="other-links-wrap">
                    <h3>Other Links</h3>
<ul>
            <!-- <li><a href="department-details.php?d="></a></li> -->
        <li><a href="theassembly.php">The Assembly</a></li>
    <li><a href="themayor.php">The Mayor</a></li>
    <li><a href="thepresidingmember.php">Presiding Member</a></li>
   <!-- <li><a href="theassemblymembers.php">Assembly Members</a></li>-->
    <li><a href="themembersofparliament.php">Members of Parliament</a></li>
    <li><a href="thehistory.php">The History</a></li>
</ul>                </div>
            </div>
 
        </div><!-- End .row -->
    </div><!-- End .container 

-->
</section> <!-- End .the-mayor-details-area -->
        <!-- End of Sub Metros Area -->