<?php 
session_start();
error_reporting(0);
include('inc/header/dbConnection.php');
    ?>
 


 <!-- ======= Blog Details Section ======= -->
 <section id="blog" class="blog">
    
      <div class="container" data-aos="fade-up">
      <div class="section-title">
          <p>Top Stories</p>
           
        </div>






        
        <div class="row g-5">

          <div class="col-lg-8">


            <article class="blog-details">

            <?php 
        if($_POST['searchtitle']!=''){
$st=$_SESSION['searchtitle']=$_POST['searchtitle'];
}
$st;
             




     if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 8;
        $offset = ($pageno-1) * $no_of_records_per_page;


        $total_pages_sql = "SELECT COUNT(*) FROM tblposts";
        $result = mysqli_query($con,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);


$query=mysqli_query($con,"select tblposts.id as pid,tblposts.PostTitle as posttitle,tblcategory.CategoryName as category,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.PostTitle like '%$st%' and tblposts.Is_Active=1 LIMIT $offset, $no_of_records_per_page");

$rowcount=mysqli_num_rows($query);
if($rowcount==0)
{
echo "No record found";
}
else {
while ($row=mysqli_fetch_array($query)) {


?>

<a href="">
<div class="post-img">
                <img src="./dashboard/assets/img/heroImg/slider-1.jpg" alt="" class="img-fluid">
              </div>

              <h2 class="card-title"><?php echo htmlentities($row['posttitle']);?></h2>

              <div class="meta-top">
                <ul>
                Posted on <?php echo htmlentities($row['postingdate']);?>
                </ul>
              </div>
</a>
           <!-- End meta top -->

             <!-- ======= Blog Section ======= -->
             <?php } ?>

<ul class="pagination justify-content-center mb-4">
    <li class="page-item"><a href="?pageno=1"  class="page-link">First</a></li>
    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?> page-item">
        <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>" class="page-link">Prev</a>
    </li>
    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?> page-item">
        <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?> " class="page-link">Next</a>
    </li>
    <li class="page-item"><a href="?pageno=<?php echo $total_pages; ?>" class="page-link">Last</a></li>
</ul>
<?php } ?>

</article>

          </div>
          

          <div class="col-lg-4">
          <?php include('inc/sidebar.php');?>
        </div>

      </div>
    </section><!-- End Blog Details Section -->

    
 
<?php include './inc/footer.php';
?>